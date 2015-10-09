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

	$result = $db->query("SELECT * FROM Grupo");

	if($result->num_rows > 0){
		$response["grupos"] = array();

		while($row = $result->fetch_array()){
			$grupo = array();
			$grupo["id_grupo"] = $row["id_grupo"];
			$grupo["id_maestro"] = $row["id_maestro"];
			$grupo["clave"] = $row["clave"];
			$grupo["turno"] = $row["turno"];

			array_push($response["grupos"],$grupo);
		}
		$response["sucess"] = 1;
		$response["message"] = "Grupos encontrados.";
		echo json_encode($response);
	}else{
		$response["sucess"] = 0;
		$reponse["message"] = "No hay grupos.";

		echo json_encode($reponse);
	}

?>