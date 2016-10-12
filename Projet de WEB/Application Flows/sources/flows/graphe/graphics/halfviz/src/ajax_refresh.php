<?php

	  /**
        ajax_refresh.php 
            description --> This page permits to have the autocompletion feature when we search a middleware
            Controllers --> None
            Model -->None
    **/

//Function that will make the connexion to the DB application
function connect() {
	require_once '../../../../Config/Config.php';
	return new PDO('mysql:host='.$host.';dbname='.$dbname.'', $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}

$pdo = connect();

// Recover the keyboards that are pressed
$keyword = '%'.$_POST['keyword'].'%';

// Get the name of the components that containt this keyword
$sql = "SELECT name FROM middleware WHERE name LIKE (:keyword) ORDER BY name";
$query = $pdo->prepare($sql);
$query->bindParam(':keyword', $keyword, PDO::PARAM_STR);
$query->execute();
$list = $query->fetchAll();
foreach ($list as $rs) {
	// put in bold the written text
	$name = str_replace($_POST['keyword'], '<b>'.$_POST['keyword'].'</b>', $rs['name']);
	// add new option
    echo '<li onclick="set_item(\''.str_replace("'", "\'", $rs['name']).'\')">'.$name.'</li>';
}
?>