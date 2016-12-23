<?php

 # La classe pour se connecter à la base 

class DB_CONNECT
{
	# constructeur
	function __construct()
	{
		# connexion à la base
		$this->connect();
	}
	# destructeur
	function __destruct()
	{
		#fermeture de la connexion
		$this->close();
	}
	
	#fonction pour se connecter à la base
	
	function connect()
	{
		# importer les variables de connexion à la BD
	    require "db_config.php";
		# connexion à la base Firebird
		$con = ibase_connect(DB_DATABASE,DB_USER,DB_PASSWORD) or die(ibase_errmsg());
	
		return $con;
	}

	#fonction pour fermer la connexion
	function close()
	{
		ibase_close();

	}


}


?>