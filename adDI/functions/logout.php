<?php

	if(isset($_GET['session-id'])){
		session_name($_GET['session-id']);
	}
	// iniciamos sesiones
	$HTML = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
	session_start();
	if(isset($_SESSION['session_usuario_id'])){	
		$HTML.= '<response>';
		$HTML.= '<string>OK</string>';
		$HTML.= '</response>';
	}
	else{
		$HTML.= '<response>';
		$HTML.= '<string>Session Already Close</string>';
		$HTML.= '</response>';
	}
	session_destroy();
	echo $HTML;

?>