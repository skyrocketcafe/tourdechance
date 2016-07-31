<div class="navbar-wrapper">
    <div class="container">
        <nav class="navbar">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                        <span class="sr-only">Toggle</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" rel="home" href="#">
                        <img style="max-width:150px; margin-top: -7px;"
                        src="/images/provided/textlogo_upd.png">
                    </a>
                </div>
                <div id="navbar" class="navbar-collapse collapse">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">Spin</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="visualise.php">What's around</a></li>
                        <?php /*if (isLoggedIn()) { 
                            echo '<li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Welcome, '.getFirstName().' <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="surprise.php">Generate an Itinerary</a></li>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="?logout=true">Logout</a></li>
                                </ul>
                            </li>';
                        } else { 
                            echo '<li><a href="signup.php" style="float:right">Sign up</a></li>';
                            echo '<li style="float:right"><a href="login.php">Login</a></li>';
                         }*/ ?>
                        <li><a href="surprise.php">Pick For Me</a></li>
                        <li><a href="browse.php">Browse</a></li>
                        <li><a href="search.php">Search</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</div>