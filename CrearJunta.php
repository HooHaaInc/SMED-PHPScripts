<?php

	require_once __DIR__ . '/db_connect.php';
	require_once __DIR__ . '/notif.php';

	//$db = new mysqli("localhost","root","","smed");
	$db = new DB_Connect();
	$db = $db->connect();

	if ($db->connect_errno) {
    	echo "Falló la conexión a MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
	}

	//Arreglo para la respuesta de JSON.
	$response = array();

	//Se checa por los campos requeridos.
	if(isset($_POST['id_grupo']) && isset($_POST['fecha']) && isset($_POST['motivo']) && isset($_POST['descripcion']) && isset($_POST["esgrupal"])) {
		$id_grupo = $_POST['id_grupo'];
		$fecha = $_POST['fecha'];
		$motivo = $_POST['motivo'];
		$descripcion = $_POST['descripcion'];
		$esgrupal = 1;

		$result = $db->query("INSERT INTO Junta(id_grupo,fecha,motivo, descripcion,esgrupal)
								VALUES('$id_grupo','$fecha','$motivo','$descripcion','$esgrupal')");
		if($result){
			$response["sucess"] = 1;
			$response["message"] = "Junta grupal creada.";

			$padres = $db->query("SELECT * FROM Padre");

			if($padres->num_rows > 0){
				$response["padres"] = array();

				while($row = $padres->fetch_array()){
					$id_padre = $row["id_padre"];

					echo "id_padre: '$id_padre'   ";

					$res = $db->query("SELECT Padre.id_persona FROM Padre,Alumno WHERE Alumno.id_padre = '$id_padre' AND Alumno.id_grupo = '$id_grupo'");
					$ar = $res->fetch_array();
					$id_persona = $ar['id_persona'];

					echo "id_persona: '$id_persona' ";	

					$r = $db->query("SELECT * FROM Usuario WHERE id_persona = '$id_persona'");
					$user = $r->fetch_array();

					$id = $user['gcm_regid'];

					echo "ID: '$id'";

					notificacion("Nueva Tarea disponible.",$id);
				}
			}	

			//newNotif("Nueva junta con el maestro.");	
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