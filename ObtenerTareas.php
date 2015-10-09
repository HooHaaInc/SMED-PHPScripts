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

	$result = $db->query("SELECT * FROM Tarea");

	if($result->num_rows > 0){
		$response["tareas"] = array();

		while($row = $result->fetch_array()){
			$tarea = array();
			$tarea["id_tarea"] = $row["id_tarea"];
			$tarea["id_grupo"] = $row["id_grupo"];
			$tarea["titulo"] = $row["titulo"];
			$tarea["descripcion"] = $row["descripcion"];
			$tarea["materia"] = $row["materia"];
			$tarea["fecha"] = $row["fecha"];

			array_push($response["tareas"],$tarea);
		}
		$response["sucess"] = 1;
		$response["message"] = "Tareas encontradas.";
		echo json_encode($response);
	}else{
		$response["sucess"] = 0;
		$reponse["message"] = "No hay tareas.";

		echo json_encode($reponse);
	}
?>