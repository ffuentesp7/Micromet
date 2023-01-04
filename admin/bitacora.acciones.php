<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	check_admin($_SESSION['session_nombre_sesion']);
	
	$ACCION = $_GET['accion'];
	
	if($ACCION == 'tabla'){
		$MES 	= $_GET['mes_query'];
		$ANIO 	= $_GET['anio_query'];
		
		$SQL = 'SELECT eve_bitacora.id,fecha,hora,observacion,nombre FROM eve_bitacora,usuario WHERE eve_bitacora.usuario_id=usuario.id ORDER BY eve_bitacora.id DESC LIMIT 30';
		if($MES != '0' && $ANIO != '0'){
			$SQL = "SELECT eve_bitacora.id,fecha,hora,observacion,nombre FROM eve_bitacora,usuario WHERE eve_bitacora.usuario_id=usuario.id AND MONTH(fecha)='$MES' AND YEAR(fecha)='$ANIO' ORDER BY eve_bitacora.id DESC";	
		}
		
		$request_bitacora = consulta_sql($SQL);
		
		$HTML = "<table style='width: 100%;' id='tabla_bitacora' class='table table-hover dataTable no-footer'>";
		$HTML.="<thead>";
		$HTML.="<tr>";
		$HTML.="<th class='top' scope='col'>Usuario</th>";
		$HTML.="<th class='top' scope='col'>Fecha</th>";
		$HTML.="<th class='top' scope='col'>Hora</th>";
		$HTML.="<th class='top' scope='col'>Observacion</th>";
		$HTML.="</tr>";
		$HTML.="</thead>";
		$HTML.="<tbody>";

		
		while($datos_bitacora = mysqli_fetch_array($request_bitacora)){
			$HTML.="<tr>";
			$HTML.="<td>".$datos_bitacora[4]."</td>";
			$HTML.="<td>".cambia_fecha_a_normal($datos_bitacora[1])."</td>";
			$HTML.="<td>".$datos_bitacora[2]."</td>";
			$HTML.="<td>".$datos_bitacora[3]."</td>";
			$HTML.="</tr>";
		}
		$HTML.= "</tbody>";
		$HTML.= "</table>";
		echo $HTML;
		return;
	}
	else{
		echo 0;
	}
?>