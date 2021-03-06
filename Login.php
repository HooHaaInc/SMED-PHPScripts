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
	if(isset($_POST['correo']) && isset($_POST['clave'])){
		$correo = $_POST['correo'];
		$password = $_POST['clave'];

		//Se inserta un nuevo renglón.
		//$result = mysql_query("INSERT INTO loginInfo(email,password) VALUES('$email','$password')");
		$checkEmail = $db->query("SELECT * from Usuario WHERE correo = '$correo'");
		$correoServer = $checkEmail->fetch_object()->correo;
		$checkEmail = $db->query("SELECT * from Usuario WHERE correo = '$correo'");
		$pass = $checkEmail->fetch_object()->clave;

		$checkEmail = $db->query("SELECT * from Usuario WHERE correo = '$correo'");
		$id_persona = $checkEmail->fetch_object()->id_persona;

		$aux = $db->query("SELECT * from Persona WHERE id_persona = '$id_persona'");
		$nombre = $aux->fetch_object()->nombre;
		$aux = $db->query("SELECT * from Persona WHERE id_persona = '$id_persona'");
		$apellido_paterno = $aux->fetch_object()->apellido_paterno;
		$aux = $db->query("SELECT * from Persona WHERE id_persona = '$id_persona'");
		$apellido_materno = $aux->fetch_object()->apellido_materno;
		$aux = $db->query("SELECT * from Persona WHERE id_persona = '$id_persona'");
		$tipo_persona = $aux->fetch_object()->tipo_persona;


		// TEST PARA REGRESAR ID_MAESTRO
		if($tipo_persona == 1){
				$id_alumno = $db->query("SELECT * FROM Alumno WHERE id_persona = '$id_persona'");
				$id_alumno = $id_alumno->fetch_object()->id_alumno;

		}else
			if($tipo_persona == 2){
				$id_maestro = $db->query("SELECT * FROM Maestro WHERE id_persona = '$id_persona'");
				$id_maestro = $id_maestro->fetch_object()->id_maestro;

			}else{
				$id_padre = $db->query("SELECT * FROM Padre WHERE id_persona = '$id_persona'");
				$id_padre = $id_padre->fetch_object()->id_padre;
			}
		

		if($correoServer == $correo){			
			if($pass == $password){
				$response["sucess"] = 1;
				$response["message"] = "Informacion correcta.";
				$response["correo"] = $correo;
				$response["id_persona"] = $id_persona;
				$response["nombre"] = $nombre;
				$response["apellido_paterno"] = $apellido_paterno;
				$response["apellido_materno"] = $apellido_materno;
				$response["tipo_persona"] = $tipo_persona;
				if($tipo_persona == 1) $response["id_alumno"] = $id_alumno;
				if($tipo_persona == 2) $response["id_maestro"] = $id_maestro;
				if($tipo_persona == 3) $response["id_padre"] = $id_padre;
				echo json_encode($response);
				
			}else{
				$response["sucess"] = 0;
				$response["message"] = "Clave de acceso incorrecta.";
				echo json_encode($response);
			}
		}else{
			$reponse["sucess"] = 0;
			$response["message"] = "Correo no registrado.";
			echo json_encode($response);
		}

	}else{
		$response["sucess"] = 0;
		$response["message"] = "Falta al menos un campo requerido.";
		echo json_encode($response);
	}
?>