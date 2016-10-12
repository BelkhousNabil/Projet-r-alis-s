<?php
	/** Error reporting */

	// Include the connexion of the DB in oreder to acces into the application
	require_once '../Config/BD_Conn.php';

	// Details of the error messages
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);
	date_default_timezone_set('Europe/London');

	define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

	date_default_timezone_set('Europe/London');

	/** Include PHPExcel */
	require_once  '../utils/Classes/PHPExcel.php';


	// Create new PHPExcel object
	$objPHPExcel = new PHPExcel();

	// Create a first sheet
	echo date('H:i:s') , " Add data" , EOL;
	$objPHPExcel->setActiveSheetIndex(0);
	$objPHPExcel->getActiveSheet()->setCellValue('A1', "Source")                              
	                              ->setCellValue('B1', "Component N°1")
	                              ->setCellValue('C1', "Middleware")
	                              ->setCellValue('D1', "Component N°2")
	                              ->setCellValue('E1', "Destination")
	                              ->setCellValue('F1', "Protocol")
	                              ->setCellValue('G1', "Description")
	                              ->setCellValue('H1', "Technical description")
	                              ->setCellValue('I1', "Type")
	                              ->setCellValue('J1', "Frequence")
	                              ->setCellValue('K1', "Volume")
	                              ->setCellValue('L1', "Transformation")
	                              ->setCellValue('M1', "Control")
	                              ->setCellValue('N1', "Treatment")
	                              ->setCellValue('O1', "Security")
	                              ->setCellValue('P1', "Constraints");
	// give some parameters to the document like the Width of the columns and the text aspect
	$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(20);
	$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(20);

	$objPHPExcel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("B1")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("C1")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("D1")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("E1")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("F1")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("G1")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("H1")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("I1")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("J1")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("K1")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("L1")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("M1")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("N1")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("O1")->getFont()->setBold(true);
	$objPHPExcel->getActiveSheet()->getStyle("P1")->getFont()->setBold(true);

	$indice=2;
	// Get all the flows
    $sqlFlow = "select * from flows";
    $resultFlow = $dbh->query($sqlFlow);
    while($flow = $resultFlow->fetch()){

    	// Get the first data flows
	    $sqlData = "select * from data where idData=".$flow[1]."";
	    $resultData = $dbh->query($sqlData);
	    $Data = $resultData->fetch();

    	$objPHPExcel->getActiveSheet()->setCellValue('A'.$indice,$flow[2])                              
		                              ->setCellValue('B'.$indice, $flow[4])
		                              ->setCellValue('C'.$indice, $flow[5])
		                              ->setCellValue('D'.$indice, $flow[6])
		                              ->setCellValue('E'.$indice, $flow[3])
		                              ->setCellValue('F'.$indice, $flow[7])
		                              ->setCellValue('G'.$indice, $Data[1])
		                              ->setCellValue('H'.$indice, $Data[11])
		                              ->setCellValue('I'.$indice, $Data[2])
		                              ->setCellValue('J'.$indice, $Data[3])
		                              ->setCellValue('K'.$indice, $Data[4])
		                              ->setCellValue('L'.$indice, $Data[5])
		                              ->setCellValue('M'.$indice, $Data[6])
		                              ->setCellValue('N'.$indice, $Data[7])
		                              ->setCellValue('O'.$indice, $Data[8])
		                              ->setCellValue('P'.$indice, $Data[9]);

    	$indice++;
    }
    
		$styleArray = array(
		  'borders' => array(
		    'allborders' => array(
		      'style' => PHPExcel_Style_Border::BORDER_HAIR 
		    )
		  )
		);

		$objPHPExcel->getActiveSheet()->getStyle('A1:P1000')->applyFromArray($styleArray);
		unset($styleArray);


	// Set active sheet index to the first sheet, so Excel opens this as the first sheet
	$objPHPExcel->setActiveSheetIndex(0);

	// Save Excel 2007 file
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
	$objWriter->save("Auto-Generated.xlsx");

	// move the generated file into an other flowder
	rename('Auto-Generated.xlsx', '../generated/Auto-Generated.xlsx');

	// download the generated file

	$file = '../generated/Auto-Generated.xlsx';
	$title='Auto-Generated.xlsx';

	header("Pragma: public");
	header('Content-disposition: attachment; filename='.$title);


	header('Content-Transfer-Encoding: binary');
	ob_clean();
	flush();

	$chunksize = 1 * (1024 * 1024); // how many bytes per chunk
	if (filesize($file) > $chunksize) {
	    $handle = fopen($file, 'rb');
	    $buffer = '';

	    while (!feof($handle)) {
	        $buffer = fread($handle, $chunksize);
	        echo $buffer;
	        ob_flush();
	        flush();
	    }

	    fclose($handle);
	} else {
	    readfile($file);
	}



