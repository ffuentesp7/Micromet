<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	check_admin($_SESSION['session_nombre_sesion']);

	$ACCION = $_GET['accion'];
	
	if($ACCION == "getdatasource"){
		$EID = $_GET['eid'];
		
		$SQL = "SELECT ip FROM estacion,fuente_de_datos WHERE fuente_de_datos.id=estacion.fuente_de_datos_id AND estacion.id=$EID";
		
		$result_fuente_de_datos = consulta_sql($SQL);
		
		if($datos_fuente_de_datos = mysqli_fetch_array($result_fuente_de_datos)){
			echo $datos_fuente_de_datos[0];
			return;
		}
		else{
			echo 'No existe Fuente de Datos Asociada';
			return;
		}
		
	}
	elseif($ACCION == "datosestacion"){
		$EID = $_GET['eid'];
		
		$SQL = "SELECT adcon_id,latitud,longitud,altura,ultima_fecha,ultima_hora,intentos_de_descarga,estacion_clon_id,estado,descargar,clonar,ultima_fecha_clon,ultima_hora_clon FROM estacion WHERE estacion.id=$EID";
		
		$result_fuente_de_datos = consulta_sql($SQL);
		
		if($datos_fuente_de_datos = mysqli_fetch_array($result_fuente_de_datos)){
			$HTML = "<table style='width: 90%;'>";
			$HTML.="<tbody>";
			$HTML.="<tr>";
			$HTML.="<th class='top' scope='col'>Intem</th>";
			$HTML.="<th class='top' scope='col'>Valor</th>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>ID Adcon</th>";
			$HTML.="<td>".$datos_fuente_de_datos[0]."</th>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>Latitud</th>";
			$HTML.="<td>".$datos_fuente_de_datos[1]."</th>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>Longitud</th>";
			$HTML.="<td>".$datos_fuente_de_datos[2]."</th>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>Altura</th>";
			$HTML.="<td>".$datos_fuente_de_datos[3]."</th>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>&Uacute;ltima Fecha</th>";
			$HTML.="<td>".$datos_fuente_de_datos[4]."</th>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>&Uacute;ltima Hora</th>";
			$HTML.="<td>".$datos_fuente_de_datos[5]."</th>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>Intentos de Descarga</th>";
			$HTML.="<td>".$datos_fuente_de_datos[6]."</th>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>ID Estaci&oacute;n Clon</th>";
			$HTML.="<td>".$datos_fuente_de_datos[7]."</th>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>Estado</th>";
			$HTML.="<td>".$datos_fuente_de_datos[8]."</th>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>Descargar</th>";
			$HTML.="<td>".$datos_fuente_de_datos[9]."</th>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>Clonar</th>";
			$HTML.="<td>".$datos_fuente_de_datos[10]."</th>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>&Uacute;ltima Fecha Clon</th>";
			$HTML.="<td>".$datos_fuente_de_datos[11]."</th>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>&Uacute;ltima Hora Clon</th>";
			$HTML.="<td>".$datos_fuente_de_datos[12]."</th>";
			$HTML.="</tr>";
			
			$HTML.= "</tbody>";
			$HTML.= "</table>";
			
			echo $HTML;
			
			return;
		}
		else{
			echo 'No existe ID';
			return;
		}
		
	}
	elseif($ACCION == "downloadinfo"){
		
		$SQL = "SELECT 	adcon_id,
				nombre,
				ultima_fecha,
				ultima_hora,
				intentos_de_descarga,
				estado,
				ultima_fecha_clon,
				ultima_hora_clon,
				latitud,
				longitud 
			FROM 	estacion 
			ORDER BY estacion.estado, estacion.nombre";
		
		$result_fuente_de_datos = consulta_sql($SQL);
		
		$HTML = "<table style='width: 90%;'>";
		$HTML.="<tbody>";
		
		while($datos_fuente_de_datos = mysqli_fetch_array($result_fuente_de_datos)){
			
			$D = retorna_unix($datos_fuente_de_datos[2],$datos_fuente_de_datos[3]);
			$A = retorna_unix(date("Y-m-d"),date("H:i:s"));
			
			$S = $A - $D;
			
			$HTML.="<tr>";
			
			if($S < 3600){
				$HTML.="<th class='top' scope='col'><img class='centernoborder' src='../img/actionicons/bullet_green.png'/></th>";
			}
			elseif($S >= 3600 && $S < 10800){
				$HTML.="<th class='top' scope='col'><img class='centernoborder' src='../img/actionicons/bullet_yellow.png'/></th>";
			}
			elseif($S >= 10800 && $S < 86400){
				$HTML.="<th class='top' scope='col'><img class='centernoborder' src='../img/actionicons/bullet_orange.png'/></th>";
			}
			else{
				$HTML.="<th class='top' scope='col'><img class='centernoborder' src='../img/actionicons/bullet_red.png'/></th>";
			}
			
			$HTML.="<th class='top' scope='col' colspan='7'>".$datos_fuente_de_datos[1]."(".$datos_fuente_de_datos[0].") (Lat. ".$datos_fuente_de_datos[8].", Lon. ".$datos_fuente_de_datos[9].")</th>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<th class='top' scope='col'>Fecha</th>";
			$HTML.="<th class='top' scope='col'>Hora</th>";
			$HTML.="<th class='top' scope='col'>Intentos D</th>";
			$HTML.="<th class='top' scope='col' colspan='2'>Estado</th>";
			$HTML.="<th class='top' scope='col'>Fecha CD</th>";
			$HTML.="<th class='top' scope='col'>Hora CD</th>";
			$HTML.="</tr>";
			
			
			
			$HTML.="<tr>";
			$HTML.="<td>".cambia_fecha_a_normal($datos_fuente_de_datos[2])."</td>";
			$HTML.="<td>".$datos_fuente_de_datos[3]."</td>";
			$HTML.="<td>".$datos_fuente_de_datos[4]."</td>";
			$HTML.="<td colspan='2'>".getStationState($datos_fuente_de_datos[5])."</td>";
			$HTML.="<td>".cambia_fecha_a_normal($datos_fuente_de_datos[6])."</td>";
			$HTML.="<td>".$datos_fuente_de_datos[7]."</td>";
			$HTML.="</tr>";
			
		}
		$HTML.= "</tbody>";
		$HTML.= "</table>";
		
		echo $HTML;
		
		return;
		
	}
	elseif($ACCION == "instrumentos"){
		$EID = $_GET['eid'];
		
		$SQL = "SELECT tipo_instrumento.nombre,tipo_instrumento.code,instrumento.modelo,instrumento.marca,instrumento.unidad,instrumento.id,instrumento.adcon_id,instrumento.ubicacion_nombre,instrumento.observacion,instrumento.fecha_instalacion,instrumento.revisar_datos
			FROM estacion,instrumento,tipo_instrumento 
			WHERE estacion.id=instrumento.estacion_id
			AND instrumento.tipo_instrumento_id=tipo_instrumento.id
			AND estacion.id=$EID";
		
		$result_fuente_de_datos = consulta_sql($SQL);
		
		$HTML = "<table style='width: 90%;'>";
		$HTML.="<tbody>";
		
		while($datos_fuente_de_datos = mysqli_fetch_array($result_fuente_de_datos)){
			
			$HTML.="<tr>";
			$HTML.="<th class='top' scope='col' colspan='2'>".$datos_fuente_de_datos[2]." (".$datos_fuente_de_datos[3].")</th>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>ID</td>";
			$HTML.="<td>".$datos_fuente_de_datos[5]."</td>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>ID Adcon</td>";
			$HTML.="<td>".$datos_fuente_de_datos[6]."</td>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>Tipo</td>";
			$HTML.="<td>".$datos_fuente_de_datos[0]."</td>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>Tipo (C&oacute;digo)</td>";
			$HTML.="<td>".$datos_fuente_de_datos[1]."</td>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>Unidad</td>";
			$HTML.="<td>".$datos_fuente_de_datos[4]."</td>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>Ubicaci&oacute;n</td>";
			$HTML.="<td>".$datos_fuente_de_datos[7]."</td>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>Observaci&oacute;n</td>";
			$HTML.="<td>".$datos_fuente_de_datos[8]."</td>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>Fecha de Instalaci&oacute;n</td>";
			$HTML.="<td>".$datos_fuente_de_datos[9]."</td>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>Revisar Datos</td>";
			$HTML.="<td>".$datos_fuente_de_datos[10]."</td>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td class='whitenoborder' colspan='2'></td>";
			$HTML.="</tr>";

		}
		$HTML.= "</tbody>";
		$HTML.= "</table>";
		
		echo $HTML;
			
		return;
	}
	elseif($ACCION == "modelos"){
		$EID = $_GET['eid'];
		
		$SQL = "SELECT tipo_modelo.nombre,tipo_modelo.descripcion,tipo_modelo.script_nombre,estacion_has_modelo.activo
			FROM estacion,estacion_has_modelo,tipo_modelo 
			WHERE estacion.id=estacion_has_modelo.id_estacion
			AND estacion_has_modelo.id_tipo_modelo=tipo_modelo.id
			AND estacion.id=$EID";
		
		$result_fuente_de_datos = consulta_sql($SQL);
		
		$HTML = "<table style='width: 90%;'>";
		$HTML.="<tbody>";
		
		$OK = 0;
		
		while($datos_fuente_de_datos = mysqli_fetch_array($result_fuente_de_datos)){
			$OK = 1;
			$HTML.="<tr>";
			$HTML.="<th class='top' scope='col' colspan='2'>".$datos_fuente_de_datos[0]."</th>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>Descripci&oacute;n</td>";
			$HTML.="<td>".$datos_fuente_de_datos[1]."</td>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>Script</td>";
			$HTML.="<td>".$datos_fuente_de_datos[2]."</td>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td>Activo</td>";
			$HTML.="<td>".$datos_fuente_de_datos[3]."</td>";
			$HTML.="</tr>";
			
			$HTML.="<tr>";
			$HTML.="<td class='whitenoborder' colspan='2'></td>";
			$HTML.="</tr>";

		}
		if($OK == 0){
			$HTML.="<tr>";
			$HTML.="<th class='top' scope='col' colspan='2'>No existen Modelos</th>";
			$HTML.="</tr>";
		}
		
		$HTML.= "</tbody>";
		$HTML.= "</table>";
		
		echo $HTML;
			
		return;
	}
	elseif($ACCION == "newscript"){
		$NAME = $_REQUEST['nombre'];
		$DESC = $_REQUEST['descripcion'];
		$SCRT = $_REQUEST['script'];
		
		$SQL = "INSERT INTO calibration_script (name, filename, description) 
			VALUES ( '$NAME', '$SCRT', '$DESC')";
			
		if(comando_sql($SQL)){
			echo 'true';
		}
		else{
			echo 'false';
		}
		
	}
	elseif($ACCION == "updatescript"){
	
		$NAME = $_REQUEST['nombre'];
		$DESC = $_REQUEST['descripcion'];
		$SCRT = $_REQUEST['script'];
		$CSI = $_REQUEST['csi'];
		
		$SQL = "UPDATE calibration_script SET name='$NAME', filename='$SCRT', description='$DESC' WHERE id=$CSI";
			
		if(comando_sql($SQL)){
			echo 'true';
		}
		else{
			echo 'false';
		}
		
	}
	elseif($ACCION == "setcalibrationforinstrument"){
		
		$iid = $_REQUEST['instrumentId']; 
		$csi = $_REQUEST['scriptId']; 
		$av = $_REQUEST['aValue']; 
		$bv = $_REQUEST['bValue']; 
		$cv = $_REQUEST['cValue']; 
		$dv = $_REQUEST['dValue']; 
		$ev = $_REQUEST['eValue'];
	
		$SQL = "SELECT a FROM instrumento_calibracion WHERE instrumento_id=$iid";
		
		$RES = consulta_sql($SQL);
		
		if(mysqli_num_rows($RES) > 0){
			$SQL = "UPDATE 	instrumento_calibracion 
				SET 	calibration_script_id=$csi, 
					a=$av, 
					b=$bv, 
					c=$cv, 
					d=$dv, 
					e=$ev 
				WHERE 	instrumento_id=$iid";
		}
		else{
			$SQL = "INSERT INTO instrumento_calibracion (instrumento_id, calibration_script_id, a, b, c, d, e) 
				VALUES ( $iid, $csi, $av, $bv, $cv, $dv, $ev)";
		}
	
		if(consulta_sql($SQL)){
			echo "true";
		}
		else{
			echo "false";
		}
	}
	elseif($ACCION == "getlistscript"){
		$SQL = "SELECT id, name, filename, description FROM calibration_script ORDER BY name";
									
		$RES = consulta_sql($SQL);
		
		$HTML = '<tr>
				<th class="top" scope="col">Nombre</th>
				<th class="top" scope="col">Descripci&oacute;n</th>
				<th class="top" scope="col">Archivo</th>
				<th class="top" scope="col">Editar</th>
				<th class="top" scope="col">Borrar</th>
			</tr>';
		while($DATA = mysqli_fetch_array($RES)){
			$HTML.='<tr><td>'.$DATA[1].'</td><td>'.$DATA[3].'</td><td>'.$DATA[2].'</td>';
			$HTML.='<td><input type="button" class="button" value="Editar" onclick="setCalibrationScriptData('.$DATA[0].')"/></td>';
			$HTML.='<td><input type="button" class="button" value="Borrar" onclick="deleteCalibrationScript('.$DATA[0].')"/></td></tr>';
		}
		echo $HTML;
	}
	elseif($ACCION == "getinstrumentocalibraciondata"){
		$iid = $_REQUEST['instrumentId'];
	
		$SQL = "SELECT calibration_script_id, a, b, c, d, e FROM instrumento_calibracion WHERE instrumento_id=$iid";
		
		$RES = consulta_sql($SQL);
		
		if($DATA = mysqli_fetch_array($RES)){
			echo $DATA[0].'|'.$DATA[1].'|'.$DATA[2].'|'.$DATA[3].'|'.$DATA[4].'|'.$DATA[5];
		}
		else{
			echo "0|0";
		}
	}
	elseif($ACCION == "getcalibrationscriptdata"){
		$csi = $_REQUEST['scriptId'];
	
		$SQL = "SELECT name, filename, description FROM calibration_script WHERE id=$csi";
		
		$RES = consulta_sql($SQL);
		
		if($DATA = mysqli_fetch_array($RES)){
			echo $DATA[0].'|'.$DATA[1].'|'.$DATA[2];
		}
		else{
			echo "0|0";
		}
	}
	elseif($ACCION == "unsetinstrumentocalibracion"){
		$iid = $_REQUEST['instrumentId'];
		$csi = $_REQUEST['scriptId'];
		
		$SQL = "DELETE FROM instrumento_calibracion WHERE instrumento_id=$iid AND calibration_script_id=$csi";
		
		if(comando_sql($SQL)){
			echo "true";
		}
		else{
			echo "false";
		}
	}
	elseif($ACCION == "deletecalibrationscript"){
		
		$csi = $_REQUEST['scriptId'];
		
		$SQL = "DELETE FROM instrumento_calibracion WHERE calibration_script_id=$csi";
		
		comando_sql($SQL);
		
		$SQL = "DELETE FROM calibration_script WHERE id=$csi";
		
		if(comando_sql($SQL)){
			echo "true";
		}
		else{
			echo "false";
		}
	}
	else{
		echo 'No Action Send!!';
	}

?>
