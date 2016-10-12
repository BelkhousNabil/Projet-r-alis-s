<?php
    
    /**
        Index.php 
            description --> This is the gate of the application
            Controllers --> None
            Model --> None
    **/
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    

    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:200" rel="stylesheet">
    
    <!-- Including the icon of the page -->
    <link rel="icon" type="image/png" href="assets/img/2.png" />

    <link href='http://fonts.googleapis.com/css?family=Montserrat+Alternates:400,700' rel='stylesheet' type='text/css'>
    
    
    
</head>

<body data-spy="scroll" data-target="#navbar" data-offset="0" >
    <header id="header" role="banner">
        <div class="container" style="width: 1000%; margin:0; padding:0;">
            <div id="navbar" class="navbar navbar-default" style="width: 150%;">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="http://www.engie.com/" target="_blank"></a>
                </div>
                <div class="collapse navbar-collapse" >
                    <ul class="nav navbar-nav" style="margin-left:12%;">
                        <li class="active" ><a href="#main-slider"><i class="icon-home"></i></a></li>
                        <li><a href="#services">Description</a></li>
                        <li><a href="statistics.php">Statistics</a></li>
                        <li><a href="View/search.php">Search</a></li>
                        <!--<li><a href="graphe/graphics/halfviz/schema_Client.php">Graphic</a></li>-->
                        <li><a href="View/connection.php">Login</a></li>
                    </ul>

                    <div class='flows' style='margin-left:30%;'>
                        <span>Flows</span>      
                    </div>

                </div>
            </div>
        </div>
    </header>

    <section id="main-slider" class="carousel">
        <div class="carousel-inner">
            <div class="item active">
                <div class="container">
                    <div class="carousel-content">
                        <h1></h1>
                        <p class="lead"><br></p>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="container">
                    <div class="carousel-content">
                        <h1></h1>
                        <p class="lead"><br></p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="services">
        <div class="container">
            <div class="box first">
                <div class="row">
                    <div class="col-md-4 col-sm-6">
                        <div class="center">
                            <i class="icon-md icon-color1"></i>
                            <h4>Flows Manager</h4>
                            <p>With this application, the monitoring of the flows will be easier because of the sumplicity of the add, update and delete features</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="center">
                            <i class="icon-md icon-color2"></i>
                            <h4>Middleware Manager</h4>
                            <p>With all the changes that can affect middlewares, this application will make you life easier to manage middlewares</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="center">
                            <i class="icon-md icon-color3"></i>
                            <h4>Partner Manager</h4>
                            <p>The updating, adding and deleting features will help you to manage the partners that are in relation with the flows</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="center">
                            <i class="icon-md icon-color4"></i>
                            <h4>Component Manager</h4>
                            <p>All of components will be managed with the application in order to keep the flows information consistency</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="center">
                            <i class="icon-md icon-color5"></i>
                            <h4>Search flows</h4>
                            <p>The search flows device will permit to display flows information using the source, the destination, the middleware or the components that are in the flows</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6">
                        <div class="center">
                            <i class="icon-md icon-color6"></i>
                            <h4>Contact team manager flows</h4>
                            <p>This appplication helps clients to contacts the team manager flows in order to notify a problem on their flows information</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="portfolio">
        <div class="container">
            <div class="box">
                
            </div>
        </div>
    </section>

    <!-- The footer of the page that containt the engie corporation -->
    <footer>
        <div class='bas'>
            <div id='corp' style='display: inline;'> </br>
                <p><b>© 2016 ENGIE IT Corporation. All Rights Reserved</b></p> 
                <a href='mailto:mehdi.mtougui@engie.com'> <img src='assets/img/outlook.png' alt='Contact' /></a> <a class='contact' href='mailto:mehdi.mtougui@engie.com'></b>Contact</b></a>
            </div>
            <img src='assets/img/flux.PNG' />
        </div>
    </footer>
</br>
</body>
</html>








