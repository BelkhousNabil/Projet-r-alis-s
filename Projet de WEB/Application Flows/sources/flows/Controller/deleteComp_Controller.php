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
		// get the id of the component description
		$selectId = $dbh->query("select id_desc from component where name ='".$name."'");
		$result1 = $selectId->fetch();
		
		// drop this description the component that where selected previously
		$dropMidd = $dbh->query("delete from description where iddesc ='".$result1[0]."'");

		// get all the data flow that contain this coponent
        $selectDataFlow = $dbh->query("select idData from flows where component_1 ='".$name."' or component_2 ='".$name."'");

        while($resultDataFlow = $selectDataFlow->fetch()){
        	// Drop all the data of the flow
            $dropData = $dbh->query("delete from data where idData ='".$resultDataFlow[0]."'");
        }
        // drop the flow that contein this component
        $dropFlow = $dbh->query("delete from flows where component_1 ='".$name."' or component_2 ='".$name."'");

        // Drop the componenet
		$dropMidd = $dbh->query("delete from component where name ='".$name."'");

		// Redirection to the component page
		header('Location: ../View/component.php');	

	} else if (isset($_POST['abort'])) {

			// Redirection int o the view 
			header('Location: ../View/component.php');	
	}

?>