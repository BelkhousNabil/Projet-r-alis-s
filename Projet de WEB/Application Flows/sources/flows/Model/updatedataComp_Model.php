<?php

	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	/* Get the description id of ther component */
	$sql="select * from component where name='".$name."'";
	$resultrech = $dbh->query($sql);
	$result = $resultrech->fetch();
	$re = $result[1];
	/* Get the environment id */
	$sql1="select idenv from description where iddesc ='".$re."'";
	$resultrech1 = $dbh->query($sql1);
	$result1 = $resultrech1->fetch();

		/* Get the environment of the component*/
		$sql3="select name from environment where id='".$result1[0]."'";
		$resultrech3 = $dbh->query($sql3);
		$result3 = $resultrech3->fetch();

	/* Get the complete description of the component */
	$sql2="select * from description where iddesc ='".$re."'";
	$resultrech2 = $dbh->query($sql2);
	$result2 = $resultrech2->fetch();

	$name = trim($name) ;
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

	//$port = trim($result2[4]) ;
	$dns = trim($result2[4]) ;
		$dns = str_replace("\"", "&quot;", $dns);
	    $dns = str_replace('\'', "&apos;", $dns);

	$access = trim($result2[6]) ;
		$access = str_replace("\"", "&quot;", $access);
	    $access = str_replace('\'', "&apos;", $access);
	
	$description = trim($result[3]) ;
		$description = str_replace("\"", "&quot;", $description);
	    $description = str_replace('\'', "&apos;", $description);

	$contacts = trim($result[4]) ;
		$contacts = str_replace("\"", "&quot;", $contacts);
	    $contacts = str_replace('\'', "&apos;", $contacts);

	$tech_cont = trim($result[5]) ;
		$tech_cont = str_replace("\"", "&quot;", $tech_cont);
	    $tech_cont = str_replace('\'', "&apos;", $tech_cont);

	$tech_desc = trim($result[6]) ;
		$tech_desc = str_replace("\"", "&quot;", $tech_desc);
	    $tech_desc = str_replace('\'', "&apos;", $tech_desc);

?>