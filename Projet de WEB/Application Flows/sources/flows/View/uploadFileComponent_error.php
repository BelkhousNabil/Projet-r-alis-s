<?php
    /**
        uploadFileComponent_error.php 
            description --> This page permit to notify the error when the user upload the generated file
            Controllers --> uploadFileComp_Controller.php
            Model --> None
    **/

	session_start();
	if(!$_SESSION['owner']){
		header('Location: ../index.php');
	}
	
    // Include the connexion of the DB in oreder to acces into the application
	require_once '../Config/BD_Conn.php';

    // Show error details
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Handlee" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Black+Ops+One|Bungee+Shade|Oswald|Suez+One|Yatra+One" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:200" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Exo" rel="stylesheet">

        <!-- Including the icon of the page -->
        <link rel="icon" type="image/png" href="../assets/img/2.PNG" />
        
        <!-- Script that allows to give the file name selected -->
        <script type="text/javascript">
            function GetNameFile() {
                name = document.getElementById("fileselect").value.replace(/.*[\/\\]/, '');
                document.getElementById("pAdd").innerHTML = name;
                if(name!="Auto-Generated-Comp.xlsx"){
                    document.getElementById("pAdd").style.color='red';
                }else{
                    document.getElementById("pAdd").style.color='#5d5d5d';
                }                
            }            
        </script>
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
        </div>
        
         <form id="upload" action="../Controller/uploadFileComp_Controller.php" method="POST" enctype="multipart/form-data">

            <fieldset id='uploadField'>
                <div>               
                    <div class="addEdit_BTN">
                        <a href="../Controller/fileGeneratorComp_Controller.php" id="a4"> <img src="../assets/img/download.png"> <span><b>Download xlsx template file</b></span></a></br></br></br>
                    </div>

                    <div class="input-file-container">  
                        <input class="input-file" id="fileselect" name="fileselect" type="file" onchange="GetNameFile()">
                        <label tabindex="0" for="fileselect" class="input-file-trigger" id='btnChoose'><b>Choose file</b></label>
                    </div>
                  <p class="file-return" id='pAdd'></p>
                </div>
            </fieldset>

            <input type='submit' name='uploadFlows' id='uploadFlows' value="Add components" style='width:50%;'>
        </form>

        <!-- The error message -->
        <div class = "Error_upload"> 
          <p><b>Please choose the xlsx file generated</b></p>
        </div>

        <!-- The footer of the page that containt the engie corporation -->
        <?php
          // get the fotter
          require_once 'footer_absolut.php';
        ?>
        
  </body>
</html>
