<?php
	session_start();

	// destryo the session
	session_destroy();

	/* Destroy the session account */
	header('Location: ../index.php');
?>