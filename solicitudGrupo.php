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

	if(isset($_POST['id_alumno']) && isset($_POST['id_grupo'])){
		$id_alumno = $_POST['id_alumno'];
		$id_grupo = $_POST['id_grupo'];

		$result = $db->query("UPDATE Alumno SET id_grupo = '$id_grupo',estado = '0' WHERE id_alumno = '$id_alumno'");

		if($result){
			$response["sucess"] = 1;
			$response["message"] = "Solicitud enviada.";
			echo json_encode($response);
		}else{
			$response["sucess"] = 0;
			$response["message"] = "Error en la peticion.";
			echo json_encode($response);
		}
	}else{
		$response["sucess"] = 0;
		$response["message"] = "Falta al menos un campo requerido.";
		echo json_encode($response);
	}
?>