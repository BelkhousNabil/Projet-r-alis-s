<?php
require_once '../utils/Classes/PHPExcel/IOFactory.php';
 
 // Show error details
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Chargement du fichier Excel
$objPHPExcel = PHPExcel_IOFactory::load("../uploads/Auto-Generated.xlsx");
 
// Get the first style shit of the excel document
$sheet = $objPHPExcel->getSheet(0);

// counter of elements 
$cpt=0;

$log = array();
// Iterate on the document lines
foreach($sheet->getRowIterator() as $row) {
 $info = array();
 
   // Iterate on the cellule line
   foreach ($row->getCellIterator() as $cell) {
      if($cpt>0){
        $info [] = $cell->getValue();
      }
    }

    // While the line N° 1000 is not reached
    if($cpt>0 and $cpt<1000){
        // get the source flow information from the corespendant line
        $source = $info[0];
            $source = str_replace("\"", "&quot;", $source);
            $source = str_replace('\'', "&apos;", $source);

        // get the first component flow information  from the corespendant line 
        $comp1 = $info[1]; 
            $comp1 = str_replace("\"", "&quot;", $comp1);
            $comp1 = str_replace('\'', "&apos;", $comp1);

        // get the middleware flow information  from the corespendant line 
        $midd = $info[2];  
            $midd = str_replace("\"", "&quot;", $midd);
            $midd = str_replace('\'', "&apos;", $midd);

        // get the seconde component flow information  from the corespendant line 
        $comp2 = $info[3]; 
            $comp2 = str_replace("\"", "&quot;", $comp2);
            $comp2 = str_replace('\'', "&apos;", $comp2);

        // get the destination flow information  from the corespendant line 
        $destination = $info[4]; 
            $destination = str_replace("\"", "&quot;", $destination);
            $destination = str_replace('\'', "&apos;", $destination);
            
        // get the protocol flow information  from the corespendant line 
        $protocol = $info[5];
            $protocol = str_replace("\"", "&quot;", $protocol);
            $protocol = str_replace('\'', "&apos;", $protocol);

        // get the description flow information  from the corespendant line 
        $description = $info[6];
            $description = str_replace("\"", "&quot;", $description);
            $description = str_replace('\'', "&apos;", $description);

        // get the technical description flow information  from the corespendant line 
        $desc_tech = $info[7];
            $desc_tech = str_replace("\"", "&quot;", $desc_tech);
            $desc_tech = str_replace('\'', "&apos;", $desc_tech);

        // get the type flow from information  the corespendant line 
        $type = $info[8]; 
            $type = str_replace("\"", "&quot;", $type);
            $type = str_replace('\'', "&apos;", $type);

        // get the frequence flow information  from the corespendant line 
        $frequence = $info[9]; 
            $frequence = str_replace("\"", "&quot;", $frequence);
            $frequence = str_replace('\'', "&apos;", $frequence);

        // get the volume flow information  from the corespendant line 
        $volume = $info[10];
            $volume = str_replace("\"", "&quot;", $volume);
            $volume = str_replace('\'', "&apos;", $volume);

        // get the transformation flow information  from the corespendant line  
        $trasnformation = $info[11]; 
            $trasnformation = str_replace("\"", "&quot;", $trasnformation);
            $trasnformation = str_replace('\'', "&apos;", $trasnformation);

        // get the control flow information  from the corespendant line 
        $control = $info[12]; 
            $control = str_replace("\"", "&quot;", $control);
            $control = str_replace('\'', "&apos;", $control);

        // get the treatment flow information  from the corespendant line 
        $treatment = $info[13]; 
            $treatment = str_replace("\"", "&quot;", $treatment);
            $treatment = str_replace('\'', "&apos;", $treatment);

        // get the security flow information  from the corespendant line 
        $security = $info[14];
            $security = str_replace("\"", "&quot;", $security);
            $security = str_replace('\'', "&apos;", $security);

        // get the constraints flow information  from the corespendant line    
        $constraints = $info[15];
            $constraints = str_replace("\"", "&quot;", $constraints);
            $constraints = str_replace('\'', "&apos;", $constraints);

        // if at least one of all the information is not empty
        if($source !='' or $comp1 !='' or $midd !='' or $comp2 !='' or $destination !='' or $description !='' or $desc_tech !='' or $type !='' or $frequence !='' or $volume !='' or $trasnformation !='' or $control !='' or $treatment !='' or $security !='' or $constraints!='' or $protocol!=''){
            // if source, destination or middleware is empty display an error message because they are required for a flow
            if($source=='' or $destination == '' or $midd ==''){
                header('Location: ../View/uploadFileData_error.php');exit;
            }else{
                $com1 = $comp1;
                $com2 = $comp2;

                /* verify the fact that the source doesn't exist in the DB application */
                $sqlCountSource = "select count(*) from partner where name = '".$source."'";
                $resultCountSource = $dbh->query($sqlCountSource);
                $countSource = $resultCountSource->fetch();
                (int)$cptSource = $countSource[0];

                // if the source given doesn't exist in the DB application then display an error message
                if($cptSource == 0){
                    //header('Location: ../View/uploadFileData_error.php');exit;
                    $log [] = "This source doesn't exist: ".$source;
                }

                /* verify the fact that the destination doesn't exist in the DB application */
                $sqlCountDest = "select count(*) from partner where name = '".$destination."'";
                $resultCountDest = $dbh->query($sqlCountDest);
                $countDest = $resultCountDest->fetch();
                (int)$cptDest = $countDest[0];

                // if the destination given doesn't exist in the DB application then display an error message
                if($cptDest == 0){
                    //header('Location: ../View/uploadFileData_error.php');exit;
                    $log [] = "This destination doesn't exist: ".$destination;
                }

                /* verify the fact that the middleawre doesn't exist in the DB application */
                $sqlCountMidd = "select count(*) from middleware where name = '".$midd."'";
                $resultCountMidd = $dbh->query($sqlCountMidd);
                $countMidd = $resultCountMidd->fetch();
                (int)$cptMidd = $countMidd[0];

                // if the middleware given doesn't exist in the DB application then display an error message
                if($cptMidd == 0){
                    //header('Location: ../View/uploadFileData_error.php');exit;
                    $log [] = "This middleware doesn't exist: ".$midd;
                }

                if($comp1==''){
                    $comp1="";
                }else{
                        /* verify the fact that the component1 doesn't exist in the DB application */
                        $sqlCountComp1 = "select count(*) from component where name = '".$comp1."'";
                        $resultCountComp1 = $dbh->query($sqlCountComp1);
                        $countComp1 = $resultCountComp1->fetch();
                        (int)$cptComp1 = $countComp1[0];

                        // if the fist component given doesn't exist in the DB application then display an error message
                        if($cptComp1 == 0){
                            //header('Location: ../View/uploadFileData_error.php');exit;
                            $log [] = "This component doesn't exist: ".$comp1;
                        }
                }

                if($comp2==''){
                    $comp2="";
                }else{
                        /* verify the fact that the component2 doesn't exist in the DB application */
                        $sqlCountComp2 = "select count(*) from component where name = '".$comp2."'";
                        $resultCountComp2 = $dbh->query($sqlCountComp2);
                        $countComp2 = $resultCountComp2->fetch();
                        (int)$cptComp2 = $countComp2[0];

                        // if the seconde component given doesn't exist in the DB application then display an error message
                        if($cptComp2 == 0){
                            //header('Location: ../View/uploadFileData_error.php');exit;
                            $log [] = "This component doesn't exist: ".$comp2;
                        }
                }

                // The case that have component 1 and component 2 that are not empty
                if($com1 != '' and $com2 != ''){
                    if( $cptMidd[0] !=0 and $cptSource[0] != 0 and $cptDest[0] != 0 and $cptComp1[0] != 0 and $cptComp2[0] != 0 ){
                        // try to find if the flow is already exist
                        $sqlCountFlow = "select count(*) from flows where source='$source' and destination='$destination' and component_1='$comp1' and middleware='$midd' and component_2='$comp2' and protocol='$protocol' ";
                        $resultCountFlow = $dbh->query($sqlCountFlow);
                        $countFlow = $resultCountFlow->fetch();
                        (int)$cptFlow = $countFlow[0];

                        if($cptFlow != 0){
                            $sqlIdData = "select idData from flows where source='$source' and destination='$destination' and component_1='$comp1' and middleware='$midd' and component_2='$comp2' and protocol='$protocol' ";
                            $resultIdData = $dbh->query($sqlIdData);
                            $idData = $resultIdData->fetch();

                            /* update the first data flows */
                            $sqlUpdateData = "update data set description='$description', type='$type', frequence='$frequence',volum='$volume',transformation='$trasnformation',control='$control',treatment='$treatment',security='$security',constr='$constraints',file='empty',desc_tech='$desc_tech' where idData=".$idData[0]."";
                            $resultRequete = $dbh->query($sqlUpdateData);

                        }else{
                                /* Add the data flows */
                                $sqlInsertData = "insert into data values (DEFAULT,'$description','$type','$frequence','$volume','$trasnformation','$control','$treatment','$security','$constraints','empty','$desc_tech')";
                                
                                $resultData = $dbh->query($sqlInsertData);

                                /* Get the last description that we stored in the DB (The appropriate Data) */
                                $sqlMax = "select MAX(idData) from data";
                                $resultrechMax = $dbh->query($sqlMax);
                                $resultMax = $resultrechMax->fetch();
                                (int)$maxId = $resultMax[0];

                                /* counter of the flows identifiants */
                                $requete = "update idf set cpt=cpt+1";
                                $resultRequete = $dbh->query($requete);

                                // count the flows number in order to give an id for the name
                                $sqlCount = "select cpt from idf";
                                $resulCount = $dbh->query($sqlCount);
                                $resultMax = $resulCount->fetch();
                                $count = $resultMax[0];

                                /* Add flow */
                                $sqlFlow="insert into flows(name,idData,source,destination,component_1,middleware,component_2,protocol) values('$midd"."_flow".$count."',$maxId,'$source','$destination','$com1','$midd','$com2','$protocol')";
                                $resultFlow = $dbh->query($sqlFlow);
                        }
                        
                    }
                }

                // The case that have component 1 and component 2 that are empty
                if($com1 == '' and $com2 == ''){                
                    if( $cptMidd[0] !=0 and $cptSource[0] != 0 and $cptDest[0] != 0 ){
                        // try to find if the flow is already exist
                        $sqlCountFlow = "select count(*) from flows where source='$source' and destination='$destination' and component_1='$comp1' and middleware='$midd' and component_2='$comp2' and protocol='$protocol' ";
                        $resultCountFlow = $dbh->query($sqlCountFlow);
                        $countFlow = $resultCountFlow->fetch();
                        (int)$cptFlow = $countFlow[0];

                        if($cptFlow != 0){
                            $sqlIdData = "select idData from flows where source='$source' and destination='$destination' and component_1='$comp1' and middleware='$midd' and component_2='$comp2' and protocol='$protocol' ";
                            $resultIdData = $dbh->query($sqlIdData);
                            $idData = $resultIdData->fetch();

                            /* update the first data flows */
                            $sqlUpdateData = "update data set description='$description', type='$type', frequence='$frequence',volum='$volume',transformation='$trasnformation',control='$control',treatment='$treatment',security='$security',constr='$constraints',file='empty',desc_tech='$desc_tech' where idData=".$idData[0]."";
                            $resultRequete = $dbh->query($sqlUpdateData);

                        }else{
                                /* Add the data flows */
                                $sqlInsertData = "insert into data values (DEFAULT,'$description','$type','$frequence','$volume','$trasnformation','$control','$treatment','$security','$constraints','empty','$desc_tech')";
                                $resultData = $dbh->query($sqlInsertData);

                                /* Get the last description that we stored in the DB (The appropriate Data) */
                                $sqlMax = "select MAX(idData) from data";
                                $resultrechMax = $dbh->query($sqlMax);
                                $resultMax = $resultrechMax->fetch();
                                (int)$maxId = $resultMax[0];

                                /* counter of the flows identifiants */
                                $requete = "update idf set cpt=cpt+1";
                                $resultRequete = $dbh->query($requete);

                                // count the flows number in order to give an id for the name
                                $sqlCount = "select cpt from idf";
                                $resulCount = $dbh->query($sqlCount);
                                $resultMax = $resulCount->fetch();
                                $count = $resultMax[0];

                                /* Add flow */
                                $sqlFlow="insert into flows(name,idData,source,destination,component_1,middleware,component_2,protocol) values('$midd"."_flow".$count."',$maxId,'$source','$destination','$com1','$midd','$com2','$protocol')";
                                $resultFlow = $dbh->query($sqlFlow);
                        }
                    }
                }

                // The case that have component 1  that is empty and component 2 that is not empty
                if($com1 == '' and $com2 != ''){                
                    if( $cptMidd[0] !=0 and $cptSource[0] != 0 and $cptDest[0] != 0 and $cptComp2[0] != 0 ){
                        // try to find if the flow is already exist
                        $sqlCountFlow = "select count(*) from flows where source='$source' and destination='$destination' and component_1='$comp1' and middleware='$midd' and component_2='$comp2' and protocol='$protocol' ";
                        $resultCountFlow = $dbh->query($sqlCountFlow);
                        $countFlow = $resultCountFlow->fetch();
                        (int)$cptFlow = $countFlow[0];

                        if($cptFlow != 0){
                            $sqlIdData = "select idData from flows where source='$source' and destination='$destination' and component_1='$comp1' and middleware='$midd' and component_2='$comp2' and protocol='$protocol' ";
                            $resultIdData = $dbh->query($sqlIdData);
                            $idData = $resultIdData->fetch();

                            /* update the first data flows */
                            $sqlUpdateData = "update data set description='$description', type='$type', frequence='$frequence',volum='$volume',transformation='$trasnformation',control='$control',treatment='$treatment',security='$security',constr='$constraints',file='empty',desc_tech='$desc_tech' where idData=".$idData[0]."";
                            $resultRequete = $dbh->query($sqlUpdateData);

                        }else{
                                /* Add the data flows */
                                $sqlInsertData = "insert into data values (DEFAULT,'$description','$type','$frequence','$volume','$trasnformation','$control','$treatment','$security','$constraints','empty','$desc_tech')";
                                //echo($sqlInsertData); exit;
                                $resultData = $dbh->query($sqlInsertData);

                                /* Get the last description that we stored in the DB (The appropriate Data) */
                                $sqlMax = "select MAX(idData) from data";
                                $resultrechMax = $dbh->query($sqlMax);
                                $resultMax = $resultrechMax->fetch();
                                (int)$maxId = $resultMax[0];

                                /* counter of the flows identifiants */
                                $requete = "update idf set cpt=cpt+1";
                                $resultRequete = $dbh->query($requete);

                                // count the flows number in order to give an id for the name
                                $sqlCount = "select cpt from idf";
                                $resulCount = $dbh->query($sqlCount);
                                $resultMax = $resulCount->fetch();
                                $count = $resultMax[0];

                                /* Add flow */
                                $sqlFlow="insert into flows(name,idData,source,destination,component_1,middleware,component_2,protocol) values('$midd"."_flow".$count."',$maxId,'$source','$destination','$com1','$midd','$com2','$protocol')";
                                $resultFlow = $dbh->query($sqlFlow);
                        }
                    }
                }

                // The case that have component 1  that is not empty and component 2 that is empty
                if($com1 != '' and $com2 == ''){
                    if( $cptMidd[0] !=0 and $cptSource[0] != 0 and $cptDest[0] != 0 and $cptComp1[0] != 0 ){
                        // try to find if the flow is already exist
                        $sqlCountFlow = "select count(*) from flows where source='$source' and destination='$destination' and component_1='$comp1' and middleware='$midd' and component_2='$comp2' and protocol='$protocol' ";
                        $resultCountFlow = $dbh->query($sqlCountFlow);
                        $countFlow = $resultCountFlow->fetch();
                        (int)$cptFlow = $countFlow[0];

                        if($cptFlow != 0){
                            $sqlIdData = "select idData from flows where source='$source' and destination='$destination' and component_1='$comp1' and middleware='$midd' and component_2='$comp2' and protocol='$protocol' ";
                            $resultIdData = $dbh->query($sqlIdData);
                            $idData = $resultIdData->fetch();

                            /* update the first data flows */
                            $sqlUpdateData = "update data set description='$description', type='$type', frequence='$frequence',volum='$volume',transformation='$trasnformation',control='$control',treatment='$treatment',security='$security',constr='$constraints',file='empty',desc_tech='$desc_tech' where idData=".$idData[0]."";
                            $resultRequete = $dbh->query($sqlUpdateData);

                        }else{
                                /* Add the data flows */
                                $sqlInsertData = "insert into data values (DEFAULT,'$description','$type','$frequence','$volume','$trasnformation','$control','$treatment','$security','$constraints','empty','$desc_tech')";
                                $resultData = $dbh->query($sqlInsertData);

                                /* Get the last description that we stored in the DB (The appropriate Data) */
                                $sqlMax = "select MAX(idData) from data";
                                $resultrechMax = $dbh->query($sqlMax);
                                $resultMax = $resultrechMax->fetch();
                                (int)$maxId = $resultMax[0];

                                /* counter of the flows identifiants */
                                $requete = "update idf set cpt=cpt+1";
                                $resultRequete = $dbh->query($requete);

                                // count the flows number in order to give an id for the name
                                $sqlCount = "select cpt from idf";
                                $resulCount = $dbh->query($sqlCount);
                                $resultMax = $resulCount->fetch();
                                $count = $resultMax[0];

                                /* Add flow */
                                $sqlFlow="insert into flows(name,idData,source,destination,component_1,middleware,component_2,protocol) values('$midd"."_flow".$count."',$maxId,'$source','$destination','$com1','$midd','$com2','$protocol')";
                                $resultFlow = $dbh->query($sqlFlow);
                        }
                    }
                } 

            }
        }

    }
    $cpt++;
}
    $j=0; 
    $logMessage='';
    $size=sizeof($log);
    while($j < $size){
        $logMessage= $logMessage.$log[$j].'\n';
        $j++;
    }
    if($size > 0){
        echo '<script language="javascript">';
            echo 'alert("'.$logMessage.'")';
        echo '</script>';
    }
    

    header( "refresh:0;url=../View/flows.php" );