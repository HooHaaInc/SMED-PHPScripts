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

	if(isset($_POST['id_grupo'])){
		$id_grupo = $_POST['id_grupo'];
		$result = $db->query("SELECT * FROM Alumno WHERE id_grupo = '$id_grupo'");

		if($result->num_rows > 0){
			$response["alumnos"] = array();

			while($row = $result->fetch_array()){
				$id_persona = $row['id_persona'];
				$result2 = $db->query("SELECT * FROM Persona WHERE id_persona = '$id_persona'");
				$nombre = $result2->fetch_object()->nombre;
				$result2 = $db->query("SELECT * FROM Persona WHERE id_persona = '$id_persona'");
				$apellidoP = $result2->fetch_object()->apellido_paterno;
				


				$alumno = array();
				$alumno['nombre'] = $nombre;
				$alumno['apellido_paterno'] = $apellidoP;
				$alumno['id_alumno'] = $row['id_alumno'];
				$alumno['id_persona'] = $row['id_persona'];
				$alumno['id_grupo'] = $row['id_grupo'];
				$alumno['id_padre'] = $row['id_padre'];
				array_push($response["alumnos"],$alumno);
			}
			$response["sucess"] = 1;
			$response["message"] = "Alumnos encontrados.";
			echo json_encode($response);
		}else{
			$response["sucess"] = 0;
			$reponse["message"] = "No hay alumnos.";
			echo json_encode($reponse);
		}
	}else{
		$response["sucess"] = 0;
		$reponse["message"] = "Falta al menos un campo requerido";
		echo json_encode($reponse);
	}
?>