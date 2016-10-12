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

	
	$id  = $_GET['Environment'] ;
        $id = str_replace("\"", "&quot;", $id);
        $id = str_replace('\'', "&apos;", $id);

	if (isset($_POST['confir'])) {

        // get the id of the environment
        $sqlIdEnv="select id from environment where name ='".$id."'";
        $resultIdEnv = $dbh->query($sqlIdEnv);
        $idEnv = $resultIdEnv->fetch();

        // get the description that has this environment
        $sqlIdDescription="select iddesc from description where idenv =".$idEnv[0];
        $resultIdDesc = $dbh->query($sqlIdDescription);

        while ($idDesc = $resultIdDesc->fetch()){
            // get all the middlewares that use this description
            $sqlMidd="select name from middleware where id_desc =".$idDesc[0];
            $resultMidd = $dbh->query($sqlMidd);
          
            while ($Midd = $resultMidd->fetch()){

                // select the data flow
                $sqlFlows="select idData from flows where middleware ='".$Midd[0]."'";
                $resultFlows = $dbh->query($sqlFlows);
                while ($flw = $resultFlows->fetch()){
                    // drop the data
                    $dropData = $dbh->query("delete from data where idData =".$flw[0]);
                }

                // drop all the flows that use this middlewares
                $sqlDropFlows="delete from flows where middleware ='".$Midd[0]."'";
                $resultDropFlows = $dbh->query($sqlDropFlows);

                // drop the middleware
                $dropMidd = $dbh->query("delete from middleware where name ='".$Midd[0]."'");
            }

            // get all the components that use this description
            $sqlComp="select name from component where id_desc =".$idDesc[0];
            $resultComp = $dbh->query($sqlComp);
            
            while ($Comp = $resultComp->fetch()){

                // drop the data flow
                $sqlFlows="select idData from flows where component_1 ='".$Comp[0]."' or component_2 = '".$Comp[0]."'";
                $resultFlows = $dbh->query($sqlFlows);
                while ($flw = $resultFlows->fetch()){
                    // drop the data
                    $dropData = $dbh->query("delete from data where idData =".$flw[0]);
                }

                // get all the flows that use this component
                $sqlDropFlows="delete from flows where component_1 ='".$Comp[0]."' or component_2 = '".$Comp[0]."'";
                $resultDropFlows = $dbh->query($sqlDropFlows);

                // drop the component
                $dropComp = $dbh->query("delete from component where name ='".$Comp[0]."'");
            }

            // get all the partners that use this description
            $sqlPart="select name from partner where id_desc =".$idDesc[0];
            $resultPart = $dbh->query($sqlPart);
            
            while ($Part = $resultPart->fetch()){
                // drop the data flow
                $sqlFlows="select idData from flows where source ='".$Part[0]."' or destination = '".$Part[0]."'";
                $resultFlows = $dbh->query($sqlFlows);
                while ($flw = $resultFlows->fetch()){
                    // drop the data
                    $dropData = $dbh->query("delete from data where idData =".$flw[0]);
                }

                // get all the flows that use this partner
                $sqlDropFlows="delete from flows where source ='".$Part[0]."' or destination = '".$Part[0]."'";
                $resultDropFlows = $dbh->query($sqlDropFlows);

                // drop the partner
                $dropPart = $dbh->query("delete from partner where name ='".$Part[0]."'");
            }
            
            // drop the description
            $dropComp = $dbh->query("delete from description where iddesc =".$idDesc[0]."");

        }

        $dropEnv = $dbh->query("delete from environment where name ='".$id."'");

		header('Location: ../View/environment.php');	

	} else if (isset($_POST['abort'])) {
			header('Location: ../View/environment.php');	
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
        <script type="text/javascript" src="../assets/js/scriptComponent.js"></script>

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
                <li class='logout'><a href="../Controller/logout.php"> <img src='../assets/img/logout.png' alt='Logout' />   Logout</a></li>
            </ul>
        </header>
    </br></br></br>
        
        <div class="Etat_gestion">
    
            <form method = "POST" action = "#" name = "form_delete_midd">
                 <div class="confirm">
                    <p>Do you really want to delete this environment ?</p>
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
                </footer></br>"
            );
        ?>
    
  </body>
</html>

