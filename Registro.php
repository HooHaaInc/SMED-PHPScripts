<?php

	require_once __DIR__ . '/db_connect.php';

	//$db = new mysqli("localhost","root","","smed");
	$db = new DB_Connect();
	$db = $db->connect();
	$db->set_charset("utf8");

	if ($db->connect_errno) {
    	echo "Falló la conexión a MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
	}

	//Arreglo para la respuesta de JSON.
	$response = array();

	//Se checa por los campos requeridos.
	if(isset($_POST['correo']) && isset($_POST['clave']) && isset($_POST['nombre']) && isset($_POST['apellido_paterno']) && isset($_POST['apellido_materno']) && isset($_POST['tipo_persona']) && isset($_POST['gcm_regid'])){
		$email = $_POST['correo'];
		$clave = $_POST['clave'];
		$nombre = $_POST['nombre'];
		$apellido_paterno = $_POST['apellido_paterno'];
		$apellido_materno = $_POST['apellido_materno'];
		$tipo_persona = $_POST['tipo_persona'];
		$gcm_regid = $_POST['gcm_regid'];

		//Se inserta un nuevo renglón.
		//$result = mysql_query("INSERT INTO loginInfo(email,password) VALUES('$email','$password')");
		$correoTest = $db->query("SELECT * FROM Usuario WHERE correo = '$email'");
		$correoTest = $correoTest->fetch_object()->correo;

		if($correoTest != $email){
			$result = $db->query("INSERT INTO Persona(nombre, apellido_paterno,apellido_materno,tipo_persona)
									 VALUES('$nombre','$apellido_paterno','$apellido_materno','$tipo_persona')");

			//TODO Checar lo de fetch_array, tal vez ahi esté el pex.

			$query = $db->query("SELECT * FROM Persona 
									  WHERE nombre = '$nombre' AND apellido_paterno = '$apellido_paterno' AND apellido_materno = '$apellido_materno'");

			$id_persona = $query->fetch_object()->id_persona;

			$result2 = $db->query("INSERT INTO Usuario(id_persona,correo,clave,tipo_usuario,gcm_regid)
									VALUES('$id_persona','$email','$clave','$tipo_persona','$gcm_regid')");

			if($tipo_persona == 1){
				$result2 = $db->query("INSERT INTO Alumno(id_persona) VALUES('$id_persona')");
				$id_a = $db->query("SELECT * FROM Alumno WHERE id_persona = '$id_persona'");
				$id_alumno = $id_a->fetch_object()->id_alumno;
				$response["id_alumno"] = $id_alumno;

			} 
			if($tipo_persona == 2){
				$result2 = $db->query("INSERT INTO Maestro(id_persona) VALUES('$id_persona')");
				$id_m = $db->query("SELECT * FROM Maestro WHERE id_persona = '$id_persona'");
				$id_maestro = $id_m->fetch_object()->id_maestro;
				$response["id_maestro"] = $id_maestro;

			}
			if($tipo_persona == 3){
				$result2 = $db->query("INSERT INTO Padre(id_persona) VALUES('$id_persona')");
				$id_p = $db->query("SELECT * FROM Padre WHERE id_persona = '$id_persona'");
				$id_padre = $id_p->fetch_object()->id_padre;
				$response["id_padre"] = $id_padre;
			}

			if($result){
				$response["sucess"] = 1;
				$response["message"] = "Registro exitoso.";
				$response["id_persona"] = $id_persona;
				$response["nombre"] = $nombre;
				$response["apellido_paterno"] = $apellido_paterno;
				$response["apellido_materno"] = $apellido_materno;
				$response["tipo_persona"] = $tipo_persona;
				
				//Se envía la información por medio de JSON.
				echo json_encode($response);
			}else{
				$response["sucess"] = 0;
				$response["message"] = "Error.";
				echo json_encode($response);
			}
		}else{
			$response["sucess"] = 0;
			$response["message"] = "Correo ya registrado.";
			echo json_encode($response);
		}
		//Se verifica si se ha insertado correctamente.
		
	}else{
		$response["sucess"] = 0;
		$response["message"] = "Falta al menos un campo requerido á é í ó ú ñ.";

		echo json_encode($response);
	}
?>