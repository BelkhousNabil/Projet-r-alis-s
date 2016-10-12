<?php
	session_start();
	if(!$_SESSION['owner'])
	{
		header('Location: ../index.php');
	}
	require_once '../Config/BD_Conn.php';
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// add the query that gives the name owner
    require_once '../Model/owner_Model.php';

	
	$id  = $_GET["mid"] ;
        $id = str_replace("\"", "&quot;", $id);
        $id = str_replace('\'', "&apos;", $id);


	if (isset($_POST['confir'])) {
        // select the id description of the middleware that we want to delete
		$selectId = $dbh->query("select id_desc from middleware where name ='".$id."'");
		$result1 = $selectId->fetch();

        // drop the description of that middleware
		$dropMidd = $dbh->query("delete from description where iddesc ='".$result1[0]."'");

        // select the data flows that contain the middleware that we want to delete
        $selectDataFlow = $dbh->query("select idData from flows where middleware ='".$id."'");
        while($resultDataFlow = $selectDataFlow->fetch()){
            // drop the data flows that contain that middleware
            $dropData = $dbh->query("delete from data where idData ='".$resultDataFlow[0]."'");
        }

        // frop the flows that contain that middleware
        $dropFlow = $dbh->query("delete from flows where middleware ='".$id."'");

        // delete the middleware
        $dropMidd = $dbh->query("delete from middleware where name ='".$id."'");

		header('Location: ../View/middleware.php');	

	} else if (isset($_POST['abort'])) {
			header('Location: ../View/middleware.php');	
	}

		
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        
        <title>Flows</title>
        
        <!-- Our CSS stylesheet file -->
        <link rel="stylesheet" href="../assets/css/styles.css" />
		
		<link rel="stylesheet" media="screen and (min-width: 1300px)" href="../assets/css/largeStyle.css" />
        
        <!-- Including the Lobster font from Google's Font Directory -->
        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Lobster" />
        <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Handlee" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Black+Ops+One|Bungee+Shade|Oswald|Suez+One|Yatra+One" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:200" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Exo" rel="stylesheet">

        <script type="text/javascript" src="../assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="../assets/js/script.js"></script>

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
                <li><a href="../View/middleware.php" class='middleware2'> <img src='../assets/img/server.png' alt='Middleware' />   Middlewares</a></li>
                <li><a href="../View/component.php" class='component'> <img src='../assets/img/component.png' alt='Components' />   Components</a></li>
                <li><a href="../View/partner.php" class='partner'> <img src='../assets/img/partner.png' alt='Partners'  />   Partners</a></li>
                <li><a href="../View/environment.php" class='environment'> <img src='../assets/img/environment.png' alt='Environments' />   Environments</a></li>
                <li class='logout'><a href="../Controller/logout.php"> <img src='../assets/img/logout.png' alt='Logout' />   Logout</a></li>
            </ul>
        </header>
    </br></br></br>
        
        <div class="addEdit_BTN" id='midBTN'>
            </br>
            <a href="../View/uploadFileMiddlewares.php" id="a1"> <img src="../assets/img/add.png"> <span><b>Add middlewares file</b></span></a>
            <a href="../View/addMiddleware.php" id="a3"> <img src="../assets/img/a2.png"> <span><b>Add middleware</b></span></a>
            <a href="../View/editMiddleware.php" id="a2"> <img src="../assets/img/s21.png"> <span><b>Edit middleware</b></span></a>
        </div></br></br></br>
        
        <div class="Etat_gestion">
    
            <form method = "POST" action = "#" name = "form_delete_midd">
                 <div class="confirm">
                    <p>Do you really want to delete this middleware ?</p>
                    <input type='submit' name='confir' id='confir' value="Confirm"> 
                    <input type='submit' name='abort' id='abort' value="Abort"> 
                </div>
                
            </form>     

        </div>

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

