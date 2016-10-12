<?php

  /**
        updateFlows_Controller.php 
            description --> This page permit to update flows
            Controllers --> checkFlows_Controller.php
            Model --> 
    **/

	session_start();
	if(!$_SESSION['owner'])
	{
		header('Location: ../index.php');
	}
	
  // Include the connexion of the DB in oreder to acces into the application
	require_once '../Config/BD_Conn.php';

  // Query that will gives the name of the owner
  $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
	// add the query that gives the name owner
  require_once '../Model/owner_Model.php';

  $flow = $_GET['flow'];
    $flow = str_replace("\"", "&quot;", $flow);
    $flow = str_replace('\'', "&apos;", $flow);

  $_SESSION['flw'] = $flow;
  
  /* Get flow information*/
  $sqlFlows="select * from flows where name='".$flow."'";
  $resultrechFlows = $dbh->query($sqlFlows);
  $resFlux = $resultrechFlows->fetch();

  /* Count the number of the data that are in the flow */
  $sqlCount="select count(idData) from flows where name='".$flow."'";
  $resultrechCount = $dbh->query($sqlCount);
  $count = $resultrechCount->fetch();

  $cpt=1;

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
        <link href="https://fonts.googleapis.com/css?family=Black+Ops+One|Bungee+Shade|Oswald|Suez+One|Yatra+One" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:200" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Exo" rel="stylesheet">

        <!-- Including the icon of the page -->
        <link rel="icon" type="image/png" href="../assets/img/2.PNG" />
        
        <!-- Scirpt that allows to gives the possibility of showing or hidding a form to add data -->
        <script type="text/JavaScript">

            function BuildTableData(c,d){
              
              if (c.checked==1){
                document.getElementById(d).style.display = 'block';
              }
              else{
                document.getElementById(d).style.display = 'none';
              }
            }

        </script>

        <!-- Including the external scripts -->
        <script type="text/javascript" src="../assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="../assets/js/scriptUpdate_refrech.js"></script>

        <!-- Scirpt that allows to hide the autocompletion list -->
        <script type="text/javascript">
            $(document).keyup(function(e) {
               if (e.keyCode == 27) {    
                  $('#mid_list_id_part1').hide();
                  $('#mid_list_id_part2').hide();
                  $('#mid_list_id_comp').hide();
                  $('#mid_list_id_mid').hide();
                  $('#mid_list_id_comp1').hide();
              }
            });
        </script>

    </head>
    
    <body>

        <!-- Header of the the page that containt the logo of engie and the name of the application -->
        <header>
            <div class='menuItems'>
                <img class='logo' src="../assets/img/logo-scroll.png" alt="engie">
                <h2>Flows</h2>
                </br>
            </div>  
            <ul id="menu">
                <li><a href="#" class='welcome'> <img src='../assets/img/user.png' alt='Welcome' /><?php echo("   Welcome ".strtoupper($owner[0]).""); ?></a></li>
                <li><a href="../View/flows.php" class='flows2'> <img src='../assets/img/flows.png' alt='Flows' />   Flows</a></li>
                <li><a href="../View/middleware.php" class='middleware'> <img src='../assets/img/server.png' alt='Middleware' />   Middlewares</a></li>
                <li><a href="../View/component.php" class='component'> <img src='../assets/img/component.png' alt='Components' />   Components</a></li>
                <li><a href="../View/partner.php" class='partner'> <img src='../assets/img/partner.png' alt='Partners'  />   Partners</a></li>
                <li><a href="../View/environment.php" class='environment'> <img src='../assets/img/environment.png' alt='Environments' />   Environments</a></li>
                <li class='logout'><a href="../Controller/logout.php"> <img src='../assets/img/logout.png' alt='Logout' />   Logout</a></li>
            </ul>
        </header>
    </br></br></br>

    <div class="addEdit_BTN">
        </br>
        <a href="../View/uploadFile.php" id="a1"> <img src="../assets/img/add.png"> <span><b>Import flows</b></span></a>
        <a href="../View/addFlows.php" id="a3"> <img src="../assets/img/a2.png"> <span><b>Add flow</b></span></a> 
        <a href="../View/editFlows.php" id="a2"> <img src="../assets/img/s21.png"> <span><b>Edit flow</b></span></a> 
    </div></br></br></br>

        <!-- Form that allows to update flows -->
        <fieldset class="add_field" id="add_flow">
                <form method = "POST" action = "checkFlows_Controller.php" enctype="multipart/form-data" name ="form_update_flow">
                      <table class="table_add" id="addflows">

                        <table class="table_add" id="addflows">
                          <tr>
                         <tr>
                            <th style="text-align : center"> <label><b>Source</b></label> </th>      
                            <th style="text-align : center"> <label><b>Component N°1</b></label> </th>
                            <th style="text-align : center"> <label><b>Middleware</b></label> </th>
                            <th style="text-align : center"> <label><b>Component N°2</b></label> </th>
                            <th style="text-align : center"> <label><b>Destination</b></label> </th>
                            <th style="text-align : center"> <label><b>Protocol</b></label> </th>
                         </tr>
                         <tr>
                         <div class="input_container">
                            <td> <input type="text" id='s1' name='s1' onkeyup="autocomplet_part1()" required <?php echo("value='".$resFlux[2]."'"); ?>   > </td>
                            
                            <?php
                                if($resFlux[4]==''){ ?>
                                    <td> <input type="text" id='c1' name='c1' onkeyup="autocomplet_comp()" value=''> </td>
                            <?php
                                }else{ 
                            ?>
                                <td> <input type="text" id='c1' name='c1' onkeyup="autocomplet_comp()" <?php echo("value='".$resFlux[4]."'"); ?>   > </td>
                            <?php
                                }
                            ?>                            
                            <td> <input type="text" id='m1' name='m1' onkeyup="autocomplet_mid()" required <?php echo("value='".$resFlux[5]."'"); ?>   > </td>

                            <?php
                                if($resFlux[6]==''){ ?>
                                    <td> <input type="text" id='ct1' name='ct1' onkeyup="autocomplet_comp1()" value=''> </td>
                            <?php
                                }else{ 
                            ?>
                               <td> <input type="text" id='ct1' name='ct1' onkeyup="autocomplet_comp1()" <?php echo("value='".$resFlux[6]."'"); ?>   > </td>
                            <?php
                                }
                            ?>   
                            <td> <input type="text" id='d1' name='d1' onkeyup="autocomplet_part2()" required <?php echo("value='".$resFlux[3]."'"); ?>   >   </td>

                            <td> <input type="text" id='p1' name='p1' required <?php echo("value='".$resFlux[7]."'"); ?>   >   </td>

                         </tr>
                         <tr class='autoline'> 
                            <td class = "auto"> <ul id="mid_list_id_part1"></ul> </td>
                            <td class = "auto"> <ul id="mid_list_id_comp"></ul> </td>
                            <td class = "auto"> <ul id="mid_list_id_mid"></ul> </td>
                            <td class = "auto"> <ul id="mid_list_id_comp1"></ul> </td>
                            <td class = "auto"> <ul id="mid_list_id_part2"></ul> </td>
                            <td class = "auto"> <ul></ul> </td>
                        </tr>
                      </table></br><hr>

                        </div>

                    <?php
                      $sqlBoucle="select * from flows where name='".$flow."'";
                      $resultrechBoucle = $dbh->query($sqlBoucle);
                      while($boucle = $resultrechBoucle->fetch()){

                        /* Get the datas flow */
                        $sqlData="select * from data where idData='".$boucle[1]."'";
                        $resultrechData = $dbh->query($sqlData);
                        $resData = $resultrechData->fetch();

                    ?>
                      <?php echo("<input type='hidden' id='id_Data".$cpt."' name='id_Data".$cpt."' value='".$boucle[1]."' >"); ?>
                        <table class="table_add">
                             <?php  echo("<p><b>Data N° ".$cpt."</b></p>"); ?>
                              <tr>
                                <th style="text-align : center"> <label><b>Description</b></label> </th>
                                <th style="text-align : center"> <label><b>Type</b></label> </th>
                                <th style="text-align : center"> <label><b>Frequency</b></label> </th>
                                <th style="text-align : center"> <label><b>Volume</b></label> </th>
                             </tr>

                             <tr>
                                <td> <?php echo("<textarea rows='3' cols='30' id='desc".$cpt."' name='desc".$cpt."' > ".$resData[1]." </textarea> ");  ?> </td>
                                <td> <?php echo("<input type='text' id='type".$cpt."' name='type".$cpt."' value='".$resData[2]."' >"); ?> </td>
                                <td> <?php echo("<input type='text' id='freq".$cpt."' name='freq".$cpt."' value='".$resData[3]."' >"); ?> </td>
                                <td> <?php echo("<input type='text' id='volu".$cpt."' name='volu".$cpt."' value='".$resData[4]."' >"); ?> </td>
                             </tr>

                          </table>
                          
                          <table class="table_add">

                              <tr>
                                <th style="text-align : center"> <label><b>Transformation</b></label> </th>
                                <th style="text-align : center"> <label><b>Control</b></label> </th>
                                <th style="text-align : center"> <label><b>Treatment</b></label> </th>
                              </tr>

                              <tr>
                                <td> <?php echo("<input type='text' id='tran".$cpt."' name='tran".$cpt."' value='".$resData[5]."' >"); ?> </td>
                                <td> <?php echo("<input type='text' id='cont".$cpt."' name='cont".$cpt."' value='".$resData[6]."' >"); ?> </td>
                                <td> <?php echo("<input type='text' id='trea".$cpt."' name='trea".$cpt."' value='".$resData[7]."' >"); ?> </td>
                              </tr>

                          </table>

                          <table class="table_add">

                              <tr>
                                <th style="text-align : center"> <label><b>Security</b></label> </th>
                                <th style="text-align : center"> <label><b>Constraint</b></label> </th>
                                <th style="text-align : center"> <label><b>File</b></label> </th>
                              </tr>

                              <tr>
                                <td> <?php echo("<input type='text' id='secu".$cpt."' name='secu".$cpt."' value='".$resData[8]."' >"); ?> </td>
                                <td> <?php echo("<input type='text' id='cons".$cpt."' name='cons".$cpt."' value='".$resData[9]."' >"); ?> </td>
                                <td> <?php echo("<input type='file' id='file".$cpt."' name='file".$cpt."'  >"); ?> </td>
                                
                              </tr>
                          </table></br><hr>
                          
                    <?php
                        $cpt++;
                      }
                      echo("<p style='text-align:center; font-size:20px;'><b>New data</b></p></br>");
                      echo("<input type='checkbox' id='add".$cpt."' name='add".$cpt."' onclick=\"BuildTableData(this,'data".$cpt."');\" ><span><b>Add data</b></span></br></br>");
                      while($cpt<100){
                        
                        echo("<div id='data".$cpt."'>");
                    ?>
                          <table class="table_add">
                             <?php  echo("<p><b>Data N° ".$cpt."</b></p>"); ?>
                              <tr>
                                <th style="text-align : center"> <label><b>Description</b></label> </th>
                                <th style="text-align : center"> <label><b>Type</b></label> </th>
                                <th style="text-align : center"> <label><b>Frequency</b></label> </th>
                                <th style="text-align : center"> <label><b>Volume</b></label> </th>
                             </tr>

                             <tr>
                                <td> <?php echo("<textarea rows='3' cols='30' id='desc".$cpt."' name='desc".$cpt."' >   </textarea> ");  ?> </td>
                                <td> <?php echo("<input type='text' id='type".$cpt."' name='type".$cpt."' value='' >"); ?> </td>
                                <td> <?php echo("<input type='text' id='freq".$cpt."' name='freq".$cpt."' value='' >"); ?> </td>
                                <td> <?php echo("<input type='text' id='volu".$cpt."' name='volu".$cpt."' value='' >"); ?> </td>
                             </tr>

                          </table>
                          
                          <table class="table_add">

                              <tr>
                                <th style="text-align : center"> <label><b>Transformation</b></label> </th>
                                <th style="text-align : center"> <label><b>Control</b></label> </th>
                                <th style="text-align : center"> <label><b>Treatment</b></label> </th>
                              </tr>

                              <tr>
                                <td> <?php echo("<input type='text' id='tran".$cpt."' name='tran".$cpt."' value='' >"); ?> </td>
                                <td> <?php echo("<input type='text' id='cont".$cpt."' name='cont".$cpt."' value='' >"); ?> </td>
                                <td> <?php echo("<input type='text' id='trea".$cpt."' name='trea".$cpt."' value='' >"); ?> </td>
                              </tr>

                          </table>

                          <table class="table_add">

                              <tr>
                                <th style="text-align : center"> <label><b>Security</b></label> </th>
                                <th style="text-align : center"> <label><b>Constraint</b></label> </th>
                                <th style="text-align : center"> <label><b>File</b></label> </th>
                              </tr>

                              <tr>
                                <td> <?php echo("<input type='text' id='secu".$cpt."' name='secu".$cpt."' value='' >"); ?> </td>
                                <td> <?php echo("<input type='text' id='cons".$cpt."' name='cons".$cpt."' value='' >"); ?> </td>
                                <td> <?php echo("<input type='file' id='file".$cpt."' name='file".$cpt."' >"); ?> </td>
                                
                              </tr>
                          </table></br><hr>

                    <?php
                        $cpt++;
                        echo("<input type='checkbox' id='add".$cpt."' name='add".$cpt."' onclick=\"BuildTableData(this,'data".$cpt."');\" ><span><b>Add data</b></span></br></br>");
                        echo("</div>");
                      }
                    ?>

                    <div id="data100" name="data100">
                      <table class="table_add">
                           
                            <tr>
                              <th style="text-align : center"> <label><b>Description</b></label> </th>
                              <th style="text-align : center"> <label><b>Type</b></label> </th>
                              <th style="text-align : center"> <label><b>Frequency</b></label> </th>
                              <th style="text-align : center"> <label><b>Volume</b></label> </th>
                           </tr>

                           <tr>
                              <td> <textarea   rows="3" cols="30" id='desc100' name='desc100'></textarea> </td>
                              <td> <input type="text" id='type100' name='type100'> </td>
                              <td> <input type="text" id='freq100' name='freq100'> </td>
                              <td> <input type="text" id='volu100' name='volu100'> </td>
                           </tr>

                        </table>
                        
                        <table class="table_add">

                            <tr>
                              <th style="text-align : center"> <label><b>Transformation</b></label> </th>
                              <th style="text-align : center"> <label><b>Control</b></label> </th>
                              <th style="text-align : center"> <label><b>Treatment</b></label> </th>
                            </tr>

                            <tr>
                              <td> <input type="text" id='tran100' name='tran100'> </td>
                              <td> <input type="text" id='cont100' name='cont100'> </td>
                              <td> <input type="text" id='trea100' name='trea100'> </td>
                            </tr>

                        </table>

                        <table class="table_add">

                            <tr>
                              <th style="text-align : center"> <label><b>Security</b></label> </th>
                              <th style="text-align : center"> <label><b>Constraint</b></label> </th>
                              <th style="text-align : center"> <label><b>File</b></label> </th>
                            </tr>

                            <tr>
                              <td> <input type="text" id='secu100' name='secu100'> </td>
                              <td> <input type="text" id='cons100' name='cons100'> </td>
                              <td> <input type="file" id='file100' name='file100'> </td>
                            </tr>
                        </table>
                    </div>
                    
                    <input type='submit' name='conex' id='add_fl' value="Modify">
        
                    <script>document.foo.submit();</script>
                </form>
        </fieldset>
</br></br></br>
    </br><!--
        <footer style='position:absolute; bottom:0;'>
            <div class='bas'>
                  
              <div id='corp' style='display: inline;'> </br>
                  <p><b>© 2016 ENGIE IT Corporation. All Rights Reserved</b></p> 
                  <a href='mailto:mehdi.mtougui@engie.com'> <img src='../assets/img/outlook.png' alt='Contact' /></a> <a class='contact' href='mailto:mehdi.mtougui@engie.com'>Contact</a>
              </div>
              <img src='../assets/img/flux.PNG'>
            </div>
        </footer></br>-->
    
  </body>
</html>





                