<?php
	session_start();
	if(!$_SESSION['owner'])
	{
		header('Location: ../index.php');
	}

	require_once '../Config/BD_Conn.php';
	
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (isset($_POST['edit'])) {
		$name = trim($_POST['mid']) ;
			$name = str_replace("\"", "&quot;", $name);
			$name = str_replace('\'', "&apos;", $name);

		$_SESSION['dropName'] = $name;
		/* Check if the partner existe on the BD */
		$sql1="select count(*) from partner where name='".$name."'";
		$resultrech1 = $dbh->query($sql1);
		$result1 = $resultrech1->fetch();
		$cpt = $result1[0];

		if($cpt==0){
			header('Location: ../View/editPartner_error.php');
		}else{
			header('Location: ../View/updatePartner.php');
		}
		
	} else if (isset($_POST['delete'])) {
		$name = trim($_POST['mid']) ;
			$name = str_replace("\"", "&quot;", $name);
			$name = str_replace('\'', "&apos;", $name);
			
		$_SESSION['dropName'] = $name;

		$sql1="select count(*) from partner where name='".$name."'";
		$resultrech1 = $dbh->query($sql1);
		$result1 = $resultrech1->fetch();
		$cpt = $result1[0];
		
		if($cpt==0){
			header('Location: ../View/editPartner_error.php');
		}else{
			header('Location: ../View/deletePartner.php');
		}
			
	}

	
	

		
?>