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
	/// TODO seleccionar a quien se le mandará la notificación. un while?
	$id_grupo = 1;

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

					//notificacion("Nueva Tarea disponible.",$id);
					//echo "notificacion enviada \n\n\n";
				}

		//notificacion("Nueva Tarea disponible.",$user);	
			}


	$res = $db->query("SELECT Padre.id_persona FROM Padre,Alumno WHERE Alumno.id_padre = '$id_padre' AND Alumno.id_grupo = '$id_grupo'");

	$ar = $res->fetch_array();
	$id_persona = $ar['id_persona'];

	//echo " '$id_persona' ";


	/*$notifs = $db->query("SELECT * FROM Alumno WHERE id_alumno = '$id_alumno'");
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

	echo "'$id'";*/


	
			
?>