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

	if (isset($_POST['edit'])) {
		$name = trim($_POST['mid']) ;
			$name = str_replace("\"", "&quot;", $name);
			$name = str_replace('\'', "&apos;", $name);

		$_SESSION['dropName'] = $name;
		/* Check if the flow existe on the BD */
		$sql1="select count(*) from flows where name='".$_POST['mid']."'";
		$resultrech1 = $dbh->query($sql1);
		$result1 = $resultrech1->fetch();
		$cpt = $result1[0];

		if($cpt==0){
			header('Location: ../View/editFlows_error.php');
		}else{
			header('Location: ../Controller/updateFlows_Controller.php?flow='.$name.'');
		}
		
	} else if (isset($_POST['delete'])) {
				$name = trim($_POST['mid']) ;
					$name = str_replace("\"", "&quot;", $name);
					$name = str_replace('\'', "&apos;", $name);

				$_SESSION['dropName'] = $name;

				$sql1="select count(*) from flows where name='".$_POST['mid']."'";
				$resultrech1 = $dbh->query($sql1);
				$result1 = $resultrech1->fetch();
				$cpt = $result1[0];

				if($cpt==0){
					header('Location: ../View/editFlows_error.php');
				}else{
					header('Location: ../Controller/deleteFlows_table_Controller.php?flow='.$name.'');
				}
			
			}else if (isset($_POST['open'])) {
						$name = trim($_POST['mid']) ;
							$name = str_replace("\"", "&quot;", $name);
							$name = str_replace('\'', "&apos;", $name);

						$_SESSION['dropName'] = $name;

						$sql1="select count(*) from flows where name='".$_POST['mid']."'";
						$resultrech1 = $dbh->query($sql1);
						$result1 = $resultrech1->fetch();
						$cpt = $result1[0];
						
						if($cpt==0){
							header('Location: ../View/editFlows_error.php');
						}else{
							header('Location: ../View/displayFlows.php?flow='.$name.'');
						}
					
					}	

	
?>