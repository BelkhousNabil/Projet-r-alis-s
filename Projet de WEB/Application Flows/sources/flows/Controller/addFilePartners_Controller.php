<?php
require_once '../utils/Classes/PHPExcel/IOFactory.php';
 
// Chargement du fichier Excel
$objPHPExcel = PHPExcel_IOFactory::load("../uploads/Auto-Generated-Part.xlsx");
 
// Get the first style shit of the excel document
$sheet = $objPHPExcel->getSheet(0);

// counter of elements 
$cpt=0;

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
        // get the restricted name partner from the corespendant line
        $namePart = $info[0];
            $namePart = str_replace("\"", "&quot;", $namePart);
            $namePart = str_replace('\'', "&apos;", $namePart);

        // get the environment partner from the corespendant line
        $environment = $info[1];
            $environment = str_replace("\"", "&quot;", $environment);
            $environment = str_replace('\'', "&apos;", $environment);

        // get the full name of partner
        $name = trim($namePart)."_".$environment;  
            $name = str_replace("\"", "&quot;", $name);
            $name = str_replace('\'', "&apos;", $name);

        // get the description partner information  from the corespendant line 
        $description = $info[2];  
            $description = str_replace("\"", "&quot;", $description);
            $description = str_replace('\'', "&apos;", $description);

        // get the contacts partner information  from the corespendant line 
        $contacts = $info[3];  
            $contacts = str_replace("\"", "&quot;", $contacts);
            $contacts = str_replace('\'', "&apos;", $contacts);

        // get the technical contacts partner information  from the corespendant line 
        $tech_cont = $info[4];  
            $tech_cont = str_replace("\"", "&quot;", $tech_cont);
            $tech_cont = str_replace('\'', "&apos;", $tech_cont);

        // get the localisation partner information  from the corespendant line 
        $localisation = $info[5];  
            $localisation = str_replace("\"", "&quot;", $localisation);
            $localisation = str_replace('\'', "&apos;", $localisation);

         // get the technical contacts partner information  from the corespendant line 
        $tech_desc = $info[6];  
            $tech_desc = str_replace("\"", "&quot;", $tech_desc);
            $tech_desc = str_replace('\'', "&apos;", $tech_desc);

        // get the IP address partner information  from the corespendant line 
        $IP = $info[7]; 
            $IP = str_replace("\"", "&quot;", $IP);
            $IP = str_replace('\'', "&apos;", $IP);

        // get the DNS partner information  from the corespendant line 
        $DNS = $info[8]; 
            $DNS = str_replace("\"", "&quot;", $DNS);
            $DNS = str_replace('\'', "&apos;", $DNS);
            
        // get the server partner information  from the corespendant line 
        $server = $info[9];
            $server = str_replace("\"", "&quot;", $server);
            $server = str_replace('\'', "&apos;", $server);

        // get the access account partner information  from the corespendant line 
        $access = $info[10];
            $access = str_replace("\"", "&quot;", $access);
            $access = str_replace('\'', "&apos;", $access); 

       /* echo("-- Name: ".$namePart."</br>-- Environment: ".$environment."</br>-- Complet name: ".$name."</br>-- Description: ".$description."</br>-- Contacts".$contacts."</br>-- technical description: ".$tech_cont."</br>-- IP: ".$IP."</br>-- DNS: ".$DNS."</br>-- Server: ".$server."</br>-- Account: ".$access);
        exit;*/

        /* Get the id environment */
        $sqlGetEv="select id from environment where name='".$environment."'";
        $resultrechGetEv = $dbh->query($sqlGetEv);
        $GetIdEnv = $resultrechGetEv->fetch();

        if(!$GetIdEnv[0] ==''){
            // if at least one of all the information is not empty
            if($namePart !='' or $environment !='' or $localisation !='' or $IP !='' or $DNS !='' or $server !='' or $access !='' or $description !='' or $contacts !='' or $tech_cont !='' or $tech_desc !=''){
                // if source, destination or partner is empty display an error message because they are required for a flow
                if($namePart=='' or $environment ==''){
                    header('Location: ../View/uploadFileDataPart_error.php');exit;
                }else{

                        /* check if there is no partner that have the same name whose is in the parameter */
                        $sql="select count(*) from partner where name='".$name."'";
                        $resultrech = $dbh->query($sql);
                        $result = $resultrech->fetch();
                        $count = $result[0];
                        
                        if($count==0){
                            
                           /* Add the description of the partner */
                            $sql2="insert into description(idenv,localisation,ipadr,dns,server,compte) values(".$GetIdEnv[0].",'$localisation','$IP','$DNS','$server','$access')";
                            $result = $dbh->query($sql2);
                            
                            /* Get the last description that we stored in the DB (The appropriate description for the partner) */
                            $sql = "select MAX(iddesc) from description";
                            $resultrech = $dbh->query($sql);
                            $result = $resultrech->fetch();
                            (int)$max = $result[0];

                            /* Add the partner into the DB */
                            $sql2="insert into partner(name,id_desc,restricted_name,description,contact,tech_contact,tech_desc) values('$name',$max,'$namePart','$description','$contacts','$tech_cont','$tech_desc')";
                            $result = $dbh->query($sql2);

                            }else{

                                // get the id description of the partner
                                $sqlGetDesc="select id_desc from partner where name='".$name."'";
                                $resultGetDesc = $dbh->query($sqlGetDesc);
                                $GetIdDesc = $resultGetDesc->fetch();

                                //update the description
                                $updateDesc = $dbh->query("update description set localisation='$localisation',ipadr='$IP', dns='$DNS', server='$server',compte='$access' where iddesc ='".$GetIdDesc[0]."'");
                                //update the partner
                                $updateComp = $dbh->query("update partner set description = '$description', contact = '$contacts', tech_contact = '$tech_cont', tech_desc = '$tech_desc' where name ='".$name."'");
                            }
                   
                }
            }
        }  

    }
    $cpt++;
}

header('Location: ../View/partner.php');