<?php
// Motor autentificacion usuarios.

// Cargar datos conexion y otras variables.
//error_reporting(E_ALL);
require("config.inc.php");
require('antinyeccion.inc.php');

// chequear pagina que lo llama para devolver errores a dicha pagina.

$redir="index.php";
// chequear si se llama directo al script.


// Chequeamos si se esta autentificandose un usuario por medio del formulario
if (isset($_POST['rut_desde_index']) && isset($_POST['clave_desde_index'])) {

	$db_conexion= mysqli_connect(EVE_SQL_HOST_DATABASE, EVE_SQL_HOST_DATABASE_USER_NAME, EVE_SQL_DATABASE_PASSWORD) or die(header ("Location:  $redir?error_login=0"));
	mysqli_select_db($db_conexion, EVE_SQL_DATABASE_NAME);

	$login = mysql_quote($_POST['rut_desde_index']);

	$usuario_consulta = mysqli_query($db_conexion,"SELECT id,nombre,clave,administrador,rut,email,ultimo_ingreso,sistema FROM usuario WHERE rut='".$login."'") or die(header ("Location:  $redir?error_login=1&login=".$login));

	if (mysqli_num_rows($usuario_consulta) != 0){

		$password = md5($_POST['clave_desde_index']);

		$usuario_datos = mysqli_fetch_array($usuario_consulta);

		mysqli_free_result($usuario_consulta);
		mysqli_close($db_conexion);

		if ($login != $usuario_datos['rut']){
			Header ("Location: $redir?error_login=4");
			exit;
		}

		if ($password != $usuario_datos['clave']){

			Header ("Location: $redir?error_login=3");
	    		exit;
	    	}

		unset($login);
		unset($password);


		// le damos un nombre a la sesion, concatenando el nombre de usuario con una cadena aleatoria y posteriormente encriptada con md5.
		$nombre_sesion = md5($usuario_datos['rut'].md5(microtime() * mktime(0)));
		session_name($nombre_sesion);
		// inicia sessiones
		session_start();

		// Paranoia: decimos al navegador que no "cachee" esta pagina.
		//session_cache_limiter('nocache,private');

		$_SESSION['session_usuario_id'] = $usuario_datos['id'];

		$_SESSION['session_nombre_sesion'] = $nombre_sesion;

		$_SESSION['session_usuario_nombre'] = $usuario_datos['nombre'];

		$_SESSION['session_usuario_clave'] = $usuario_datos['clave'];

		$_SESSION['session_usuario_administrador'] = $usuario_datos['administrador'];

		$_SESSION['session_usuario_email'] = $usuario_datos['email'];

		$_SESSION['session_usuario_ultimo_ingreso'] = $usuario_datos['ultimo_ingreso'];

		$_SESSION['session_usuario_rut'] = $usuario_datos['rut'];

		$_SESSION['session_usuario_sistema'] = $usuario_datos['sistema'];

		$_SESSION['process_csv'] = false;
		// Carga las estaciones como string para la sidebar
		include("system/navigation_sidebar_ajax.inc.php");

		// Hacemos una llamada a si mismo (scritp) para que queden disponibles
		// las variables de session en el array asociado $HTTP_...
		$pag = $_SERVER['PHP_SELF'];
		Header ("Location: $pag?sid=".$nombre_sesion);
		exit;

	}
	else {
		// si no esta el nombre de usuario en la BD o el password ..
		// se devuelve a pagina q lo llamo con error

		Header ("Location: $redir?error_login=2");
		exit;
	}
}
else {

	// -------- Chequear sesion existe -------

	// usamos la sesion de nombre definido a partir del nombre de usuario y la cadena aleatoria encriptada.
	if(isset($_REQUEST['sid']))
		session_name($_REQUEST['sid']);
	// Iniciamos el uso de sesiones
	session_start();

	// Chequeamos si estan creadas las variables de sesion de identificacion del usuario,
	// El caso mas comun es el de una vez "matado" la sesion se intenta volver hacia atras
	// con el navegador.

	if (!isset($_SESSION['session_usuario_rut'])){
		// Borramos la sesion creada por el inicio de session anterior
		session_destroy();
		die("<h1>Error</h1><h2>Su sesi&oacute;n ha caducado.</h2>");
		exit;
	}
}?>