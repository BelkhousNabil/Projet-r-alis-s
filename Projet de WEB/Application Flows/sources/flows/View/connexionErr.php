<?php
    /**
        ConnexionErr.php 
            description --> View that permit to treat errors authentification
            Controllers --> connexion_Controller.php
            Model --> user_Model.php
    **/

?>


<!DOCTYPE html>
<html>
    <html>
    <head>
        <meta charset="utf-8" />
        
        <title>Flows</title>
        
        <!-- CSS stylesheet file -->
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="../assets/css/style_index.css" />
        <link href="https://fonts.googleapis.com/css?family=Exo" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:200" rel="stylesheet">

        <!-- Including the icon of the page -->
        <link rel="icon" type="image/png" href="../assets/img/2.PNG" />
        
    </head>
    
    <body>

        <!-- Header of the the page that containt the logo of engie and the name of the application -->
        <header>
            <div class='menuItems'>
                <img class='logo' src="../assets/img/logo-scroll.png" alt="engie">
                <h2 style='margin-left:38%;'>Flows</h2>
                </br>
            </div>  
            
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

        <!-- Error message -->
        <div class="Err_conex">
            <p>Authentification error, please check your email and your password</p>
        </div>

        <!-- The footer of the page that containt the engie corporation -->
        <?php
          // get the fotter
          require_once 'footer_absolut.php';
        ?>
            
    </body>
</html>

