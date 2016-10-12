<?php
	session_start();
	if(!$_SESSION['owner'])
	{
		header('Location: ../index.php');
	}

	// Include the connexion of the DB in oreder to acces into the application
	require_once '../Config/BD_Conn.php';

	// Show the error details
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	/* Recover the submited information */
	$name=$_SESSION['dropName'];
		$name = str_replace("\"", "&quot;", $name);
		$name = str_replace('\'', "&apos;", $name);

	// If there are confirmation
	if (isset($_POST['confir'])) {
		// select the id description of the middleware that will be delete
		$selectId = $dbh->query("select id_desc from middleware where name ='".$name."'");
		$result1 = $selectId->fetch();
		
		// drop the description previously selected
		$dropMidd = $dbh->query("delete from description where iddesc ='".$result1[0]."'");

		// select all the data flows that contain that middleware
        $selectDataFlow = $dbh->query("select idData from flows where middleware ='".$id."'");
        while($resultDataFlow = $selectDataFlow->fetch()){
        	// drop all the data flows that contain that middleware
            $dropData = $dbh->query("delete from data where idData ='".$resultDataFlow[0]."'");
        }
        // drop the flows that contain that middleware
        $dropFlow = $dbh->query("delete from flows where middleware ='".$name."'");

        // drop that middleware
        $dropMidd = $dbh->query("delete from middleware where name ='".$name."'");
			
		header('Location: ../View/middleware.php');	

	} else if (isset($_POST['abort'])) {
			header('Location: ../View/middleware.php');	
	}
		
?>