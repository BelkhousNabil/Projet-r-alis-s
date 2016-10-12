<?php

	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	/* Get the Id of the environment that we had chosen */
	$sql5 = "select * from environment where name ='".$env."'";
	$resultrech5 = $dbh->query($sql5);
	$result5 = $resultrech5->fetch();
	(int)$environ = $result5[0];

	//Select the id description of the component
	$sql1="select id_desc from component where name='".$name."'";
	$resultrech1 = $dbh->query($sql1);
	$result1 = $resultrech1->fetch();
	$id = $result1[0];
	
	//The case that we change the name of the component
	if($name != $name_mid){
		
		//See if the name doesn't already exist on the DB
		$sql="select count(*) from component where name='".$name_mid."'";
		$resultrech = $dbh->query($sql);
		$result = $resultrech->fetch();
		$count = $result[0];

		if($count==0){
			//update the description
			$updateDesc = $dbh->query("update description set idenv=$environ,localisation='$loc',ipadr='$ip', dns='$dns', server='$server',compte='$access' where iddesc ='".$id."'");
			
			//get the new restricted name of the component
			$sqlNameRest="select restricted_name from component where name ='".$name."'";
			$restName = $dbh->query($sqlNameRest);
			$name_rest_old = $restName->fetch();

			$rest_name = substr($name_mid, 0, strrpos($name_mid, "_"));

			//update the component
			$updateMidd = $dbh->query("update component set name='$name_mid', id_desc='$id' , restricted_name = '$rest_name', description = '$description', contact = '$contacts', tech_contact = '$tech_cont', tech_desc = '$tech_desc' where name ='".$name."'");

			// get the name of the flow that contain this component 1
			$sqlNameflw="select name from flows where component_1 ='".$name."'";
			$resultnameFlw = $dbh->query($sqlNameflw);
			while($nameFlw = $resultnameFlw->fetch()){
				// modify the flow name
				$newFlwName = str_replace($name_rest_old, $rest_name, $nameFlw[0]);

				// update the the flows 
				$updateFlows = $dbh->query("update flows set component_1 = '$name_mid' where component_1 ='".$name."'");
			}
			
			// get the name of the flow that contain this component 2
			$sqlNameflw="select name from flows where component_2 ='".$name."'";
			$resultnameFlw = $dbh->query($sqlNameflw);
			while($nameFlw = $resultnameFlw->fetch()){
				// modify the flow name
				$newFlwName = str_replace($name_rest_old, $rest_name, $nameFlw[0]);

				// update the the flows 
				$updateFlows = $dbh->query("update flows set component_2 = '$name_mid' where component_2 ='".$name."'");
			}

			header('Location: ../View/component.php');	
		}else{
				header('Location: ../View/updateComponent_error.php');	
		}
	}else{
			//update the description
			$updateDesc = $dbh->query("update description set idenv=$environ,localisation='$loc',ipadr='$ip', dns='$dns', server='$server',compte='$access' where iddesc ='".$id."'");
			//update the component
			$updateMidd = $dbh->query("update component set id_desc='$id' , description = '$description', contact = '$contacts', tech_contact = '$tech_cont', tech_desc = '$tech_desc' where name ='".$name."'");

			header('Location: ../View/component.php');	
	}
	
?>