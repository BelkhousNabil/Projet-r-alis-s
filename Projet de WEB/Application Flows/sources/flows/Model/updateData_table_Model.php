<?php

	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	/* Get the description id of ther middleware */
	$sql="select * from middleware where name='".$id."'";
	$resultrech = $dbh->query($sql);
	$result = $resultrech->fetch();
	$re = $result[1];
	/* Get the environment id */
	$sql1="select idenv from description where iddesc ='".$re."'";
	$resultrech1 = $dbh->query($sql1);
	$result1 = $resultrech1->fetch();

		/* Get the environment of the middleware*/
		$sql3="select name from environment where id='".$result1[0]."'";
		$resultrech3 = $dbh->query($sql3);
		$result3 = $resultrech3->fetch();

	/* Get the complete description of the middleware */
	$sql2="select * from description where iddesc ='".$re."'";
	$resultrech2 = $dbh->query($sql2);
	$result2 = $resultrech2->fetch();

	$name = trim($id) ;
		$name = str_replace("\"", "&quot;", $name);
    	$name = str_replace('\'', "&apos;", $name);

	$env = trim($result3[0]) ;
		$env = str_replace("\"", "&quot;", $env);
    	$env = str_replace('\'', "&apos;", $env);

	$loc = trim($result2[2]) ;
		$loc = str_replace("\"", "&quot;", $loc);
    	$loc = str_replace('\'', "&apos;", $loc);

	$server = trim($result2[5]) ;
		$server = str_replace("\"", "&quot;", $server);
    	$server = str_replace('\'', "&apos;", $server);

	$ip = trim($result2[3]) ;
		$ip = str_replace("\"", "&quot;", $ip);
    	$ip = str_replace('\'', "&apos;", $ip);

	$dns = trim($result2[4]) ;
		$dns = str_replace("\"", "&quot;", $dns);
    	$dns = str_replace('\'', "&apos;", $dns);

	$access = trim($result2[6]) ;
		$access = str_replace("\"", "&quot;", $access);
    	$access = str_replace('\'', "&apos;", $access);

    $description = trim($result[3]) ;
		$description = str_replace("\"", "&quot;", $description);
		$description = str_replace('\'', "&apos;", $description);

	$client = trim($result[4]) ;
		$client = str_replace("\"", "&quot;", $client);
		$client = str_replace('\'', "&apos;", $client);

	$users = trim($result[5]) ;
		$users = str_replace("\"", "&quot;", $users);
		$users = str_replace('\'', "&apos;", $users);

	$contact_cl = trim($result[6]) ;
		$contact_cl = str_replace("\"", "&quot;", $contact_cl);
		$contact_cl = str_replace('\'', "&apos;", $contact_cl);

	$service = trim($result[7]) ;
		$service = str_replace("\"", "&quot;", $service);
		$service = str_replace('\'', "&apos;", $service);

	$appli_manager = trim($result[8]) ;
		$appli_manager = str_replace("\"", "&quot;", $appli_manager);
		$appli_manager = str_replace('\'', "&apos;", $appli_manager);

	$appli_team = trim($result[9]) ;
		$appli_team = str_replace("\"", "&quot;", $appli_team);
		$appli_team = str_replace('\'', "&apos;", $appli_team);

	$prod_team = trim($result[10]) ;
		$prod_team = str_replace("\"", "&quot;", $prod_team);
		$prod_team = str_replace('\'', "&apos;", $prod_team);

	$tech_desc = trim($result[11]) ;
		$tech_desc = str_replace("\"", "&quot;", $tech_desc);
		$tech_desc = str_replace('\'', "&apos;", $tech_desc);

	
?>