<?php
	class DB_Connect {
		//Constructor
		function __construct(){
			$this->connect(); //Se conecta a la base de datos.
		}
		//Destructor
		function __destruct(){
			$this->close(); //Se cierra la conexión a la base de datos.
		}

		//Método para conectarse a la base de datos.
		function connect(){
			//Es una clase de import. Consigue las variables de db_config.php
			require_once __DIR__ . '/db_config.php';

			//Conectando a la base de datos.
			$con = new mysqli(DB_SERVER,DB_USER,DB_PASSWORD,DB_DATABASE);

			//Se regresa el cursor de la conexión.
			return $con;
		}

		//Método para desconectarse de la base de datos.
		function close(){
			mysqli_close($this->connect());
		}


	}
?>