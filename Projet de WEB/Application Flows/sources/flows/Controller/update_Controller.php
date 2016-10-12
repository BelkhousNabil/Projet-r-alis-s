<?php
	session_start();
	if(!$_SESSION['owner'])
	{
		header('Location: ../index.php');
	}

	// Include the DB application script
	require_once '../Config/BD_Conn.php';

	// dislay the error details of the queries
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (isset($_POST['edit'])) {
		$name = trim($_POST['mid']) ;
			$name = str_replace("\"", "&quot;", $name);
			$name = str_replace('\'', "&apos;", $name);

		$_SESSION['dropName'] = $name;
		/* Check if the middleware existe on the BD */
		$sql1="select count(*) from middleware where name='".$name."'";
		$resultrech1 = $dbh->query($sql1);
		$result1 = $resultrech1->fetch();
		$cpt = $result1[0];

		if($cpt==0){
			header('Location: ../View/editMiddleware_error.php');
		}else{
			header('Location: ../View/updateMiddleware.php');
		}
		
	} else if (isset($_POST['delete'])) {
		$name = trim($_POST['mid']) ;
			$name = str_replace("\"", "&quot;", $name);
			$name = str_replace('\'', "&apos;", $name);
			
		$_SESSION['dropName'] = $name;

		$sql1="select count(*) from middleware where name='".$name."'";
		$resultrech1 = $dbh->query($sql1);
		$result1 = $resultrech1->fetch();
		$cpt = $result1[0];

		if($cpt==0){
			header('Location: ../View/editMiddleware_error.php');
		}else{
			header('Location: ../View/deleteMiddleware.php');
		}
			
	}

		
?>