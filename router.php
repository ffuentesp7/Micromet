<?php
	require('aut_verifica.inc.php');
	require('funciones.inc.php');
	$SYSTEM_ENABLE = get_parameter('SYSTEM_ENABLE');
	$ADMINVALUE = $_SESSION['session_usuario_administrador'];

	ultima_visita($_SESSION['session_usuario_id']);

	estadisticas('WEB','USER_ACCESS_IDENTIFIED');

	bitacora("Acceso desde ".$_SERVER['REMOTE_ADDR'].", usando ".$_SERVER['HTTP_USER_AGENT']);
	if($ADMINVALUE == 1){
		redirect("admin/index.php?sid=".$_SESSION['session_nombre_sesion']);
	}
	elseif($ADMINVALUE == 0){
		if($SYSTEM_ENABLE == 'ON')
			redirect("system/index.php?sid=".$_SESSION['session_nombre_sesion']);
		else
			redirect("index.php?sid=".$_SESSION['session_nombre_sesion']);
	}
?>