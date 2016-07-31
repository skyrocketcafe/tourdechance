<?php
	$databaseHost = "localhost";
	$databaseUser = "root";				//Black out these fields for submission
	$databasePassword = "govhack2016";	//Black out these fields for submission

	$primaryTable = "govhack_CBR";
	$userTable = "govhack_CBR_users";

	//Dumped data tables can be found on the project github...

	//Connect to the database...
	// Create connection
	$conn = new mysqli($databaseHost, $databaseUser, $databasePassword);
	$conn->select_db("TDC");


	// Check connection
	if ($conn->connect_error) {
		//Display crazy error!!!
    	die("OMG! The Database Connection failed: " . $conn->connect_error);
	} 

	$insertError = "";
	function db_insertUser($email, $password, $firstName, $lastName){
		$email = sanitize($email);
		$password = sanitize($password);
		$firstName = sanitize($firstName);
		$lastName = sanitize($lastName);
		/*$email = mysql_real_escape_string($email);
		$password = mysql_real_escape_string($password);
		$firstName = mysql_real_escape_string($firstName);
		$lastName = mysql_real_escape_string($lastName);*/

		//CHECK IF EMAIL EXISTS IN DATABASE!
		$emails = db_returnUsers();
		while($row = $emails->fetch_assoc()){
    		if(!strcmp($email, $row['email'])){
 				$insertError = "An account with the same email address exists.";
    			return false;
    		}
		}

		global $conn, $userTable;
		echo $email;
		$sql = "INSERT INTO ".$userTable." (email, firstName, lastName, password) VALUES ('".$email."', '".$firstName."', '".$lastName."', '".$password."')";
		echo $sql;
		$result = $conn->query($sql);
		if(!$result){
    		die('Error running the query [' . $conn->error . ']');
		}
		return $result;

	}
	function sanitize($input) {
		//Dodgiest input sanitation...
    	$input = addslashes($input);
    	$input = str_replace(";", "", $input);
    	return $input;
	}


	function db_returnUsers(){
		global $conn, $userTable;

		$sql = "SELECT *
    		FROM ".$userTable;

    	if(!$result = $conn->query($sql)){
    		die('Error running the query [' . $conn->error . ']');
		}

		return $result;

	}
	function stats_for_category($category){
		global $conn, $primaryTable;

		$sql = "SELECT *
    		FROM ".$primaryTable;

    	if(!$result = $conn->query($sql)){
    		die('Error running the query [' . $conn->error . ']');
		}

		$count = 0;

		while($row = $result->fetch_assoc()){
    		if(strcmp($row["CATEGORY"],$category) == 0){
    			$count++;
    		}
		}
		return $count;
	}
	function info_for_field($id, $field){
		global $conn, $primaryTable;

		$sql = "SELECT *
    		FROM ".$primaryTable;

    	if(!$result = $conn->query($sql)){
    		die('Error running the query [' . $conn->error . ']');
		}

		while($row = $result->fetch_assoc()){
    		if(strcmp($row["ID"], $id) == 0){
    			//Have a match
    			return $row[$field];
    		}
		}
		return "Not Provided";
	}
	function does_id_exist($id){
		global $conn, $primaryTable;

		$sql = "SELECT *
    		FROM ".$primaryTable;

    	if(!$result = $conn->query($sql)){
    		die('Error running the query [' . $conn->error . ']');
		}

		$count = 0;

		while($row = $result->fetch_assoc()){
    		if(strcmp($row["ID"], $id) == 0){
    			//Have a match
    			return true;
    		}
		}
		return false;
	}

	function db_getClosestAttractions($lat, $long) {

                global $conn;

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
                    $distance = db_distance($lat, $long, $row["LATITUDE"], $row["LONGITUDE"]);
                    $string = $distance."|".$row["NAME"]."|".$row["ID"];
                    if ($distance != 0){
                        array_push($storage, $string);
                    }
                }
                //asort($storage);
                //var_dump($storage);
                shuffle($storage);
                $searchRange = 3;
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
                return $ordered;
            }

    function db_distance($lat1, $lon1, $lat2, $lon2) { 

        $theta = $lon1 - $lon2; 
        $dist = sin(deg2rad(floatval($lat1))) * sin(deg2rad(floatval($lat2))) +  cos(deg2rad(floatval($lat1))) * cos(deg2rad(floatval($lat2))) * cos(deg2rad(floatval($theta))); 
        $dist = acos($dist); 
        $dist = rad2deg($dist); 
        $kms = $dist * 60 * 1.1515 * 1.609344;

        return $kms;
    }
    function thumbnailForID($id){
    	$latitude = info_for_field($id, "LATITUDE");
    	$longitude = info_for_field($id, "LONGITUDE");

    	$imageSizeX = 640;
		$imageSizeY = 640;
		$apikey = "AIzaSyBV5VSXH5YEUdrMZhGdVNc1C2objtjJTxk";

		return "https://maps.googleapis.com/maps/api/streetview?size=".$imageSizeX."x".$imageSizeY."&location=".$latitude.",".$longitude."&fov=180&heading=235&pitch=10&key=".$apikey;

    }

    function search($string){
		global $conn, $primaryTable;

		$sql = "SELECT *
    		FROM ".$primaryTable;

    	if(strcmp($string, "*") == 0){
    		$sql = "SELECT *
    		FROM ".$primaryTable. " ORDER BY NAME ASC";
    	}
    	if(!$result = $conn->query($sql)){
    		die('Error running the query [' . $conn->error . ']');
		}

		$res = array();

		while($row = $result->fetch_assoc()){
			//Realistically, you would implete fuzzy string matching.. but hey...
			if(strcmp($string, "*") == 0){
				array_push($res, $row["ID"]);
			}
    		else if(stripos($row["NAME"], $string) !== false){
    			//Have a match
    			array_push($res, $row["ID"]);
    		}
		}
		return $res;
	}

?>