<?php

    /**
        displayFlows.php 
            description --> This page permit to display the data of a specific flow
            Controllers --> None
            Model --> None
    **/
    
	// Include the connexion of the DB in oreder to acces into the application
	require_once '../Config/BD_Conn.php';

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
                <h2>Flows</h2>
                </br>
            </div>  
            
        </header>
    </br></br></br></br>

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

			</div><!--
			<footer class="sear">
	            <div class="bas">
	                <img src="../assets/img/flux.png">
	                <div id="corp"><p><b>© 2016 ENGIE IT Corporation. All Rights Reserved</b></p> </div>
	            </div>
	        </footer> -->
		</body>

	</html>								
						