<?php
	session_start();
	if(!$_SESSION['owner'])
	{
		header('Location: ../index.php');
	}

	// Include the connexion of the DB in oreder to acces into the application
	require_once '../Config/BD_Conn.php';

	// Query that will gives the name of the owner
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	/* Recover the submited information */
	$source = trim($_POST['s1']) ;
		$source = str_replace("\"", "&quot;", $source);
    	$source = str_replace('\'', "&apos;", $source);

	$destination = trim($_POST['d1']) ;
		$destination = str_replace("\"", "&quot;", $destination);
    	$destination = str_replace('\'', "&apos;", $destination);

	$comp1 = trim($_POST['c1']) ;
		$comp1 = str_replace("\"", "&quot;", $comp1);
    	$comp1 = str_replace('\'', "&apos;", $comp1);

	$midd = trim($_POST['m1']) ;
		$midd = str_replace("\"", "&quot;", $midd);
    	$midd = str_replace('\'', "&apos;", $midd);
    	
	$comp2 = trim($_POST['ct1']) ;
		$comp2 = str_replace("\"", "&quot;", $comp2);
    	$comp2 = str_replace('\'', "&apos;", $comp2);

    $protocol = trim($_POST['p1']) ;
		$protocol = str_replace("\"", "&quot;", $protocol);
    	$protocol = str_replace('\'', "&apos;", $protocol);

	$flowName = $_SESSION['flw'];
		$flowName = str_replace("\"", "&quot;", $flowName);
    	$flowName = str_replace('\'', "&apos;", $flowName);

	/* verify the fact that the source doesn't exist in the DB application */
	$sqlCountSource = "select count(*) from partner where name = '".$source."'";
	$resultCountSource = $dbh->query($sqlCountSource);
	$countSource = $resultCountSource->fetch();
	(int)$cptSource = $countSource[0];

	// Check if the source given exist on the DB application
	if($cptSource == 0){
		header('Location: updateFlows_error_Controller.php'); exit();
	}

	/* verify the fact that the destination doesn't exist in the DB application */
	$sqlCountDest = "select count(*) from partner where name = '".$destination."'";
	$resultCountDest = $dbh->query($sqlCountDest);
	$countDest = $resultCountDest->fetch();
	(int)$cptDest = $countDest[0];

	// Check if the source given exist on the DB application
	if($cptDest == 0){
		header('Location: updateFlows_error_Controller.php'); exit();
	}

	/* verify the fact that the middleawre doesn't exist in the DB application */
	$sqlCountMidd = "select count(*) from middleware where name = '".$midd."'";
	$resultCountMidd = $dbh->query($sqlCountMidd);
	$countMidd = $resultCountMidd->fetch();
	(int)$cptMidd = $countMidd[0];

	// Check if the middleware given exist on the DB application
	if($cptMidd == 0){
		header('Location: updateFlows_error_Controller.php'); exit();
	}

	$flowName = $_SESSION['flw'];

	if(empty($_POST['c1'])){
		$comp1="";
	}else{
			/* verify the fact that the component1 doesn't exist in the DB application */
			$sqlCountComp1 = "select count(*) from component where name = '".$comp1."'";
			$resultCountComp1 = $dbh->query($sqlCountComp1);
			$countComp1 = $resultCountComp1->fetch();
			(int)$cptComp1 = $countComp1[0];

			// Check if the first component given exist on the DB application
			if($cptComp1 == 0){
				header('Location: updateFlows_error_Controller.php'); exit();
			}
	}

	if(empty($_POST['ct1'])){
		$comp2="";
	}else{
			/* verify the fact that the component2 doesn't exist in the DB application */
			$sqlCountComp2 = "select count(*) from component where name = '".$comp2."'";
			$resultCountComp2 = $dbh->query($sqlCountComp2);
			$countComp2 = $resultCountComp2->fetch();
			(int)$cptComp2 = $countComp2[0];

			// Check if the seconde component given exist on the DB application
			if($cptComp2 == 0){
				header('Location: updateFlows_error_Controller.php'); exit();
			}
	}

	// update the flow information
	$sqlUpdateFlw = "update flows set source='$source', destination='$destination', component_1='$comp1', middleware='$midd', component_2='$comp2', protocol = '$protocol' where name = '$flowName' ";
	$resultUpdateFlw = $dbh->query($sqlUpdateFlw);



	$data_id = trim($_POST['id_Data1']) ;
	
	// If at leaste one of the information of the first data flow are not empty
	if(!empty($_POST['desc1']) or !empty($_POST['type1']) or !empty($_POST['freq1']) or !empty($_POST['volu1']) or !empty($_POST['tran1']) or !empty($_POST['cont1']) or !empty($_POST['trea1']) or !empty($_POST['secu1']) or !empty($_POST['cons1']) or !empty($_FILES["file1"]["name"])){
		$desc1 = trim($_POST['desc1']) ;
			$desc1 = str_replace("\"", "&quot;", $desc1);
			$desc1 = str_replace('\'', "&apos;", $desc1);

		$tech_desc1 = trim($_POST['tech_desc1']) ;
			$tech_desc1 = str_replace("\"", "&quot;", $tech_desc1);
			$tech_desc1 = str_replace('\'', "&apos;", $tech_desc1);

		$type1 = trim($_POST['type1']) ; 
			$type1 = str_replace("\"", "&quot;", $type1);
			$type1 = str_replace('\'', "&apos;", $type1);

		$freq1 = trim($_POST['freq1']) ; 
			$freq1 = str_replace("\"", "&quot;", $freq1);
			$freq1 = str_replace('\'', "&apos;", $freq1);

		$volu1 = trim($_POST['volu1']) ;
			$volu1 = str_replace("\"", "&quot;", $volu1);
			$volu1 = str_replace('\'', "&apos;", $volu1);

		$tran1 = trim($_POST['tran1']) ;
			$tran1 = str_replace("\"", "&quot;", $tran1);
			$tran1 = str_replace('\'', "&apos;", $tran1);

		$cont1 = trim($_POST['cont1']) ; 
			$cont1 = str_replace("\"", "&quot;", $cont1);
			$cont1 = str_replace('\'', "&apos;", $cont1);

		$trea1 = trim($_POST['trea1']) ;
			$trea1 = str_replace("\"", "&quot;", $trea1);
			$trea1 = str_replace('\'', "&apos;", $trea1);

		$secu1 = trim($_POST['secu1']) ; 
			$secu1 = str_replace("\"", "&quot;", $secu1);
			$secu1 = str_replace('\'', "&apos;", $secu1);

		$cons1 = trim($_POST['cons1']) ;
			$cons1 = str_replace("\"", "&quot;", $cons1);
			$cons1 = str_replace('\'', "&apos;", $cons1);

		$file1 = $_FILES["file1"]["name"];

		// if a file was uploaded
		if(isset($_FILES["file1"]["name"]) and !empty($_FILES["file1"]["name"])){
			
			move_uploaded_file($_FILES["file1"]["tmp_name"],
			"../download/" . $_FILES["file1"]["name"]) ;
			/* Add the data flows */
			$sqlInsertData = "update data set description='$desc1', desc_tech='$tech_desc1' ,type='$type1', frequence='$freq1', volum='$volu1', transformation='$tran1', control='$cont1', treatment='$trea1', security='$secu1',constr='$cons1' ,file='$file1' where idData = $data_id";
			$resultData = $dbh->query($sqlInsertData);
			
		}else{
			/* Add the data flows */
			$sqlInsertData = "update data set description='$desc1', desc_tech='$tech_desc1' ,type='$type1', frequence='$freq1', volum='$volu1', transformation='$tran1', control='$cont1', treatment='$trea1', security='$secu1',constr='$cons1' where idData = $data_id";
			$resultData = $dbh->query($sqlInsertData);
		}
					
		// if all the information are empty
	}else if(empty($_POST['desc1']) and empty($_POST['type1']) and empty($_POST['freq1']) and empty($_POST['volu1']) and empty($_POST['tran1']) and empty($_POST['cont1']) and empty($_POST['trea1']) and empty($_POST['secu1']) and empty($_POST['cons1']) and empty($_FILES["file1"]["name"])){
		
		$sqlInsertData = "update data set description='', type='', frequence='', volum='', transformation='', control='', treatment='', security='',constr='' where idData = $data_id ";
		$resultData = $dbh->query($sqlInsertData);
	}
		
	$i=2;

	// while we didnt riched the last possible data flow
	while($i<101){

		// if we ticked the add flow check box 
		if(isset($_POST['add'.$i.''])){

			$desc2 = trim($_POST['desc'.$i.'']) ;
				$desc2 = str_replace("\"", "&quot;", $desc2);
				$desc2 = str_replace('\'', "&apos;", $desc2);

			$tech_desc2 = trim($_POST['tech_desc'.$i.'']) ;
				$tech_desc2 = str_replace("\"", "&quot;", $tech_desc2);
				$tech_desc2 = str_replace('\'', "&apos;", $tech_desc2);

			$type2 = trim($_POST['type'.$i.'']) ; 
				$type2 = str_replace("\"", "&quot;", $type2);
				$type2 = str_replace('\'', "&apos;", $type2);

			$freq2 = trim($_POST['freq'.$i.'']) ; 
				$freq2 = str_replace("\"", "&quot;", $freq2);
				$freq2 = str_replace('\'', "&apos;", $freq2);

			$volu2 = trim($_POST['volu'.$i.'']) ;
				$volu2 = str_replace("\"", "&quot;", $volu2);
				$volu2 = str_replace('\'', "&apos;", $volu2);

			$tran2 = trim($_POST['tran'.$i.'']) ; 
				$tran2 = str_replace("\"", "&quot;", $tran2);
				$tran2 = str_replace('\'', "&apos;", $tran2);

			$cont2 = trim($_POST['cont'.$i.'']) ; 
				$cont2 = str_replace("\"", "&quot;", $cont2);
				$cont2 = str_replace('\'', "&apos;", $cont2);

			$trea2 = trim($_POST['trea'.$i.'']) ;
				$trea2 = str_replace("\"", "&quot;", $trea2);
				$trea2 = str_replace('\'', "&apos;", $trea2);

			$secu2 = trim($_POST['secu'.$i.'']) ; 
				$secu2 = str_replace("\"", "&quot;", $secu2);
				$secu2 = str_replace('\'', "&apos;", $secu2);

			$cons2 = trim($_POST['cons'.$i.'']) ;
				$cons2 = str_replace("\"", "&quot;", $cons2);
				$cons2 = str_replace('\'', "&apos;", $cons2);

			$file2 = $_FILES["file".$i.""]["name"];

			if(isset($_FILES["file".$i.""]["name"]) and !empty($_FILES["file".$i.""]["name"])){
				if (file_exists("../download/" . $_FILES["file".$i.""]["name"])){
					echo '<script language="javascript">alert(" Sorry!! $file2 Already Exists, You have to change it through the update")</script>';
					$file2='empty';
				}
				else{
					move_uploaded_file($_FILES["file".$i.""]["tmp_name"],
					"../download/" . $_FILES["file".$i.""]["name"]) ;
				}
			}else{
				$file2='empty';
			}
						
			/* Adding the data flows */
			$sqlInsertData = "insert into data values (DEFAULT,'$desc2','$type2','$freq2','$volu2','$tran2','$cont2','$trea2','$secu2','$cons2','$file2','$tech_desc2')";
			$resultData = $dbh->query($sqlInsertData);

			/* Get the last description that we stored in the DB (The appropriate Data) */
			$sqlMax = "select MAX(idData) from data";
			$resultrechMax = $dbh->query($sqlMax);
			$resultMax = $resultrechMax->fetch();
			(int)$maxId = $resultMax[0];

			/* Addflow */
			$sqlFlow="insert into flows(name,idData,source,destination,component_1,middleware,component_2,protocol) values('$flowName',$maxId,'$source','$destination','$comp1','$midd','$comp2','$protocol')";
			$resultFlow = $dbh->query($sqlFlow);

		}

		// if we updated the old information that already exist
		if(isset($_POST['id_Data'.$i.''])){
			$desc2 = trim($_POST['desc'.$i.'']) ;
				$desc2 = str_replace("\"", "&quot;", $desc2);
				$desc2 = str_replace('\'', "&apos;", $desc2);

			$tech_desc2 = trim($_POST['tech_desc'.$i.'']) ;
				$tech_desc2 = str_replace("\"", "&quot;", $tech_desc2);
				$tech_desc2 = str_replace('\'', "&apos;", $tech_desc2);

			$type2 = trim($_POST['type'.$i.'']) ; 
				$type2 = str_replace("\"", "&quot;", $type2);
				$type2 = str_replace('\'', "&apos;", $type2);

			$freq2 = trim($_POST['freq'.$i.'']) ; 
				$freq2 = str_replace("\"", "&quot;", $freq2);
				$freq2 = str_replace('\'', "&apos;", $freq2);

			$volu2 = trim($_POST['volu'.$i.'']) ;
				$volu2 = str_replace("\"", "&quot;", $volu2);
				$volu2 = str_replace('\'', "&apos;", $volu2);

			$tran2 = trim($_POST['tran'.$i.'']) ;
				$tran2 = str_replace("\"", "&quot;", $tran2);
				$tran2 = str_replace('\'', "&apos;", $tran2);

			$cont2 = trim($_POST['cont'.$i.'']) ; 
				$cont2 = str_replace("\"", "&quot;", $cont2);
				$cont2 = str_replace('\'', "&apos;", $cont2);

			$trea2 = trim($_POST['trea'.$i.'']) ;
				$trea2 = str_replace("\"", "&quot;", $trea2);
				$trea2 = str_replace('\'', "&apos;", $trea2);

			$secu2 = trim($_POST['secu'.$i.'']) ; 
				$secu2 = str_replace("\"", "&quot;", $secu2);
				$secu2 = str_replace('\'', "&apos;", $secu2);

			$cons2 = trim($_POST['cons'.$i.'']) ;
				$cons2 = str_replace("\"", "&quot;", $cons2);
				$cons2 = str_replace('\'', "&apos;", $cons2);

			$file2 = $_FILES["file".$i.""]["name"];

			$data_id = trim($_POST['id_Data'.$i.'']) ;

			if(empty($desc2) and empty($type2) and empty($freq2) and empty($volu2) and empty($tran2) and empty($cont2) and empty($trea2) and empty($secu2) and empty($cons2) and $file2=='empty'){
				$sqlDelete = "delete from data where idData = $data_id ";
				$resultDelete = $dbh->query($sqlDelete);
				$sqlDeleteF = "delete from flows where idData = $data_id ";
				$resultDeleteF = $dbh->query($sqlDeleteF);

			}else{

				if(isset($_FILES["file".$i.""]["name"]) and !empty($_FILES["file".$i.""]["name"])){
					
					move_uploaded_file($_FILES["file".$i.""]["tmp_name"],
					"../download/" . $_FILES["file".$i.""]["name"]) ;

					/* Adding the data flows */
					$sqlInsertData = "update data set description='$desc2', desc_tech ='$tech_desc2', type='$type2', frequence='$freq2', volum='$volu2', transformation='$tran2', control='$cont2', treatment='$trea2', security='$secu2',constr='$cons2' ,file='$file2' where idData = $data_id ";
					$resultData = $dbh->query($sqlInsertData);
					
				}else{
					/* Adding the data flows */
					$sqlInsertData = "update data set description='$desc2',desc_tech ='$tech_desc2',  type='$type2', frequence='$freq2', volum='$volu2', transformation='$tran2', control='$cont2', treatment='$trea2', security='$secu2', constr='$cons2' where idData = $data_id ";
					$resultData = $dbh->query($sqlInsertData);
				}
			}
		}
			
		$i++;
	}

	header('Location: ../View/flows.php');
	
?>