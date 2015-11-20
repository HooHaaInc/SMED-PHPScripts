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

	if(isset($_POST['id_maestro']) && isset($_POST['clave']) && isset($_POST['turno'])){
		$id_maestro = $_POST['id_maestro'];
		$clave = $_POST['clave'];
		$turno = $_POST['turno'];

		$result = $db->query("INSERT INTO Grupo(id_maestro,clave,turno)
							 VALUES ('$id_maestro','$clave','$turno')");

		$result2 = $db->query("SELECT * from Grupo WHERE id_maestro = '$id_maestro'");

		$id_grupo = $result2->fetch_object()->id_grupo;

		if($result){
			
			$response["sucess"] = 1;
			$response["message"] = "Operación exitosa.";
			$response["id_grupo"] = $id_grupo;

			//Se envía la información por medio de JSON.
			echo json_encode($response);
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