<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');

	$ACCION = $_GET['accion'];
	
	if($ACCION == "data"){
		$UID = $_SESSION['session_usuario_id'];
		
		$nombre = $_GET['nombre'];
		$email = $_GET['email'];
		$telefono = $_GET['telefono'];
		
		$SQL = "UPDATE usuario SET nombre='$nombre', email='$email', telefono_movil='$telefono' WHERE id=$UID";
		
		if(comando_sql($SQL) > 0){
			echo 1;
			exit;
		}
		else{
			echo 'Error SQL';
			exit;
		}	
	}
	elseif($ACCION == "checkpass"){
		$UID = $_SESSION['session_usuario_id'];
		
		$pass = MD5($_GET['oldpass']);
		
		$SQL = "SELECT clave FROM usuario WHERE id=$UID";
		
		$result_usuario = consulta_sql($SQL);

		if($datos_usuario = mysqli_fetch_array($result_usuario)){
			if($pass == $datos_usuario[0]){
				echo 1;
				exit;
			}else{
				echo 'La clave actual es incorrecta';
				exit;
			}
			
		}
		else{
			echo 'Error SQL';
			exit;
		}
	}
	elseif($ACCION == "pass"){
		$UID = $_SESSION['session_usuario_id'];
		
		$pass = MD5($_GET['newpass']);
		
		$SQL = "UPDATE usuario SET clave='$pass' WHERE id=$UID";
		
		if(comando_sql($SQL) > 0){
			echo 1;
			exit;
		}
		else{
			echo 'Error SQL';
			exit;
		}	
	}

?>