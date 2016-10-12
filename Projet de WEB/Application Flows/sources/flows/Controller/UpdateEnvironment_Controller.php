<?php

  /**
        UpdateEnvironment.php 
            description --> This page permit to edit an environment
            Controllers --> 
            Model --> 
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


  $_SESSION['oldEnvName'] = $_GET['Environment'];
    $_SESSION['oldEnvName'] = str_replace("\"", "&quot;", $_SESSION['oldEnvName']);
    $_SESSION['oldEnvName'] = str_replace("'", "&apos;", $_SESSION['oldEnvName']);

  if(isset($_POST['mod_c'])){
      
      $name=$_SESSION['oldEnvName'];
        $name = str_replace("\"", "&quot;", $name);
        $name = str_replace('\'', "&apos;", $name);

      //update the flows components, partners and middlewares
      $select = "select name from component where name like '%".$name."'";
      $resultSelect = $dbh->query($select);

      while($resultat = $resultSelect->fetch()){
        // change the name component because of the updating of the name environment
        $newName = str_replace($_SESSION['oldEnvName'], $_POST['name_mid'], $resultat[0]); 

        // update the component
        $sqlUpdate="update component set name='".trim($newName)."' where name = '".$resultat[0]."'"; 
        $resultUpdate = $dbh->query($sqlUpdate);

        // update the flows that contain this component like fist component
        $sqlUpdateFlw="update flows set component_1='".trim($newName)."' where component_1 = '".$resultat[0]."'"; 
        $resultUpdateFlw = $dbh->query($sqlUpdateFlw);

        // update the flows that contain this component like seconde component
        $sqlUpdateFlw="update flows set component_2='".trim($newName)."' where component_2 = '".$resultat[0]."'"; 
        $resultUpdateFlw = $dbh->query($sqlUpdateFlw);
      }

      // Get the partner that contain on their name the environment name
      $select = "select name from partner where name like '%".$name."'";
      $resultSelect = $dbh->query($select);

      while($resultat = $resultSelect->fetch()){
        // change the name partner because of the updating of the name environment
        $newName = str_replace($_SESSION['oldEnvName'], $_POST['name_mid'], $resultat[0]); 

        // update the name partner
        $sqlUpdate="update partner set name='".trim($newName)."' where name = '".$resultat[0]."'";
        $resultUpdate = $dbh->query($sqlUpdate);

        // update the flows that contain this partner like source
        $sqlUpdateFlw="update flows set source='".trim($newName)."' where source = '".$resultat[0]."'"; 
        $resultUpdateFlw = $dbh->query($sqlUpdateFlw);

        // update the flows that contain this partner like destination
        $sqlUpdateFlw="update flows set description='".trim($newName)."' where description = '".$resultat[0]."'"; 
        $resultUpdateFlw = $dbh->query($sqlUpdateFlw);
      }

      // Get the middleware that contain on their name the environment name
      $select = "select name from middleware where name like '%".$name."'";
      $resultSelect = $dbh->query($select);

      while($resultat = $resultSelect->fetch()){
        // change the name middleware because of the updating of the name environment
        $newName = str_replace($_SESSION['oldEnvName'], $_POST['name_mid'], $resultat[0]); 

        // update the name middleware
        $sqlUpdate="update middleware set name='".trim($newName)."' where name = '".$resultat[0]."'";
        $resultUpdate = $dbh->query($sqlUpdate);

        // update the flows that contain this middleware
        $sqlUpdateFlw="update flows set middleware='".trim($newName)."' where middleware = '".$resultat[0]."'"; 
        $resultUpdateFlw = $dbh->query($sqlUpdateFlw);
      }

      // get the environments name
      $sqlUpdate="update environment set name='".trim($_POST['name_mid'])."' where name = '".$_SESSION['oldEnvName']."'";
      $resultUpdate = $dbh->query($sqlUpdate);

      header('Location: ../View/environment.php');
  }
  

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
                <li><a href="../View/component.php" class='component'> <img src='../assets/img/component.png' alt='Components' />   Components</a></li>
                <li><a href="../View/partner.php" class='partner'> <img src='../assets/img/partner.png' alt='Partners'  />   Partners</a></li>
                <li><a href="../View/environment.php" class='environment2'> <img src='../assets/img/environment.png' alt='Environments' />   Environments</a></li>
                <li class='logout'><a href="../Controller/logout.php" > <img src='../assets/img/logout.png' alt='Logout' />   Logout</a></li>
            </ul>
        </header>
    </br></br></br>
        
        <!-- The form that allows to add an environment -->
        <fieldset style='width:30%;'>
          <form method = "POST" action = "" name = "form_add_comp">
              <label style='margin-left:20px;' ><b>Name</b></label> </td>
              <?php echo("<input required type='text' name='name_mid' value='".$_GET['Environment']."' style='width:200px;'>"); ?>
              <input type='submit' name='mod_c' id='mod_c' value="Modify" style='margin-left:0px;' >
              
          </form>
        </fieldset>
        
        
        <?php
            echo("
                </br>
                <footer style='position:absolute; bottom:0;'>
                    <div class='bas'>
                          
                      <div id='corp' style='display: inline;'> </br>
                          <p><b>© 2016 ENGIE IT Corporation. All Rights Reserved</b></p> 
                          <a href='mailto:mehdi.mtougui@engie.com'> <img src='../assets/img/outlook.png' alt='Contact' /></a> <a class='contact' href='mailto:mehdi.mtougui@engie.com'>Contact</a>
                      </div>
                      <img src='../assets/img/flux.PNG' style='margin-top:10px;'>
                    </div>
                </footer>"
            );
        ?>
    
  </body>
</html>

