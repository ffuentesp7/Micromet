<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');

	$SQL = "SELECT estacion.nombre,estacion.id
	FROM eve_usuario_has_tipo_de_permiso_usuario, eve_tipo_de_permiso_usuario, estacion
	WHERE usuario_id=".$_SESSION['session_usuario_id']."
	AND eve_tipo_de_permiso_usuario_id=eve_tipo_de_permiso_usuario.id
	AND eve_tipo_de_permiso_usuario.value=estacion.id
	ORDER BY estacion.ultima_fecha DESC, estacion.ultima_hora DESC";
	
	$result_estaciones = consulta_sql($SQL);
	
	$HTML = '';
	
	$numero_estaciones = mysqli_num_rows($result_estaciones);
	$seleccionada1 = rand(0,$numero_estaciones-1);
	//$seleccionada2 = rand(0,$numero_estaciones-1);
	//$seleccionada3 = rand(0,$numero_estaciones-1);
	
	for($i = 0; $datos_estaciones = mysqli_fetch_array($result_estaciones); $i++){
		
		if($i == $seleccionada1){
			$medicion = get_last_sensor_value("TEMP",$datos_estaciones[1]);
			
			$med = -1;
			$fecha = '0000-00-00';
			$hora = '00:00:00';
			
			if($medicion != "NULL"){
				$medicion_split = explode("|",$medicion);
				
				$fecha 	= $medicion_split[0];
				$hora 	= $medicion_split[1];
				$med 	= $medicion_split[2];
			}
			$HTML.= '<div>';
			$HTML.= '<img src="../img/sensorsicons/'.get_temp_icon($med).'.png"/>'.sprintf("%0.1f",$med).'&deg;C en ';
			$HTML.= $datos_estaciones[0];
			$HTML.= ' ('.$hora.'hrs. del '.cambia_fecha_a_normal($fecha);
			$HTML.= ')</div>';
		}
	}
	if($HTML == '')
		$HTML = '<div><a>No Existen Estaciones</a></div>';
	echo $HTML;
	
	function get_temp_icon($level){
		if($level < 0)
			return 'temperature_1';
		elseif($level >= 0 && $level < 10)
			return 'temperature_2';
		elseif($level >= 10 && $level < 20)
			return 'temperature_3';
		elseif($level >= 20 && $level < 30)
			return 'temperature_4';
		elseif($level >= 30)
			return 'temperature_5';
	}
?>