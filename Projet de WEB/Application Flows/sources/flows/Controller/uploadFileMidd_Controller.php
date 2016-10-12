<?php
	session_start();
	if(!$_SESSION['owner'])
	{
		header('Location: ../index.php');
	}

	// Include the connexion of the DB in oreder to acces into the application
	require_once '../Config/BD_Conn.php';

	// Details of the error messages
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// A list of permitted file extensions
	$allowed = array('xlsx');

	$fileName = $_FILES["fileselect"]["name"];
	if($fileName == 'Auto-Generated-Midd.xlsx'){
		if(isset($_FILES["fileselect"]["name"]) and !empty($_FILES["fileselect"]["name"])){

			$extension = pathinfo($_FILES['fileselect']['name'], PATHINFO_EXTENSION);

			if(!in_array(strtolower($extension), $allowed)){
				header('Location: ../View/uploadFileMiddleware_error.php'); exit();
			}else if(move_uploaded_file($_FILES['fileselect']['tmp_name'], '../uploads/'.$_FILES['fileselect']['name'])){

					// get the document informations
					include '../Controller/addFileMiddlewares_Controller.php';
				}
		}else{
			header('Location: ../View/uploadFileMiddleware_error.php'); exit();
		}
	}else{
		header('Location: ../View/uploadFileMiddleware_error.php'); exit();
	}
	

?>