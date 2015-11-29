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
	if(isset($_POST['id_alumno']) && isset($_POST['comentario']) && isset($_POST['fecha'])){
		$id_alumno = $_POST['id_alumno'];
		$comentario = $_POST['comentario'];
		$fecha = $_POST['fecha'];

		//Se inserta un nuevo renglón.
		//$result = mysql_query("INSERT INTO loginInfo(email,password) VALUES('$email','$password')");
		$result = $db->query("INSERT INTO Reporte(id_alumno,comentario,fecha)
								 VALUES('$id_alumno','$comentario','$fecha')");

		// SELECT * FROM Persona WHERE nombre="Nan";

		//Se verifica si se ha insertado correctamente.
		if($result){
			$response["sucess"] = 1;
			$response["message"] = "Operación exitosa.";

			$notifs = $db->query("SELECT * FROM Alumno WHERE id_alumno = '$id_alumno'");
			$user = $notifs->fetch_array();
			$id_grupo = $user['id_grupo'];

			echo " '$id_grupo'";
			
			$notifs = $db->query("SELECT * FROM Grupo WHERE id_grupo = '$id_grupo'");
			$user = $notifs->fetch_array();
			$id_maestro = $user['id_maestro'];
			echo " '$id_maestro'";

			$notifs = $db->query("SELECT * FROM Maestro WHERE id_maestro = '$id_maestro'");
			$user = $notifs->fetch_array();
			$id_persona = $user['id_persona'];
			echo " '$id_persona'";

			$notifs = $db->query("SELECT * FROM Usuario WHERE id_persona = '$id_persona'");
			$user = $notifs->fetch_array();
			$id = $user['gcm_regid'];

			notificacion("Nuevo Reporte disponible.",$id);

			//Se envía la información por medio de JSON.
			echo "Se ha insertado correctamente";
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