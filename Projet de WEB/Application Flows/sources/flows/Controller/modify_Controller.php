<?php
	session_start();
	if(!$_SESSION['owner'])
	{
		header('Location: ../index.php');
	}

	// include the connection of the DB application
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

	$server = trim($_POST['server']) ;
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

		$client = trim($_POST['client']) ;
			$client = str_replace("\"", "&quot;", $client);
			$client = str_replace('\'', "&apos;", $client);

		$users = trim($_POST['users']) ;
			$users = str_replace("\"", "&quot;", $users);
			$users = str_replace('\'', "&apos;", $users);

		$contact_cl = trim($_POST['contact_cl']) ;
			$contact_cl = str_replace("\"", "&quot;", $contact_cl);
			$contact_cl = str_replace('\'', "&apos;", $contact_cl);

		$service = trim($_POST['service']) ;
			$service = str_replace("\"", "&quot;", $service);
			$service = str_replace('\'', "&apos;", $service);

		$appli_manager = trim($_POST['appli_manager']) ;
			$appli_manager = str_replace("\"", "&quot;", $appli_manager);
			$appli_manager = str_replace('\'', "&apos;", $appli_manager);

		$appli_team = trim($_POST['appli_team']) ;
			$appli_team = str_replace("\"", "&quot;", $appli_team);
			$appli_team = str_replace('\'', "&apos;", $appli_team);

		$prod_team = trim($_POST['prod_team']) ;
			$prod_team = str_replace("\"", "&quot;", $prod_team);
			$prod_team = str_replace('\'', "&apos;", $prod_team);

		$tech_desc = trim($_POST['tech_desc']) ;
			$tech_desc = str_replace("\"", "&quot;", $tech_desc);
			$tech_desc = str_replace('\'', "&apos;", $tech_desc);

	
	require_once '../Model/modify_Model.php';
	

?>