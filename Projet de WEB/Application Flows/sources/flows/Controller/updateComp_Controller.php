<?php
	session_start();
	if(!$_SESSION['owner']){
		header('Location: ../index.php');
	}

	// Include the connexion of the DB in oreder to acces into the application
	require_once '../Config/BD_Conn.php';

	// Show the error details
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// Edit button
	if (isset($_POST['edit'])) {
		$name = trim($_POST['mid']) ;
			$name = str_replace("\"", "&quot;", $name);
       		$name = str_replace('\'', "&apos;", $name);

		$_SESSION['dropName'] = $name;
			$_SESSION['dropName'] = str_replace("\"", "&quot;", $_SESSION['dropName']);
       		$_SESSION['dropName'] = str_replace('\'', "&apos;", $_SESSION['dropName']);
		
		/* Check if the component existe on the BD */
		$sql1="select count(*) from component where name='".$_POST['mid']."'";
		$resultrech1 = $dbh->query($sql1);
		$result1 = $resultrech1->fetch();
		$cpt = $result1[0];

		if($cpt==0){
			header('Location: ../View/editComponent_error.php');
		}else{
			header('Location: ../View/updateComponent.php');
		}
		
	} else if (isset($_POST['delete'])) {
		$name = trim($_POST['mid']) ;
			$name = str_replace("\"", "&quot;", $name);
       		$name = str_replace('\'', "&apos;", $name);

		$_SESSION['dropName'] = $name;
			$_SESSION['dropName'] = str_replace("\"", "&quot;", $_SESSION['dropName']);
       		$_SESSION['dropName'] = str_replace('\'', "&apos;", $_SESSION['dropName']);

		$sql1="select count(*) from component where name='".$_POST['mid']."'";
		$resultrech1 = $dbh->query($sql1);
		$result1 = $resultrech1->fetch();
		$cpt = $result1[0];
		
		if($cpt==0){
			header('Location: ../View/editComponent_error.php');
		}else{
			header('Location: ../View/deleteComponent.php');
		}
			
	}

?>