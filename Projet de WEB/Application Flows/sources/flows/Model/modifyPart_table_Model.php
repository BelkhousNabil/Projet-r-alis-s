<?php

	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	/* Get the Id of the environment that we had chosen */
	$sql5 = "select id from environment where name ='".$env."'";
	$resultrech5 = $dbh->query($sql5);
	$result5 = $resultrech5->fetch();
	(int)$environ = $result5[0];

	//Select the id description of the partner
	$sql1="select id_desc from partner where name='".$idf."'";
	$resultrech1 = $dbh->query($sql1);
	$result1 = $resultrech1->fetch();
	$id = $result1[0];
	
	//The case that we change the name of the partner
	if($idf != $name_mid){
		
		//See if the name doesn't already exist on the DB
		$sql="select count(*) from partner where name='".$name_mid."'";
		$resultrech = $dbh->query($sql);
		$result = $resultrech->fetch();
		$count = $result[0];

		if($count==0){
			//update the description
			$updateDesc = $dbh->query("update description set idenv=$environ,localisation='$loc',ipadr='$ip', dns='$dns', server='$server',compte='$access' where iddesc ='".$id."'");
			
			//get the new restricted name of the partner
			$sqlNameRest="select restricted_name from partner where name ='".$idf."'";
			$restName = $dbh->query($sqlNameRest);
			$name_rest_old = $restName->fetch();

			$rest_name = substr($name_mid, 0, strrpos($name_mid, "_"));

			//update the partner
			$updateMidd = $dbh->query("update partner set name='$name_mid', id_desc='$id' , restricted_name = '$rest_name', description = '$description', contact = '$contacts', tech_contact = '$tech_cont', tech_desc = '$tech_desc' where name ='".$idf."'");

			// get the name of the flow that contain this partner
			$sqlNameflw="select name from flows where source ='".$idf."'";
			$resultnameFlw = $dbh->query($sqlNameflw);
			while($nameFlw = $resultnameFlw->fetch()){
				// modify the flow name
				$newFlwName = str_replace($name_rest_old, $rest_name, $nameFlw[0]);

				// update the the flows 
				$updateFlows = $dbh->query("update flows set source = '$name_mid' where source ='".$idf."'");
			}
			
			// get the name of the flow that contain this partner destination
			$sqlNameflw="select name from flows where destination ='".$idf."'";
			$resultnameFlw = $dbh->query($sqlNameflw);
			while($nameFlw = $resultnameFlw->fetch()){
				// modify the flow name
				$newFlwName = str_replace($name_rest_old, $rest_name, $nameFlw[0]);

				// update the the flows 
				$updateFlows = $dbh->query("update flows set destination = '$name_mid' where destination ='".$idf."'");
			}

			header('Location: ../View/partner.php');	
		}else{
				header('Location: ../View/updatePartner_error.php');	
		}
	}else{
			//update the description
			$updateDesc = $dbh->query("update description set idenv=$environ,localisation='$loc',ipadr='$ip', dns='$dns', server='$server',compte='$access' where iddesc ='".$id."'");
			//update the partner
			$updateMidd = $dbh->query("update partner set name='$name_mid', id_desc='$id' , restricted_name = '$rest_name', description = '$description', contact = '$contacts', tech_contact = '$tech_cont', tech_desc = '$tech_desc' where name ='".$idf."'");

			header('Location: ../View/partner.php');	
	}
	
?>