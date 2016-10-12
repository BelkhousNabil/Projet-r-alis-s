<?php
// Query that will gives the name of the owner
	$sql="select fname from user where email='".$_SESSION['owner']."'";
	$resultrech = $dbh->query($sql);
	$owner = $resultrech->fetch();
?>