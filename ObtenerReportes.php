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

	$result = $db->query("SELECT * FROM Reporte");

	if($result->num_rows > 0){
		$response["reportes"] = array();

		while($row = $result->fetch_array()){
			$reporte = array();
			$reporte["id_reporte"] = $row["id_reporte"];
			$reporte["id_alumno"] = $row["id_alumno"];
			$reporte["fecha"] = $row["fecha"];
			$reporte["comentario"] = $row["comentario"];

			array_push($response["reportes"],$reporte);
		}
		$response["sucess"] = 1;
		$response["message"] = "Reportes encontrados.";
		echo json_encode($response);
	}else{
		$response["sucess"] = 0;
		$reponse["message"] = "No hay reportes.";

		echo json_encode($reponse);
	}
?>