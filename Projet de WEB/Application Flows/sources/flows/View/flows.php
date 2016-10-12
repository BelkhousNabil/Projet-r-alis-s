<?php
    /**
        flows.php 
            description --> This page permit to display the flows that are in the DB of the application
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

    // Show error details
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // add the query that gives the name owner
    require_once '../Model/owner_Model.php';

     /* Upload the middlewares */
    $sq="select distinct name,source,destination,component_1,middleware,component_2 from flows";
    $resultr = $dbh->query($sq);

    // Get all the flows
    $q="select distinct count(*) \"total\"  from flows";
    $ros=$dbh->query($q);
    $row=($ros->fetch());
    $total=$row['total'];
    $dis=30;
    $total_page=ceil($total/$dis);
    $page_cur=(isset($_GET['page']))?$_GET['page']:1;
    $k=($page_cur-1)*$dis;
    $q="SELECT distinct name,source,destination,component_1,middleware,component_2 FROM flows ORDER BY name ASC limit $k,$dis";
    $ros=$dbh->query($q);
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

        <link href="https://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:200" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Exo" rel="stylesheet">

        <link href="https://fonts.googleapis.com/css?family=Black+Ops+One|Bungee+Shade|Oswald|Suez+One|Yatra+One" rel="stylesheet">

        <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

        <!-- Including the icon of the page -->
        <link rel="icon" type="image/png" href="../assets/img/2.PNG" />
        
        <!-- Including the external scripts -->
        <script type="text/javascript" src="../assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="../assets/js/search_refrech.js"></script>

        <!-- Scirpt that allows to hide the autocompletion list -->
        <script type="text/javascript">
            $(document).keyup(function(e) {
               if (e.keyCode == 27) {    
                  $('#list_part1').hide();
                  $('#list_part2').hide();
                  $('#list_comp').hide();
                  $('#list_mid').hide();
              }
            });
        </script>

    </head>
    
    <body>
        <!-- Header of the the page that containt the logo of engie and the name of the application -->
        <header style='width:2030px;'>
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
    </br></br></br></br></br>

    <div class="addEdit_BTN">
        </br>
        <a href="../graphe/graphics/halfviz/schema.php" id="a5"> <img src="../assets/img/graph.png"> <span><b>Flows graph</b></span></a>
        <a href="../Controller/exportFile_Controller.php" id="a6"> <img src="../assets/img/export.png"> <span><b>Export flows</b></span></a>
        <a href="../View/uploadFile.php" id="a1"> <img src="../assets/img/add.png"> <span><b>Import flows</b></span></a>
        <a href="../View/addFlows.php" id="a3"> <img src="../assets/img/a2.png"> <span><b>Add flow</b></span></a> 
        <a href="../View/editFlows.php" id="a2"> <img src="../assets/img/s21.png"> <span><b>Edit flow</b></span></a> 
    </div>

        <fieldset class="add_field" id="search_flow_member">
                <span class='recherche'>Search</span>
                <form method = "POST" action = "#" name ="form_add_flow">
                    <table class="table_add" id='textInput' >
                        <tr>
                            <th> <input   type="text" style='color:#666B85;' name='source' id='source' onkeyup="autocomplet_part1()" value="" placeholder="Source" ></th>                            
                            <th> <input   type="text" style='color:#666B85;' name='middleware' id='middleware' onkeyup="autocomplet_mid()" value="" placeholder="Middleware" ></th>
                            <th> <input   type="text" style='color:#666B85;' name='component' id='component' onkeyup="autocomplet_comp()" value="" placeholder="Component" ></th>
                            <th> <input   type="text" style='color:#666B85;' name='destination' id='destination' onkeyup="autocomplet_part2()" value="" placeholder="Destination" ></th>
                            <th> <input type='submit' name='search' id='search' value="   "></th>
                        </tr>
                        <tr class='autoline'> 
                            <td class = "auto"> <ul id="list_part1"></ul> </td>
                            <td class = "auto"> <ul id="list_mid"></ul> </td>
                            <td class = "auto"> <ul id="list_comp"></ul> </td>
                            <td class = "auto" style='text-align:center;'> <ul id="list_part2"></ul> </td>
                        </tr>
                    </table></br>

                </form>

                <?php 
                    if (isset($_POST['search'])){

                        /** Search without parameters **/
                        if ((empty($_POST['source'])) and (empty($_POST['destination'])) and (empty($_POST['middleware'])) and (empty($_POST['component'])) ){
                            echo("<div class = 'must'> ");
                              echo("<p><b>You must give at least one parameter </b></p>");
                            echo("</div>");
                        }

                        /** Search with source parameter **/
                        if ((!empty($_POST['source'])) and (empty($_POST['destination'])) and (empty($_POST['middleware'])) and (empty($_POST['component']))){
                            
                            $sqlCount="select count(*) from flows where source='".$_POST['source']."'";
                            $resulCount = $dbh->query($sqlCount);
                            $counter = $resulCount->fetch();

                            if($counter[0] == 0){
                                echo("<div class = 'must'> ");
                                  echo("<p><b>No documents match to the specified search parameters</b></p>");
                                echo("</div>");
                            }
                            else{
                                $sq="select distinct name,source,destination,component_1,middleware,component_2 from flows where source='".$_POST['source']."'";
                                $ros = $dbh->query($sq);
                                    
                                    echo("<table class='table-fill' style='width:2000px;'>
                                        <tr>
                                            <th rowspan='2'>flow</th>
                                            <th colspan='4'>source</th>
                                            <th rowspan='2'>Component N°1</th>
                                            <th rowspan='2'>Middleware</th>
                                            <th rowspan='2'>Component N°2</th>
                                            <th colspan='4'>Destination</th>
                                            <th colspan='3' rowspan='2'>Manage</th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>

                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>
                                        </tr>");

                                        while($row=$ros->fetch()){
                                        $sqlSource = "select id_desc from partner where name ='".$row[1]."'";
                                        $resultSource = $dbh->query($sqlSource);
                                        $src= $resultSource->fetch();

                                            $sqlDescS = "select * from description where iddesc =".$src[0]."";
                                            $resultDescS = $dbh->query($sqlDescS);
                                            $resS= $resultDescS->fetch();

                                        $sqlDest = "select id_desc from partner where name ='".$row[2]."'";
                                        $resultDest = $dbh->query($sqlDest);
                                        $des= $resultDest->fetch();

                                            $sqlDescD = "select * from description where iddesc =".$des[0]."";
                                            $resultDescD = $dbh->query($sqlDescD);
                                            $resD= $resultDescD->fetch();


                                        echo '<tr>';
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[0]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[1]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[4]." / ".$resS[5]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[4]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[5]."</td>";
                                            
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[4]." / ".$resD[5]."</td>";

                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/updateFlows_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/s2.png' alt='manage'>");
                                                echo("</a>");
                                                echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/deleteFlows_table_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/tr2.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"displayFlows.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/open.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            
                                        echo '</tr>';
                                        }

                                        echo("</table>");
                                        
                                echo("</div>");
                            }
                            
                        }

                        /** Search with destination parameter **/
                        if ((empty($_POST['source'])) and (!empty($_POST['destination'])) and (empty($_POST['middleware'])) and (empty($_POST['component'])) ){
                            $sqlCount="select count(*) from flows where destination='".$_POST['destination']."'";
                            $resulCount = $dbh->query($sqlCount);
                            $counter = $resulCount->fetch();

                            if($counter[0] == 0){
                                echo("<div class = 'must'> ");
                                  echo("<p><b>No documents match to the specified search parameters</b></p>");
                                echo("</div>");
                            }
                            else{
                                $sq="select distinct name,source,destination,component_1,middleware,component_2 from flows where destination='".$_POST['destination']."'";
                                $ros = $dbh->query($sq);
                                    
                                    echo("<table class='table-fill' style='width:2000px;'>
                                        <tr>
                                            <th rowspan='2'>flow</th>
                                            <th colspan='4'>source</th>
                                            <th rowspan='2'>Component N°1</th>
                                            <th rowspan='2'>Middleware</th>
                                            <th rowspan='2'>Component N°2</th>
                                            <th colspan='4'>Destination</th>
                                            <th colspan='3' rowspan='2'>Manage</th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>

                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>
                                        </tr>");

                                        while($row=$ros->fetch()){
                                        $sqlSource = "select id_desc from partner where name ='".$row[1]."'";
                                        $resultSource = $dbh->query($sqlSource);
                                        $src= $resultSource->fetch();

                                            $sqlDescS = "select * from description where iddesc =".$src[0]."";
                                            $resultDescS = $dbh->query($sqlDescS);
                                            $resS= $resultDescS->fetch();

                                        $sqlDest = "select id_desc from partner where name ='".$row[2]."'";
                                        $resultDest = $dbh->query($sqlDest);
                                        $des= $resultDest->fetch();

                                            $sqlDescD = "select * from description where iddesc =".$des[0]."";
                                            $resultDescD = $dbh->query($sqlDescD);
                                            $resD= $resultDescD->fetch();


                                        echo '<tr>';
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[0]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[1]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[4]." / ".$resS[5]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[4]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[5]."</td>";
                                            
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[4]." / ".$resD[5]."</td>";

                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/updateFlows_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/s2.png' alt='manage'>");
                                                echo("</a>");
                                                echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/deleteFlows_table_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/tr2.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"displayFlows.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/open.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                        echo '</tr>';
                                        }

                                        echo("</table>");
                                        
                                echo("</div>");
                            
                                }
                            }

                        /** Search with middleware parameter **/
                        if ((empty($_POST['source'])) and (empty($_POST['destination'])) and (!empty($_POST['middleware'])) and (empty($_POST['component'])) ){
                            $sqlCount="select count(*) from flows where middleware='".$_POST['middleware']."'";
                            $resulCount = $dbh->query($sqlCount);
                            $counter = $resulCount->fetch();

                            if($counter[0] == 0){
                                echo("<div class = 'must'> ");
                                  echo("<p><b>No documents match to the specified search parameters</b></p>");
                                echo("</div>");
                            }
                            else{
                                $sq="select distinct name,source,destination,component_1,middleware,component_2 from flows where middleware='".$_POST['middleware']."'";
                                $ros = $dbh->query($sq);
                                    
                                    echo("<table class='table-fill' style='width:2000px;'>
                                        <tr>
                                            <th rowspan='2'>flow</th>
                                            <th colspan='4'>source</th>
                                            <th rowspan='2'>Component N°1</th>
                                            <th rowspan='2'>Middleware</th>
                                            <th rowspan='2'>Component N°2</th>
                                            <th colspan='4'>Destination</th>
                                            <th colspan='3' rowspan='2'>Manage</th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>

                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>
                                        </tr>");

                                        while($row=$ros->fetch()){
                                        $sqlSource = "select id_desc from partner where name ='".$row[1]."'";
                                        $resultSource = $dbh->query($sqlSource);
                                        $src= $resultSource->fetch();

                                            $sqlDescS = "select * from description where iddesc =".$src[0]."";
                                            $resultDescS = $dbh->query($sqlDescS);
                                            $resS= $resultDescS->fetch();

                                        $sqlDest = "select id_desc from partner where name ='".$row[2]."'";
                                        $resultDest = $dbh->query($sqlDest);
                                        $des= $resultDest->fetch();

                                            $sqlDescD = "select * from description where iddesc =".$des[0]."";
                                            $resultDescD = $dbh->query($sqlDescD);
                                            $resD= $resultDescD->fetch();


                                        echo '<tr>';
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[0]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[1]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[4]." / ".$resS[5]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[4]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[5]."</td>";
                                            
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[4]." / ".$resD[5]."</td>";

                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/updateFlows_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/s2.png' alt='manage'>");
                                                echo("</a>");
                                                echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/deleteFlows_table_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/tr2.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"displayFlows.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/open.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                        echo '</tr>';
                                        }

                                        echo("</table>");
                                        
                                echo("</div>");
                            }
                        }

                        /** Search with component parameter **/
                        if ((empty($_POST['source'])) and (empty($_POST['destination'])) and (empty($_POST['middleware'])) and (!empty($_POST['component'])) ){
                            $sqlCount="select count(*) from flows where (component_1='".$_POST['component']."' OR component_2='".$_POST['component']."')";
                            $resulCount = $dbh->query($sqlCount);
                            $counter = $resulCount->fetch();

                            if($counter[0] == 0){
                                echo("<div class = 'must'> ");
                                  echo("<p><b>No documents match to the specified search parameters</b></p>");
                                echo("</div>");
                            }
                            else{
                                $sq="select distinct name,source,destination,component_1,middleware,component_2 from flows where (component_1='".$_POST['component']."' or component_2='".$_POST['component']."')";
                                $ros = $dbh->query($sq);
                                    
                                    echo("<table class='table-fill' style='width:2000px;'>
                                        <tr>
                                            <th rowspan='2'>flow</th>
                                            <th colspan='4'>source</th>
                                            <th rowspan='2'>Component N°1</th>
                                            <th rowspan='2'>Middleware</th>
                                            <th rowspan='2'>Component N°2</th>
                                            <th colspan='4'>Destination</th>
                                            <th colspan='3' rowspan='2'>Manage</th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>

                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>
                                        </tr>");

                                        while($row=$ros->fetch()){
                                        $sqlSource = "select id_desc from partner where name ='".$row[1]."'";
                                        $resultSource = $dbh->query($sqlSource);
                                        $src= $resultSource->fetch();

                                            $sqlDescS = "select * from description where iddesc =".$src[0]."";
                                            $resultDescS = $dbh->query($sqlDescS);
                                            $resS= $resultDescS->fetch();

                                        $sqlDest = "select id_desc from partner where name ='".$row[2]."'";
                                        $resultDest = $dbh->query($sqlDest);
                                        $des= $resultDest->fetch();

                                            $sqlDescD = "select * from description where iddesc =".$des[0]."";
                                            $resultDescD = $dbh->query($sqlDescD);
                                            $resD= $resultDescD->fetch();


                                        echo '<tr>';
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[0]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[1]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[4]." / ".$resS[5]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[4]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[5]."</td>";
                                            
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[4]." / ".$resD[5]."</td>";

                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/updateFlows_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/s2.png' alt='manage'>");
                                                echo("</a>");
                                                echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/deleteFlows_table_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/tr2.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"displayFlows.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/open.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                        echo '</tr>';   
                                        }

                                        echo("</table>");
                                        
                                    echo("</div>");
                                }
                            }

                        /** Search with source and destination parameters **/
                        if ((!empty($_POST['source'])) and (!empty($_POST['destination'])) and (empty($_POST['middleware'])) and (empty($_POST['component'])) ){
                            $sqlCount="select count(*) from flows where source='".$_POST['source']."' and destination ='".$_POST['destination']."'";
                            $resulCount = $dbh->query($sqlCount);
                            $counter = $resulCount->fetch();

                            if($counter[0] == 0){
                                echo("<div class = 'must'> ");
                                  echo("<p><b>No documents match to the specified search parameters</b></p>");
                                echo("</div>");
                            }
                            else{
                                $sq="select distinct name,source,destination,component_1,middleware,component_2 from flows where source='".$_POST['source']."' and destination ='".$_POST['destination']."'";
                                $ros = $dbh->query($sq);
                                    
                                    echo("<table class='table-fill' style='width:2000px;'>
                                        <tr>
                                            <th rowspan='2'>flow</th>
                                            <th colspan='4'>source</th>
                                            <th rowspan='2'>Component N°1</th>
                                            <th rowspan='2'>Middleware</th>
                                            <th rowspan='2'>Component N°2</th>
                                            <th colspan='4'>Destination</th>
                                            <th colspan='3' rowspan='2'>Manage</th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>

                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>
                                        </tr>");

                                        while($row=$ros->fetch()){
                                        $sqlSource = "select id_desc from partner where name ='".$row[1]."'";
                                        $resultSource = $dbh->query($sqlSource);
                                        $src= $resultSource->fetch();

                                            $sqlDescS = "select * from description where iddesc =".$src[0]."";
                                            $resultDescS = $dbh->query($sqlDescS);
                                            $resS= $resultDescS->fetch();

                                        $sqlDest = "select id_desc from partner where name ='".$row[2]."'";
                                        $resultDest = $dbh->query($sqlDest);
                                        $des= $resultDest->fetch();

                                            $sqlDescD = "select * from description where iddesc =".$des[0]."";
                                            $resultDescD = $dbh->query($sqlDescD);
                                            $resD= $resultDescD->fetch();


                                        echo '<tr>';
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[0]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[1]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[4]." / ".$resS[5]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[4]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[5]."</td>";
                                            
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[4]." / ".$resD[5]."</td>";

                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/updateFlows_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/s2.png' alt='manage'>");
                                                echo("</a>");
                                                echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/deleteFlows_table_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/tr2.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"displayFlows.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/open.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                        echo '</tr>';    
                                        }

                                        echo("</table>");
                                        
                                echo("</div>");
                                }
                            }

                        /** Search with source and middleware parameters **/
                        if ((!empty($_POST['source'])) and (empty($_POST['destination'])) and (!empty($_POST['middleware'])) and (empty($_POST['component'])) ){
                            $sqlCount="select count(*) from flows where source='".$_POST['source']."' and middleware ='".$_POST['middleware']."'";
                            $resulCount = $dbh->query($sqlCount);
                            $counter = $resulCount->fetch();

                            if($counter[0] == 0){
                                echo("<div class = 'must'> ");
                                  echo("<p><b>No documents match to the specified search parameters</b></p>");
                                echo("</div>");
                            }
                            else{
                                $sq="select distinct name,source,destination,component_1,middleware,component_2 from flows where source='".$_POST['source']."' and middleware ='".$_POST['middleware']."'";
                                $ros = $dbh->query($sq);
                                    
                                    echo("<table class='table-fill' style='width:2000px;'>
                                        <tr>
                                            <th rowspan='2'>flow</th>
                                            <th colspan='4'>source</th>
                                            <th rowspan='2'>Component N°1</th>
                                            <th rowspan='2'>Middleware</th>
                                            <th rowspan='2'>Component N°2</th>
                                            <th colspan='4'>Destination</th>
                                            <th colspan='3' rowspan='2'>Manage</th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>

                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>
                                        </tr>");

                                        while($row=$ros->fetch()){
                                        $sqlSource = "select id_desc from partner where name ='".$row[1]."'";
                                        $resultSource = $dbh->query($sqlSource);
                                        $src= $resultSource->fetch();

                                            $sqlDescS = "select * from description where iddesc =".$src[0]."";
                                            $resultDescS = $dbh->query($sqlDescS);
                                            $resS= $resultDescS->fetch();

                                        $sqlDest = "select id_desc from partner where name ='".$row[2]."'";
                                        $resultDest = $dbh->query($sqlDest);
                                        $des= $resultDest->fetch();

                                            $sqlDescD = "select * from description where iddesc =".$des[0]."";
                                            $resultDescD = $dbh->query($sqlDescD);
                                            $resD= $resultDescD->fetch();


                                        echo '<tr>';
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[0]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[1]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[4]." / ".$resS[5]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[4]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[5]."</td>";
                                            
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[4]." / ".$resD[5]."</td>";

                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/updateFlows_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/s2.png' alt='manage'>");
                                                echo("</a>");
                                                echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/deleteFlows_table_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/tr2.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"displayFlows.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/open.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                        echo '</tr>';    
                                        }

                                        echo("</table>");
                                        
                                echo("</div>");
                            }
                        }

                        /** Search with source and component parameters **/
                        if ((!empty($_POST['source'])) and (empty($_POST['destination'])) and (empty($_POST['middleware'])) and (!empty($_POST['component'])) ){
                            $sqlCount="select count(*) from flows where source='".$_POST['source']."' and (component_1 ='".$_POST['component']."' OR component_2 ='".$_POST['component']."')";
                            $resulCount = $dbh->query($sqlCount);
                            $counter = $resulCount->fetch();

                            if($counter[0] == 0){
                                echo("<div class = 'must'> ");
                                  echo("<p><b>No documents match to the specified search parameters</b></p>");
                                echo("</div>");
                            }
                            else{
                                $sq="select distinct name,source,destination,component_1,middleware,component_2 from flows where source='".$_POST['source']."' and (component_1 ='".$_POST['component']."' or component_2 ='".$_POST['component']."')";
                                $ros = $dbh->query($sq);
                                    
                                    echo("<table class='table-fill' style='width:2000px;'>
                                        <tr>
                                            <th rowspan='2'>flow</th>
                                            <th colspan='4'>source</th>
                                            <th rowspan='2'>Component N°1</th>
                                            <th rowspan='2'>Middleware</th>
                                            <th rowspan='2'>Component N°2</th>
                                            <th colspan='4'>Destination</th>
                                            <th colspan='3' rowspan='2'>Manage</th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>

                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>
                                        </tr>");

                                        while($row=$ros->fetch()){
                                        $sqlSource = "select id_desc from partner where name ='".$row[1]."'";
                                        $resultSource = $dbh->query($sqlSource);
                                        $src= $resultSource->fetch();

                                            $sqlDescS = "select * from description where iddesc =".$src[0]."";
                                            $resultDescS = $dbh->query($sqlDescS);
                                            $resS= $resultDescS->fetch();

                                        $sqlDest = "select id_desc from partner where name ='".$row[2]."'";
                                        $resultDest = $dbh->query($sqlDest);
                                        $des= $resultDest->fetch();

                                            $sqlDescD = "select * from description where iddesc =".$des[0]."";
                                            $resultDescD = $dbh->query($sqlDescD);
                                            $resD= $resultDescD->fetch();


                                        echo '<tr>';
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[0]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[1]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[4]." / ".$resS[5]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[4]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[5]."</td>";
                                            
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[4]." / ".$resD[5]."</td>";

                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/updateFlows_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/s2.png' alt='manage'>");
                                                echo("</a>");
                                                echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/deleteFlows_table_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/tr2.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"displayFlows.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/open.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                        echo '</tr>';    
                                        }

                                        echo("</table>");
                                        
                                    echo("</div>");
                                }
                            }

                        /** Search with destination and middleware parameters **/
                        if ( (empty($_POST['source'])) and (!empty($_POST['destination'])) and (!empty($_POST['middleware'])) and (empty($_POST['component'])) ){
                            $sqlCount="select count(*) from flows where destination='".$_POST['destination']."' and middleware ='".$_POST['middleware']."'";
                            $resulCount = $dbh->query($sqlCount);
                            $counter = $resulCount->fetch();

                            if($counter[0] == 0){
                                echo("<div class = 'must'> ");
                                  echo("<p><b>No documents match to the specified search parameters</b></p>");
                                echo("</div>");
                            }
                            else{
                                $sq="select distinct name,source,destination,component_1,middleware,component_2 from flows where destination='".$_POST['destination']."' and middleware ='".$_POST['middleware']."'";
                                $ros = $dbh->query($sq);
                                    
                                    echo("<table class='table-fill' style='width:2000px;'>
                                        <tr>
                                            <th rowspan='2'>flow</th>
                                            <th colspan='4'>source</th>
                                            <th rowspan='2'>Component N°1</th>
                                            <th rowspan='2'>Middleware</th>
                                            <th rowspan='2'>Component N°2</th>
                                            <th colspan='4'>Destination</th>
                                            <th colspan='3' rowspan='2'>Manage</th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>

                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>
                                        </tr>");

                                        while($row=$ros->fetch()){
                                        $sqlSource = "select id_desc from partner where name ='".$row[1]."'";
                                        $resultSource = $dbh->query($sqlSource);
                                        $src= $resultSource->fetch();

                                            $sqlDescS = "select * from description where iddesc =".$src[0]."";
                                            $resultDescS = $dbh->query($sqlDescS);
                                            $resS= $resultDescS->fetch();

                                        $sqlDest = "select id_desc from partner where name ='".$row[2]."'";
                                        $resultDest = $dbh->query($sqlDest);
                                        $des= $resultDest->fetch();

                                            $sqlDescD = "select * from description where iddesc =".$des[0]."";
                                            $resultDescD = $dbh->query($sqlDescD);
                                            $resD= $resultDescD->fetch();


                                        echo '<tr>';
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[0]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[1]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[4]." / ".$resS[5]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[4]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[5]."</td>";
                                            
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[4]." / ".$resD[5]."</td>";

                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/updateFlows_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/s2.png' alt='manage'>");
                                                echo("</a>");
                                                echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/deleteFlows_table_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/tr2.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"displayFlows.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/open.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            
                                        echo '</tr>';
                                        }

                                        echo("</table>");
                                        
                                    echo("</div>");
                                }
                            }

                        /** Search with destination and component parameters **/
                        if ((empty($_POST['source'])) and (!empty($_POST['destination'])) and (empty($_POST['middleware'])) and (!empty($_POST['component']))){
                            $sqlCount="select count(*) from flows where destination='".$_POST['destination']."' and (component_1 ='".$_POST['component']."' OR component_2 ='".$_POST['component']."')";
                            $resulCount = $dbh->query($sqlCount);
                            $counter = $resulCount->fetch();

                            if($counter[0] == 0){
                                echo("<div class = 'must'> ");
                                  echo("<p><b>No documents match to the specified search parameters</b></p>");
                                echo("</div>");
                            }
                            else{
                                $sq="select distinct name,source,destination,component_1,middleware,component_2 from flows where destination='".$_POST['destination']."' and (component_1 ='".$_POST['component']."' or component_2 ='".$_POST['component']."')";
                                $ros = $dbh->query($sq);
                                    
                                    echo("<table class='table-fill' style='width:2000px;'>
                                        <tr>
                                            <th rowspan='2'>flow</th>
                                            <th colspan='4'>source</th>
                                            <th rowspan='2'>Component N°1</th>
                                            <th rowspan='2'>Middleware</th>
                                            <th rowspan='2'>Component N°2</th>
                                            <th colspan='4'>Destination</th>
                                            <th colspan='3' rowspan='2'>Manage</th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>

                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>
                                        </tr>");

                                        while($row=$ros->fetch()){
                                        $sqlSource = "select id_desc from partner where name ='".$row[1]."'";
                                        $resultSource = $dbh->query($sqlSource);
                                        $src= $resultSource->fetch();

                                            $sqlDescS = "select * from description where iddesc =".$src[0]."";
                                            $resultDescS = $dbh->query($sqlDescS);
                                            $resS= $resultDescS->fetch();

                                        $sqlDest = "select id_desc from partner where name ='".$row[2]."'";
                                        $resultDest = $dbh->query($sqlDest);
                                        $des= $resultDest->fetch();

                                            $sqlDescD = "select * from description where iddesc =".$des[0]."";
                                            $resultDescD = $dbh->query($sqlDescD);
                                            $resD= $resultDescD->fetch();


                                        echo '<tr>';
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[0]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[1]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[4]." / ".$resS[5]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[4]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[5]."</td>";
                                            
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[4]." / ".$resD[5]."</td>";

                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/updateFlows_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/s2.png' alt='manage'>");
                                                echo("</a>");
                                                echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/deleteFlows_table_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/tr2.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"displayFlows.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/open.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            
                                        echo '</tr>';
                                        }

                                        echo("</table>");
                                        
                                echo("</div>");
                                }
                            }

                        /** Search with middleware and component parameters **/
                        if ((empty($_POST['source'])) and (empty($_POST['destination'])) and (!empty($_POST['middleware'])) and (!empty($_POST['component'])) ){
                            $sqlCount="select count(*) from flows where middleware='".$_POST['middleware']."' and (component_1 ='".$_POST['component']."' OR component_2 ='".$_POST['component']."')";
                            $resulCount = $dbh->query($sqlCount);
                            $counter = $resulCount->fetch();

                            if($counter[0] == 0){
                                echo("<div class = 'must'> ");
                                  echo("<p><b>No documents match to the specified search parameters</b></p>");
                                echo("</div>");
                            }
                            else{
                                $sq="select distinct name,source,destination,component_1,middleware,component_2 from flows where middleware='".$_POST['middleware']."' and (component_1 ='".$_POST['component']."' or component_2 ='".$_POST['component']."')";
                                $ros = $dbh->query($sq);
                                    
                                    echo("<table class='table-fill' style='width:2000px;'>
                                        <tr>
                                            <th rowspan='2'>flow</th>
                                            <th colspan='4'>source</th>
                                            <th rowspan='2'>Component N°1</th>
                                            <th rowspan='2'>Middleware</th>
                                            <th rowspan='2'>Component N°2</th>
                                            <th colspan='4'>Destination</th>
                                            <th colspan='3' rowspan='2'>Manage</th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>

                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>
                                        </tr>");

                                        while($row=$ros->fetch()){
                                        $sqlSource = "select id_desc from partner where name ='".$row[1]."'";
                                        $resultSource = $dbh->query($sqlSource);
                                        $src= $resultSource->fetch();

                                            $sqlDescS = "select * from description where iddesc =".$src[0]."";
                                            $resultDescS = $dbh->query($sqlDescS);
                                            $resS= $resultDescS->fetch();

                                        $sqlDest = "select id_desc from partner where name ='".$row[2]."'";
                                        $resultDest = $dbh->query($sqlDest);
                                        $des= $resultDest->fetch();

                                            $sqlDescD = "select * from description where iddesc =".$des[0]."";
                                            $resultDescD = $dbh->query($sqlDescD);
                                            $resD= $resultDescD->fetch();


                                        echo '<tr>';
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[0]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[1]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[4]." / ".$resS[5]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[4]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[5]."</td>";
                                            
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[4]." / ".$resD[5]."</td>";

                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/updateFlows_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/s2.png' alt='manage'>");
                                                echo("</a>");
                                                echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/deleteFlows_table_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/tr2.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"displayFlows.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/open.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            
                                        echo '</tr>';
                                        }

                                        echo("</table>");
                                        
                                echo("</div>");
                            }
                        }

                        /** Search with source, destination and middleware parameters **/
                        if ((!empty($_POST['source'])) and (!empty($_POST['destination'])) and (!empty($_POST['middleware'])) and (empty($_POST['component'])) ){
                            $sqlCount="select count(*) from flows where source='".$_POST['source']."' and destination ='".$_POST['destination']."' and middleware ='".$_POST['middleware']."'";
                            $resulCount = $dbh->query($sqlCount);
                            $counter = $resulCount->fetch();

                            if($counter[0] == 0){
                                echo("<div class = 'must'> ");
                                  echo("<p><b>No documents match to the specified search parameters</b></p>");
                                echo("</div>");
                            }
                            else{
                                $sq="select distinct name,source,destination,component_1,middleware,component_2 from flows where source='".$_POST['source']."' and destination ='".$_POST['destination']."' and middleware ='".$_POST['middleware']."'";
                                $ros = $dbh->query($sq);
                                    
                                    echo("<table class='table-fill' style='width:2000px;'>
                                        <tr>
                                            <th rowspan='2'>flow</th>
                                            <th colspan='4'>source</th>
                                            <th rowspan='2'>Component N°1</th>
                                            <th rowspan='2'>Middleware</th>
                                            <th rowspan='2'>Component N°2</th>
                                            <th colspan='4'>Destination</th>
                                            <th colspan='3' rowspan='2'>Manage</th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>

                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>
                                        </tr>");

                                        while($row=$ros->fetch()){
                                        $sqlSource = "select id_desc from partner where name ='".$row[1]."'";
                                        $resultSource = $dbh->query($sqlSource);
                                        $src= $resultSource->fetch();

                                            $sqlDescS = "select * from description where iddesc =".$src[0]."";
                                            $resultDescS = $dbh->query($sqlDescS);
                                            $resS= $resultDescS->fetch();

                                        $sqlDest = "select id_desc from partner where name ='".$row[2]."'";
                                        $resultDest = $dbh->query($sqlDest);
                                        $des= $resultDest->fetch();

                                            $sqlDescD = "select * from description where iddesc =".$des[0]."";
                                            $resultDescD = $dbh->query($sqlDescD);
                                            $resD= $resultDescD->fetch();


                                        echo '<tr>';
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[0]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[1]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[4]." / ".$resS[5]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[4]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[5]."</td>";
                                            
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[4]." / ".$resD[5]."</td>";

                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/updateFlows_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/s2.png' alt='manage'>");
                                                echo("</a>");
                                                echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/deleteFlows_table_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/tr2.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"displayFlows.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/open.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            
                                        echo '</tr>';
                                        }

                                        echo("</table>");
                                        
                                    echo("</div>");
                                }
                            }

                        /** Search with source, destination and component parameters **/
                        if ((!empty($_POST['source'])) and (!empty($_POST['destination'])) and (empty($_POST['middleware'])) and (!empty($_POST['component'])) ){
                            $sqlCount="select count(*) from flows where source='".$_POST['source']."' and destination ='".$_POST['destination']."' and (component_1 ='".$_POST['component']."' or component_2 ='".$_POST['component']."')";
                            $resulCount = $dbh->query($sqlCount);
                            $counter = $resulCount->fetch();

                            if($counter[0] == 0){
                                echo("<div class = 'must'> ");
                                  echo("<p><b>No documents match to the specified search parameters</b></p>");
                                echo("</div>");
                            }
                            else{
                                $sq="select distinct name,source,destination,component_1,middleware,component_2 from flows where source='".$_POST['source']."' and destination ='".$_POST['destination']."' and (component_1 ='".$_POST['component']."' or component_2 ='".$_POST['component']."')";
                                $ros = $dbh->query($sq);
                                    
                                    echo("<table class='table-fill' style='width:2000px;'>
                                        <tr>
                                            <th rowspan='2'>flow</th>
                                            <th colspan='4'>source</th>
                                            <th rowspan='2'>Component N°1</th>
                                            <th rowspan='2'>Middleware</th>
                                            <th rowspan='2'>Component N°2</th>
                                            <th colspan='4'>Destination</th>
                                            <th colspan='3' rowspan='2'>Manage</th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>

                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>
                                        </tr>");

                                        while($row=$ros->fetch()){
                                        $sqlSource = "select id_desc from partner where name ='".$row[1]."'";
                                        $resultSource = $dbh->query($sqlSource);
                                        $src= $resultSource->fetch();

                                            $sqlDescS = "select * from description where iddesc =".$src[0]."";
                                            $resultDescS = $dbh->query($sqlDescS);
                                            $resS= $resultDescS->fetch();

                                        $sqlDest = "select id_desc from partner where name ='".$row[2]."'";
                                        $resultDest = $dbh->query($sqlDest);
                                        $des= $resultDest->fetch();

                                            $sqlDescD = "select * from description where iddesc =".$des[0]."";
                                            $resultDescD = $dbh->query($sqlDescD);
                                            $resD= $resultDescD->fetch();


                                        echo '<tr>';
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[0]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[1]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[4]." / ".$resS[5]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[4]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[5]."</td>";
                                            
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[4]." / ".$resD[5]."</td>";

                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/updateFlows_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/s2.png' alt='manage'>");
                                                echo("</a>");
                                                echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/deleteFlows_table_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/tr2.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"displayFlows.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/open.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            
                                        echo '</tr>';
                                        }

                                        echo("</table>");
                                        
                                echo("</div>");
                            }
                        }

                        /** Search with source, middleware and component parameters **/
                        if ((!empty($_POST['source'])) and (empty($_POST['destination'])) and (!empty($_POST['middleware'])) and (!empty($_POST['component'])) ){
                            $sqlCount="select count(*) from flows where source='".$_POST['source']."' and middleware ='".$_POST['middleware']."' and (component_1 ='".$_POST['component']."' or component_2 ='".$_POST['component']."')";
                            $resulCount = $dbh->query($sqlCount);
                            $counter = $resulCount->fetch();

                            if($counter[0] == 0){
                                echo("<div class = 'must'> ");
                                  echo("<p><b>No documents match to the specified search parameters</b></p>");
                                echo("</div>");
                            }
                            else{
                                $sq="select distinct name,source,destination,component_1,middleware,component_2 from flows where source='".$_POST['source']."' and middleware ='".$_POST['middleware']."' and (component_1 ='".$_POST['component']."' or component_2 ='".$_POST['component']."')";
                                $ros = $dbh->query($sq);
                                    
                                    echo("<table class='table-fill' style='width:2000px;'>
                                        <tr>
                                            <th rowspan='2'>flow</th>
                                            <th colspan='4'>source</th>
                                            <th rowspan='2'>Component N°1</th>
                                            <th rowspan='2'>Middleware</th>
                                            <th rowspan='2'>Component N°2</th>
                                            <th colspan='4'>Destination</th>
                                            <th colspan='3' rowspan='2'>Manage</th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>

                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>
                                        </tr>");

                                        while($row=$ros->fetch()){
                                        $sqlSource = "select id_desc from partner where name ='".$row[1]."'";
                                        $resultSource = $dbh->query($sqlSource);
                                        $src= $resultSource->fetch();

                                            $sqlDescS = "select * from description where iddesc =".$src[0]."";
                                            $resultDescS = $dbh->query($sqlDescS);
                                            $resS= $resultDescS->fetch();

                                        $sqlDest = "select id_desc from partner where name ='".$row[2]."'";
                                        $resultDest = $dbh->query($sqlDest);
                                        $des= $resultDest->fetch();

                                            $sqlDescD = "select * from description where iddesc =".$des[0]."";
                                            $resultDescD = $dbh->query($sqlDescD);
                                            $resD= $resultDescD->fetch();


                                        echo '<tr>';
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[0]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[1]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[4]." / ".$resS[5]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[4]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[5]."</td>";
                                            
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[4]." / ".$resD[5]."</td>";

                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/updateFlows_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/s2.png' alt='manage'>");
                                                echo("</a>");
                                                echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/deleteFlows_table_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/tr2.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"displayFlows.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/open.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            
                                        echo '</tr>';
                                        }

                                        echo("</table>");
                                        
                                echo("</div>");
                            }
                        }

                        /** Search with destination, middleware and component parameters **/
                        if ((empty($_POST['source'])) and (!empty($_POST['destination'])) and (!empty($_POST['middleware'])) and (!empty($_POST['component'])) ){
                            $sqlCount="select count(*) from flows where destination='".$_POST['destination']."' and middleware ='".$_POST['middleware']."' and (component_1 ='".$_POST['component']."' or component_2 ='".$_POST['component']."')";
                            $resulCount = $dbh->query($sqlCount);
                            $counter = $resulCount->fetch();

                            if($counter[0] == 0){
                                echo("<div class = 'must'> ");
                                  echo("<p><b>No documents match to the specified search parameters</b></p>");
                                echo("</div>");
                            }
                            else{
                                $sq="select distinct name,source,destination,component_1,middleware,component_2 from flows where destination='".$_POST['destination']."' and middleware ='".$_POST['middleware']."' and (component_1 ='".$_POST['component']."' or component_2 ='".$_POST['component']."')";
                                $ros = $dbh->query($sq);
                                    
                                    echo("<table class='table-fill' style='width:2000px;'>
                                        <tr>
                                            <th rowspan='2'>flow</th>
                                            <th colspan='4'>source</th>
                                            <th rowspan='2'>Component N°1</th>
                                            <th rowspan='2'>Middleware</th>
                                            <th rowspan='2'>Component N°2</th>
                                            <th colspan='4'>Destination</th>
                                            <th colspan='3' rowspan='2'>Manage</th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>

                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>
                                        </tr>");

                                        while($row=$ros->fetch()){
                                        $sqlSource = "select id_desc from partner where name ='".$row[1]."'";
                                        $resultSource = $dbh->query($sqlSource);
                                        $src= $resultSource->fetch();

                                            $sqlDescS = "select * from description where iddesc =".$src[0]."";
                                            $resultDescS = $dbh->query($sqlDescS);
                                            $resS= $resultDescS->fetch();

                                        $sqlDest = "select id_desc from partner where name ='".$row[2]."'";
                                        $resultDest = $dbh->query($sqlDest);
                                        $des= $resultDest->fetch();

                                            $sqlDescD = "select * from description where iddesc =".$des[0]."";
                                            $resultDescD = $dbh->query($sqlDescD);
                                            $resD= $resultDescD->fetch();


                                        echo '<tr>';
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[0]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[1]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[4]." / ".$resS[5]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[4]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[5]."</td>";
                                            
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[4]." / ".$resD[5]."</td>";

                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/updateFlows_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/s2.png' alt='manage'>");
                                                echo("</a>");
                                                echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/deleteFlows_table_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/tr2.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"displayFlows.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/open.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            
                                        echo '</tr>';
                                        }

                                        echo("</table>");
                                        
                                echo("</div>");
                            }
                        }

                        /** Search with source, destination, middleware and component parameters **/
                        if ((!empty($_POST['source'])) and (!empty($_POST['destination'])) and (!empty($_POST['middleware'])) and (!empty($_POST['component'])) ){
                            $sqlCount="select count(*) from flows where source = '".$_POST['source']."' and destination='".$_POST['destination']."' and middleware ='".$_POST['middleware']."' and (component_1 ='".$_POST['component']."' or component_2 ='".$_POST['component']."')";
                            $resulCount = $dbh->query($sqlCount);
                            $counter = $resulCount->fetch();

                            if($counter[0] == 0){
                                echo("<div class = 'must'> ");
                                  echo("<p><b>No documents match to the specified search parameters</b></p>");
                                echo("</div>");
                            }
                            else{
                                $sq="select distinct name,source,destination,component_1,middleware,component_2 from flows where source = '".$_POST['source']."' and destination='".$_POST['destination']."' and middleware ='".$_POST['middleware']."' and (component_1 ='".$_POST['component']."' or component_2 ='".$_POST['component']."')";
                                $ros = $dbh->query($sq);
                                    
                                    echo("<table class='table-fill' style='width:2000px;'>
                                        <tr>
                                            <th rowspan='2'>flow</th>
                                            <th colspan='4'>source</th>
                                            <th rowspan='2'>Component N°1</th>
                                            <th rowspan='2'>Middleware</th>
                                            <th rowspan='2'>Component N°2</th>
                                            <th colspan='4'>Destination</th>
                                            <th colspan='3' rowspan='2'>Manage</th>
                                        </tr>
                                        <tr>
                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>

                                            <th>Name</th>
                                            <th>Localisation</th>
                                            <th>IP address</th>
                                            <th>DNS/Server</th>
                                        </tr>");

                                        while($row=$ros->fetch()){
                                        $sqlSource = "select id_desc from partner where name ='".$row[1]."'";
                                        $resultSource = $dbh->query($sqlSource);
                                        $src= $resultSource->fetch();

                                            $sqlDescS = "select * from description where iddesc =".$src[0]."";
                                            $resultDescS = $dbh->query($sqlDescS);
                                            $resS= $resultDescS->fetch();

                                        $sqlDest = "select id_desc from partner where name ='".$row[2]."'";
                                        $resultDest = $dbh->query($sqlDest);
                                        $des= $resultDest->fetch();

                                            $sqlDescD = "select * from description where iddesc =".$des[0]."";
                                            $resultDescD = $dbh->query($sqlDescD);
                                            $resD= $resultDescD->fetch();


                                        echo '<tr>';
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[0]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[1]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[4]." / ".$resS[5]."</td>";

                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[4]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[5]."</td>";
                                            
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[2]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[3]."</td>";
                                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[4]." / ".$resD[5]."</td>";

                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/updateFlows_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/s2.png' alt='manage'>");
                                                echo("</a>");
                                                echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"../Controller/deleteFlows_table_Controller.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/tr2.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            echo("<td style='text-align:center;'>");
                                                echo("<a href=\"displayFlows.php?flow=$row[0]\" class='amanage1'>");
                                                    echo("<img src='../assets/img/open.png' alt='manage'>");
                                                echo("</a>");
                                            echo("</td>");
                                            
                                        echo '</tr>';
                                        }

                                        echo("</table>");
                                        
                                echo("</div>");
                            }
                        }

                    }
                ?>

        </fieldset>


        <?php
            if (!isset($_POST['search'])){
        ?>
                <div class="display_fl_comp">
                <table class="table-fill" style='width:2000px;'>
                  <tr>
                    <th rowspan='2'>flow</th>
                    <th colspan="4">Source</th>
                    <th rowspan="2">Component N°1</th>
                    <th rowspan="2">Middleware</th>
                    <th rowspan="2">Component N°2</th>
                    <th colspan="4">Destination</th>
                    <th colspan="3" rowspan="2">Manage</th>
                  </tr>
                  <tr>
                    <th>Name</th>
                    <th>Localisation</th>
                    <th>IP address</th>
                    <th>DNS/Server</th>

                    <th>Name</th>
                    <th>Localisation</th>
                    <th>IP address</th>
                    <th>DNS/Server</th>
                  </tr>
                
                <?php 
                    while($row=$ros->fetch()){
                        $sqlSource = "select id_desc from partner where name ='".$row[1]."'";
                        $resultSource = $dbh->query($sqlSource);
                        $src= $resultSource->fetch();

                            $sqlDescS = "select * from description where iddesc =".$src[0]."";
                            $resultDescS = $dbh->query($sqlDescS);
                            $resS= $resultDescS->fetch();

                        $sqlDest = "select id_desc from partner where name ='".$row[2]."'";
                        $resultDest = $dbh->query($sqlDest);
                        $des= $resultDest->fetch();

                            $sqlDescD = "select * from description where iddesc =".$des[0]."";
                            $resultDescD = $dbh->query($sqlDescD);
                            $resD= $resultDescD->fetch();
                        

                        echo '<tr>';
                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[0]."</td>";

                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[1]."</td>";
                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[2]."</td>";
                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[3]."</td>";
                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resS[4]." / ".$resS[5]."</td>";

                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[3]."</td>";
                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[4]."</td>";
                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[5]."</td>";
                            
                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$row[2]."</td>";
                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[2]."</td>";
                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[3]."</td>";
                            echo "<td style='overflow: hidden; word-wrap: break-word;'>" .$resD[4]." / ".$resD[5]."</td>";

                            echo("<td style='text-align:center;'>");
                                echo("<a href=\"../Controller/updateFlows_Controller.php?flow=$row[0]\" class='amanage1'>");
                                    echo("<img src='../assets/img/s2.png' alt='manage'>");
                                echo("</a>");
                                echo("</td>");
                            echo("<td style='text-align:center;'>");
                                echo("<a href=\"../Controller/deleteFlows_table_Controller.php?flow=$row[0]\" class='amanage1'>");
                                    echo("<img src='../assets/img/tr2.png' alt='manage'>");
                                echo("</a>");
                            echo("</td>");
                            echo("<td style='text-align:center;'>");
                                echo("<a href=\"displayFlows.php?flow=$row[0]\" class='amanage1'>");
                                    echo("<img src='../assets/img/open.png' alt='manage'>");
                                echo("</a>");
                            echo("</td>");

                        echo '</tr>';
                    }
                
                 
            
                ?> 
                </table>
                        

                        <?php  
                            echo '<br/>';
                        ?>    
                        <div class='pagination'>
    
                        <?php
                            if($page_cur>1){
                                    echo '<a class=\'aBtn\' href="flows.php?page='.($page_cur-1).'" style=" cursor:pointer;color:white ;" ><input style=" margin:0;padding:0; text-align:center; cursor:pointer;background-color:#0078BE;border-radius:3px;width:20px;height:20px;color:white;font-size:12px;font-weight:bold;" type="button" value="<"></a> ';
                            }
                            else{
                                echo '<input style=" margin:0;padding:0; text-align:center; border-color:#0078BE; background-color:#0078BE;border-radius:3px;width:20px;height:20px;color:black;font-size:13px;font-weight:bold;" type="button" value="<"> ';
                            }
                            for($i=1;$i<=$total_page;$i++){
                                if($page_cur==$i){ 
                                    echo '<input  style="margin:0;padding:0; text-align:center; border-color:#0078BE; background-color:#0078BE ;border-radius:3px;width:20px;height:20px;color:black;font-size:13px;font-weight:bold;" type="button" value="'.$i.'"> ';
                                }
                                else{
                                        echo '<a class=\'aBtn\' href="flows.php?page='.$i.'"> <input style="margin:0;padding:0; text-align:center; cursor:pointer;background-color:#0078BE; border-radius:3px;width:20px;height:20px;color:white;font-size:13px;" type="button" value="'.$i.'"> </a> ';       
                                }
                            }
                            if($page_cur<$total_page){      
                                echo '<a class=\'aBtn\' href="flows.php?page='.($page_cur+1).'"><input style="margin:0;padding:0; text-align:center; cursor:pointer;background-color:#0078BE; border-radius:3px;width:20px;height:20px;color:white;font-size:13px;font-weight:bold;" type="button" value=">"></a>';     
                            }
                            else{
                                echo '<input style="margin:0;padding:0; text-align:center; border-color:#0078BE; background-color:#0078BE; border-radius:3px;width:20px;height:20px;color:black;font-size:13px;font-weight:bold;" type="button" value=">"> ';
                            }
        }    
                        ?>
                        </div>
                        
        </div>

        <!-- The footer of the page that containt the engie corporation -->
        <?php
          // get the fotter
          require_once 'footer.php';
        ?>
        
  </body>
</html>

