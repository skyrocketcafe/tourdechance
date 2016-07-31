<?php
	//die("dies");
	require("database.php");
	error_reporting(-1);
	ini_set('display_errors', 'On');
	//Credit https://developers.google.com/maps/articles/phpsqlajax_v3#createtable
	// Start XML file, create parent node

	$dom = new DOMDocument("1.0");
	$node = $dom->createElement("markers");
	$parnode = $dom->appendChild($node);

	$conn = new mysqli($databaseHost, $databaseUser, $databasePassword);
	$conn->select_db("TDC");

	// Check connection
	if ($conn->connect_error) {
		//Display crazy error!!!
    	die("OMG! The Database Connection failed: " . $conn->connect_error);
	} 

	$query = "SELECT * FROM govhack_CBR";
	if(!$result = $conn->query($query)){
    	die('Error running the query [' . $conn->error . ']');
	}

	header("Content-type: text/xml");

	// Iterate through the rows, adding XML nodes for each
	while ($row = $result->fetch_assoc()){
		//var_dump($row);
  		// ADD TO XML DOCUMENT NODE
  		$node = $dom->createElement("marker");
  		$newnode = $parnode->appendChild($node);
  		$newnode->setAttribute("name", utf8_encode($row['NAME']));
  		$newnode->setAttribute("lat", utf8_encode($row['LATITUDE']));
  		$newnode->setAttribute("lng", utf8_encode($row['LONGITUDE']));
  		$newnode->setAttribute("id", utf8_encode($row['ID']));
  		//$newnode->setAttribute("type", utf8_encode($row['TYPE']));
	}

	echo $dom->saveXML();
?>