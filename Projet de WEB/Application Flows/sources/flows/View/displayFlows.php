<?php

    /**
        displayFlows.php 
            description --> This page permit to display the data of a specific flow
            Controllers --> None
            Model --> None
    **/
    
    session_start();
	if(!$_SESSION['owner']){
		header('Location: ../index.php');
	}       
	
	// Include the connexion of the DB in oreder to acces into the application
	require_once '../Config/BD_Conn.php';

	// add the query that gives the name owner
    require_once '../Model/owner_Model.php';

	// Get the flow that were sent in the URL as parametre
	$flow = $_GET['flow'];

	// Select the id data of the flow
	$query="select idData from flows where name ='$flow' ";
	$resulQuery = $dbh->query($query);

?>

	<html>
		<head>

        	<meta charset="utf-8" />
	        <title>Flows</title>
	        
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
	        
	        <!-- CSS stylesheet file -->
			<link rel="stylesheet" href="../assets/css/bootstrap.min.css" />
			
			<link rel="stylesheet" media="screen and (min-width: 1300px)" href="../assets/css/largeStyle.css" />
			
		</head>

		<body>

			<!-- Header of the the page that containt the logo of engie and the name of the application -->
        <header>
            <div class='menuItems'>
                <img class='logo' src="../assets/img/logo-scroll.png" alt="engie">
                <h2 style='margin-top:-3px;'>Flows</h2>
                </br>
            </div>  
            <ul id="menu">
                <li style='margin-left:-3%;'><a href="#" class='welcome'> <img src='../assets/img/user.png' alt='Welcome' /><?php echo("   Welcome ".strtoupper($owner[0]).""); ?></a></li>
                <li><a href="../View/flows.php" class='flows2'> <img src='../assets/img/flows.png' alt='Flows' />   Flows</a></li>
                <li><a href="../View/middleware.php" class='middleware'> <img src='../assets/img/server.png' alt='Middleware' />   Middlewares</a></li>
                <li><a href="../View/component.php" class='component'> <img src='../assets/img/component.png' alt='Components' />   Components</a></li>
                <li><a href="../View/partner.php" class='partner'> <img src='../assets/img/partner.png' alt='Partners'  />   Partners</a></li>
                <li><a href="../View/environment.php" class='environment'> <img src='../assets/img/environment.png' alt='Environments' />   Environments</a></li>
                <li class='logout'><a href="../Controller/logout.php"> <img src='../assets/img/logout.png' alt='Logout' />   Logout</a></li>
            </ul>
        </header>
    </br></br></br></br>

    <div class="addEdit_BTN">
        </br>
        <a href="../graphe/graphics/halfviz/schema.php" id="a5"> <img src="../assets/img/graph.png"> <span><b>Flows graph</b></span></a>
        <a href="../View/uploadFile.php" id="a1"> <img src="../assets/img/add.png"> <span><b>Import flows</b></span></a>
        <a href="../View/addFlows.php" id="a3"> <img src="../assets/img/a2.png"> <span><b>Add flow</b></span></a> 
        <a href="../View/editFlows.php" id="a2"> <img src="../assets/img/s21.png"> <span><b>Edit flow</b></span></a> 
    </div></br></br>

			<div class="container home" id ="tabCenter">
				<font face="comic sans ms">
				<h3><center> Data of <?php echo($flow); ?> </center> </h3>
				</font>

				<?php

					//
					$q="select count(*) from flows where name ='$flow' ";
					$ros=$dbh->query($q);
					$row=($ros->fetch());
					
					$compt=1;
					while($data_res = $resulQuery->fetch()){

						$sqlDisplay="SELECT * FROM data where idData = $data_res[0] ORDER BY idData";
						$ros=$dbh->query($sqlDisplay);

						while($row=$ros->fetch()){
							echo("<font face='comic sans ms'><b>Data N° : $compt</b></font>");
							echo ("<table class='table table-bordered'>");
									
									echo '<tr>';
										echo (" <td class='cellule'> <font face='comic sans ms'>Description</font> </td>");
										echo '<td align=center>' .$row[1].'</td>';
									echo '</tr>';

									echo '<tr>';
										echo (" <td class='cellule'> <font face='comic sans ms'>Technical description</font> </td>");
										echo '<td align=center>' .$row[11].'</td>';
									echo '</tr>';

									echo '<tr>';
										echo ("<td class='cellule'> <font face='comic sans ms'>Type</font> </td>");
										echo '<td align=center>' .$row[2].'</td>';
									echo '</tr>';
									echo '<tr>';
										echo ("<td class='cellule'> <font face='comic sans ms'>Frequence</font> </td>");
										echo '<td align=center>' .$row[3].'</td>';
									echo '</tr>';

									echo '<tr>';
										echo ("<td class='cellule'> <font face='comic sans ms'>Volume</font> </td>");
										echo '<td align=center>' .$row[4].'</td>';
									echo '</tr>';
									echo '<tr>';
										echo ("<td class='cellule'> <font face='comic sans ms'>Transformation</font> </td>");
										echo '<td align=center>' .$row[5].'</td>';
									echo '</tr>';
									echo '<tr>';
										echo ("<td class='cellule'> <font face='comic sans ms'>Control</font> </td>");
										echo '<td align=center>' .$row[6].'</td>';
									echo '</tr>';

									echo '<tr>';
										echo ("<td class='cellule'> <font face='comic sans ms'>Treatment</font> </td>");
										echo '<td align=center>' .$row[7].'</td>';
									echo '</tr>';

									echo '<tr>';
										echo ("<td class='cellule'> <font face='comic sans ms'>Security</font> </td>");
										echo '<td align=center>' .$row[8].'</td>';
									echo '</tr>';
									echo '<tr>';
										echo ("<td class='cellule'> <font face='comic sans ms'>Constraints</font> </td>");
										echo '<td align=center>' .$row[9].'</td>';
									echo '</tr>';

									if($row['file']=='empty'){
										echo '<tr>';
											echo ("<td class='cellule'> <font face='comic sans ms'>File</font> </td>");
											echo "<td align=center> </td>"; 
										echo '</tr>';
									}else{
										echo '<tr>';
											echo ("<td class='cellule'> <font face='comic sans ms'>File</font> </td>");
											echo "<td align=center><a title='Click here to download in file.' 
								     			href='../Controller/download_Controller.php?id={$row['file']}'>{$row['file']} </a> </td>"; 
										echo '</tr>';
									}
									
							echo ("</table>");			
							echo '<br/>';
						}
						$compt++;
					}

				?>

			</div>

			<!-- The footer of the page that containt the engie corporation -->
	        <?php
	          // get the fotter
	          require_once 'footer.php';
	        ?>
	        
		</body>

	</html>								
						