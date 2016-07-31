<?php
	//Google street view image access functions
	
	$imageSizeX = 640;
	$imageSizeY = 640;
	$apikey = "AIzaSyBV5VSXH5YEUdrMZhGdVNc1C2objtjJTxk";

	//$url = "https://maps.googleapis.com/maps/api/streetview?size=400x400&location=40.720032,-73.988354&fov=90&heading=235&pitch=10&key="
	function getImageURL($longitude, $latitude, $pitch){
		global $imageSizeY, $imageSizeX, $apikey, $url;
		echo "https://maps.googleapis.com/maps/api/streetview?size=".$imageSizeX."x".$imageSizeY."&location=".$latitude.",".$longitude."&fov=180&heading=235&pitch=".$pitch."&key=".$apikey;

	}
?>