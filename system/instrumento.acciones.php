<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	require('../system/functions/statistic.functions.php');
	require('../system/functions/instrument.type.php');
	require('../system/functions/convert.unit.php');
	

	$ACCION = $_GET['accion'];
	
	if($ACCION == "getstationsselect"){
	
		$TIID = $_GET['tiid'];
	
		$SQL = "SELECT estacion.nombre,estacion.id
			FROM eve_usuario_has_tipo_de_permiso_usuario, eve_tipo_de_permiso_usuario, estacion, instrumento 
			WHERE usuario_id=".$_SESSION['session_usuario_id']." 
			AND eve_tipo_de_permiso_usuario_id=eve_tipo_de_permiso_usuario.id 
			AND eve_tipo_de_permiso_usuario.value=estacion.id 
			AND instrumento.tipo_instrumento_id=$TIID 
			AND instrumento.estacion_id=estacion.id 
			AND eve_tipo_de_permiso_usuario.code LIKE 'STATION_ACCESS_%'
			ORDER BY estacion.nombre";
		
		$result_estaciones = consulta_sql($SQL);
		
		$HTML = '<select class="form-select" id="select_estacion" name="select_estacion">';
		
		while($datos_estaciones = mysqli_fetch_array($result_estaciones)){
			$HTML.= '<option value="'.$datos_estaciones[1].'">';
			$HTML.= $datos_estaciones[0];
			$HTML.= '</option>';
		}
		$HTML.= '</select>';
		
		echo $HTML;
	}
	elseif($ACCION == "getdata"){
		$CURRENT_DATA_ACCESS = '0'/*get_user_permission($_SESSION['session_usuario_id'],'CURRENT_DATA_ACCESS')*/;
		$TIID = $_GET['tiid'];
		$EID  = $_GET['eid'];
		
		if($CURRENT_DATA_ACCESS == '1'){
			$SQL = "SELECT fecha,hora,medicion,instrumento.modelo,instrumento.marca,unidad
				FROM medicion,instrumento
				WHERE instrumento.estacion_id=$EID
				AND medicion.instrumento_id=instrumento.id
				AND instrumento.tipo_instrumento_id=$TIID 
				ORDER BY fecha DESC, hora DESC LiMIT 96";
				
			$result_medicion = consulta_sql($SQL);
			
			$HTML = '';
			$datos_medicion = mysqli_fetch_array($result_medicion);
			
			$HTML .= '<table class="mediagrove">
					<caption>Datos de '.$datos_medicion[3].' ('.$datos_medicion[4].')</caption>
					<thead>
						<tr>
							<th scope="col">Fecha</th>
							<th scope="col">Hora</th>
							<th scope="col">Medicion ('.$datos_medicion[5].')</th>
						</tr>
					</thead>
					<tbody>';
			$i = 0;
			do{
				if(($i%2) == 0)
					$HTML .= '<tr class="data_row_'.$TIID.'" valor="'.number_format($datos_medicion[2]*1, 1, '.', '').'">';
				else
					$HTML .= '<tr class="odd data_row_'.$TIID.'" valor="'.number_format($datos_medicion[2]*1, 1, '.', '').'">';
				$HTML .=       '<td>'.cambia_fecha_a_normal($datos_medicion[0]).'</td>
						<td>'.$datos_medicion[1].'</td>
						<td>'.number_format($datos_medicion[2]*1, 1, '.', '').'</td>
					</tr>';
				$i++;
			}
			while($datos_medicion = mysqli_fetch_array($result_medicion));
			
			$HTML .= '</tbody>';
			$HTML .= '<tfoot><tr><td colspan="3">&Uacute;ltimo d&iacute;a registrado.</td></tr><tfoot></table>';
			
			$HTML .= '	<script type="text/javascript">
						$(document).ready(function(){
							$(".data_row_'.$TIID.'").each(function(e){
								var valor = $(this).attr("valor");
								$(this).mouseover(function(h){
									$.changeInstrumentValue({instrumentValue: valor});
								});
							});
						});
					</script>';
			
			echo $HTML;
		}
		else{
			$IID = getInstrumetId($EID,$TIID);
			//print_r($IID);
			$TPM = getTypeOfProcessedMeasurementOfInstrument($IID);
			$CURRENTDATE = getLastProcessedMeasurementDate($IID,$TPM[0]);
			$FIRSTDATE = cambia_fecha_a_mysql(add_days(cambia_fecha_a_normal($CURRENTDATE), -30));
			$MINTERVAL = getMeasuringInterval($IID);
			$MODELOI = '';
			$MARCAI = '';
			$UNIDADI = '';
			$HTML = '';
			$SQL = "SELECT modelo,marca,unidad FROM instrumento WHERE id=$IID";
			
			$result_instrumento = consulta_sql($SQL);

			if($datos_instrumento = mysqli_fetch_array($result_instrumento)){
				$MODELOI = $datos_instrumento[0];
				$MARCAI = $datos_instrumento[1];
				$UNIDADI = $datos_instrumento[2];
			}
			if(count($TPM) == 0){
				$HTML .= '<table class="mediagrove">
					<caption>No hay datos diarios para de '.$MODELOI.' ('.$MARCAI.')</caption>
					</table>';
			}
			else{
				$HTML .= '<table class="mediagrove">
					<caption>Datos de '.$MODELOI.' ('.$MARCAI.') Diarios</caption>
					<thead>
						<tr>
							<th scope="col">Fecha</th>';
							
				for($i = 0; $i < count($TPM); $i++){
					$HTML .= '<th scope="col">'.statisticFunctionToWords($TPM[$i]).' ('.$UNIDADI.')</th>';
				}
				
				$HTML .= '		</tr>
						</thead>
						<tbody>';
						
				for($i = 0; retorna_unix($CURRENTDATE,'00:00:00') >= retorna_unix($FIRSTDATE,'00:00:00'); $i++){
					
					if(($i%2) == 0)
						$HTML .= '<tr>';
					else
						$HTML .= '<tr class="odd">';
					$HTML .=       '<td>'.cambia_fecha_a_normal($CURRENTDATE).'</td>';
					
					for($j = 0; $j < count($TPM); $j++){
					
						$DATA = getProcessedMeasurement($IID,$TPM[$j],$CURRENTDATE);
						if($DATA[0] != "NaN"){
							$HTML .= '<td>'.number_format($DATA[0]*1, 1, '.', '').'</td>';
						}
						else{
							$HTML .= '<td>NaN</td>';
						}
					}
					
					$HTML .= '</tr>';
					$CURRENTDATE = cambia_fecha_a_mysql(add_days(cambia_fecha_a_normal($CURRENTDATE), -1));		
					
				}	
				$HTML .= '</tbody>';
				$HTML .= '<tfoot><tr><td colspan="'.(count($TPM)+1).'">&Uacute;ltimos 30 d&iacute;as registrados.</td></tr><tfoot></table>';
			}
			
			echo $HTML;
		}

	}
	elseif($ACCION == "getdata_graph"){
		$CURRENT_DATA_ACCESS = '0' /*get_user_permission($_SESSION['session_usuario_id'],'CURRENT_DATA_ACCESS')*/;
		$TIID = $_GET['tiid'];
		$EID  = $_GET['eid'];
		$PREP_DATA = array();
		if($CURRENT_DATA_ACCESS == '1'){
			$SQL = "SELECT fecha,hora,medicion,instrumento.modelo,instrumento.marca,unidad
				FROM medicion,instrumento
				WHERE instrumento.estacion_id=$EID
				AND medicion.instrumento_id=instrumento.id
				AND instrumento.tipo_instrumento_id=$TIID 
				ORDER BY fecha DESC, hora DESC LIMIT 96";
				
			$result_medicion = consulta_sql($SQL);
			
			$HTML = '';
			$datos_medicion = mysqli_fetch_array($result_medicion);
			
			while($datos_medicion = mysqli_fetch_array($result_medicion)){
				$PREP_DATA[] = array(	cambia_fecha_a_normal($datos_medicion[0]),
							$datos_medicion[1],
							number_format($datos_medicion[2], 1, '.', ''),
							tilde_to_utf8($datos_medicion[5]));
			}
						
			require('../JSON.php');
			$JSON = new Services_JSON();
				
			echo $JSON->encode($PREP_DATA);
		}
		else{
			$IID = getInstrumetId($EID,$TIID);
			$TPM = getTypeOfProcessedMeasurementOfInstrument($IID);
			$CURRENTDATE = getLastProcessedMeasurementDate($IID,$TPM[0]);
			$FIRSTDATE = cambia_fecha_a_mysql(add_days(cambia_fecha_a_normal($CURRENTDATE), -30));
			$MINTERVAL = getMeasuringInterval($IID);
			$MODELOI = '';
			$MARCAI = '';
			$UNIDADI = '';
			$HTML = '';
			$SQL = "SELECT modelo,marca,unidad FROM instrumento WHERE id=$IID";
			
			$result_instrumento = consulta_sql($SQL);

			if($datos_instrumento = mysqli_fetch_array($result_instrumento)){
				$MODELOI = $datos_instrumento[0];
				$MARCAI = $datos_instrumento[1];
				$UNIDADI = $datos_instrumento[2];
			}
			if(count($TPM) == 0){
			}
			else{
				$UNIT_ARRAY = array();
							
				for($i = 0; $i < count($TPM); $i++){
					$UNIT_ARRAY[] = statisticFunctionToWords($TPM[$i]).' ('.tilde_to_utf8($UNIDADI).')';
				}
	
				for($i = 0; retorna_unix($CURRENTDATE,'00:00:00') >= retorna_unix($FIRSTDATE,'00:00:00'); $i++){
					
					$DATA_ARRAY = array();
					
					$PREP_DATA[$i][] =  cambia_fecha_a_normal($FIRSTDATE);
					
					for($j = 0; $j < count($TPM); $j++){
					
						$DATA = getProcessedMeasurement($IID,$TPM[$j],$FIRSTDATE);
					
						$PREP_DATA[$i][] = number_format($DATA[0]*1, 1, '.', '');
						
					}
					
					for($j = 0; $j < count($TPM); $j++){
						$PREP_DATA[$i][] = tilde_to_utf8($UNIDADI).' ('.statisticFunctionToWords($TPM[$j]).')';
					}
					
					$FIRSTDATE = cambia_fecha_a_mysql(add_days(cambia_fecha_a_normal($FIRSTDATE), 1));
					
				}
			}
			
			require('../JSON.php');
			$JSON = new Services_JSON();
			echo $JSON->encode($PREP_DATA);
		}

	}

?>