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

	// get the environments number
	$sqlCountEv="select count(*) from environment";
	$resultrechCountEv = $dbh->query($sqlCountEv);
    $cptEv = $resultrechCountEv->fetch();

    $i=1;
    while ($i < $cptEv[0]+1) {
   		
   		// save the information while we are connected
		$_SESSION['middleware'] = $_POST['name_mid'];
			$_SESSION['middleware'] = str_replace("\"", "&quot;", $_SESSION['middleware']);
			$_SESSION['middleware'] = str_replace("'", "&apos;", $_SESSION['middleware']);
		
		$name_mid = $_POST['name_mid'];
			$name_mid = str_replace("\"", "&quot;", $name_mid);
			$name_mid = str_replace('\'', "&apos;", $name_mid);

   		// Get name environment
		$sqlGetEv="select name from environment where id=$i";
		$resultrechGetEv = $dbh->query($sqlGetEv);
	    $GetEv = $resultrechGetEv->fetch();

   		/* Recover the submited information */
   		$name = trim($_POST['name_mid'])."_".$GetEv[0];
   			$name = str_replace("\"", "&quot;", $name);
			$name = str_replace('\'', "&apos;", $name);

		$loc = trim($_POST['loc'.$i]) ;
			$loc = str_replace("\"", "&quot;", $loc);
			$loc = str_replace('\'', "&apos;", $loc);

		$server = trim($_POST['name_server'.$i]) ;
			$server = str_replace("\"", "&quot;", $server);
			$server = str_replace('\'', "&apos;", $server);

		$ip = trim($_POST['ip'.$i]) ;
			$ip = str_replace("\"", "&quot;", $ip);
			$ip = str_replace('\'', "&apos;", $ip);

		$dns = trim($_POST['dns'.$i]) ;
			$dns = str_replace("\"", "&quot;", $dns);
			$dns = str_replace('\'', "&apos;", $dns);

		$access = trim($_POST['account'.$i]) ;
			$access = str_replace("\"", "&quot;", $access);
			$access = str_replace('\'', "&apos;", $access);

		$description = trim($_POST['desc'.$i]) ;
			$description = str_replace("\"", "&quot;", $description);
			$description = str_replace('\'', "&apos;", $description);

		$client = trim($_POST['client'.$i]) ;
			$client = str_replace("\"", "&quot;", $client);
			$client = str_replace('\'', "&apos;", $client);

		$users = trim($_POST['users'.$i]) ;
			$users = str_replace("\"", "&quot;", $users);
			$users = str_replace('\'', "&apos;", $users);

		$contact_cl = trim($_POST['contact_cl'.$i]) ;
			$contact_cl = str_replace("\"", "&quot;", $contact_cl);
			$contact_cl = str_replace('\'', "&apos;", $contact_cl);

		$service = trim($_POST['service'.$i]) ;
			$service = str_replace("\"", "&quot;", $service);
			$service = str_replace('\'', "&apos;", $service);

		$appli_manager = trim($_POST['appli_manager'.$i]) ;
			$appli_manager = str_replace("\"", "&quot;", $appli_manager);
			$appli_manager = str_replace('\'', "&apos;", $appli_manager);

		$appli_team = trim($_POST['appli_team'.$i]) ;
			$appli_team = str_replace("\"", "&quot;", $appli_team);
			$appli_team = str_replace('\'', "&apos;", $appli_team);

		$prod_team = trim($_POST['prod_team'.$i]) ;
			$prod_team = str_replace("\"", "&quot;", $prod_team);
			$prod_team = str_replace('\'', "&apos;", $prod_team);

		$tech_desc = trim($_POST['tech_desc'.$i]) ;
			$tech_desc = str_replace("\"", "&quot;", $tech_desc);
			$tech_desc = str_replace('\'', "&apos;", $tech_desc);

		$env = trim($GetEv[0]);

		// save the information while we are connected
		$_SESSION['environment'.$i] = $env;
		$_SESSION['location'.$i] = $loc;
		$_SESSION['server'.$i] = $server;
		$_SESSION['ip'.$i] = $ip;
		$_SESSION['dns'.$i] = $dns;
		$_SESSION['acces'.$i] = $access;

		$_SESSION['desc'.$i] = $description;
		$_SESSION['client'.$i] = $client;
		$_SESSION['users'.$i] = $users;
		$_SESSION['contact_cl'.$i] = $contact_cl;
		$_SESSION['service'.$i] = $service;
		$_SESSION['appli_manager'.$i] = $appli_manager;

		$_SESSION['appli_team'.$i] = $appli_team;
		$_SESSION['prod_team'.$i] = $prod_team;
		$_SESSION['tech_desc'.$i] = $tech_desc;
		
		if($loc !='' or $server !='' or $ip !='' or $dns !='' or $access !='' or $description !='' or $client !='' or $users !='' or $contact_cl !='' or $service !='' or $appli_manager !='' or $appli_team !='' or $prod_team !='' or $tech_desc !=''){
			/* see Model */
			include '../Model/addMidd_Model.php';
		}
		

		$i++;
    }

    header('Location: ../View/middleware.php');

?>