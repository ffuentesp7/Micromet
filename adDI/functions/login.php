<?php

require("../config.inc.php");
require_once("../antinyeccion.inc.php");

// chequear pagina que lo llama para devolver errores a dicha pagina.

$redir="adDI.php";


// Chequeamos si se esta autentificandose un usuario por medio del formulario
if ($_GET['function'] == 'login' && isset($_GET['user']) && isset($_GET['pass'])) {

	$db_conexion= mysql_connect(EVE_SQL_HOST_DATABASE, EVE_SQL_HOST_DATABASE_USER_NAME, EVE_SQL_DATABASE_PASSWORD) or die(header ("Location:  $redir?function=error&e=07"));
	mysql_select_db(EVE_SQL_DATABASE_NAME);

	$login = mysql_quote($_GET['user']);

	$usuario_consulta = mysql_query("SELECT id,clave,rut FROM usuario WHERE rut='".$login."'") or die(header ("Location:  $redir?function=error&e=08"));

	if (mysqli_num_rows($usuario_consulta) != 0){
		
		$password = md5($_GET['pass']);

		$usuario_datos = mysqli_fetch_array($usuario_consulta);
  
		mysql_free_result($usuario_consulta);
		mysql_close($db_conexion);
    
		if ($login != $usuario_datos['rut']){
			header ("Location:  $redir?function=error&e=05");
		}

		if ($password != $usuario_datos['clave']){
			
			header ("Location:  $redir?function=error&e=06");
	    	}

		unset($login);
		unset($password);
    
		$USUARIO_ID = $usuario_datos['id'];
		
		$db_conexion= mysql_connect(EVE_SQL_HOST_DATABASE, EVE_SQL_HOST_DATABASE_USER_NAME, EVE_SQL_DATABASE_PASSWORD) or die(header ("Location:  $redir?function=error&e=07"));
		mysql_select_db(EVE_SQL_DATABASE_NAME);
		
		$usuario_consulta = mysql_query("SELECT hash FROM addi WHERE usuario_id=$USUARIO_ID") or die(header ("Location:  $redir?function=error&e=08"));
		
		if (mysqli_num_rows($usuario_consulta) != 0){
		
			$usuario_datos = mysqli_fetch_array($usuario_consulta);
  
			mysql_free_result($usuario_consulta);
			mysql_close($db_conexion);
		
			$HTML = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
			$HTML.= '<response>';
			$HTML.= '<string>'.$usuario_datos['hash'].'</string>';
			$HTML.= '</response>';
			echo $HTML;
			exit;
		}
		else{
			header ("Location:  $redir?function=error&e=03");
		}    		
	} 
	else {
		header ("Location:  $redir?function=error&e=05");
	}
}
else{
	if(isset($_GET['h']) && isset($_GET['function'])){
		
		$USUARIO_ID = '';
		$HASH = $_GET['h'];
		
		$db_conexion= mysql_connect(EVE_SQL_HOST_DATABASE, EVE_SQL_HOST_DATABASE_USER_NAME, EVE_SQL_DATABASE_PASSWORD) or die(header ("Location:  $redir?function=error&e=07"));
		mysql_select_db(EVE_SQL_DATABASE_NAME);
		
		$usuario_consulta = mysql_query("SELECT usuario_id FROM addi WHERE hash='$HASH'") or die(header ("Location:  $redir?function=error&e=08"));
		
		if (mysqli_num_rows($usuario_consulta) != 0){
		
			$usuario_datos = mysqli_fetch_array($usuario_consulta);
  
			mysql_free_result($usuario_consulta);
			mysql_close($db_conexion);
		
			$USUARIO_ID = $usuario_datos['usuario_id'];
		
		}
		else{
			header ("Location:  $redir?function=error&e=03");
		}
	}
	else{
		header ("Location:  $redir?function=error&e=00");
	}
}

?>