<?php

	// Verify if the session is already existing otherwise redirection into the connexion page
	session_start();
	if(!$_SESSION['owner'])
	{
		header('Location: ../index.php');
	}

	// Include the connexion of the DB in oreder to acces into the application
	require_once '../Config/BD_Conn.php';
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	/* Recover the submited information */
	$login = trim($_POST['log']) ;
	$password = trim($_POST['mp']) ;
	
	/* see Model */
	include '../Model/user_Model.php';

	// Verify the fact that the email and the password are correspanding to an account that exits in the DB
	if ( $count == 1 )
	{
		/* Open the a new session */
		$_SESSION['owner']=$login;
		/* Redirection into the home page */
		header('Location:../View/flows.php');
	}
	else 
	{
		/* if there are erros: Redirection into the error connexion page */
		header('Location: ../View/connexionErr.php');	
	}
	// Closing of the query
	$resultrech->closeCursor();
		
?>