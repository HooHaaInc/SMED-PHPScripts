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
	if(isset($_POST['id_tarea']) && isset($_POST['id_grupo']) && isset($_POST['fecha']) && isset($_POST['materia']) && isset($_POST['titulo']) && isset($_POST['descripcion'])){
		$id_tarea = $_POST['id_tarea'];
		$id_grupo = $_POST['id_grupo'];
		$fecha = $_POST['fecha'];
		$materia = $_POST['materia'];
		$titulo = $_POST['titulo'];
		$descripcion = $_POST['descripcion'];

		//Se inserta un nuevo renglón.
		$result = $db->query("UPDATE Tarea SET id_grupo = '$id_grupo', fecha = '$fecha', materia = '$materia', titulo = '$titulo', descripcion = '$descripcion' WHERE id_tarea = '$id_tarea'");


		//Se verifica si se ha insertado correctamente.
		if($result){
			$response["sucess"] = 1;
			$response["message"] = "Tarea actualizada.";

			//Se envía la información por medio de JSON.
			echo json_encode($response);
		}else{
			$response["sucess"] = 0;
			$response["message"] = "Error en la conexión.";

			echo json_encode($response);
		}
	}else{
		$response["sucess"] = 0;
		$response["message"] = "Falta al menos un campo requerido.";

		echo json_encode($response);
	}
?>