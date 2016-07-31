<?php
	$passwordSalt = "govhacked";
	$destroy = false;
	$loggedInID;

	if(isset($_GET["logout"]) && strcmp($_GET["logout"], "true") == 0){
		$destroy = true;
		session_destroy();
	}

	function isLoggedIn(){
		global $destroy;
		if($destroy == true){
			return false;
		}
		else if(isset($_SESSION["loggedIn"])){
			return true;
		}
		else{return false;}
	}
	function getFirstName(){
    	return $_SESSION["firstName"];
	}
	function getLastName(){
    	return $_SESSION["lastName"];
	}
	function printUsers(){
		$result = db_returnUsers();
		while($row = $result->fetch_assoc()){
    		echo $row['email'] . '<br />';
		}
	}
	function login($email, $password){
		global $passwordSalt, $loggedInID;
		$result = db_returnUsers();
		while($row = $result->fetch_assoc()){
    		if(strcmp($row['email'], $email) == 0){
    			//We have an email..
    			$hashedPassword = md5($passwordSalt.$password);
    			if(strcmp($row['password'], $hashedPassword) == 0){
    				//We are now logged in.. set the loggedInID
    				//echo "-in";
    				$loggedInID = $row["ID"];
    				$_SESSION["loggedIn"] = true;
    				$_SESSION["loggedInID"] = $loggedInID;
    				$_SESSION["firstName"] = $row["firstName"];
    				$_SESSION["lastName"] = $row["lastName"];
    				return true;
    			}
    		}
    		else{
    			return false;
    		}
		}
	}
	function register($email, $password, $firstName, $lastName){
		//echo $firstName.$lastName;
		global $passwordSalt;
		return db_insertUser($email, md5($passwordSalt.$password), $firstName, $lastName);
	}
?>