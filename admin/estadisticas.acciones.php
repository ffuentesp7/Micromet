<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	check_admin($_SESSION['session_nombre_sesion']);
	
	$ACCION = $_GET['accion'];
	
	if($ACCION == 'tabla'){
		
		$TIPO = $_GET['tipo'];
		
		$SQL = "SELECT nombre,valor FROM eve_estadistica WHERE tipo='$TIPO' ORDER BY valor DESC";
		
		$request_estadistica = consulta_sql($SQL);
		
		$HTML = "<table style='width: 100%;' id='tabla_estadistica'>";
		$HTML.="<thead>";
		$HTML.="<tr>";
		$HTML.="<th class='top' scope='col'>Nombre</th>";
		$HTML.="<th class='top' scope='col'>Cantidad</th>";
		$HTML.="</tr>";
		$HTML.="</thead>";
		$HTML.="<tbody>";
		
		while($datos_estadistica = mysqli_fetch_array($request_estadistica)){
			$HTML.="<tr>";
			$HTML.="<td>".$datos_estadistica[0]."</td>";
			$HTML.="<td>".$datos_estadistica[1]."</td>";
			$HTML.="</tr>";
		}
		$HTML.= "</tbody>";
		$HTML.= "</table>";
		echo $HTML;
		return;
	}
?>