<?php

	/* check if the email and the password are available to permit the connection */
	$sql="select count(*) from user where email='".$login."' && pw='".$password."'";
	$resultrech = $dbh->query($sql);
	$result = $resultrech->fetch();
	$count = $result[0];
	
?>