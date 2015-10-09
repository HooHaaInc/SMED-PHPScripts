<?php
	require_once __DIR__ . '/db_connect.php';

	$db = new DB_Connect();
	$db = $db->connect();

	if ($db->connect_errno) {
    	echo "Falló la conexión a MySQL: (" . $db->connect_errno . ") " . $db->connect_error;
	}else{
		echo"Se conectó :DDDD<br>\n";
	}
?>