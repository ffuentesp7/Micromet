<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');

	$ACCION = $_GET['accion'];
	
	if($ACCION == "getareaselect"){
		$SQL = "SELECT eve_area.nombre,eve_area.id
			FROM eve_usuario_has_tipo_de_permiso_usuario, eve_tipo_de_permiso_usuario, eve_area
			WHERE usuario_id=".$_SESSION['session_usuario_id']."
			AND eve_tipo_de_permiso_usuario_id=eve_tipo_de_permiso_usuario.id
			AND eve_tipo_de_permiso_usuario.value=eve_area.id
			AND eve_tipo_de_permiso_usuario.code LIKE 'AREA_ACCESS_%'";
		
		$result_area = consulta_sql($SQL);
		
		$HTML = '<select class="combo" style="width: 400px;" id="select_area" name="select_area">';
		
		while($datos_area = mysqli_fetch_array($result_area)){
			$HTML.= '<option value="'.$datos_area[1].'">';
			$HTML.= $datos_area[0];
			$HTML.= '</option>';
		}
		$HTML.= '</select>';
		
		echo $HTML;
	}
	else if($ACCION == "getnewsletterselect"){
	
		$SQL = "SELECT id,semana,anio,fecha_inicio,fecha_termino
			FROM eve_semana_boletin
			ORDER BY id DESC";
		
		$result_boletin = consulta_sql($SQL);
		
		$HTML = '<select class="combo" style="width: 400px;" id="select_boletin" name="select_boletin">';
		
		while($datos_boletin = mysqli_fetch_array($result_boletin)){
			$HTML.= '<option value="'.$datos_boletin[0].'">';
			$HTML.= 'N&deg; '.$datos_boletin[0].', Semana '.$datos_boletin[1].' del '.cambia_fecha_a_normal($datos_boletin[3]).' al '.cambia_fecha_a_normal($datos_boletin[4]);
			$HTML.= '</option>';
		}
		$HTML.= '</select>';
		
		echo $HTML;
	}

?>