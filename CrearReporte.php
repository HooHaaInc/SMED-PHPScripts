<?php

	require_once __DIR__ . '/db_connect.php';

	//$db = new mysqli("localhost","root","","smed");
	$db = new DB_Connect();
	$db = $db->connect();

	if ($db->connect_errno) {
    	echo "Falló la conexión a MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
	}

	//Arreglo para la respuesta de JSON.
	$response = array();

	//Se checa por los campos requeridos.
	if(isset($_POST['id_alumno']) && isset($_POST['comentario'])){
		$id_alumno = $_POST['id_alumno'];
		$comentario = $_POST['comentario'];

		//Se inserta un nuevo renglón.
		//$result = mysql_query("INSERT INTO loginInfo(email,password) VALUES('$email','$password')");
		$result = $db->query("INSERT INTO Reporte(id_alumno,comentario)
								 VALUES('$id_alumno','$comentario')");

		// SELECT * FROM Persona WHERE nombre="Nan";

		//Se verifica si se ha insertado correctamente.
		if($result){
			$response["sucess"] = 1;
			$response["message"] = "Operación exitosa.";

			//Se envía la información por medio de JSON.
			echo "Se ha insertado correctamente";
		}else{
			$response["sucess"] = 0;
			$response["message"] = "Error en la inserción.";

			echo json_encode($response);
		}
	}else{
		$response["sucess"] = 0;
		$response["message"] = "Falta al menos un campo requerido.";

		echo json_encode($response);
	}
?>