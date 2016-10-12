<?php

    /**
        editComponent.php 
            description --> Allows to search specific component and update or delete it
            Controllers --> updateComp_Controller.php
            Model --> None: The model is integrated with the controller because of the small siza of the query code
    **/
            
	session_start();
	if(!$_SESSION['owner'])
	{
		header('Location: ../index.php');
	}
	
    // Include the connexion of the DB in oreder to acces into the application
	require_once '../Config/BD_Conn.php';

    // add the query that gives the name owner
    require_once '../Model/owner_Model.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        
        <title>Flows</title>
        
        <!-- CSS stylesheet file -->
        <link rel="stylesheet" href="../assets/css/styles.css" />
		
		<link rel="stylesheet" media="screen and (min-width: 1300px)" href="../assets/css/largeStyle.css" />
        
        <!-- Including Google's Font Directory -->
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Handlee" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Black+Ops+One|Bungee+Shade|Oswald|Suez+One|Yatra+One" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:200" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Exo" rel="stylesheet">

        <!-- Including the icon of the page -->
        <link rel="icon" type="image/png" href="../assets/img/2.PNG" />
        
        <!-- Including the external scripts -->
        <script type="text/javascript" src="../assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="../assets/js/scriptComponent.js"></script>
    </head>
    
    <body>

       <!-- Header of the the page that containt the logo of engie and the name of the application and the menu -->
        <header>
            <div class='menuItems'>
                <img class='logo' src="../assets/img/logo-scroll.png" alt="engie">
                <h2>Flows</h2>
                </br>
            </div>  
            <ul id="menu">
                <li><a href="#" class='welcome'> <img src='../assets/img/user.png' alt='Welcome' /><?php echo("   Welcome ".strtoupper($owner[0]).""); ?></a></li>
                <li><a href="../View/flows.php" class='flows'> <img src='../assets/img/flows.png' alt='Flows' />   Flows</a></li>
                <li><a href="../View/middleware.php" class='middleware'> <img src='../assets/img/server.png' alt='Middleware' />   Middlewares</a></li>
                <li><a href="../View/component.php" class='component2'> <img src='../assets/img/component.png' alt='Components' />   Components</a></li>
                <li><a href="../View/partner.php" class='partner'> <img src='../assets/img/partner.png' alt='Partners'  />   Partners</a></li>
                <li><a href="../View/environment.php" class='environment'> <img src='../assets/img/environment.png' alt='Environments' />   Environments</a></li>
                <li class='logout'><a href="../Controller/logout.php"> <img src='../assets/img/logout.png' alt='Logout' />   Logout</a></li>
            </ul>
        </header>
    </br></br></br>
        
        <div class="addEdit_BTN" id='midBTN'>
            </br>
            <a href="../View/uploadFileComponents.php" id="a1"> <img src="../assets/img/add.png"> <span><b>Import components</b></span></a>
            <a href="../View/addComponent.php" id="a3"> <img src="../assets/img/a2.png"> <span><b>Add component</b></span></a>
            <a href="../View/editComponent.php" id="a2"> <img src="../assets/img/s21.png"> <span><b>Edit component</b></span></a>
        </div></br></br></br>
        
        <!-- Form that allows to serach, edit and delete a component -->
        <fieldset>
          <legend> Search </legend>
            <form method = "POST" action = "../Controller/updateComp_Controller.php" name = "form_update">
               
               <div class="label_div"><b>Name  : </b></div>
                <div class="input_container">
                    <input type="text" id="mid_name" name="mid" required onkeyup="autocomplet()">
                    <ul id="mid_list_id"></ul>
                </div>
              </br> </br>

              <input type='submit' name='edit' id='edit' value=" "  >
              <input type='submit' name='delete' id='delete' value=" "  >
                  
            </form>
        </fieldset>

        <!-- The footer of the page that containt the engie corporation -->
        <?php
          // get the fotter
          require_once 'footer_absolut.php';
        ?>
    
  </body>
</html>

