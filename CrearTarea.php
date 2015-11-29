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
	if(isset($_POST['id_grupo']) && isset($_POST['fecha']) && isset($_POST['materia']) && isset($_POST['titulo']) && isset($_POST['descripcion'])){
		$id_grupo = $_POST['id_grupo'];
		$fecha = $_POST['fecha'];
		$materia = $_POST['materia'];
		$titulo = $_POST['titulo'];
		$descripcion = $_POST['descripcion'];

		//Se inserta un nuevo renglón.
		$result = $db->query("INSERT INTO Tarea(id_grupo,fecha,materia,titulo,descripcion)
								 VALUES('$id_grupo','$fecha','$materia','$titulo','$descripcion')");


		//Se verifica si se ha insertado correctamente.
		if($result){
			$response["sucess"] = 1;
			$response["message"] = "Operación exitosa.";

			/// TODO seleccionar a quien se le mandará la notificación. un while?

			$notifs = $db->query("SELECT * FROM Alumno WHERE id_grupo = '$id_grupo'");

			if($notifs->num_rows > 0){
				$response["alumnos"] = array();

				while($row = $notifs->fetch_array()){
					$id_persona = $row["id_persona"];

					echo "id_persona: '$id_persona'   ";

					$res = $db->query("SELECT * FROM Usuario WHERE id_persona = '$id_persona'");
					$user = $res->fetch_array();

					$id = $user['gcm_regid'];

					echo " '$id' ";

					notificacion("Nueva Tarea disponible.",$id);
					//echo "notificacion enviada \n\n\n";
				}

		//notificacion("Nueva Tarea disponible.",$user);	
			}				
			
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