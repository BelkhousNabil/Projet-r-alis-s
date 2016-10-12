<?php

  /**
        addFlows.php 
            description --> This page permit add new flows
            Controllers --> addFlow_Controller.php
            Model --> None - include with the controller
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
        <script type="text/javascript" src="../assets/js/script_refrech.js"></script>

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
                <li style='margin-left: -1%;'><a href="#" class='welcome'> <img src='../assets/img/user.png' alt='Welcome' /><?php echo("   Welcome ".strtoupper($owner[0]).""); ?></a></li>
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
        <a href="../graphe/graphics/halfviz/schema.php" id="a5"> <img src="../assets/img/graph.png"> <span><b>Flows graph</b></span></a>
        <a href="../View/uploadFile.php" id="a1"> <img src="../assets/img/add.png"> <span><b>Import flows</b></span></a>
        <a href="../View/addFlows.php" id="a3"> <img src="../assets/img/a2.png"> <span><b>Add flow</b></span></a> 
        <a href="../View/editFlows.php" id="a2"> <img src="../assets/img/s21.png"> <span><b>Edit flow</b></span></a> 
    </div></br></br></br></br>

        <!-- Form that allows to add the flows with thier data -->
        <fieldset class="add_field" id="add_flow">
            
                <form method = "POST" action = "../Controller/addFlow_Controller.php" enctype="multipart/form-data" name ="form_add_flow">
                    
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
                            <td> <input type="text" id='s1' name='s1' onkeyup="autocomplet_part1()" required > </td>  
                            <td> <input type="text" id='c1' name='c1' onkeyup="autocomplet_comp()" > </td>
                            <td> <input type="text" id='m1' name='m1' onkeyup="autocomplet_mid()" required> </td>
                            <td> <input type="text" id='ct1' name='ct1' onkeyup="autocomplet_comp1()"> </td>
                            <td> <input type="text" id='d1' name='d1' onkeyup="autocomplet_part2()" required > </td>
                            <td> <input type="text" id='p1' name='p1' required > </td>
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
                    <input type="checkbox" id="checkDesc" name="checkDesc" onclick="BuildTableData(this,'data1');"><span><b>Add data</b></span></br></br>

                    <?php
                        $k=1;
                        while($k <100){
                            echo("<div id='data".$k."'>");
                              echo("<table class='table_add'>");
                                   
                                    echo("<tr>");
                                      echo("<th style='text-align : center'> <label><b>Description</b></label> </th>");
                                      echo("<th style='text-align : center'> <label><b>Technical description</b></label> </th>");
                                    echo("</tr>");

                                    echo("<tr>");
                                      echo("<td> <textarea rows='3' cols='30' id='desc".$k."' name='desc".$k."'></textarea> </td>");
                                      echo("<td> <textarea rows='3' cols='30' id='tech_desc".$k."' name='desc".$k."'></textarea> </td>");
                                    echo("</tr>");

                                    echo("</table>");

                                echo("<table class='table_add'>");
                                    echo("<tr>");
                                      echo("<th style='text-align : center'> <label><b>Type</b></label> </th>");
                                      echo("<th style='text-align : center'> <label><b>Frequency</b></label> </th>");
                                      echo("<th style='text-align : center'> <label><b>Volume</b></label> </th>");
                                    echo("</tr>");

                                    echo("<tr>");
                                      echo("<td> <input type='text' id='type".$k."' name='type".$k."'> </td>");
                                      echo("<td> <input type='text' id='freq".$k."' name='freq".$k."'> </td>");
                                      echo("<td> <input type='text' id='volu".$k."' name='volu".$k."'> </td>");
                                    echo("</tr>");

                                echo("</table>");
                                
                                echo("<table class='table_add'>");

                                    echo("<tr>");
                                      echo("<th style='text-align : center'> <label><b>Transformation</b></label> </th>");
                                      echo("<th style='text-align : center'> <label><b>Control</b></label> </th>");
                                      echo("<th style='text-align : center'> <label><b>Treatment</b></label> </th>");
                                    echo("</tr>");

                                    echo("<tr>");
                                      echo("<td> <input type='text' id='tran".$k."' name='tran".$k."'> </td>");
                                      echo("<td> <input type='text' id='cont".$k."' name='cont".$k."'> </td>");
                                      echo("<td> <input type='text' id='trea".$k."' name='trea".$k."'> </td>");
                                    echo("</tr>");

                                echo("</table>");

                                echo("<table class='table_add'>");

                                    echo("<tr>");
                                      echo("<th style='text-align : center'> <label><b>Security</b></label> </th>");
                                      echo("<th style='text-align : center'> <label><b>Constraint</b></label> </th>");
                                      echo("<th style='text-align : center'> <label><b>File</b></label> </th>");
                                    echo("</tr>");

                                    echo("<tr>");
                                      echo("<td> <input type='text' id='secu".$k."' name='secu".$k."'> </td>");
                                      echo("<td> <input type='text' id='cons".$k."' name='cons".$k."'> </td>");
                                      echo("<td> <input type='file' id='file".$k."' name='file".$k."'> </td>");
                                    echo("</tr>");
                                echo("</table></br><hr>");
                                $k++;
                                echo("<input type='checkbox' id='checkDesc".$k."' name='checkDesc".$k."' onclick=\"BuildTableData(this,'data".$k."');\"><span><b>Add data</b></span></br>");
                                echo("</br>");
                            echo("</div>");
                            
                        }

                    ?>

                    <div id="data100" name="data100">
                      <table class="table_add">
                           
                            <tr>
                              <th style="text-align : center"> <label><b>Description</b></label> </th>
                              <th style="text-align : center"> <label><b>Technical description</b></label> </th>
                            </tr>

                            <tr>
                              <td> <textarea   rows="3" cols="30" id='desc100' name='desc100'></textarea> </td>
                              <td> <textarea   rows="3" cols="30" id='tech_desc100' name='desc100'></textarea> </td>
                           </tr>
                      </table>
                      <table class="table_add">
                            <tr>
                              <th style="text-align : center"> <label><b>Type</b></label> </th>
                              <th style="text-align : center"> <label><b>Frequency</b></label> </th>
                              <th style="text-align : center"> <label><b>Volume</b></label> </th>
                           </tr>

                           <tr>
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

                    <input type='submit' name='conex' id='add_fl' value="Add Flow">
        
                </form>
        </fieldset>
</br><!--
        <footer style='position:absolute; bottom:0;'>
          <div class='bas'>
            <img src='../assets/img/flux.PNG'>  
            <div id='corp' style='display: inline;'> </br>
              <p><b>© 2016 ENGIE IT Corporation. All Rights Reserved</b></p> 
              <a href='mailto:mehdi.mtougui@engie.com'> <img src='../assets/img/outlook.png' alt='Contact' /></a>
            </div>
          </div>
        </footer>-->
    
  </body>
</html>





                