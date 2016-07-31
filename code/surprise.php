<?php require("php/imports.php"); ?>
<?php require("php/random.php"); ?>
<html>
    <head>	
		    <title>Tour de Chance - Whats on</title>
		    <?php require("structure/header.php"); ?>
    </head>
    <body>
        <?php require("structure/navbar.php"); ?>
        <?php require("php/trove.php"); ?>

        <?php
            $printkey = "";
            function getClosestAttractions() {

                global $conn, $rand_LATITUDE, $rand_LONGITUDE, $printkey;

                $sql = "SELECT *
                    FROM govhack_CBR";

                if(!$result = $conn->query($sql)){
                    die('Error running the query [' . $conn->error . ']');
                }

                $storage = array();
                $ordered = array();
                while($row = $result->fetch_assoc()){
                    //Get distance between this, and the current rand values..
                    //$string = $rand_LATITUDE."|".$rand_LONGITUDE."|".$row["LATITUDE"]."|".$row["LONGITUDE"];
                    $distance = distance($rand_LATITUDE, $rand_LONGITUDE, $row["LATITUDE"], $row["LONGITUDE"]);
                    $string = $distance."|".$row["NAME"]."|".$row["ID"];
                    if ($distance != 0){
                        array_push($storage, $string);
                    }
                }
                //asort($storage);
                //var_dump($storage);
                shuffle($storage);
                $searchRange = 1;
                $count = 0;
                while(true){
                    foreach($storage as $item){
                        if($count < 3){
                            if(explode("|", $item)[0] <= $searchRange){
                                array_push($ordered, $item);
                                $ordered = array_unique($ordered);
                                $count = sizeof($ordered);
                            }
                        }
                    }
                    if($count == 3){
                        //We have found three nearby attractions.. break
                        break;
                    }
                    else{
                        $searchRange = $searchRange + 0.5;
                        shuffle($storage);
                    }
                }
                //$ordered = array_unique($ordered);
                $ordered = array_values($ordered);
                for($i = 0; $i<3; $i++){
                    if($i < 2){
                        $printkey = $printkey.$ordered[$i]."@";
                    }
                    else{
                        $printkey = $printkey.$ordered[$i];
                    }
                }
                $printkey = addslashes($printkey);
                //echo "PK :".$printkey;
                //var_dump($ordered);
                return $ordered;
            }

            function distance($lat1, $lon1, $lat2, $lon2) { 

                $lat1 = floatval($lat1);
                $lat2 = floatval($lat2);

                $theta = $lon1 - $lon2; 
                $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
                $dist = acos($dist); 
                $dist = rad2deg($dist); 
                $kms = $dist * 60 * 1.1515 * 1.609344;

                return $kms;
            }

        ?>

        <div class="container">
            <div class="page-header">
                <?php
                    //http://stackoverflow.com/questions/13031250/php-function-to-delete-all-between-certain-characters-in-string
                    function delete_all_between($beginning, $end, $string) {
                        $beginningPos = strpos($string, $beginning);
                        $endPos = strpos($string, $end);
                        if ($beginningPos === false || $endPos === false) {
                            return $string;
                        }

                        $textToDelete = substr($string, $beginningPos, ($endPos + strlen($end)) - $beginningPos);

                        return str_replace($textToDelete, '', $string);
                    }
                ?>
                <h1><?php echo $rand_NAME; ?> <small><?php echo $rand_SUBURB; ?></small></h1>
            </div>
            <div class="row">
                <div class="col-sm-6 col-md-3">
                    <div class="thumbnail">
                        <img src=<?php echo getImageURL($rand_LONGITUDE, $rand_LATITUDE, 10); ?>>
                        <div class="caption">
                            <p>Image Source: Google Street View</p>
                        </div>
                    </div>
                    <table id="info">
                        <tr>
                            <td><b>Details</b></td>
                        </tr>
                        <tr>
                            <td><span class="glyphicon glyphicon-earphone" aria-hidden="true"></span><?php
                                if($rand_PHONE != ""){
                                    echo " ".$rand_PHONE;
                                }
                                else{
                                    echo " Not Provided";
                                }
                            ?></td>
                        </tr>
                        <tr>
                            <td><span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span>
                            <?php
                                if($rand_WEBSITE != ""){
                                    echo $rand_WEBSITE;
                                }
                                else{
                                    echo "Not Provided";
                                }
                            ?></td>
                        </tr>
                        <tr>
                            <td><span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
                            <?php
                                if($rand_FREE == "Y"){
                                    echo "Free";
                                }
                                else{
                                    echo "May be some cost";
                                }
                            ?>
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-sm-6 col-md-9">
                    <h3><?php echo delete_all_between("(", ")", $rand_CATEGORY); ?></h3>
                    <?php echo $rand_DESCRIPTION; ?>
                    <div style="margin-top: 20px;">
                        <iframe width="100%" height="400" src=<?php echo "'https://www.google.com/maps?q=".$rand_LATITUDE.',%20'.$rand_LONGITUDE."&amp;z=18&amp;t=m&amp;output=embed'" ?> style="border: 0px solid rgb(0, 0, 0); border-image: none;"></iframe>
                    </div>
                </div>
            </div>
            <div class="row" style="margin-top:25px">
                <div class="col-sm-6 col-md-3">
                    <h4>Your Proposed Itinerary</h4>
                    <p>These attractions are typically within walking distance of each other</p>
                </div>
                <div class="col-sm-6 col-md-7">
                    <div class="list-group">
                        <a class="list-group-item active">
                            <h4 class="list-group-item-heading"><?php echo $rand_NAME; ?></h4>
                            <p class="list-group-item-text"><?php echo $rand_SUBURB; ?></p>
                        </a>
                        <?php $cache = getClosestAttractions(); ?>
                        <a class="list-group-item">
                            <h4 class="list-group-item-heading"><?php echo explode("|", $cache[0])[1]; ?></h4>
                            <p class="list-group-item-text"><?php echo round(explode("|", $cache[0])[0], 2)." kms away"; ?></p>
                        </a>
                        <a class="list-group-item">
                            <h4 class="list-group-item-heading"><?php echo explode("|", $cache[1])[1]; ?></h4>
                            <p class="list-group-item-text"><?php echo round(explode("|", $cache[1])[0], 2)." kms away"; ?></p>
                        </a>
                        <a class="list-group-item">
                            <h4 class="list-group-item-heading"><?php echo explode("|", $cache[2])[1]; ?></h4>
                            <p class="list-group-item-text"><?php echo round(explode("|", $cache[2])[0], 2)." kms away"; ?></p>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-md-2">
                    <button type="button" class="btn btn-danger btn-lg" style="width: 100%" onclick="location.reload();" a>
                        <span class="glyphicon glyphicon-repeat" aria-hidden="true"></span> New Itinerary
                    </button>
                    <br/><br/>
                    <form action="print.php">
                        <input class="btn btn-default" type="submit" value="Print Itinerary" style="width:100%; padding: 16px; padding-top: 10px; padding-bottom: 10px;">
                        <input type="hidden" value=<?php echo '"'.$printkey.'"'; ?> name="pk">
                    </form>
                </div>
            </div>
        </div>

    </body>
    <?php require("structure/footer.php"); ?>
</html>