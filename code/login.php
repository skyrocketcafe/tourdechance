<?php require("php/imports.php"); ?>
<?php
    $displayError = false;
    if(isset($_POST["email"]) && isset($_POST["password"])){
        //Attempt to log in..
        if(login($_POST["email"], $_POST["password"]) == true){
            //The user has validly logged in..
            //YAY! Do Something...
            $virtualHost = "canberra";
            $serverAddress = "tourdechance.net";
            header( 'Location: http://'.$virtualHost.".".$serverAddress.'/' ) ;
        }
        else{
            //Display the error message and do not redirect..
            $displayError = true;
        }
    }
?>

<html>
    <head>	
		    <title>Tour de Chance - Login</title>
		    <?php require("structure/header.php"); ?>
    </head>
    <body>
        <?php require("structure/navbar.php"); ?>
        <div class="jumbotron" style="margin: 0px;">
            <div class="container">
                <span class="white">
                    <h1>Log in</h1>
                </span>
            </div>
        </div>
        <div class="center">
            <?php if($displayError){
                echo '<div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                It appears we don\'t have any record of you! Please try again, or <a href="signup.php">sign up.</a>
                </div>';
            } ?>

            <div class="center">
                <img src="images/provided/textlogo.png"></img>
            </div>
            
            <form class="form-horizontal" method="POST">
                <fieldset>
                    <legend>Login</legend>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="email">Email Address</label>  
                        <div class="col-md-4">
                            <input id="email" name="email" type="text" placeholder="" class="form-control input-md" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="password">Password</label>
                        <div class="col-md-4">
                            <input id="password" name="password" type="password" placeholder="" class="form-control input-md" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="button"></label>
                        <div class="col-md-4">
                            <input type="submit" id="button" name="button" class="btn btn-primary"></input>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </body>
    <?php require("structure/footer.php"); ?>
</html>