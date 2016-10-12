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
		// select the id description of this partner
		$selectId = $dbh->query("select id_desc from partner where name ='".$name."'");
        $result1 = $selectId->fetch();
        
        // drop the description selected previously
        $dropMidd = $dbh->query("delete from description where iddesc ='".$result1[0]."'");

        // get all the data of the flows that contain this partner
        $selectDataFlow = $dbh->query("select idData from flows where source ='".$name."' or destination ='".$name."'");

        while($resultDataFlow = $selectDataFlow->fetch()){
        	// drop the data of the flows that contain this partner
            $dropData = $dbh->query("delete from data where idData ='".$resultDataFlow[0]."'");
        }

        // drop the flows that contain this partner like source or destination
        $dropFlow = $dbh->query("delete from flows where source ='".$name."' or destination ='".$name."'");

        // Drop the componenet
        $dropMidd = $dbh->query("delete from partner where name ='".$name."'");

		header('Location: ../View/partner.php');	

	} else if (isset($_POST['abort'])) {
			header('Location: ../View/partner.php');	
	}
		
?>