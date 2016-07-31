<?php
	//Random Site Generator
	//require("database.php");

	$rand_ID = "Not Provided";
	$rand_NAME = "Not Provided";
	$rand_CATEGORY = "Not Provided";
	$rand_TYPE = "Not Provided";
	$rand_TAGS = "Not Provided";
	$rand_DESCRIPTION = "Not Provided";
	$rand_ADDRESS1 = "Not Provided";
	$rand_SUBURB = "Not Provided";
	$rand_STATE = "Not Provided";
	$rand_POSTCODE = "Not Provided";
	$rand_REGION = "Not Provided";
	$rand_LATITUDE = "Not Provided";
	$rand_LONGITUDE = "Not Provided";
	$rand_PHONE = "Not Provided";
	$rand_WEBSITE = "Not Provided";
	$rand_FREE = "";
	$rand_RATING = "Not Provided";

	$id_start = 100000;
	$id_end = 0;


	$sql = "SELECT *
    		FROM govhack_CBR";

    if(!$result = $conn->query($sql)){
    	die('Error running the query [' . $conn->error . ']');
	}

	while($row = $result->fetch_assoc()){
		if($row["ID"] > $id_end){
			$id_end = $row["ID"];
			//echo $id_end."<br>";
		}
	}

	$randID = "";
	if(isset($_GET["spin"])){
		$randID = $_GET["spin"];
	}
	else{
		$randID = rand ( $id_start , $id_end );
	}
	//echo $randID;
	//$randID = 100143;
	//echo $randID;

	if(!$result = $conn->query($sql)){
    	die('Error running the query [' . $conn->error . ']');
	}

	while($row = $result->fetch_assoc()){
		if($row["ID"] == $randID){
			$rand_ID = $row["ID"];
			$rand_NAME = $row["NAME"];
			$rand_CATEGORY = $row["CATEGORY"];
			$rand_TYPE = $row["TYPE"];
			$rand_TAGS = $row["TAGS"];
			$rand_DESCRIPTION = $row["DESCRIPTION"];
			$rand_ADDRESS1 = $row["ADDRESS1"];
			$rand_SUBURB = $row["SUBURB"];
			$rand_STATE = $row["STATE"];
			$rand_POSTCODE = $row["POSTCODE"];
			$rand_REGION = $row["REGION"];
			$rand_LATITUDE = $row["LATITUDE"];
			$rand_LONGITUDE = $row["LONGITUDE"];
			$rand_PHONE = $row["PHONE"];
			$rand_WEBSITE = $row["WEBSITE"];
			$rand_FREE = $row["FREE"];
			$rand_RATING = $row["RATING"];
		}
	}

?>