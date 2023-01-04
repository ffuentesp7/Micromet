<?php
	require_once('../funciones.inc.php');

	$ACCION = $_GET['accion'];
	
	if($ACCION == "getnewsletterselect"){
	
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