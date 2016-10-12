<?php
	
	// Details of the error messages
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	/* check if there is no middleware that have the same name whose is in the parameter */
	$sql="select count(*) from middleware where name='".$name."'";
	$resultrech = $dbh->query($sql);
	$result = $resultrech->fetch();
	$count = $result[0];
	
	if($count==0){
		/* Get the Id of the environment that we had chosen */
		$sql = "select id from environment where name ='".$env."'";
		$resultrech = $dbh->query($sql);
		$result = $resultrech->fetch();
		(int)$environ = $result[0];

		/* Add the description of the middleware */
		$sql2="insert into description(idenv,localisation,ipadr,dns,server,compte) values($environ,'$loc','$ip','$dns','$server','$access')";
		$result = $dbh->query($sql2);
		
		/* Get the last description that we stored in the DB (The appropriate description for the middleware) */
		$sql = "select MAX(iddesc) from description";
		$resultrech = $dbh->query($sql);
		$result = $resultrech->fetch();
		(int)$max = $result[0];
		/* Add the middleware into the DB */
		$sql2="insert into middleware(name,id_desc,restricted_name,description,client,users,contact_client,service,appli_manager,appli_managment,prod_team,tech_desc) values('$name',$max,'$name_mid','$description','$client','$users','$contact_cl','$service','$appli_manager','$appli_team','$prod_team','$tech_desc')";
		$result = $dbh->query($sql2);

		/* Close the query */
		$resultrech->closeCursor();
		
	}else{
		/* Redirection because of errors */
		header('Location: ../View/addMiddleware_error.php');exit();
	}

?>