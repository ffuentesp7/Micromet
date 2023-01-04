<?php
	// Cargamos variables
	require_once("funciones.inc.php");
	require_once('antinyeccion.inc.php');
	// le damos un nombre a la sesion (por si quisieramos identificarla)
	if(isset($_GET['sid'])){
		session_name($_GET['sid']);
	}
	// iniciamos sesiones
	$error = "";
	session_start();
	if(isset($_SESSION['session_usuario_id'])){
		bitacora("Sesi&oacute;n cerrada correctamente");
		$error = "Su sesi&oacute;n ha sido cerrada.";
	}
	
	session_destroy();
	
	if(isset($_GET['error_login'])){
		$err = $_GET['error_login'];
		if($err == 0){
			$error = "Error en la base de datos.";
		}
		elseif($err == 1){
			$error = "Error en la base de datos.";
			echo($_GET['error_login']);
		}
		elseif($err == 2){
			$error = "El RUT ingresado no est&aacute; registrado.";
		}
		elseif($err == 3){
			$error = "La clave es incorrecta.";
		}
		elseif($err == 4){
			$error = "El RUT ingresado no est&aacute; registrado.";
		}
	}
?>