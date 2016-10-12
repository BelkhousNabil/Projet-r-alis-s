<?php

	  /**
        ajaxFlows_refresh.php 
            description --> This page allows the autocompletion when we search a middleware
            Controllers --> None
            Model --> None
    **/

//Function that will make the connexion to the DB application
function connect() {
	require_once '../../Config/Config.php';
	return new PDO('mysql:host='.$host.';dbname='.$dbname.'', $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}

$pdo = connect();

// Recover the keyboards that are pressed
$keyword = '%'.$_POST['keyword'].'%';

// Get the name of the components that containt this keyword
$sql = "SELECT distinct restricted_name FROM middleware WHERE restricted_name LIKE (:keyword) ORDER BY restricted_name";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
	// put in bold the written text
	$restricted_name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['restricted_name']);
	// add new option
    echo '<li onclick="set_item_mid(\''.str_replace("'", "\'", $rs['restricted_name']).'\')">'.$restricted_name.'</li>';
}
?>