<!--
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
        <title>HTML5 Canvas Winning Wheel</title>
        <link rel="stylesheet" href="main.css" type="text/css" />
        <script type="text/javascript" src="Winwheel.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.19.0/TweenMax.min.js"></script>



    </head>
    <body>

 
 
   <?php

        //ini_set('display_errors', 'On'); // turn on error reporting
        //error_reporting(E_ALL);

        require("../php/database.php"); //Imports my database connection...
        
        
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
            $catCount = 0;
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

            $sql = 'SELECT ID,NAME FROM govhack_CBR WHERE CATEGORY="'.$category.'";';

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
                        echo '"'.$row["NAME"].'"';
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
            $catIndex = 0;
            //$numberOfCats = numberOfCategories(1);
            $numberOfCats = 5;
            while ($catIndex < $numberOfCats) {

                echo "function draw_wheel".$catIndex."()\n{\n"; 
                echo "\t\t\ttheWheel = new Winwheel({\n";
                echo "\t\t\t'outerRadius'  : 234,\n";
                echo "\t\t\t'textFontSize' : 12,\n";


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


        <div align="center">
            <h1>Winwheel.js example wheel</h1>
            <p><?php getField("100001","NAME"); ?>
                
            </p>
            <p>
                
            </p>
            <br />
            <p>Choose a power setting then press the Spin button. You will be alerted to the prize won when the spinning stops.</p>
            <br />
            <table cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td>
                    <div class="power_controls">
                        <br />
                        <br />
                        <table class="power" cellpadding="10" cellspacing="0">

                            <tr>
                                <th width="78" align="center">Select Category</th>
                            </tr>
                            <?php buildCategoryList() ?>
 
                        </table>
                        <br />
                        <img id="spin_button" src="spin_off.png" alt="Spin" onClick="startSpin();" />
                        <br /><br />
                        &nbsp;&nbsp;<a href="#" onClick="resetWheel(); return false;">Play Again</a><br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(reset)
                    </div>
                </td>
                <td width="500" height="700" class="the_wheel" align="center" valign="center">
                    <canvas id="canvas" width="500" height="500">
                        <p style="{color: white}" align="center">Sorry, your browser doesn't support canvas. Please try another.</p>
                    </canvas>
                </td>
            </tr>
        </table>
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

            draw_wheel0();
           

              function draw_wheel(catIndex)
                {

                    // Create new wheel object specifying the parameters at creation time.
                    theWheel = new Winwheel({
                        
                        'outerRadius'  : 234,
                        'textFontSize' : 12,

                        //gutsArray[catIndex];
                        
                        'animation' :
                        {
                            'type'     : 'spinToStop',
                            'duration' : 5,
                            'spins'    : 8,
                            'callbackFinished' : 'alertPrize()'
                        }
                    });
            } // end function draw_wheel

            <?php wheelGutsArrayPHP() ?>
    
                
                // Vars used by the code in this page to do power controls.
                //var wheelPower    = 0;
                //var wheelSpinning = false;
            
            

            // -------------------------------------------------------
            // Function to handle the onClick on the power buttons.
            // -------------------------------------------------------
            function powerSelected(powerLevel)
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
                    
                    // Now light up all cells below-and-including the one selected by changing the class.
                    if (category = 1)
                    {
                        document.getElementById('cat1').className = "cat1";
                    }
                        
                    if (category = 2)
                    {
                        document.getElementById('cat2').className = "cat2";
                    }
                        
                    if (category = 3)
                    {
                        document.getElementById('cat3').className = "cat3";
                    }
                    if (category = 4)
                    {
                        document.getElementById('cat4').className = "cat4";
                    }
                                      if (category = 3)
                    {
                        document.getElementById('cat5').className = "cat5";
                    }
                    
                    // Set wheelPower var used when spin button is clicked.
                    //wheelPower = powerLevel;
                    
                    // Light up the spin button by changing it's source image and adding a clickable class to it.
                    document.getElementById('spin_button').src = "spin_on.png";
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
                    document.getElementById('spin_button').src       = "spin_off.png";
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
                
                // Do basic alert of the segment text. You would probably want to do something more interesting with this information.
                alert("You have won " + winningSegment.text + "  ("+winningSegment.ID+")");
            }
        </script>
    </body>
</html>