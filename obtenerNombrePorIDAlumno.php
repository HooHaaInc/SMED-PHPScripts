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

	if(!isset($_POST['id_alumno'])){
		$id_alumno = 1 //$_POST['id_alumno'];
		$result = $db->query("SELECT * FROM Alumno WHERE id_alumno = '$id_alumno'");
		echo $result;
		$id_persona = $result->fetch_object()->id_persona;

		$res = $db->query("SELECT * FROM Persona WHERE id_persona = '$id_persona'");

		$nombre = $res->fetch_object()->nombre;

		if($result){
			$response["sucess"] = 1;
			$response["message"] = "Busqueda exitosa";
			$response["nombre"] = $nombre+"";
			echo json_encode($response);
		}else{
			$response["sucess"] = 0;
			$response["nombre"] = "";
			$response["message"] = "No se encontro";
			echo json_encode($response);
		}
	}else{
		$response["sucess"] = 0;
		$response["nombre"] = "";
		$response["message"] = "Falta al menos un campo requerido-";
		echo json_encode($response);
	}

?>