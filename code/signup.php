<?php require("php/imports.php"); ?>
<?php
    //ERROR LOGIC
    $displayError = false;
    $matchError = false;
    $createdAcccount = false;

    if(strcmp($_POST["password"], $_POST["repeatPassword"]) != 0){
        //Passwords don't match..
        $matchError = true;
    }
    else if(isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["repeatPassword"]) && isset($_POST["firstName"]) && isset($_POST["lastName"])){
        if(register($_POST["email"], $_POST["password"], $_POST["firstName"], $_POST["lastName"]) == true){
            //Awesome.. Send email and redirect..
            $createdAcccount = true;

            //Send email..
            mail( $_POST["email"] , "Tour de Chance Account creation successful " , "Hi, ".$_POST["firstName"]."\nYour Tour de Chance account has been succefully created and activated. Have a great time around Canberra :)" );
            //Redirect..
            $virtualHost = "canberra";
            $serverAddress = "tourdechance.net";

            header( 'Location: http://'.$virtualHost.".".$serverAddress.'/?acd=true' ) ;

        }
        else{
            //Display the error message and do not redirect..
            $displayError = true;
        }
    }

?>
<html>
    <head>  
            <title>Tour de Chance - Signup</title>
            <?php require("structure/header.php"); ?>
    </head>
    <body>
        <?php require("structure/navbar.php"); ?>
        <div class="jumbotron" style="margin: 0px;">
            <div class="container">
                <span class="white">
                    <h1>Sign up</h1>
                </span>
            </div>
        </div>
        <div class="center">
            <?php if($displayError){
                echo '<div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                There was an error creating your account, maybe you already have one? If so, <a href="login.php">log in.</a>
                </div>';
            } ?>
            <?php if($matchError){
                echo '<div class="alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                The provided passwords don\'t match. Please try again.
                </div>';
            } ?>

            <div class="center">
                <img src="images/provided/textlogo.png"></img>
            </div>
            
            <form class="form-horizontal" method="POST">
                <fieldset>
                    <legend>Signup</legend>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="firstName">First Name</label>  
                        <div class="col-md-4">
                            <input id="firstName" name="firstName" type="text" placeholder="" class="form-control input-md" required="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-4 control-label" for="lastName">Last Name</label>  
                        <div class="col-md-4">
                            <input id="lastName" name="lastName" type="text" placeholder="" class="form-control input-md" required="">
                        </div>
                    </div>
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
                        <label class="col-md-4 control-label" for="repeatPassword">Password (Again)</label>
                        <div class="col-md-4">
                            <input id="repeatPassword" name="repeatPassword" type="password" placeholder="" class="form-control input-md" required="">
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