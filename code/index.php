<!--
    Copyright/Licensing note for "Winwheel.js" code included with this GovHack project. SkyrocketCafe, 2016...

    WINWHEEL.JS
    Winhweel.js basic code wheel example by Douglas McKechie @ www.dougtesting.net
    See website for tutorials and other documentation.
    
    The MIT License (MIT)

    Copyright (c) 2016 Douglas McKechie

    Permission is hereby granted, free of charge, to any person obtaining a copy
    of this software and associated documentation files (the "Software"), to deal
    in the Software without restriction, including without limitation the rights
    to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
    copies of the Software, and to permit persons to whom the Software is
    furnished to do so, subject to the following conditions:

    The above copyright notice and this permission notice shall be included in all
    copies or substantial portions of the Software.

    THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
    IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
    FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
    AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
    LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
    OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
    SOFTWARE.
-->

<html>
    <head>	
		<title>Tour de Chance - Home</title>
        <?php require("structure/header.php"); ?> 

        <!-- SPINNER CODE... -->
        <link rel="stylesheet" href="./css/main_spinner.css" type="text/css" />
        <script type="text/javascript" src="../css/Winwheel.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js"></script>
        <!-- END SPINNER CODE --> 
    </head>

    <body>
        <?php require("structure/navbar.php"); ?>
        <div id="mainJumbo">
            <div class="jumbotron">
                <div class="container">
                    <span class="white">
                        <h2 style="font-size:38px;">Take a chance, explore the Unexpected!</h2>
                        <p>There's more to do in Canberra than you ever imagined...</p>
                        <!--<p><a class="btn btn-primary btn-lg" href="surprise.php" role="button">Build your itinerary</a></p>-->
                    </span>
                </div>
            </div>
        </div>


                    
 
 <!-- SPINNER CODE...
 -->
<?php

        //ini_set('display_errors', 'On'); // turn on error reporting
        //error_reporting(E_ALL);

        require("./php/database.php"); //Imports my database connection...
        
        
        function getField($id,$field)
        {
            global $conn;

            $sql = "SELECT * FROM govhack_CBR WHERE ID = ".$id;

            if(!$result = $conn->query($sql)){
                die("Error running sql query. ");
            }

            while($row = $result->fetch_assoc()){
                if(strcmp($row["ID"], $id) == 0){
                    if(array_key_exists($field, $row)){
                        echo "ID: ".$id." ".$field.":". $row[$field]. "<br>";
                    }
                }
            }
            
       }    // end function getField

       function buildCategoryList()
        {
            global $conn;
            $catCount = 1;

            $sql = "SELECT DISTINCT CATEGORY FROM govhack_CBR";

            if(!$result = $conn->query($sql)){
                die("Error running sql query. ");
            }

            while($row = $result->fetch_assoc()){
                //if(strcmp($row["ID"], $id) == 0){
                    //$catCount = 0;
                    if(array_key_exists("CATEGORY", $row)){
                        
                        $catID = "cat".$catCount;
                        //echo "COUNT ".$catID."<br>";
                        //echo "CATEGORY: ";
                        //echo $row["CATEGORY"];
                        //echo "<br>";
                        echo '<tr><td align="center" id="';
                        echo $catID;
                        echo '" onClick= "';
                        echo "draw_wheel".$catCount."('".$row['CATEGORY']."');";
                        echo '">';
                        echo $row["CATEGORY"];
                        echo "</td></tr>\n";

                        $catCount++;

                        //echo '<tr><td align="center" id="'.$catID.'" onClick="'.redraw_wheel($row["CATEGORY"]).'">'.$row["CATEGORY"].'</td></tr><br>';
 
                    }
                //}
            }
        } // end buildCategoryList function

        function numberOfCategories($quiet)
        {
            //echo "Calculating number of cats...";
            global $conn;
            $catCount = 1;
            $suppressOutput = true;
            $catArray = array();


            $sql = "SELECT DISTINCT CATEGORY FROM govhack_CBR;";

            if(!$result = $conn->query($sql)){
                die("Error running sql query. ");
            }

            while($row = $result->fetch_assoc()){
                //if(strcmp($row["ID"], $id) == 0){
                    //$catCount = 0;
                    if(array_key_exists("CATEGORY", $row)){
                        $catArray[$catCount] = $row["CATEGORY"];
                        $catCount++;

                    }
                //}
            }
            if($suppressOutput) {
                return $catCount;
            }
            echo $catCount;
       }    // end function numberOfCategories function

        function numberOfItemsInCategory($category)
        {
            //echo "Calculating number of cats...";
            global $conn;
            $itemCount = 0;

            $sql = 'SELECT ID FROM govhack_CBR WHERE CATEGORY ="'.$category.'";';
            //echo "SQL: ".$sql."<br>";

            if(!$result = $conn->query($sql)){
                die("Error running sql query. ");
            }

            while($row = $result->fetch_assoc()){
                //if(strcmp($row["ID"], $id) == 0){
                    //$catCount = 0;
                    if(array_key_exists("ID", $row)){
                        $itemCount++;
                    }
                //}
            }
            echo $itemCount;
       }    // end function numberOfItemsInCategory function

       function CategoryArrayPHP()
       {
            global $conn;
            //$catCount = 0;
            $catArrayString = "";


            $sql = "SELECT DISTINCT CATEGORY FROM govhack_CBR;";

            if(!$result = $conn->query($sql)){
                die("Error running sql query. ");
            }

            while($row = $result->fetch_assoc()){
                //if(strcmp($row["ID"], $id) == 0){
                    

                    if(array_key_exists("CATEGORY", $row)){
                        $catArrayString .= '"';
                        $catArrayString .= $row["CATEGORY"].'",';

                    }
                //}
            }
            //$catArrayString .= '"';
            echo $catArrayString;
       }

       function makeCatArrayPHP()
       {
            global $conn;
            $catCount = 1;
            $catArrayString = "";


            $sql = "SELECT DISTINCT CATEGORY FROM govhack_CBR;";

            if(!$result = $conn->query($sql)){
                die("Error running sql query. ");
            }

            while($row = $result->fetch_assoc()){
                //if(strcmp($row["ID"], $id) == 0){
                    

                    if(array_key_exists("CATEGORY", $row)){
                        $catArray[$catCount] = $row["CATEGORY"];
                        $catCount++;
                    }
                //}
            }
            //$catArrayString .= '"';
            return $catArray;
       }

        function segmentColorPHP($segmentNumber)
            {
                $segmentColors = array("#eae56f","#89f26e","#7de6ef","#e7706f");
                $numberOfColors = count($segmentColors);
                $colorIndex = $segmentNumber % $numberOfColors;
                return $segmentColors[$colorIndex]; 
            }


        function wheelGutsPHP($category)
        {
            //echo $category;
            global $conn;
            $itemCount = 0;
            //$numberOfCats = numberOfCategories(1);

            $sql = 'SELECT ID,SHORTNAME FROM govhack_CBR WHERE CATEGORY="'.$category.'";';

            if(!$result = $conn->query($sql)){
                die("Error running sql query. ");
            }

            echo "\t\t\t'numSegments'  :";
            echo numberOfItemsInCategory($category);
            echo ",\n";
            echo "\t\t\t'segments' : \n[\n";
            while($row = $result->fetch_assoc()){
                //if(strcmp($row["ID"], $id) == 0){
                    //$catCount = 0;
                    if(array_key_exists("ID", $row)){
                        $itemCount++;
                        //$itemID = "cat".$catCount;
                        //echo "COUNT ".$catID."<br>";
                        //echo "CATEGORY: ";
                        //echo $row["CATEGORY"];
                        //echo "<br>";
                        //echo '<tr><td align="center" id="';
                        //echo $catID;
                        //echo '" onClick= "';

                        echo "\t\t\t{'fillStyle' :'";
                        echo segmentColorPHP($itemCount);
                        echo "', 'text' : ";
                        echo '"'.$row["SHORTNAME"].'"';
                        echo ", 'ID' : '";
                        echo $row["ID"];
                        echo "'},\n";
                    }
            }
            echo "],\n";
        }   // end wheelGutsPHP function

        //var gutsArray = [];

        function wheelGutsArrayPHP()
        // Innards of each categories wheel have to be pre-created by PHP at page creation, made available
        // to the Javascript later on...
        {
            //echo "wheelGutsArray...\n";
            $catArray = makeCatArrayPHP();
            $catIndex = 1;
            //$numberOfCats = numberOfCategories(1);
            $numberOfCats = 11;
            while ($catIndex <= $numberOfCats) {

                $catCode = "cat".$catIndex;
                echo "function draw_wheel".$catIndex."()\n{\n\t\t\t"; 
                echo 'powerSelected("';
                echo $catCode;
                echo '");';
                echo "\n\t\t\t theWheel = new Winwheel({\n";
                echo "\t\t\t 'outerRadius'  : 234,\n";
                echo "\t\t\t 'textFontSize' : 16,\n";


                //echo "gutsArray[$catIndex] = \n";
                echo wheelGutsPHP($catArray[$catIndex]);
                echo "\n\n";

                echo "\t\t\t'animation' :\n";
                echo "{\n";
                echo "\t\t\t\t\t\t'type'     : 'spinToStop',\n";
                echo "\t\t\t\t\t\t'duration' : 5,\n";
                echo "\t\t\t\t\t\t'spins'    : 8,\n";
                echo "\t\t\t\t\t\t'callbackFinished' : 'alertPrize()'\n";
                echo "\t\t\t}\n";
                echo "\t\t\t});\n}\n\n";

                $catIndex++;

            }

        }

    ?>
    <div class="container">
        <div class="row">
            <h1>Select a Category then "Spin!"</h1>
            <p style="margin-top:20px;">Can't think of anything to do today? Bored with your same old destinations? Have you ever been surprised and delighted by an unexpected discovery?<br>Spin the wheel and visit what turns up. You never know what surprises await...</p>
        </div>
        <div class="row" style="margin-top:50px;">
            <div class="col-md-3">
                <div align="center">
                    <table class="power" cellpadding="10" cellspacing="10">
                        <tr><th style="width='120'; text-align='center';"><h3>Select Category</h3></th></tr>
                        <?php buildCategoryList() ?>
                    </table>
                    <img style="margin-top:35px; border-radius:12px; overflow: hidden;" id="spin_button" src="images/spin_on.png" alt="Spin" onClick="startSpin();" />
                    <h2 style="margin-top:35px;"><a id="SpunLink" href="http://canberra.tourdechance.net"></a></h2>
                </div>
            </div>
            <div class="col-md-9">
                <div align="center">
                    <div style="clear:both;"></div>
                    <div class="the_wheel" style="width='550';height='650';align:right">

                    <table cellpadding="0" cellspacing="0" border="0"><tr>
                    <td width="500" height="624" class="the_wheel" align="center" valign="center">
                    <canvas id="canvas" width="500" height="500">
                        <p style="{color: white}" align="center">Sorry, your browser doesn't support canvas. Please try another.</p>
                    </canvas>
                </td>
            </tr>
          </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

        </div></div></div></div>

        <script>

            var wheelSpinning = false;
            var wheelPower = 2;
            var catArray = [<?php CategoryArrayPHP(); ?>]; // define $catArray

            function segmentColor($segmentNumber)
            {
                $segmentColors = array("#eae56f","#89f26e","#7de6ef","#e7706f");
                $numberOfColors = count($segmentColors);
                $colorIndex = $segmentNumber % $numberOfColors;
                return $segmentColors[$colorIndex]; 
            }

            draw_wheel1();

            <?php wheelGutsArrayPHP() ?>
    
                
                // Vars used by the code in this page to do power controls.
                //var wheelPower    = 0;
                //var wheelSpinning = false;
            
            

            // -------------------------------------------------------
            // Function to handle the onClick on the power buttons.
            // -------------------------------------------------------
            function powerSelected(category)
            {
                // Ensure that power can't be changed while wheel is spinning.
                if (wheelSpinning == false)
                {
                    // Reset all to grey incase this is not the first time the user has selected the power.
                    document.getElementById('cat1').className = "";
                    document.getElementById('cat2').className = "";
                    document.getElementById('cat3').className = "";
                    document.getElementById('cat4').className = "";
                    document.getElementById('cat5').className = "";
                    document.getElementById('cat6').className = "";
                    document.getElementById('cat7').className = "";
                    document.getElementById('cat8').className = "";
                    document.getElementById('cat9').className = "";
                    document.getElementById('cat10').className = "";
                    document.getElementById('cat11').className = "";
                    
                    // Now light up the selected cell...
                    document.getElementById(category).className = category;



                    
                    // Set wheelPower var used when spin button is clicked.
                    //wheelPower = powerLevel;
                    
                    // Light up the spin button by changing it's source image and adding a clickable class to it.
                    document.getElementById('spin_button').src = "images/spin_on.png";
                    document.getElementById('spin_button').className = "clickable";
                }
            }
            
            // -------------------------------------------------------
            // Click handler for spin button.
            // -------------------------------------------------------
            function startSpin()
            {
                // Ensure that spinning can't be clicked again while already running.
                if (wheelSpinning == false)
                {

                    theWheel.rotationAngle = 0;     // Re-set the wheel angle to 0 degrees.
                    theWheel.draw();  

                    // Based on the power level selected adjust the number of spins for the wheel, the more times is has
                    // to rotate with the duration of the animation the quicker the wheel spins.
                    if (wheelPower == 1)
                    {
                        theWheel.animation.spins = 3;
                    }
                    else if (wheelPower == 2)
                    {
                        theWheel.animation.spins = 8;
                    }
                    else if (wheelPower == 3)
                    {
                        theWheel.animation.spins = 15;
                    }
                    
                    // Disable the spin button so can't click again while wheel is spinning.
                    document.getElementById('spin_button').src       = "images/spin_off.png";
                    document.getElementById('spin_button').className = "";
                    
                    // Begin the spin animation by calling startAnimation on the wheel object.
                    theWheel.startAnimation();
                    
                    // Set to true so that power can't be changed and spin button re-enabled during
                    // the current animation. The user will have to reset before spinning again.
                    wheelSpinning = true;
                }
            }
            
            // -------------------------------------------------------
            // Function for reset button.
            // -------------------------------------------------------
            function resetWheel()
            {
                theWheel.stopAnimation(false);  // Stop the animation, false as param so does not call callback function.
                theWheel.rotationAngle = 0;     // Re-set the wheel angle to 0 degrees.
                theWheel.draw();                // Call draw to render changes to the wheel.
                
                //document.getElementById('pw1').className = "";  // Remove all colours from the power level indicators.
                //document.getElementById('pw2').className = "";
                //document.getElementById('pw3').className = "";
                
                wheelSpinning = false;          // Reset to false to power buttons and spin can be clicked again.
            }
            
            // -------------------------------------------------------
            // Called when the spin animation has finished by the callback feature of the wheel because I specified callback in the parameters.
            // -------------------------------------------------------
            function alertPrize()
            {
                // Get the segment indicated by the pointer on the wheel background which is at 0 degrees.
                var winningSegment = theWheel.getIndicatedSegment();

                document.getElementById('SpunLink').innerHTML=winningSegment.text;
                document.getElementById('SpunLink').href="./surprise.php?spin=" + winningSegment.ID;
                
                // Do basic alert of the segment text. You would probably want to do something more interesting with this information.
                //alert("Congratulations! You will be visiting: " + winningSegment.text + "  ("+winningSegment.ID+")");

                theWheel.stopAnimation(false);
                wheelSpinning = false;

                // Enable the spin button so can click again now wheel has stopped...
                document.getElementById('spin_button').src       = "images/spin_on.png";
                document.getElementById('spin_button').className = "clickable";

                //Delay 1500 ms
                setTimeout("location.href = 'surprise.php?spin=" + winningSegment.ID + "';",1500);
 


        }
        </script>


<!--
END SPINNER CODE  
--> 



    </body>
    <?php require("structure/footer.php"); ?>
</html>