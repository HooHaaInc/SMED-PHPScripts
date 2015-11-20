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
	if(isset($_POST['id_junta']) && (isset($_POST['id_padre']) || isset($_POST['id_grupo'])) && isset($_POST['fecha'])
	&& isset($_POST['motivo']) && isset($_POST['descripcion'])) {
		if(isset($_POST['id_padre'])){
			$id_junta = $_POST['id_junta'];
			$id_padre = $_POST['id_padre'];
			$fecha = $_POST['fecha'];
			$motivo = $_POST['motivo'];
			$descripcion = $_POST['descripcion'];

			$result = $db->query("UPDATE Junta SET id_padre = '$id_padre', fecha = '$fecha', motivo = '$motivo', descripcion = '$descripcion' WHERE id_junta = '$id_junta'");
			if($result){
				$response["sucess"] = 1;
				$response["message"] = "Junta personal creada.";
				echo json_encode($response);
			}else{
				$response["sucess"] = 0;
				$response["message"] = "Error en la inserción.";
				echo json_encode($response);
			}
		}else{
			$id_junta = $_POST['id_junta'];
			$id_grupo = $_POST['id_grupo'];
			$fecha = $_POST['fecha'];
			$motivo = $_POST['motivo'];
			$descripcion = $_POST['descripcion'];

			$result = $db->query("UPDATE Junta SET id_grupo = '$id_grupo', fecha = '$fecha', motivo = '$motivo', descripcion = '$descripcion' WHERE id_junta = '$id_junta'");
			if($result){
				$response["sucess"] = 1;
				$response["message"] = "Junta grupal creada.";
				echo json_encode($response);
			}else{
				$response["sucess"] = 0;
				$response["message"] = "Error en la inserción.";
				echo json_encode($response);
			}
		}
	}else{
		$response["sucess"] = 0;
		$response["message"] = "Falta al menos un campo requerido.";
		echo json_encode($response);
	}
?>