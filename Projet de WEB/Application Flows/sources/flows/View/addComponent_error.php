<?php

    /**
        addComponent_error.php 
            description --> Allows to notify the errors at the momement of adding a component
            Controllers --> addComp_Controller.php
            Model --> addComp_Model.php
    **/

	session_start();
	if(!$_SESSION['owner'])
	{
		header('Location: ../index.php');
	}
	// Include the connexion of the DB in oreder to acces into the application
	require_once '../Config/BD_Conn.php';
  
  require_once '../Model/owner_Model.php';

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

        <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:200" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Exo" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Black+Ops+One|Bungee+Shade|Oswald|Suez+One|Yatra+One" rel="stylesheet">

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
                <li style='margin-left: -1%;'><a href="#" class='welcome'> <img src='../assets/img/user.png' alt='Welcome' /><?php echo("   Welcome ".strtoupper($owner[0]).""); ?></a></li>
                <li><a href="../View/flows.php" class='flows'> <img src='../assets/img/flows.png' alt='Flows' />   Flows</a></li>
                <li><a href="../View/middleware.php" class='middleware'> <img src='../assets/img/server.png' alt='Middleware' />   Middlewares</a></li>
                <li><a href="../View/component.php" class='component2'> <img src='../assets/img/component.png' alt='Components' />   Components</a></li>
                <li><a href="../View/partner.php" class='partner'> <img src='../assets/img/partner.png' alt='Partners'  />   Partners</a></li>
                <li><a href="../View/environment.php" class='environment'> <img src='../assets/img/environment.png' alt='Environments' />   Environments</a></li>
                <li class='logout'><a href="../Controller/logout.php"> <img src='../assets/img/logout.png' alt='Logout' />   Logout</a></li>
            </ul>
        </header>
    </br></br></br></br></br>
        <!-- The error message -->
        <div class = "Verif"> 
          <p><b>The component name already exist</b></p>
        </div>
        <!-- The form that allows to add a component -->
        <fieldset class="add_midd" id="add_midd_Env">
            
                <form method = "POST" action = "../Controller/addComp_Controller.php" name = "form_add_comp">
                    <table class="table_add">

                        <tr>
                          <td class="line"> <label><b>Name</b></label> </td>
                          <td class="line" colspan=<?php echo($cptEv[0]); ?> > <?php echo("<input required style='border-color:red; color:red'  type='text' name='name_mid' value='".$_SESSION['middleware']."' onFocus=\"this.style.color='black'\"; >"); ?> </td>
                        </tr>
                        <tr>
                          <td class="line"> <label><b>Environment</b></label> </td>
                            <?php
                                while($NameEv = $resultrechNameEv->fetch()){
                                    echo("<td class='line'> <label><b>$NameEv[0]</b></label> </td>");
                                }
                            ?>
                          </td>
                        </tr>

                        <tr>
                          <td class="line"> <label><b>Description</b></label> </td>
                          <?php
                              $i=0;
                              while($i < $cptEv[0]){                                  
                                  echo("<td class='line'> <textarea rows='3' cols='50' name='desc".++$i."'> </textarea> </td>");
                              }
                          ?>
                        </tr>

                        <tr>
                          <td class="line"> <label><b>Contacts</b></label> </td>
                          <?php
                              $i=0;
                              while($i < $cptEv[0]){                                  
                                  echo("<td class='line'> <textarea rows='3' cols='50' name='contacts".++$i."'> </textarea> </td>");
                              }
                          ?>
                        </tr>

                        <tr>
                          <td class="line"> <label><b>Technical contacts</b></label> </td>
                          <?php
                              $i=0;
                              while($i < $cptEv[0]){                                  
                                  echo("<td class='line'> <textarea rows='3' cols='50' name='tech_cont".++$i."'> </textarea> </td>");
                              }
                          ?>
                        </tr>

                        <tr>
                          <td class="line"> <label><b>Localisation</b></label> </td>
                          <?php
                              $i=0;
                              while($i < $cptEv[0]){                                  
                                  echo("<td class='line'> <input type='text' name='loc".++$i."'> </td>");
                              }
                          ?>
                        </tr>

                        <tr>
                          <td class="line"> <label><b>Technical description</b></label> </td>
                          <?php
                              $i=0;
                              while($i < $cptEv[0]){                                  
                                  echo("<td class='line'> <textarea rows='3' cols='50' name='tech_desc".++$i."'> </textarea> </td>");
                              }
                          ?>
                        </tr>

                        <tr>
                          <td class="line"> <label><b>Server name</b></label> </td>
                          <?php
                              $i=0;
                              while($i < $cptEv[0]){                                  
                                  echo("<td class='line'> <textarea rows='3' cols='50' name='name_server".++$i."'> </textarea> </td>");
                              }
                          ?>
                        </tr>
                        <tr>
                          <td class="line"> <label><b>IP Addresses<b></label> </td>
                          <?php
                              $i=0;
                              while($i < $cptEv[0]){                                  
                                  echo("<td class='line'> <textarea rows='3' cols='50' name='ip".++$i."'> </textarea> </td>");
                              }
                          ?>
                        </tr>

                       <!--<tr>
                          <td class="line"> <label><b>Port</b></label> </td>
                          <td class="line"> <input type="text" name="port"> </td>
                       </tr> -->
                        <tr>
                          <td class="line"> <label><b>DNS</b></label> </td>
                          <?php
                              $i=0;
                              while($i < $cptEv[0]){                                  
                                  echo("<td class='line'> <textarea rows='3' cols='50' name='dns".++$i."'> </textarea> </td>");
                              }
                          ?>
                        </tr>

                        <tr>
                          <td class="line"> <label><b>Acces account</b></label> </td>
                          <?php
                              $i=0;
                              while($i < $cptEv[0]){                                  
                                  echo("<td class='line'> <textarea rows='3' cols='50' name='account".++$i."'> </textarea> </td>");
                              }
                          ?>
                        </tr>

                    </table>

                    <input type='submit' name='modif_mid' id='add_c' value="Add"  >
        
                </form>
        </fieldset>

        <!-- The footer of the page that containt the engie corporation -->
        <?php
          // get the fotter
          require_once 'footer.php';
        ?>
    
  </body>
</html>

