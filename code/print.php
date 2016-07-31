<html>
	<head>
		<title>Print</title>
	</head>

	<?php
		require("php/database.php");

		$cache = $_GET["pk"];
		$cache = explode("@", $cache);

        $id0 = explode("|", $cache[0])[2];
        $id1 = explode("|", $cache[1])[2];
        $id2 = explode("|", $cache[2])[2];

    ?>


	<body>
		<img src="images/provided/textlogo_upd.png"></img>
		<div style="padding:20px;">
			<h3>Your Tour de Chance Itinerary consists of the following three destinations..</h3>
			<h4><?php echo info_for_field($id0, "NAME"); ?></h4>
			<p style="padding-left: 30px; padding-right: 30px;"><?php echo info_for_field($id0, "DESCRIPTION"); ?></p>
			<p style="padding-left: 30px; padding-right: 30px;"><b>Does this destination cost money: </b>
			<?php 
				$response = info_for_field($id0, "FREE"); 
				if($response == ""){
					echo "Unknown";
				}
				else if($response == "Y"){
					echo "Nope. Totally Free.";
				}
			?></p>
			<iframe width="600" height="400" src=<?php echo "'https://www.google.com/maps?q=".info_for_field($id0, "LATITUDE").',%20'.info_for_field($id0, "LONGITUDE")."&amp;z=14&amp;t=m&amp;output=embed'" ?> style="border: 0px solid rgb(0, 0, 0); border-image: none; padding-left: 30px;"></iframe>

			<h4><?php echo info_for_field($id1, "NAME"); ?></h4>
			<p style="padding-left: 30px; padding-right: 30px;"><?php echo info_for_field($id1, "DESCRIPTION"); ?></p>
			<p style="padding-left: 30px; padding-right: 30px;"><b>Does this destination cost money: </b>
			<?php 
				$response = info_for_field($id1, "FREE"); 
				if($response == ""){
					echo "Unknown";
				}
				else if($response == "Y"){
					echo "Nope. Totally Free.";
				}
			?></p>
			<iframe width="600" height="400" src=<?php echo "'https://www.google.com/maps?q=".info_for_field($id1, "LATITUDE").',%20'.info_for_field($id1, "LONGITUDE")."&amp;z=14&amp;t=m&amp;output=embed'" ?> style="border: 0px solid rgb(0, 0, 0); border-image: none; padding-left: 30px;"></iframe>

			<h4><?php echo info_for_field($id2, "NAME"); ?></h4>
			<p style="padding-left: 30px; padding-right: 30px;"><?php echo info_for_field($id2, "DESCRIPTION"); ?></p>
			<p style="padding-left: 30px; padding-right: 30px;"><b>Does this destination cost money: </b>
			<?php 
				$response = info_for_field($id2, "FREE"); 
				if($response == ""){
					echo "Unknown";
				}
				else if($response == "Y"){
					echo "Nope. Totally Free.";
				}
			?></p>
			<iframe width="600" height="400" src=<?php echo "'https://www.google.com/maps?q=".info_for_field($id2, "LATITUDE").',%20'.info_for_field($id2, "LONGITUDE")."&amp;z=14&amp;t=m&amp;output=embed'" ?> style="border: 0px solid rgb(0, 0, 0); border-image: none; padding-left: 30px;"></iframe>

			<br></br>
			<br></br>
			<b>This page is printer friendly - please consider the environment before printing</b>
			<br>
			<b>Tour de Chance, Govhack2016</b>
		</div>
	</body>
</html>