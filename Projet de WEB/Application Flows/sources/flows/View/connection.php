<?php
    
    /**
        connection.php 
            description --> This is the login form
            Controllers --> connexion_Controller.php
            Model --> user_Model.php
    **/
            
    // Include the connexion of the DB in oreder to acces into the application
	require_once '../Config/BD_Conn.php';
?>

<!DOCTYPE html>
<html >
    <head>
        <meta charset="UTF-8">
        <title>Flows</title>
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="../assets/css/style_index.css" />
        <link href="https://fonts.googleapis.com/css?family=Exo" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:200" rel="stylesheet">

        <!-- Including the icon of the page -->
        <link rel="icon" type="image/png" href="../assets/img/2.png" />
    </head>

    <body>

        <header>
            <div class='menuItems'>
                <img class='logo' src="../assets/img/logo-scroll.png" alt="engie">
                <h2 style='margin-left:38%;'>Flows</h2>
                </br>
            </div>  
            
            <li style='float:right;margin-top:-15px;'><a href="../index.php"> <img src='../assets/img/home.png' alt='Welcome' />Home</a></li>
            
        </header>
        </br></br></br></br></br>

        <form method = "POST" action = "../Controller/connexion_Controller.php" name = "form_connexion">
            <div class="login-block">
                <h1>Login</h1>
                <input type="text" value="" placeholder="Username" id="username" name='log' />
                <input type="password" value="" placeholder="Password" id="password" name='mp' />

                <input type='submit' name='conex' id='conex' value="Submit"  >
                
            </div>
        </form>
    </br>
        <!-- The footer of the page that containt the engie corporation -->
        <footer style='position:absolute; bottom:0;'>
            <div class='bas'>
                  
                <div id='corp' style='display: inline;'> </br>
                    <p><b>© 2016 ENGIE IT Corporation. All Rights Reserved</b></p> 
                    <a href='mailto:mehdi.mtougui@engie.com'> <img src='../assets/img/outlook.png' alt='Contact' /></a> <a class='contact' href='mailto:mehdi.mtougui@engie.com'>Contact</a>
                </div>
                <img src='../assets/img/flux.PNG'>
            </div>
        </footer>
    </br>
    </body>
</html>









