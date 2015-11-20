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
	if(isset($_POST['id_tarea'])){
		$id_tarea = $_POST['id_tarea'];

		//Se inserta un nuevo renglón.
		$result = $db->query("DELETE FROM Tarea WHERE id_tarea = $id_tarea");


		//Se verifica si se ha insertado correctamente.
		if($db->affected_rows > 0){
			$response["sucess"] = 1;
			$response["message"] = "Tarea eliminada.";

			//Se envía la información por medio de JSON.
			echo json_encode($response);
		}else{
			$response["sucess"] = 0;
			$response["message"] = "Error, Tarea no encontrada.";

			echo json_encode($response);
		}
	}else{
		$response["sucess"] = 0;
		$response["message"] = "Falta al menos un campo requerido.";

		echo json_encode($response);
	}
?>