<?php

    /**
        partner.php 
            description --> Allows to display the partners that are in the DB of the application
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

    /* Upload the partners */

    $sql="select * from partner";
    $resultrech = $dbh->query($sql);

    // Get all the partners
    $q="select count(*) \"total\"  from partner";
    $ros=$dbh->query($q);
    $row=($ros->fetch());
    $total=$row['total'];
    $dis=30;
    $total_page=ceil($total/$dis);
    $page_cur=(isset($_GET['page']))?$_GET['page']:1;
    $k=($page_cur-1)*$dis;
    $q="SELECT * FROM partner ORDER BY name ASC limit $k,$dis";
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
        <header style='width:2030px;'>
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
                <li><a href="../View/partner.php" class='partner2'> <img src='../assets/img/partner.png' alt='Partners'  />   Partners</a></li>
                <li><a href="../View/environment.php" class='environment'> <img src='../assets/img/environment.png' alt='Environments' />   Environments</a></li>
                <li class='logout'><a href="../Controller/logout.php"> <img src='../assets/img/logout.png' alt='Logout' />   Logout</a></li>
            </ul>
        </header>
    </br></br></br></br></br>
        
        <div class="addEdit_BTN" id='midBTN'>
            </br>
            <a href="../Controller/exportFilePartner_Controller.php" id="a6" style='margin-left:18%;margin-right:3%;'> <img src="../assets/img/export.png"> <span><b>Export Partners</b></span></a>
            <a href="../View/uploadFilePartners.php" id="a1" style='margin-left:1%;'> <img src="../assets/img/add.png"> <span><b>Import partners</b></span></a>
            <a href="../View/addPartner.php" id="a3"> <img src="../assets/img/a2.png"> <span><b>Add partner</b></span></a>
            <a href="../View/editPartner.php" id="a2"> <img src="../assets/img/s21.png"> <span><b>Edit partner</b></span></a>
        </div></br></br></br>

        <!-- Display the partners that are the DB into a table -->
        <div>
            <div class="display_fl_comp">
                    <table class="table-fill" style='width:2000px;'>
                        <thead>
                            <tr>
                                <th class="text-left">Partner</th>
                                <th class="text-left">Description</th>
                                <th class="text-left">Contacts</th>
                                <th class="text-left">Technical contacts</th>
                                <th class="text-left">Localisation</th>
                                <th class="text-left">Technical description</th>
                                <th class="text-left">IP address</th>
                                <th class="text-left">DNS</th>
                                <th class="text-left">Server</th>
                                <th class="text-left">Accounts</th>
                                <th class="text-left" colspan=2 >Manage</th>
                            </tr>
                        </thead>
                        <tbody class="table-hover">

                            <?php
                                while($row=$ros->fetch()){
                                    echo ("<tr data-url='index.html'>");
                                        echo ("<td class='text-left' style=' overflow: hidden; word-wrap: break-word;'> ".$row[0]."</td>");

                                        echo ("<td class='text-left' style=' overflow: hidden; word-wrap: break-word; max-width:400px;'> ".$row[3]."</td>");
                                        echo ("<td class='text-left' style=' overflow: hidden; word-wrap: break-word;max-width:200px;'> ".$row[4]."</td>");
                                        echo ("<td class='text-left' style=' overflow: hidden; word-wrap: break-word; max-width:200px;'> ".$row[5]."</td>");

                                            /* Getting the description informations */
                                            $sql1="select * from description where iddesc =".$row[1];
                                            $resultrech1 = $dbh->query($sql1);
                                            $res= $resultrech1->fetch();

                                            $sql2="select name from environment where id =".$res[1];
                                            $resultrech2 = $dbh->query($sql2);
                                            $res2= $resultrech2->fetch();

                                            /* Getting the name of the environment *///             

                                        echo ("<td class='text-left' style=' overflow: hidden; word-wrap: break-word;'> ".$res[2]."</td>");

                                        echo ("<td class='text-left' style=' overflow: hidden; word-wrap: break-word; max-width:400px;'> ".$row[6]."</td>");

                                        echo ("<td class='text-left' style=' overflow: hidden; word-wrap: break-word; max-width:200px;'> ".$res[3]."</td>");

                                        echo ("<td class='text-left' style=' overflow: hidden; word-wrap: break-word;'> ".$res[4]."</td>");
                                        echo ("<td class='text-left' style=' overflow: hidden; word-wrap: break-word;'> ".$res[5]."</td>");
                                        echo ("<td class='text-left' style=' overflow: hidden; word-wrap: break-word;'> ".$res[6]."</td>");
                                        
                                        echo("<td class='text-left'  style='text-align: center' id='manage' style='max-width: 150px; overflow: hidden; word-wrap: break-word;'>");
                                            echo("<a href=\"../Controller/updatePart_table_Controller.php?mid=$row[0]\" class='amanage'>");
                                                echo("<img src='../assets/img/s2.png' alt='manage'>");
                                            echo("</a>");
                                            echo("</td>");
                                        echo("<td class='text-left' style='text-align: center' id='manage' style='max-width: 150px; overflow: hidden; word-wrap: break-word;'>");
                                            echo("<a href=\"../Controller/deletePart_table_Controller.php?mid=$row[0]\" class='amanage'>");
                                                echo("<img src='../assets/img/tr2.png' alt='manage'>");
                                            echo("</a>");
                                        echo("</td>");
                                    echo("</tr>");
                                }
                            ?>    
                            
                        </tbody>
                    </table></br>

                    <div class='pagination'>
    
                        <?php
                            if($page_cur>1){
                                    echo '<a class=\'aBtn\' href="partner.php?page='.($page_cur-1).'" style=" cursor:pointer;color:white ;" ><input style=" margin:0;padding:0; text-align:center; cursor:pointer;background-color:#0078BE;border-radius:3px;width:20px;height:20px;color:white;font-size:12px;font-weight:bold;" type="button" value="<"></a> ';
                            }
                            else{
                                echo '<input style=" margin:0;padding:0; text-align:center; border-color:#0078BE; background-color:#0078BE;border-radius:3px;width:20px;height:20px;color:black;font-size:13px;font-weight:bold;" type="button" value="<"> ';
                            }
                            for($i=1;$i<=$total_page;$i++){
                                if($page_cur==$i){ 
                                    echo '<input  style="margin:0;padding:0; text-align:center; border-color:#0078BE; background-color:#0078BE ;border-radius:3px;width:20px;height:20px;color:black;font-size:13px;font-weight:bold;" type="button" value="'.$i.'"> ';
                                }
                                else{
                                        echo '<a class=\'aBtn\' href="partner.php?page='.$i.'"> <input style="margin:0;padding:0; text-align:center; cursor:pointer;background-color:#0078BE; border-radius:3px;width:20px;height:20px;color:white;font-size:13px;" type="button" value="'.$i.'"> </a> ';       
                                }
                            }
                            if($page_cur<$total_page){      
                                echo '<a class=\'aBtn\' href="partner.php?page='.($page_cur+1).'"><input style="margin:0;padding:0; text-align:center; cursor:pointer;background-color:#0078BE; border-radius:3px;width:20px;height:20px;color:white;font-size:13px;font-weight:bold;" type="button" value=">"></a>';     
                            }
                            else{
                                echo '<input style="margin:0;padding:0; text-align:center; border-color:#0078BE; background-color:#0078BE; border-radius:3px;width:20px;height:20px;color:black;font-size:13px;font-weight:bold;" type="button" value=">"> ';
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

