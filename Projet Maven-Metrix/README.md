# Project description:
	Maven-Metrix is a project that has as aim to analyse the diffrent metrix in an open source project.

# How to unstall:

	1. Clone the repository of the project with : (on the terminal)
			git clone https://gitlab.com/NabilBelkhous/Maven-metrix.git

	2- Connect to the mysql db with : (on the terminal)
			mysql -u root -p 

	3- Create the BD with the appropriate file and the appropriat privileges with : (on mysql)
			create user cvsanaly ; (Dont create it if you did it before)
			create database maven_trunk;
			grant all on maven_trunk.* to cvsanaly@'localhost' identified by 'cvsanaly';

	4- Go to the trunk directory with : (on the terminal)
			cd trunk

	5- Copy the trunk directory into the DB with : (on the terminal)
			cvsanaly2 -u cvsanaly -p cvsanaly -d maven_trunk -H localhost

	6- See the data base structure with : (on mysql)
			use maven_trunk;
			show tables;

	7- Start browser with : (on the terminal)
			ipython notebook --matplotlib inline

	8- bicho instalation : https://github.com/MetricsGrimoire/Bicho
	
	9- import table bugues using bicho with this command on terminal :
	bicho --db-user-out='root' --db-password-out='DB PASS' --db-database-out='bicho_maven' -d 15 -b allura -u "https://issues.apache.org/jira/browse/MNG-6160?jql=project%20%3D%20MNG"

