<?php
	//API FOR OTHER SERVICES TO USE OUR DATABASE..

	$dbHost = "localhost";
	$dbUser = "root";
	$dbPass = "govhack2016";
	$dbTable = "govhack_CBR";

	$conn = new mysqli($dbHost, $dbUser, $dbPass);
	$conn->select_db("TDC");

	// Check connection
	if ($conn->connect_error) {
		//Display crazy error!!!
    	die("OMG! The Database Connection failed: " . $conn->connect_error);
	} 

	$sql = "SELECT *
    		FROM govhack_CBR";

	$result = $conn->query($sql);
	$found = 0;
	
	if(isset($_GET["id"])){
		if(isset($_GET["field"])){
			while($row = $result->fetch_assoc()){
    			
				if(array_key_exists ( $_GET["field"] , $row )){
					if($_GET["id"] == $row["ID"]){
						echo $row[$_GET["field"]];
						$found = 1;
						die();
					}
				}
				else{
					echo "You are asking for something that does not exist.";
					die();
				}
			}
			$found = 2;
		}
		else{
			echo "What are you asking for?";
		}
	}
	else{
		echo "Bouncer: You don't have any ID. Access Denied.<br>";
		echo "ask.php?id=(Your ID)&field=(What Field)";
	}

	if($found == 2){
		echo "No data with that ID was found.";
	}
?>