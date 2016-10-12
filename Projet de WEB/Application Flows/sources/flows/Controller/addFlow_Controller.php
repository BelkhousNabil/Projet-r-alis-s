<?php
	session_start();
	if(!$_SESSION['owner'])
	{
		header('Location: ../index.php');
	}

	// Include the connexion of the DB in oreder to acces into the application
	require_once '../Config/BD_Conn.php';

	// Details of errors that are displayed
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

		$com1 = $comp1;

	$midd = trim($_POST['m1']) ;
		$midd = str_replace("\"", "&quot;", $midd);
		$midd = str_replace('\'', "&apos;", $midd);

	$comp2 = trim($_POST['ct1']) ;	
		$comp2 = str_replace("\"", "&quot;", $comp2);
		$comp2 = str_replace('\'', "&apos;", $comp2);

		$com2 = $comp2;

	$protocol = trim($_POST['p1']) ;
		$protocol = str_replace("\"", "&quot;", $protocol);
		$protocol = str_replace('\'', "&apos;", $protocol);

	/* verify the fact that the source doesn't exist in the DB application */
	$sqlCountSource = "select count(*) from partner where restricted_name = '".$source."'";
	$resultCountSource = $dbh->query($sqlCountSource);
	$countSource = $resultCountSource->fetch();
	(int)$cptSource = $countSource[0];

	// if the source given doesn't exist in the DB application then display an error message
	if($cptSource == 0){
		header('Location: ../View/addFlows_error.php'); exit();
	}

	/* verify the fact that the destination doesn't exist in the DB application */
	$sqlCountDest = "select count(*) from partner where restricted_name = '".$destination."'";
	$resultCountDest = $dbh->query($sqlCountDest);
	$countDest = $resultCountDest->fetch();
	(int)$cptDest = $countDest[0];

	// if the destination given doesn't exist in the DB application then display an error message
	if($cptDest == 0){
		header('Location: ../View/addFlows_error.php'); exit();
	}

	/* verify the fact that the middleawre doesn't exist in the DB application */
	$sqlCountMidd = "select count(*) from middleware where restricted_name = '".$midd."'";
	$resultCountMidd = $dbh->query($sqlCountMidd);
	$countMidd = $resultCountMidd->fetch();
	(int)$cptMidd = $countMidd[0];

	// if the middleware given doesn't exist in the DB application then display an error message
	if($cptMidd == 0){
		header('Location: ../View/addFlows_error.php'); exit();
	}

	$flowName = $_SESSION['flw'];

	if(empty($_POST['c1'])){
		$comp1="";
	}else{
			/* verify the fact that the component1 doesn't exist in the DB application */
			$sqlCountComp1 = "select count(*) from component where restricted_name = '".$comp1."'";
			$resultCountComp1 = $dbh->query($sqlCountComp1);
			$countComp1 = $resultCountComp1->fetch();
			(int)$cptComp1 = $countComp1[0];

			// if the first component given doesn't exist in the DB application then display an error message
			if($cptComp1 == 0){
				header('Location: ../View/addFlows_error.php'); exit();
			}
	}

	if(empty($_POST['ct1'])){
		$comp2="";
	}else{
			/* verify the fact that the component2 doesn't exist in the DB application */
			$sqlCountComp2 = "select count(*) from component where restricted_name = '".$comp2."'";
			$resultCountComp2 = $dbh->query($sqlCountComp2);
			$countComp2 = $resultCountComp2->fetch();
			(int)$cptComp2 = $countComp2[0];

			// if the seconde component given doesn't exist in the DB application then display an error message
			if($cptComp2 == 0){
				header('Location: ../View/addFlows_error.php'); exit();
			}
	}

	// if the fist data is given
	if(isset($_POST['checkDesc'])){
		$addData1 = trim($_POST['checkDesc']) ;
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

		if(isset($_FILES["file1"]["name"]) and !empty($_FILES["file1"]["name"])){
			if (file_exists("../download/" . $_FILES["file1"]["name"])){
				echo '<script language="javascript">alert(" Sorry!! $file1 Already Exists, You have to change it through the update")</script>';
				$file1='empty';
			}
			else{
				move_uploaded_file($_FILES["file1"]["tmp_name"],
				"../download/" . $_FILES["file1"]["name"]) ;
			}
		}else{
			$file1='empty';
		}
					
		/* Add the data flows */
		$sqlInsertData = "insert into data values (DEFAULT,'$desc1','$type1','$freq1','$volu1','$tran1','$cont1','$trea1','$secu1','$cons1','$file1','$tech_desc1')";
		$resultData = $dbh->query($sqlInsertData);

		/* Get the last description that we stored in the DB (The appropriate Data) */
		$sqlMax = "select MAX(idData) from data";
		$resultrechMax = $dbh->query($sqlMax);
		$resultMax = $resultrechMax->fetch();
		(int)$maxId = $resultMax[0];

		// get the environments name
		$sqlNameEv="select name from environment";
		$resultrechNameEv = $dbh->query($sqlNameEv);

		// Iterate on the environments
		while($NameEv = $resultrechNameEv->fetch()){

			$com1 = '';
            $com2 = '';

            if($comp1!=''){
                $com1 = $comp1."_".$NameEv[0];
            }

            if($comp2!=''){
                $com2 = $comp2."_".$NameEv[0];
            }
            
            // check if the midlewares, partners and the components of this environment already exist
            $sqlCountMid="select count(*) from middleware where name = '$midd"."_".$NameEv[0]."'";
			$resultCountMid = $dbh->query($sqlCountMid);
			$countMid = $resultCountMid->fetch();
			
			$sqlCountSource="select count(*) from partner where name = '$source"."_".$NameEv[0]."'";
			$resultCountSource = $dbh->query($sqlCountSource);
			$countSource = $resultCountSource->fetch();

			$sqlCountDesct="select count(*) from partner where name = '$destination"."_".$NameEv[0]."'";
			$resultCountDest = $dbh->query($sqlCountDesct);
			$countDest = $resultCountDest->fetch();

			$sqlCountComp1="select count(*) from component where name = '$com1'";
			$resultCountComp1 = $dbh->query($sqlCountComp1);
			$countComp1 = $resultCountComp1->fetch();	

			$sqlCountComp2="select count(*) from component where name = '$com2'";
			$resultCountComp2 = $dbh->query($sqlCountComp2);
			$countComp2 = $resultCountComp2->fetch();
			
			// The case that have component 1 and component 2 that are not empty
            if($com1 != '' and $com2 != ''){
                if( $countMid[0] !=0 and $countSource[0] != 0 and $countDest[0] != 0 and $countComp1[0] != 0 and $countComp2[0] != 0 ){
                	/* counter of the flows identifiants */
					$requete = "update idf set cpt=cpt+1";
					$resultRequete = $dbh->query($requete);

					// count the flows number in order to give an id for the name
					$sqlCount = "select cpt from idf";
					$resulCount = $dbh->query($sqlCount);
					$resultMax = $resulCount->fetch();
					$count = $resultMax[0];

                    /* Add flow */
                    $sqlFlow="insert into flows(name,idData,source,destination,component_1,middleware,component_2,protocol) values('$midd"."_flow".$count."',$maxId,'$source"."_".$NameEv[0]."','$destination"."_".$NameEv[0]."','$com1','$midd"."_".$NameEv[0]."','$com2','$protocol')";
                    $resultFlow = $dbh->query($sqlFlow);
                }
            }

            // The case that have component 1 and component 2 that are empty
            if($com1 == '' and $com2 == ''){            	
                if( $countMid[0] !=0 and $countSource[0] != 0 and $countDest[0] != 0 ){
                	/* counter of the flows identifiants */
					$requete = "update idf set cpt=cpt+1";
					$resultRequete = $dbh->query($requete);

					// count the flows number in order to give an id for the name
					$sqlCount = "select cpt from idf";
					$resulCount = $dbh->query($sqlCount);
					$resultMax = $resulCount->fetch();
					$count = $resultMax[0];

                    /* Add flow */
                    $sqlFlow="insert into flows(name,idData,source,destination,component_1,middleware,component_2,protocol) values('$midd"."_flow".$count."',$maxId,'$source"."_".$NameEv[0]."','$destination"."_".$NameEv[0]."','$com1','$midd"."_".$NameEv[0]."','$com2','$protocol')";
                    $resultFlow = $dbh->query($sqlFlow);
                }
            }

            // The case that have component 1  that is empty and component 2 that is not empty
            if($com1 == '' and $com2 != ''){            	
                if( $countMid[0] !=0 and $countSource[0] != 0 and $countDest[0] != 0 and $countComp2[0] != 0 ){
                	/* counter of the flows identifiants */
					$requete = "update idf set cpt=cpt+1";
					$resultRequete = $dbh->query($requete);

					// count the flows number in order to give an id for the name
					$sqlCount = "select cpt from idf";
					$resulCount = $dbh->query($sqlCount);
					$resultMax = $resulCount->fetch();
					$count = $resultMax[0];

                    /* Add flow */
                    $sqlFlow="insert into flows(name,idData,source,destination,component_1,middleware,component_2,protocol) values('$midd"."_flow".$count."',$maxId,'$source"."_".$NameEv[0]."','$destination"."_".$NameEv[0]."','$com1','$midd"."_".$NameEv[0]."','$com2','$protocol')";
                    $resultFlow = $dbh->query($sqlFlow);
                }
            }

            // The case that have component 1  that is not empty and component 2 that is empty
            if($com1 != '' and $com2 == ''){
                if( $countMid[0] !=0 and $countSource[0] != 0 and $countDest[0] != 0 and $countComp1[0] != 0 ){
                	/* counter of the flows identifiants */
					$requete = "update idf set cpt=cpt+1";
					$resultRequete = $dbh->query($requete);

					// count the flows number in order to give an id for the name
					$sqlCount = "select cpt from idf";
					$resulCount = $dbh->query($sqlCount);
					$resultMax = $resulCount->fetch();
					$count = $resultMax[0];

                    /* Add flow */
                    $sqlFlow="insert into flows(name,idData,source,destination,component_1,middleware,component_2,protocol) values('$midd"."_flow".$count."',$maxId,'$source"."_".$NameEv[0]."','$destination"."_".$NameEv[0]."','$com1','$midd"."_".$NameEv[0]."','$com2','$protocol')";
                    $resultFlow = $dbh->query($sqlFlow);
                }
            }
    
		}
	
	}else{
		
		/* Add empty data flows */
		$sqlInsertData = "insert into data values (DEFAULT,'','','','','','','','','','','')";
		$resultData = $dbh->query($sqlInsertData);

		/* Get the last description that we stored in the DB (The appropriate Data) */
		$sqlMax = "select MAX(idData) from data";
		$resultrechMax = $dbh->query($sqlMax);
		$resultMax = $resultrechMax->fetch();
		(int)$maxId = $resultMax[0];

		// get the environments name
		$sqlNameEv="select name from environment";
		$resultrechNameEv = $dbh->query($sqlNameEv);

		// Iterate on the environments
		while($NameEv = $resultrechNameEv->fetch()){

			$com1 = '';
            $com2 = '';

            if($comp1!=''){
                $com1 = $comp1."_".$NameEv[0];
            }

            if($comp2!=''){
                $com2 = $comp2."_".$NameEv[0];
            }
            
            // check if the midlewares, partners and the components of this environment already exist
            $sqlCountMid="select count(*) from middleware where name = '$midd"."_".$NameEv[0]."'";
			$resultCountMid = $dbh->query($sqlCountMid);
			$countMid = $resultCountMid->fetch();
			
			$sqlCountSource="select count(*) from partner where name = '$source"."_".$NameEv[0]."'";
			$resultCountSource = $dbh->query($sqlCountSource);
			$countSource = $resultCountSource->fetch();

			$sqlCountDesct="select count(*) from partner where name = '$destination"."_".$NameEv[0]."'";
			$resultCountDest = $dbh->query($sqlCountDesct);
			$countDest = $resultCountDest->fetch();

			$sqlCountComp1="select count(*) from component where name = '$com1'";
			$resultCountComp1 = $dbh->query($sqlCountComp1);
			$countComp1 = $resultCountComp1->fetch();	

			$sqlCountComp2="select count(*) from component where name = '$com2'";
			$resultCountComp2 = $dbh->query($sqlCountComp2);
			$countComp2 = $resultCountComp2->fetch();
			
			// The case that have component 1 and component 2 that are not empty
            if($com1 != '' and $com2 != ''){
                if( $countMid[0] !=0 and $countSource[0] != 0 and $countDest[0] != 0 and $countComp1[0] != 0 and $countComp2[0] != 0 ){
                	/* counter of the flows identifiants */
					$requete = "update idf set cpt=cpt+1";
					$resultRequete = $dbh->query($requete);

					// count the flows number in order to give an id for the name
					$sqlCount = "select cpt from idf";
					$resulCount = $dbh->query($sqlCount);
					$resultMax = $resulCount->fetch();
					$count = $resultMax[0];

                    /* Add flow */
                    $sqlFlow="insert into flows(name,idData,source,destination,component_1,middleware,component_2,protocol) values('$midd"."_flow".$count."',$maxId,'$source"."_".$NameEv[0]."','$destination"."_".$NameEv[0]."','$com1','$midd"."_".$NameEv[0]."','$com2','$protocol')";
                    $resultFlow = $dbh->query($sqlFlow);
                }
            }

            // The case that have component 1 and component 2 that are empty
            if($com1 == '' and $com2 == ''){            	
                if( $countMid[0] !=0 and $countSource[0] != 0 and $countDest[0] != 0 ){
                	/* counter of the flows identifiants */
					$requete = "update idf set cpt=cpt+1";
					$resultRequete = $dbh->query($requete);

					// count the flows number in order to give an id for the name
					$sqlCount = "select cpt from idf";
					$resulCount = $dbh->query($sqlCount);
					$resultMax = $resulCount->fetch();
					$count = $resultMax[0];

                    /* Add flow */
                    $sqlFlow="insert into flows(name,idData,source,destination,component_1,middleware,component_2,protocol) values('$midd"."_flow".$count."',$maxId,'$source"."_".$NameEv[0]."','$destination"."_".$NameEv[0]."','$com1','$midd"."_".$NameEv[0]."','$com2','$protocol')";
                    $resultFlow = $dbh->query($sqlFlow);
                }
            }

            // The case that have component 1  that is empty and component 2 that is not empty
            if($com1 == '' and $com2 != ''){            	
                if( $countMid[0] !=0 and $countSource[0] != 0 and $countDest[0] != 0 and $countComp2[0] != 0 ){
                	/* counter of the flows identifiants */
					$requete = "update idf set cpt=cpt+1";
					$resultRequete = $dbh->query($requete);

					// count the flows number in order to give an id for the name
					$sqlCount = "select cpt from idf";
					$resulCount = $dbh->query($sqlCount);
					$resultMax = $resulCount->fetch();
					$count = $resultMax[0];

                    /* Add flow */
                    $sqlFlow="insert into flows(name,idData,source,destination,component_1,middleware,component_2,protocol) values('$midd"."_flow".$count."',$maxId,'$source"."_".$NameEv[0]."','$destination"."_".$NameEv[0]."','$com1','$midd"."_".$NameEv[0]."','$com2','$protocol')";
                    $resultFlow = $dbh->query($sqlFlow);
                }
            }

            // The case that have component 1  that is not empty and component 2 that is empty
            if($com1 != '' and $com2 == ''){
                if( $countMid[0] !=0 and $countSource[0] != 0 and $countDest[0] != 0 and $countComp1[0] != 0 ){
                	/* counter of the flows identifiants */
					$requete = "update idf set cpt=cpt+1";
					$resultRequete = $dbh->query($requete);

					// count the flows number in order to give an id for the name
					$sqlCount = "select cpt from idf";
					$resulCount = $dbh->query($sqlCount);
					$resultMax = $resulCount->fetch();
					$count = $resultMax[0];

                    /* Add flow */
                    $sqlFlow="insert into flows(name,idData,source,destination,component_1,middleware,component_2,protocol) values('$midd"."_flow".$count."',$maxId,'$source"."_".$NameEv[0]."','$destination"."_".$NameEv[0]."','$com1','$midd"."_".$NameEv[0]."','$com2','$protocol')";
                    $resultFlow = $dbh->query($sqlFlow);
                }
            }

		}

		header('Location: ../View/flows.php');
	}
		
	// if the seconde data is given
	$y=2;
	while($y<=30){
		if(isset($_POST['checkDesc'.$y.''])){
			$addData2 = trim($_POST['checkDesc'.$y.'']) ;

			$desc2 = trim($_POST['desc'.$y.'']) ;
				$desc2 = str_replace("\"", "&quot;", $desc2);
				$desc2 = str_replace('\'', "&apos;", $desc2);

			$tech_desc2 = trim($_POST['tech_desc'.$y.'']) ;
				$tech_desc2 = str_replace("\"", "&quot;", $tech_desc2);
				$tech_desc2 = str_replace('\'', "&apos;", $tech_desc2);

			$type2 = trim($_POST['type'.$y.'']) ; 
				$type2 = str_replace("\"", "&quot;", $type2);
				$type2 = str_replace('\'', "&apos;", $type2);

			$freq2 = trim($_POST['freq'.$y.'']) ; 
				$freq2 = str_replace("\"", "&quot;", $freq2);
				$freq2 = str_replace('\'', "&apos;", $freq2);

			$volu2 = trim($_POST['volu'.$y.'']) ;
				$volu2 = str_replace("\"", "&quot;", $volu2);
				$volu2 = str_replace('\'', "&apos;", $volu2);

			$tran2 = trim($_POST['tran'.$y.'']) ; 
				$tran2 = str_replace("\"", "&quot;", $tran2);
				$tran2 = str_replace('\'', "&apos;", $tran2);

			$cont2 = trim($_POST['cont'.$y.'']) ; 
				$cont2 = str_replace("\"", "&quot;", $cont2);
				$cont2 = str_replace('\'', "&apos;", $cont2);

			$trea2 = trim($_POST['trea'.$y.'']) ;
				$trea2 = str_replace("\"", "&quot;", $trea2);
				$trea2 = str_replace('\'', "&apos;", $trea2);

			$secu2 = trim($_POST['secu'.$y.'']) ; 
				$secu2 = str_replace("\"", "&quot;", $secu2);
				$secu2 = str_replace('\'', "&apos;", $secu2);

			$cons2 = trim($_POST['cons'.$y.'']) ;
				$cons2 = str_replace("\"", "&quot;", $cons2);
				$cons2 = str_replace('\'', "&apos;", $cons2);

			$file2 = $_FILES["file".$y.""]["name"];

			if(isset($_FILES["file".$y.""]["name"]) and !empty($_FILES["file".$y.""]["name"])){
				if (file_exists("../download/" . $_FILES["file".$y.""]["name"])){
					echo '<script language="javascript">alert(" Sorry!! $file2 Already Exists, You have to change it through the update")</script>';
					$file2='empty';
				}
				else{
					move_uploaded_file($_FILES["file".$y.""]["tmp_name"],
					"../download/" . $_FILES["file".$y.""]["name"]) ;
				}
			}else{
				$file2='empty';
			}
						
			/* Add the data flows */
			$sqlInsertData = "insert into data values (DEFAULT,'$desc2','$type2','$freq2','$volu2','$tran2','$cont2','$trea2','$secu2','$cons2','$file2','$tech_desc2')";
			$resultData = $dbh->query($sqlInsertData);

			/* Get the last description that we stored in the DB (The appropriate Data) */
			$sqlMax = "select MAX(idData) from data";
			$resultrechMax = $dbh->query($sqlMax);
			$resultMax = $resultrechMax->fetch();
			(int)$maxId = $resultMax[0];

			// get the environments name
			$sqlNameEv="select name from environment";
			$resultrechNameEv = $dbh->query($sqlNameEv);

			// Iterate on the environments
			while($NameEv = $resultrechNameEv->fetch()){
			
				$com1 = '';
                $com2 = '';

                if($comp1!=''){
                    $com1 = $comp1."_".$NameEv[0];
                }

                if($comp2!=''){
                    $com2 = $comp2."_".$NameEv[0];
                }
                
                // check if the midlewares, partners and the components of this environment already exist
	            $sqlCountMid="select count(*) from middleware where name = '$midd"."_".$NameEv[0]."'";
				$resultCountMid = $dbh->query($sqlCountMid);
				$countMid = $resultCountMid->fetch();
				
				$sqlCountSource="select count(*) from partner where name = '$source"."_".$NameEv[0]."'";
				$resultCountSource = $dbh->query($sqlCountSource);
				$countSource = $resultCountSource->fetch();

				$sqlCountDesct="select count(*) from partner where name = '$destination"."_".$NameEv[0]."'";
				$resultCountDest = $dbh->query($sqlCountDesct);
				$countDest = $resultCountDest->fetch();

				$sqlCountComp1="select count(*) from component where name = '$com1'";
				$resultCountComp1 = $dbh->query($sqlCountComp1);
				$countComp1 = $resultCountComp1->fetch();	

				$sqlCountComp2="select count(*) from component where name = '$com2'";
				$resultCountComp2 = $dbh->query($sqlCountComp2);
				$countComp2 = $resultCountComp2->fetch();
				
				// The case that have component 1 and component 2 that are not empty
	            if($com1 != '' and $com2 != ''){
	                if( $countMid[0] !=0 and $countSource[0] != 0 and $countDest[0] != 0 and $countComp1[0] != 0 and $countComp2[0] != 0 ){
	                	/* counter of the flows identifiants */
						$requete = "update idf set cpt=cpt+1";
						$resultRequete = $dbh->query($requete);

						// count the flows number in order to give an id for the name
						$sqlCount = "select cpt from idf";
						$resulCount = $dbh->query($sqlCount);
						$resultMax = $resulCount->fetch();
						$count = $resultMax[0];

	                    /* Add flow */
	                    $sqlFlow="insert into flows(name,idData,source,destination,component_1,middleware,component_2,protocol) values('$midd"."_flow".$count."',$maxId,'$source"."_".$NameEv[0]."','$destination"."_".$NameEv[0]."','$com1','$midd"."_".$NameEv[0]."','$com2','$protocol')";
	                    $resultFlow = $dbh->query($sqlFlow);
	                }
	            }

	            // The case that have component 1 and component 2 that are empty
	            if($com1 == '' and $com2 == ''){            	
	                if( $countMid[0] !=0 and $countSource[0] != 0 and $countDest[0] != 0 ){
	                	/* counter of the flows identifiants */
						$requete = "update idf set cpt=cpt+1";
						$resultRequete = $dbh->query($requete);

						// count the flows number in order to give an id for the name
						$sqlCount = "select cpt from idf";
						$resulCount = $dbh->query($sqlCount);
						$resultMax = $resulCount->fetch();
						$count = $resultMax[0];

	                    /* Add flow */
	                    $sqlFlow="insert into flows(name,idData,source,destination,component_1,middleware,component_2,protocol) values('$midd"."_flow".$count."',$maxId,'$source"."_".$NameEv[0]."','$destination"."_".$NameEv[0]."','$com1','$midd"."_".$NameEv[0]."','$com2','$protocol')";
	                    $resultFlow = $dbh->query($sqlFlow);
	                }
	            }

	            // The case that have component 1  that is empty and component 2 that is not empty
	            if($com1 == '' and $com2 != ''){            	
	                if( $countMid[0] !=0 and $countSource[0] != 0 and $countDest[0] != 0 and $countComp2[0] != 0 ){
	                	/* counter of the flows identifiants */
						$requete = "update idf set cpt=cpt+1";
						$resultRequete = $dbh->query($requete);

						// count the flows number in order to give an id for the name
						$sqlCount = "select cpt from idf";
						$resulCount = $dbh->query($sqlCount);
						$resultMax = $resulCount->fetch();
						$count = $resultMax[0];

	                    /* Add flow */
	                    $sqlFlow="insert into flows(name,idData,source,destination,component_1,middleware,component_2,protocol) values('$midd"."_flow".$count."',$maxId,'$source"."_".$NameEv[0]."','$destination"."_".$NameEv[0]."','$com1','$midd"."_".$NameEv[0]."','$com2','$protocol')";
	                    $resultFlow = $dbh->query($sqlFlow);
	                }
	            }

	            // The case that have component 1  that is not empty and component 2 that is empty
	            if($com1 != '' and $com2 == ''){
	                if( $countMid[0] !=0 and $countSource[0] != 0 and $countDest[0] != 0 and $countComp1[0] != 0 ){
	                	/* counter of the flows identifiants */
						$requete = "update idf set cpt=cpt+1";
						$resultRequete = $dbh->query($requete);

						// count the flows number in order to give an id for the name
						$sqlCount = "select cpt from idf";
						$resulCount = $dbh->query($sqlCount);
						$resultMax = $resulCount->fetch();
						$count = $resultMax[0];

	                    /* Add flow */
	                    $sqlFlow="insert into flows(name,idData,source,destination,component_1,middleware,component_2,protocol) values('$midd"."_flow".$count."',$maxId,'$source"."_".$NameEv[0]."','$destination"."_".$NameEv[0]."','$com1','$midd"."_".$NameEv[0]."','$com2','$protocol')";
	                    $resultFlow = $dbh->query($sqlFlow);
	                }
	            }

			}
		}

		$y++;
	}

	header('Location: ../View/flows.php');

?>