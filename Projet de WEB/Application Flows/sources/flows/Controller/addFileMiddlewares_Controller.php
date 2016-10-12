<?php
require_once '../utils/Classes/PHPExcel/IOFactory.php';
 
// Chargement du fichier Excel
$objPHPExcel = PHPExcel_IOFactory::load("../uploads/Auto-Generated-Midd.xlsx");
 
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
        // get the name middleware information from the corespendant line
        $nameMidd = $info[0];
            $nameMidd = str_replace("\"", "&quot;", $nameMidd);
            $nameMidd = str_replace('\'', "&apos;", $nameMidd);

        // get the environment middleware from the corespendant line
        $environment = $info[1];
            $environment = str_replace("\"", "&quot;", $environment);
            $environment = str_replace('\'', "&apos;", $environment);

        // get the full name of middleware
        $name = trim($nameMidd)."_".$environment;  
            $name = str_replace("\"", "&quot;", $name);
            $name = str_replace('\'', "&apos;", $name);

        // get the description middleware from the corespendant line
        $description = $info[2];
            $description = str_replace("\"", "&quot;", $description);
            $description = str_replace('\'', "&apos;", $description);

        // get the client middleware from the corespendant line
        $client = $info[3];
            $client = str_replace("\"", "&quot;", $client);
            $client = str_replace('\'', "&apos;", $client);

        // get the users middleware from the corespendant line
        $users = $info[4];
            $users = str_replace("\"", "&quot;", $users);
            $users = str_replace('\'', "&apos;", $users);

        // get the contact client middleware from the corespendant line
        $contact_cl = $info[5];
            $contact_cl = str_replace("\"", "&quot;", $contact_cl);
            $contact_cl = str_replace('\'', "&apos;", $contact_cl);

        // get the service middleware from the corespendant line
        $service = $info[6];
            $service = str_replace("\"", "&quot;", $service);
            $service = str_replace('\'', "&apos;", $service);

        // get the application manager middleware from the corespendant line
        $appli_manage = $info[7];
            $appli_manage = str_replace("\"", "&quot;", $appli_manage);
            $appli_manage = str_replace('\'', "&apos;", $appli_manage);

        // get the application management team middleware from the corespendant line
        $appli_team = $info[8];
            $appli_team = str_replace("\"", "&quot;", $appli_team);
            $appli_team = str_replace('\'', "&apos;", $appli_team);

        // get the production team middleware from the corespendant line
        $prod_team = $info[9];
            $prod_team = str_replace("\"", "&quot;", $prod_team);
            $prod_team = str_replace('\'', "&apos;", $prod_team);

        // get the localisation middleware information  from the corespendant line 
        $localisation = $info[10];  
            $localisation = str_replace("\"", "&quot;", $localisation);
            $localisation = str_replace('\'', "&apos;", $localisation);

        // get the technical description middleware from the corespendant line
        $tech_desc = $info[11];
            $tech_desc = str_replace("\"", "&quot;", $tech_desc);
            $tech_desc = str_replace('\'', "&apos;", $tech_desc);

        // get the IP address middleware information  from the corespendant line 
        $IP = $info[12]; 
            $IP = str_replace("\"", "&quot;", $IP);
            $IP = str_replace('\'', "&apos;", $IP);

        // get the DNS middleware information  from the corespendant line 
        $DNS = $info[13]; 
            $DNS = str_replace("\"", "&quot;", $DNS);
            $DNS = str_replace('\'', "&apos;", $DNS);
            
        // get the server middleware information  from the corespendant line 
        $server = $info[14];
            $server = str_replace("\"", "&quot;", $server);
            $server = str_replace('\'', "&apos;", $server);

        // get the access account middleware information  from the corespendant line 
        $access = $info[15];
            $access = str_replace("\"", "&quot;", $access);
            $access = str_replace('\'', "&apos;", $access); 

        /* Get the id environment */
        $sqlGetEv="select id from environment where name='".$environment."'";
        $resultrechGetEv = $dbh->query($sqlGetEv);
        $GetIdEnv = $resultrechGetEv->fetch();

        if(!$GetIdEnv[0] ==''){
            
            // if at least one of all the information is not empty
            if($nameMidd !='' or $environment !='' or $localisation !='' or $IP !='' or $DNS !='' or $server !='' or $access !='' or $environment !='' or $description !='' or $client !='' or $users !='' or $contact_cl !='' or $service !='' or $appli_manage !='' or $appli_team !='' or $tech_desc !='' or $prod_team !=''){
                // if source, destination or middleware is empty display an error message because they are required for a flow
                if($nameMidd=='' or $environment ==''){
                    header('Location: ../View/uploadFileDataMidd_error.php');exit;
                }else{

                        /* check if there is no middleware that have the same name whose is in the parameter */
                        $sql="select count(*) from middleware where name='".$name."'";
                        $resultrech = $dbh->query($sql);
                        $result = $resultrech->fetch();
                        $count = $result[0];
                    
                        if($count==0){
                            /* Add the description of the middleware */
                            $sql2="insert into description(idenv,localisation,ipadr,dns,server,compte) values(".$GetIdEnv[0].",'$localisation','$IP','$DNS','$server','$access')";
                            $result = $dbh->query($sql2);
                            
                            /* Get the last description that we stored in the DB (The appropriate description for the middleware) */
                            $sql = "select MAX(iddesc) from description";
                            $resultrech = $dbh->query($sql);
                            $result = $resultrech->fetch();
                            (int)$max = $result[0];

                            /* Add the middleware into the DB */
                            $sql2="insert into middleware(name,id_desc,restricted_name,description,client,users,contact_client,service,appli_manager,appli_managment,prod_team,tech_desc) values('$name',$max,'$nameMidd','$description','$client','$users','$contact_cl','$service','$appli_manage','$appli_team','$prod_team','$tech_desc')";
                            $result = $dbh->query($sql2);

                        }else{
                            // get the id description of the middleware
                            $sqlGetDesc="select id_desc from middleware where name='".$name."'";
                            $resultGetDesc = $dbh->query($sqlGetDesc);
                            $GetIdDesc = $resultGetDesc->fetch();

                            //update the description
                            $updateDesc = $dbh->query("update description set localisation='$localisation',ipadr='$IP', dns='$DNS', server='$server',compte='$access' where iddesc ='".$GetIdDesc[0]."'");
                            //update the middleware
                            $updateMidd = $dbh->query("update middleware set description='$description',client='$client',users='$users', contact_client='$contact_cl', service='$service', appli_manager='$appli_manage', appli_managment='$appli_team', prod_team='$prod_team', tech_desc='$tech_desc' where name ='".$name."'");
                        }
                   
                }
            }
        }
        
    }
    $cpt++;
}

header('Location: ../View/middleware.php');