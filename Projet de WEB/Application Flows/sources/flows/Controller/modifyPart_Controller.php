<?php
	session_start();
	if(!$_SESSION['owner']){
		header('Location: ../index.php');
	}

	// include the connection DB script
	require_once '../Config/BD_Conn.php';

	// Display the details errors of the queries
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$name=$_SESSION['dropName'];
		$name = str_replace("\"", "&quot;", $name);
        $name = str_replace('\'', "&apos;", $name);

	$name_mid = trim($_POST['name_mid']) ;
		$name_mid = str_replace("\"", "&quot;", $name_mid);
        $name_mid = str_replace('\'', "&apos;", $name_mid);

	/* Recover the submited information */
	$env = trim($_POST['select_env']) ;
		$env = str_replace("\"", "&quot;", $env);
        $env = str_replace('\'', "&apos;", $env);

	$loc = trim($_POST['loc']) ;
		$loc = str_replace("\"", "&quot;", $loc);
        $loc = str_replace('\'', "&apos;", $loc);

	$server = trim($_POST['name_server']) ;
		$server = str_replace("\"", "&quot;", $server);
        $server = str_replace('\'', "&apos;", $server);

	$ip = trim($_POST['ip']) ;
		$ip = str_replace("\"", "&quot;", $ip);
        $ip = str_replace('\'', "&apos;", $ip);

	//$port = trim($_POST['port']) ;
	$dns = trim($_POST['dns']) ;
		$dns = str_replace("\"", "&quot;", $dns);
        $dns = str_replace('\'', "&apos;", $dns);

	$access = trim($_POST['account']) ;
		$access = str_replace("\"", "&quot;", $access);
        $access = str_replace('\'', "&apos;", $access);
	
	$description = trim($_POST['desc']) ;
		$description = str_replace("\"", "&quot;", $description);
		$description = str_replace('\'', "&apos;", $description);

	$contacts = trim($_POST['contacts']) ;
		$contacts = str_replace("\"", "&quot;", $contacts);
		$contacts = str_replace('\'', "&apos;", $contacts);

	$tech_cont = trim($_POST['tech_cont']) ;
		$tech_cont = str_replace("\"", "&quot;", $tech_cont);
		$tech_cont = str_replace('\'', "&apos;", $tech_cont);

	$tech_desc = trim($_POST['tech_desc']) ;
		$tech_desc = str_replace("\"", "&quot;", $tech_desc);
		$tech_desc = str_replace('\'', "&apos;", $tech_desc);
		
	require_once '../Model/modifyPart_Model.php';
	

?>