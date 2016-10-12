<?php

  /**
        environment.php 
            description --> This page permit add new environments
            Controllers --> None
            Model --> None
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

  if(isset($_POST['add_c'])){
      $nameEnv = $_POST['name_mid'];
        $nameEnv = str_replace("\"", "&quot;", $nameEnv);
        $nameEnv = str_replace("'", "&apos;", $nameEnv);

      $sqlenv="select count(*) from environment where name='".$nameEnv."'";
      $resultenv = $dbh->query($sqlenv);
      $envRep = $resultenv->fetch();

      if($envRep[0]==0){
        $sqlMaxId="select max(id) from environment";
        $resultrechMaxId = $dbh->query($sqlMaxId);
        $MaxId = $resultrechMaxId->fetch();
        $id = $MaxId[0]+1;
        $sqlInsert = "insert into environment values ($id,'".trim($nameEnv)."')";
        $resultData = $dbh->query($sqlInsert);
      }else{
          header('Location: ../View/environment_error.php');
      }
      
  }
  
  // Get the environment
  require_once '../Model/getEnvironment_Model.php';

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

        <link href="https://fonts.googleapis.com/css?family=Exo" rel="stylesheet">

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
        
        <!-- The form that allows to add a component -->
        <fieldset style='width:30%;'>
          <form method = "POST" action = "" name = "form_add_comp">
              <label style='margin-left:20px;' ><b>Name</b></label> </td>
              <input required type="text" name="name_mid" style='width:200px;'>
              <input type='submit' name='add_c' id='add_c' value="Add" style='margin-left:0px;' >
              <div class = "Err_flows" style='width:80%;' > 
                <p><b>This environment already exists</b></p>
              </div>
          </form>
        </fieldset>
        
        <fieldset style='width:30%; margin-top:-40px;'>
          <table class="table_add" style='margin-left:auto; margin-right:auto;'>                       
            <?php
                echo("<th class='text-left'> <label><b>Name environment</b></label>");
                echo("<th class='text-left' colspan=3 id='man1'> <label><b>Manage</b></label>");
                while($NameEv = $resultrechNameEv->fetch()){     
                  echo("<tr>");   

                    echo("<td class='line'> <label><b>$NameEv[0]</b></label> </td>");
                                        
                    echo("<td class='text-left'>");
                      echo("<a href=\"../Controller/updateEnvironment_Controller.php?Environment=$NameEv[0]\" class='amanage1'>");
                          echo("<img src='../assets/img/s2.png' alt='manage'>");
                      echo("</a>");
                    echo("</td>");

                    echo("<td class='text-left'>");
                        echo("<a href=\"../Controller/deleteEnvironment_table_Controller.php?Environment=$NameEv[0]\" class='amanage1'>");
                            echo("<img src='../assets/img/tr2.png' alt='manage'>");
                        echo("</a>");
                    echo("</td>");
                    
                  echo("</tr>");
                }
                echo("</th>");
            ?>
          </table>     
        </fieldset>

        <!-- The footer of the page that containt the engie corporation -->
        <?php
          // get the fotter
          require_once 'footer_absolut.php';
        ?>
    
  </body>
</html>

