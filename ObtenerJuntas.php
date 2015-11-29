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

	$result = $db->query("SELECT * FROM Junta");

	if($result->num_rows > 0){
		$response["juntas"] = array();

		while($row = $result->fetch_array()){
			$junta = array();
			$junta["id_junta"] = $row["id_junta"];
			$junta["id_padre"] = $row["id_padre"];
			$junta["id_grupo"] = $row["id_grupo"];
			$junta["fecha"] = $row["fecha"];
			$junta["motivo"] = $row["motivo"];
			$junta["descripcion"] = $row["descripcion"];
			$junta["esgrupal"] = $row["esgrupal"];

			array_push($response["juntas"],$junta);
		}
		$response["sucess"] = 1;
		$response["message"] = "Juntas encontradas.";
		echo json_encode($response);
	}else{
		$response["sucess"] = 0;
		$reponse["message"] = "No hay tareas.";

		echo json_encode($reponse);
	}
?>