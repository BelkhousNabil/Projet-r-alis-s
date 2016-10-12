<?php

	require_once '../Config/BD_Conn.php';
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$sqlFlows="select * from flows where name='".$flow."'";
	$resultrechFlows = $dbh->query($sqlFlows);
	$resFlux = $resultrechFlows->fetch();

?>