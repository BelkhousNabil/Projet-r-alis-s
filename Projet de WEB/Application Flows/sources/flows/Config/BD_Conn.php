<?php
	
	/* Include the variables parameters of the DB connexion */
	require_once 'Config.php';
	
	
	// Connection to the server
	$dbh = new PDO('mysql:host='.$host, $user, $password);
		
	// Create the data base if it doesn't exist
	$requete = "CREATE DATABASE IF NOT EXISTS `".$dbname."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci";
	$dbh->prepare($requete)->execute();

	try
		{
			/* Connection to the DB Server */
			$dbh = new PDO('mysql:host='.$host.';dbname='.$dbname.'', $user, $password);
			
			// Create the component table 
			/*$table_Component = $dbh->query("CREATE TABLE IF NOT EXISTS `component` (
										  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
										  `id_desc` int(11) NOT NULL,
										  `restricted_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
										  PRIMARY KEY (`name`)
										) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"); 

			// Create the data table 
			$table_Data = $dbh->query("CREATE TABLE IF NOT EXISTS `data` (
									  `idData` int(11) NOT NULL AUTO_INCREMENT,
									  `description` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
									  `type` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
									  `frequence` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
									  `volum` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
									  `transformation` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
									  `control` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
									  `treatment` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
									  `security` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
									  `constr` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
									  `file` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
									  PRIMARY KEY (`idData`)
									) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"); 

			// Create the descritpion table 
			$table_Descritpion = $dbh->query("CREATE TABLE IF NOT EXISTS `description` (
											  `iddesc` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
											  `idenv` int(10) UNSIGNED NOT NULL,
											  `localisation` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
											  `ipadr` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
											  `dns` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
											  `server` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
											  `compte` varchar(300) COLLATE utf8_unicode_ci DEFAULT NULL,
											  PRIMARY KEY (`iddesc`),
											  KEY `fk_env` (`idenv`)
											) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");


			// Create the environment table 
			$table_Environment = $dbh->query("CREATE TABLE IF NOT EXISTS `environment` (
											  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
											  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
											  PRIMARY KEY (`id`)
											) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"); 

			// Create the flows table 
			$table_Flows = $dbh->query("CREATE TABLE IF NOT EXISTS `flows` (
									  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
									  `idData` int(11) NOT NULL,
									  `source` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
									  `destination` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
									  `component_1` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
									  `middleware` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
									  `component_2` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
									  PRIMARY KEY (`name`,`idData`)
									) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"); 

			// Create the idf table 
			$table_idf = $dbh->query("CREATE TABLE IF NOT EXISTS `idf` (
									  `cpt` int(100) NOT NULL,
									  PRIMARY KEY (`cpt`)
									) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"); 

			// Create the middleware table 
			$table_middleware = $dbh->query("CREATE TABLE IF NOT EXISTS `middleware` (
									  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
									  `id_desc` int(11) NOT NULL,
									  `restricted_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
									  PRIMARY KEY (`name`)
									) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci"); 

			// Create the partner table 
			$table_partner = $dbh->query("CREATE TABLE IF NOT EXISTS `partner` (
										  `name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
										  `id_desc` int(11) NOT NULL,
										  `restricted_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
										  PRIMARY KEY (`name`)
										) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");

			// Create the user table 
			$table_user = $dbh->query("CREATE TABLE IF NOT EXISTS `user` (
									  `email` varchar(70) COLLATE utf8_unicode_ci NOT NULL,
									  `name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
									  `fname` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
									  `pw` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
									  PRIMARY KEY (`email`)
									) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci");
			*/
		}
		catch(PDOException $e)
		{
			/* Print this error message in case there are errors connection with the DB server */
			Die ( 'Erreur  au niveau de la BDD ');
		}
?>
