<?php

	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	/* Get the Id of the environment that we had chosen */
	$sql5 = "select id from environment where name ='".$env."'";
	$resultrech5 = $dbh->query($sql5);
	$result5 = $resultrech5->fetch();
	(int)$environ = $result5[0];

	//Select the id description of the middleware that have this parameter name
	$sql1="select id_desc from middleware where name='".$idf."'";
	$resultrech1 = $dbh->query($sql1);
	$result1 = $resultrech1->fetch();
	$id = $result1[0];
	
	//The case that we change the name of the middleware
	if($idf != $name_mid){
		
		//See if the name doesn't already exist on the DB
		$sql="select count(*) from middleware where name='".$name_mid."'";
		$resultrech = $dbh->query($sql);
		$result = $resultrech->fetch();
		$count = $result[0];

		if($count==0){
			//update the description
			$updateDesc = $dbh->query("update description set idenv=$environ,localisation='$loc',ipadr='$ip', dns='$dns', server='$server',compte='$access' where iddesc ='".$id."'");

			//get the new restricted name of the middleware
			$sqlNameRest="select restricted_name from middleware where name ='".$idf."'";
			$restName = $dbh->query($sqlNameRest);
			$name_rest_old = $restName->fetch();

			$rest_name = substr($name_mid, 0, strrpos($name_mid, "_"));

			//update the middleware
			$updateMidd = $dbh->query("update middleware set name='$name_mid', id_desc='$id' , restricted_name = '$rest_name', description='$description',client='$client',users='$users', contact_client='$contact_cl', service='$service', appli_manager='$appli_manager', appli_managment='$appli_team', prod_team='$prod_team', tech_desc='$tech_desc' where name ='".$idf."'");

			// get the name of the flow that contain this middleware
			$sqlNameflw="select name from flows where middleware ='".$idf."'";
			$resultnameFlw = $dbh->query($sqlNameflw);
			while($nameFlw = $resultnameFlw->fetch()){
				// modify the flow name
				$newFlwName = str_replace($name_rest_old, $rest_name, $nameFlw[0]);

				// update the name middleware on the flows 
				$updateFlows = $dbh->query("update flows set name = '$newFlwName', middleware = '$name_mid' where middleware ='".$idf."'");
			}
			header('Location: ../View/middleware.php');	
		}else{
				header('Location: ../View/updateMiddleware_error.php');	
		}
	}else{
			//update the description
			$updateDesc = $dbh->query("update description set idenv=$environ,localisation='$loc',ipadr='$ip', dns='$dns', server='$server',compte='$access' where iddesc ='".$id."'");
			//update the middleware
			$updateMidd = $dbh->query("update middleware set description='$description',client='$client',users='$users', contact_client='$contact_cl', service='$service', appli_manager='$appli_manager', appli_managment='$appli_team', prod_team='$prod_team', tech_desc='$tech_desc' where name ='".$idf."'");

			header('Location: ../View/middleware.php');	
	}
	
?>