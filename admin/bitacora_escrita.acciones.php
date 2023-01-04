<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	check_admin($_SESSION['session_nombre_sesion']);

	$ACCION = $_GET['accion'];
	
	if($ACCION == "getlog"){
		$fecha1 = $_GET['fecha1'];
		$fecha2 = $_GET['fecha2'];
		
		$SQL = "SELECT evento, fecha, nombre, usuario.id 
			FROM eve_bitacora_escrita,usuario 
			WHERE usuario_id=usuario.id 
			AND fecha>='$fecha1' 
			AND fecha<='$fecha2' 
			ORDER BY fecha DESC, eve_bitacora_escrita.id DESC LIMIT 30";
		
		$result_log = consulta_sql($SQL);
		
		$HTML .= "<table style='width: 90%;'>";
		$HTML.="<tbody>";
		$HTML.="<tr>";
		$HTML.="<th class='top' scope='col' align='left'>Fecha</td>";
		$HTML.="<th class='top' scope='col' align='left'>Evento</td>";
		$HTML.="<th class='top' scope='col' align='left'>UID</td>";
		$HTML.="</tr>";
		
		while($datos_log = mysqli_fetch_array($result_log)){
			$HTML.="<tr>";
			$HTML.="<td>".cambia_fecha_a_normal($datos_log[1])."</td>";
			$HTML.="<td>".$datos_log[0]."</td>";
			$HTML.="<td><span title='".$datos_log[2]."'>".$datos_log[3]."</span></td>";
			$HTML.="</tr>";
		}
		
		$HTML.= "</tbody>";
		$HTML.= "</table>";
		echo $HTML;
		return;
	}
	elseif($ACCION == "add"){
		$evento = $_GET['evento'];
		$fecha = $_GET['fecha'];
		$uid = $_SESSION['session_usuario_id'];
		
		$SQL = "INSERT INTO `eve_bitacora_escrita` (`evento`, `fecha`, `usuario_id`) VALUES ( '$evento', '$fecha', $uid)";
		
		if(comando_sql($SQL) > 0){
			echo 1;
			return;
		}
		else{
			echo 0;
			return;
		}
		
	}
	elseif($ACCION == "getlog_for_print"){
		$fecha1 = $_GET['fecha1'];
		$fecha2 = $_GET['fecha2'];
		
		$SQL = "SELECT evento, fecha, nombre, usuario.id 
			FROM eve_bitacora_escrita,usuario 
			WHERE usuario_id=usuario.id 
			AND fecha>='$fecha1' 
			AND fecha<='$fecha2' 
			ORDER BY fecha DESC, eve_bitacora_escrita.id DESC LIMIT 30";
		
		$result_log = consulta_sql($SQL);
		
		$HTML .= "<table style='width: 90%; border: 1px #000 solid; border-collapse: collapse'>";
		$HTML.="<tbody>";
		$HTML.="<tr>";
		$HTML.="<th class='top' scope='col' align='left' style='border: 1px #000 solid;'>Fecha</td>";
		$HTML.="<th class='top' scope='col' align='left' style='border: 1px #000 solid;'>Evento</td>";
		$HTML.="<th class='top' scope='col' align='left' style='border: 1px #000 solid;'>UID</td>";
		$HTML.="</tr>";
		
		while($datos_log = mysqli_fetch_array($result_log)){
			$HTML.="<tr>";
			$HTML.="<td style='border: 1px #000 solid;'>".cambia_fecha_a_normal($datos_log[1])."</td>";
			$HTML.="<td style='border: 1px #000 solid;'>".$datos_log[0]."</td>";
			$HTML.="<td style='border: 1px #000 solid;'><span title='".$datos_log[2]."'>".$datos_log[3]."</span></td>";
			$HTML.="</tr>";
		}
		
		$HTML.= "</tbody>";
		$HTML.= "</table>";
		echo $HTML;
		return;
	}

?>