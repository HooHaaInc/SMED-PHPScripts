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
	if(isset($_POST['correo']) && isset($_POST['clave']) && isset($_POST['nombre']) && isset($_POST['apellido_paterno']) && isset($_POST['apellido_materno']) && isset($_POST['tipo_persona'])){
		$email = $_POST['correo'];
		$clave = $_POST['clave'];
		$nombre = $_POST['nombre'];
		$apellido_paterno = $_POST['apellido_paterno'];
		$apellido_materno = $_POST['apellido_materno'];
		$tipo_persona = $_POST['tipo_persona'];

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

			$result2 = $db->query("INSERT INTO Usuario(id_persona,correo,clave,tipo_usuario)
									VALUES('$id_persona','$email','$clave','$tipo_persona')");

			if($tipo_persona == 1){


			}else if($tipo_persona == 2){
				$result2 = $db->query("INSERT INTO Maestro(id_persona) VALUES('$id_persona')");

			}else{
				$result2 = $db->query("INSERT INTO Padres(id_persona) VALUES('$id_persona')");

			}

			if($result){
				$response["sucess"] = 1;
				$response["message"] = "Registro exitoso.";
				$reponse["id_persona"] = $id_persona;
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
		$response["message"] = "Falta al menos un campo requerido.";

		echo json_encode($response);
	}
?>