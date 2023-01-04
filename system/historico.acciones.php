<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	require('../system/functions/statistic.functions.php');

	$ACCION = $_GET['accion'];
	
	if($ACCION == "get_select_stations"){
		
		$SQL = "SELECT estacion.nombre,estacion.id
			FROM eve_usuario_has_tipo_de_permiso_usuario, eve_tipo_de_permiso_usuario, estacion
			WHERE usuario_id=".$_SESSION['session_usuario_id']." 
			AND eve_tipo_de_permiso_usuario_id=eve_tipo_de_permiso_usuario.id 
			AND eve_tipo_de_permiso_usuario.value=estacion.id 
			AND eve_tipo_de_permiso_usuario.code LIKE 'STATION_ACCESS_%'
			ORDER BY estacion.nombre";
		
		$HTML = '<select id="select_estacion" class="form-select">';
		$HTML.='<option value="0">Seleccione Estaci&oacute;n</option>';
		
		$RES_STATION = consulta_sql($SQL);
		
		while($DAT_STATION = mysqli_fetch_array($RES_STATION)){
			$HTML.='<option value="'.$DAT_STATION[1].'">';
			$HTML.=$DAT_STATION[0];
			$HTML.='</option>';
		}
		$HTML.='</select">';
		
		echo $HTML;
		
	}
	if($ACCION == "get_select_stations_admin"){
		
		$SQL = "SELECT estacion.nombre,estacion.id
					FROM eve_usuario_has_tipo_de_permiso_usuario, eve_tipo_de_permiso_usuario, estacion
					WHERE usuario_id=" . $_SESSION['session_usuario_id'] . " 
					AND eve_tipo_de_permiso_usuario_id=eve_tipo_de_permiso_usuario.id 
					AND eve_tipo_de_permiso_usuario.value=estacion.id 
					AND eve_tipo_de_permiso_usuario.code LIKE 'STATION_ACCESS_%'
					ORDER BY estacion.nombre";

		$HTML = '<select id="nombre_estacion" name="nombre_estacion" class="form-select">';
		$HTML .= '<option value="0">Seleccione Estaci&oacute;n</option>';

		$RES_STATION = consulta_sql($SQL);

		while ($DAT_STATION = mysqli_fetch_array($RES_STATION)) {
			$HTML .= '<option value="' . $DAT_STATION[1] . '"' . 'onclick="javascript:self.parent.setLabelsFromStationForGetStatus(' . "'" .  $DAT_STATION[0] . "'," . "'" . $DAT_STATION[1] . "'" . ')">';
			$HTML .= $DAT_STATION[0];
			$HTML .= '</option>';
		}
		$HTML .= '</select">';

		echo $HTML;
		
	}
	elseif($ACCION == "get_select_instruments"){
		$EID = $_GET['eid'];
	
		$SQL = "SELECT id,marca,modelo FROM instrumento WHERE estacion_id=$EID ORDER BY modelo";
		
		$HTML = '<select id="select_instrumento" class="form-select">';
		$HTML.='<option value="0">Seleccione Instrumento</option>';
		
		$RES_INSTRUMENT = consulta_sql($SQL);
		
		while($DAT_INSTRUMENT = mysqli_fetch_array($RES_INSTRUMENT)){
			$HTML.='<option value="'.$DAT_INSTRUMENT[0].'">';
			$HTML.=$DAT_INSTRUMENT[2].' ('.$DAT_INSTRUMENT[1].')';
			$HTML.='</option>';
		}
		$HTML.='</select">';
		
		echo $HTML;
	}
	elseif($ACCION == "get_select_instruments_types"){
	
		$SQL = "SELECT DISTINCT tipo_instrumento.nombre,tipo_instrumento.code,tipo_instrumento.id
			FROM instrumento,tipo_instrumento
			WHERE tipo_instrumento_id=tipo_instrumento.id";
		
		$HTML = '<select id="select_tipo_instrumento" class="form-select">';
		$HTML.='<option value="0">Seleccione Tipo de Instrumento</option>';
		
		$RES_INSTRUMENT = consulta_sql($SQL);
		
		while($DAT_INSTRUMENT = mysqli_fetch_array($RES_INSTRUMENT)){
			$HTML.='<option value="'.$DAT_INSTRUMENT[2].'">';
			$HTML.=$DAT_INSTRUMENT[0].' ('.$DAT_INSTRUMENT[1].')';
			$HTML.='</option>';
		}
		$HTML.='</select">';
		
		echo $HTML;
	}
	elseif($ACCION == "get_data_station"){
		$HTML = '';
		
		$STATION = $_GET['sta'];
		$DATE_FROM = $_GET['fd'];
		$DATE_TO = $_GET['fh'];
		$DETAILS = $_GET['det'];
		$INSTRUMENTS = getInstrumentsOfStation($STATION);
		$COLS = 1;
		
		if($DETAILS == 'diario'){
			$L = count($INSTRUMENTS);
			$PROCESSEDMEASUREMENTS = array();
			
			for($i = 0; $i < $L ; $i++){
				$PROCESSEDMEASUREMENTS[$i] = getTypeOfProcessedMeasurementOfInstrument($INSTRUMENTS[$i][0]);
			}
		
			if(!isset($_GET['offset'])){
				$HTML.='<table id="tabla_datos" class="mediagrove" style="width: 100%;">';
				
				$HTML.='<thead>';
				$HTML.='<tr>';
				$HTML.='<th>Fecha</th>';
				
				for($i = 0; $i < $L ; $i++){
					$NPROCESSEDMEASUREMENTS = count($PROCESSEDMEASUREMENTS[$i]);
					if($NPROCESSEDMEASUREMENTS != 0)
						$HTML.='<th colspan="'.$NPROCESSEDMEASUREMENTS.'">'.$INSTRUMENTS[$i][1].' ('.$INSTRUMENTS[$i][3].')</th>';
				}
				$HTML.='</tr>';
				$HTML.='<tr>';
				$HTML.='<th></th>';
				
				for($i = 0; $i < $L ; $i++){
					for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
						$HTML.='<th>'.statisticFunctionToWords($PROCESSEDMEASUREMENTS[$i][$j]).'</th>';
						$COLS++;
					}
				}
				$HTML.='</tr>';
				
				$HTML.='</thead>';
				$HTML.="<tbody id='body_table'>";
			}
			
			$SQL = 'SELECT';
			$insertFecha = true;
			$L = count($INSTRUMENTS);
			for($i = 0; $i < $L ; $i++){
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
					if($insertFecha){
						$SQL.=" pmi".$i."e$j.fecha";
						$SQLFECHA=" WHERE pmi".$i."e$j.fecha >= '$DATE_FROM' AND pmi".$i."e$j.fecha <= '$DATE_TO'";
						$SQLORDER=" ORDER BY pmi".$i."e$j.fecha DESC";
						$SQL.=", pmi".$i."e$j.valor";
						$insertFecha = false;
					}
					else{
						$SQL.=", pmi".$i."e$j.valor";
					}
				}		
			}
			$SQL.=" FROM";
			$insertComma = true;
			for($i = 0; $i < $L ; $i++){
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
					if($insertComma){
						$SQL.="  medicion_procesada AS pmi".$i."e$j";
						$insertComma = false;
					}
					else{
						$SQL.=", medicion_procesada AS pmi".$i."e$j";
					}
				}		
			}
			$SQL.=$SQLFECHA;
			$colNumbers = 0;
			for($i = 0; $i < $L ; $i++){
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
					$colNumbers++;
					$SQL.="  AND pmi".$i."e$j.tipo_medicion_procesada_id = ".getProcessedMeasurementTypeId($PROCESSEDMEASUREMENTS[$i][$j])." AND pmi".$i."e$j.instrumento_id = ".$INSTRUMENTS[$i][0];	
				}		
			}
			$beforeTable = '';
			for($i = 0; $i < $L ; $i++){
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
				
					if($beforeTable == '')
						$beforeTable = "pmi".$i."e$j";
					else{
						$SQL.="  AND pmi".$i."e$j.fecha = $beforeTable.fecha";	
						$beforeTable = "pmi".$i."e$j";
					}
				}		
			}
			
			$OFFSET = 0;
			if(isset($_GET['offset'])){
				$OFFSET = 200 * $_GET['offset'];
			}
			
			$SQL.=$SQLORDER." LIMIT 200 OFFSET $OFFSET";
			
			//$HTML.=$SQL;
			
			$RES_DATA = consulta_sql($SQL);
			
			for($j = 0; $DATA = mysqli_fetch_array($RES_DATA); $j++){
				if($j%2 == 0)
					$HTML.="<tr>";
				else
					$HTML.="<tr class='odd'>";
				$HTML.="<td>".cambia_fecha_a_normal($DATA[0])."</td>";
				
				for($i = 1; $i <= $colNumbers ; $i++){
					$HTML.="<td>".number_format($DATA[$i], 1, '.', '')."</td>";
				}
				
				$HTML.="</tr>";
			}
			
			$HTML.="<tr id='load_buttom_row'><td colspan='".($colNumbers+1)."'><a href='javascript:load_data();'>&#091;Cargar m&aacute;s datos&#093;</a></td></tr>";
			
			if(!isset($_GET['offset'])){
				$HTML.="</tbody>";
				$HTML.='</table>';
			}
			
		}
		elseif($DETAILS == 'diario_estacion_ver'){
			$L = count($INSTRUMENTS);
			$PROCESSEDMEASUREMENTS = array();
			
			for($i = 0; $i < $L ; $i++){
				$PROCESSEDMEASUREMENTS[$i] = getTypeOfProcessedMeasurementOfInstrument($INSTRUMENTS[$i][0]);
			}
		
			if(!isset($_GET['offset'])){
				$HTML.='<table id="tabla_datos" class="mediagrove">';
				
				$HTML.='<thead>';
				$HTML.='<tr>';
				$HTML.='<th>Fecha</th>';
				
				for($i = 0; $i < $L ; $i++){
					$NPROCESSEDMEASUREMENTS = count($PROCESSEDMEASUREMENTS[$i]);
					if($NPROCESSEDMEASUREMENTS != 0)
						$HTML.='<th colspan="'.$NPROCESSEDMEASUREMENTS.'">'.$INSTRUMENTS[$i][1].' ('.$INSTRUMENTS[$i][3].')</th>';
				}
				$HTML.='</tr>';
				$HTML.='<tr>';
				$HTML.='<th></th>';
				
				for($i = 0; $i < $L ; $i++){
					for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
						$HTML.='<th>'.statisticFunctionToWords($PROCESSEDMEASUREMENTS[$i][$j]).'</th>';
					}
				}
				$HTML.='</tr>';
				
				$HTML.='</thead>';
				$HTML.="<tbody id='body_table'>";
			}
			
			$SQL = 'SELECT';
			$insertFecha = true;
			$L = count($INSTRUMENTS);
			for($i = 0; $i < $L ; $i++){
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
					if($insertFecha){
						$SQL.=" pmi".$i."e$j.fecha";
						$SQLFECHA=" WHERE pmi".$i."e$j.fecha >= '$DATE_FROM' AND pmi".$i."e$j.fecha <= '$DATE_TO'";
						$SQLORDER=" ORDER BY pmi".$i."e$j.fecha DESC";
						$SQL.=", pmi".$i."e$j.valor";
						$insertFecha = false;
					}
					else{
						$SQL.=", pmi".$i."e$j.valor";
					}
				}		
			}
			$SQL.=" FROM";
			$insertComma = true;
			for($i = 0; $i < $L ; $i++){
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
					if($insertComma){
						$SQL.="  medicion_procesada AS pmi".$i."e$j";
						$insertComma = false;
					}
					else{
						$SQL.=", medicion_procesada AS pmi".$i."e$j";
					}
				}		
			}
			$SQL.=$SQLFECHA;
			$colNumbers = 0;
			for($i = 0; $i < $L ; $i++){
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
					$colNumbers++;
					$SQL.="  AND pmi".$i."e$j.tipo_medicion_procesada_id = ".getProcessedMeasurementTypeId($PROCESSEDMEASUREMENTS[$i][$j])." AND pmi".$i."e$j.instrumento_id = ".$INSTRUMENTS[$i][0];	
				}		
			}
			$beforeTable = '';
			for($i = 0; $i < $L ; $i++){
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
				
					if($beforeTable == '')
						$beforeTable = "pmi".$i."e$j";
					else{
						$SQL.="  AND pmi".$i."e$j.fecha = $beforeTable.fecha";	
						$beforeTable = "pmi".$i."e$j";
					}
				}		
			}
			
			$OFFSET = 0;
			if(isset($_GET['offset'])){
				$OFFSET = 200 * $_GET['offset'];
			}
			
			$SQL.=$SQLORDER." LIMIT 200 OFFSET $OFFSET";
			
			//$HTML.=$SQL;
			
			$RES_DATA = consulta_sql($SQL);
			
			for($j = 0; $DATA = mysqli_fetch_array($RES_DATA); $j++){
				if($j%2 == 0)
					$HTML.="<tr>";
				else
					$HTML.="<tr class='odd'>";
				$HTML.="<td>".cambia_fecha_a_normal($DATA[0])."</td>";
				
				for($i = 1; $i <= $colNumbers ; $i++){
					$HTML.="<td>".number_format($DATA[$i], 1, '.', '')."</td>";
				}
				
				$HTML.="</tr>";
			}
			//$HTML.="<tr id='load_buttom_row'><td colspan='".($colNumbers+1)."'><a href='javascript:load_data();'>&#091;Cargar m&aacute;s datos&#093;</a></td></tr>";
			if(!isset($_GET['offset'])){
				$HTML.="</tbody>";
				$HTML.='</table>';
			}
			
		}
		elseif($DETAILS == 'detalle_diario'){
		
			if(!isset($_GET['offset'])){
				$HTML.='<table id="tabla_datos" class="mediagrove" style="width: 100%;">';
				
				$HTML.='<thead>';
				$HTML.='<tr>';
				$HTML.='<th>Fecha</th>';
				$HTML.='<th>Hora</th>';
				
				$L = count($INSTRUMENTS);
				for($i = 0; $i < $L ; $i++){
					$HTML.='<th>'.$INSTRUMENTS[$i][1].' ('.$INSTRUMENTS[$i][3].')</th>';
				}
				$HTML.='</tr>';
				$HTML.='</thead>';
				$HTML.="<tbody id='body_table'>";
			}	
			
			$SQL = 'SELECT med0.fecha, med0.hora ';
			$L = count($INSTRUMENTS);
			for($i = 0; $i < $L ; $i++){
				$SQL.=", med$i.medicion";
			}
			$SQL.=" FROM";
			
			for($i = 0; $i < $L ; $i++){
				if($i != 0)
					$SQL.=", medicion AS med$i";
				else
					$SQL.=" medicion AS med$i";
			}
			
			$SQL.=" WHERE med0.fecha >= '$DATE_FROM' AND med0.fecha <= '$DATE_TO'";
			
			for($i = 0; $i < ($L-1) ; $i++){
				$SQL.=" AND med$i.fecha = med".($i+1).".fecha AND med$i.hora = med".($i+1).".hora";
			}
			
			for($i = 0; $i < $L ; $i++){
				$SQL.=" AND med$i.instrumento_id = ".$INSTRUMENTS[$i][0];
			}
			
			$OFFSET = 0;
			if(isset($_GET['offset'])){
				$OFFSET = 672 * $_GET['offset'];
			}
			
			$SQL.=" ORDER BY med0.fecha DESC, med0.hora DESC LIMIT 672 OFFSET $OFFSET";
			
			//$HTML.=$SQL;
			
			$RES_DATA = consulta_sql($SQL);
				
				
			
			for($j = 0; $DATA = mysqli_fetch_array($RES_DATA); $j++){
				if($j%2 == 0)
					$HTML.="<tr>";
				else
					$HTML.="<tr class='odd'>";
				$HTML.="<td style='width: 70px;'>".cambia_fecha_a_normal($DATA[0])."</td>";
				$HTML.="<td style='width: 60px;'>".$DATA[1]."</td>";
				
				for($i = 2; $i < ($L+2) ; $i++){
					$HTML.="<td>".number_format($DATA[$i], 1, '.', '')."</td>";
				}
				
				$HTML.="</tr>";
			}
			$HTML.="<tr id='load_buttom_row'><td colspan='".($L+2)."'><a href='javascript:load_data();'>&#091;Cargar m&aacute;s datos&#093;</a></td></tr>";
			if(!isset($_GET['offset'])){
				$HTML.="</tbody>";
				$HTML.='</table>';
			}
		}
		//$HTML.="<script type='text/javascript'></script>";
		//$HTML.='</body></html>';
		
		echo $HTML;
	}
	elseif($ACCION == "get_data_station_json_graph"){
		
		$STATION = $_GET['sta'];
		$DATE_FROM = $_GET['fd'];
		$DATE_TO = $_GET['fh'];
		$DETAILS = $_GET['det'];
		$INSTRUMENTS = getInstrumentsOfStation($STATION);
		$COLS = 1;
		
		$DATOS = array();
		$LINE = array();
		$LINE2 = array();
		$LINE3 = array();
		
		if($DETAILS == 'diario'){
			$L = count($INSTRUMENTS);
			$PROCESSEDMEASUREMENTS = array();
			
			for($i = 0; $i < $L ; $i++){
				$PROCESSEDMEASUREMENTS[$i] = getTypeOfProcessedMeasurementOfInstrument($INSTRUMENTS[$i][0]);
			}
			
			$LINE[] = 'Fecha';
			$LINE2[] = '';
			$LINE3[] = '';
			
			for($i = 0; $i < $L ; $i++){
				$NPROCESSEDMEASUREMENTS = count($PROCESSEDMEASUREMENTS[$i]);
				if($NPROCESSEDMEASUREMENTS != 0){
					for($j = 0; $j < $NPROCESSEDMEASUREMENTS; $j++){
						$LINE[] = ''.$INSTRUMENTS[$i][1].' ('.$INSTRUMENTS[$i][3].')';
						$LINE2[] = $INSTRUMENTS[$i][3];
						$LINE3[] = $NPROCESSEDMEASUREMENTS;
					}
				}
			}
			
			$DATOS[] = $LINE;
			$LINE = array();
			$LINE[] = '';
			for($i = 0; $i < $L ; $i++){
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
					$LINE[] = ''.statisticFunctionToWords($PROCESSEDMEASUREMENTS[$i][$j]).'';
					$COLS++;
				}
			}
			$DATOS[] = $LINE;
			$LINE = array();
			
			$SQL = 'SELECT';
			$insertFecha = true;
			$L = count($INSTRUMENTS);
			for($i = 0; $i < $L ; $i++){
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
					if($insertFecha){
						$SQL.=" pmi".$i."e$j.fecha";
						$SQLFECHA=" WHERE pmi".$i."e$j.fecha >= '$DATE_FROM' AND pmi".$i."e$j.fecha <= '$DATE_TO'";
						$SQLORDER=" ORDER BY pmi".$i."e$j.fecha DESC";
						$SQL.=", pmi".$i."e$j.valor";
						$insertFecha = false;
					}
					else{
						$SQL.=", pmi".$i."e$j.valor";
					}
				}		
			}
			$SQL.=" FROM";
			$insertComma = true;
			for($i = 0; $i < $L ; $i++){
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
					if($insertComma){
						$SQL.="  medicion_procesada AS pmi".$i."e$j";
						$insertComma = false;
					}
					else{
						$SQL.=", medicion_procesada AS pmi".$i."e$j";
					}
				}		
			}
			$SQL.=$SQLFECHA;
			$colNumbers = 0;
			for($i = 0; $i < $L ; $i++){
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
					$colNumbers++;
					$SQL.="  AND pmi".$i."e$j.tipo_medicion_procesada_id = ".getProcessedMeasurementTypeId($PROCESSEDMEASUREMENTS[$i][$j])." AND pmi".$i."e$j.instrumento_id = ".$INSTRUMENTS[$i][0];	
				}		
			}
			$beforeTable = '';
			for($i = 0; $i < $L ; $i++){
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
				
					if($beforeTable == '')
						$beforeTable = "pmi".$i."e$j";
					else{
						$SQL.="  AND pmi".$i."e$j.fecha = $beforeTable.fecha";	
						$beforeTable = "pmi".$i."e$j";
					}
				}		
			}
			
			$SQL.=$SQLORDER." ";
			
			//$HTML.=$SQL;
			
			$RES_DATA = consulta_sql($SQL);
			
			for($j = 0; $DATA = mysqli_fetch_array($RES_DATA); $j++){
								
				$LINE[] = "".cambia_fecha_a_normal($DATA[0])."";
				
				for($i = 1; $i <= $colNumbers ; $i++){
					$LINE[] = "".number_format($DATA[$i], 1, '.', '')."";
				}
				$DATOS[] = $LINE;
				$LINE = array();
			}
			
		}
		elseif($DETAILS == 'diario_estacion_ver'){
			$DATOS = array();
			$LINE = array();
			$L = count($INSTRUMENTS);
			$PROCESSEDMEASUREMENTS = array();
			
			for($i = 0; $i < $L ; $i++){
				$PROCESSEDMEASUREMENTS[$i] = getTypeOfProcessedMeasurementOfInstrument($INSTRUMENTS[$i][0]);
			}
		
			if(!isset($_GET['offset'])){

				$LINE[] = 'Fecha';
				
				for($i = 0; $i < $L ; $i++){
					$NPROCESSEDMEASUREMENTS = count($PROCESSEDMEASUREMENTS[$i]);
					if($NPROCESSEDMEASUREMENTS != 0)
						$HTML.='<th colspan="'.$NPROCESSEDMEASUREMENTS.'">'.$INSTRUMENTS[$i][1].' ('.$INSTRUMENTS[$i][3].')</th>';
				}
				$HTML.='</tr>';
				$HTML.='<tr>';
				$HTML.='<th></th>';
				
				for($i = 0; $i < $L ; $i++){
					for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
						$HTML.='<th>'.statisticFunctionToWords($PROCESSEDMEASUREMENTS[$i][$j]).'</th>';
					}
				}
				$HTML.='</tr>';
				
				$HTML.='</thead>';
				$HTML.="<tbody id='body_table'>";
			}
			
			$SQL = 'SELECT';
			$insertFecha = true;
			$L = count($INSTRUMENTS);
			for($i = 0; $i < $L ; $i++){
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
					if($insertFecha){
						$SQL.=" pmi".$i."e$j.fecha";
						$SQLFECHA=" WHERE pmi".$i."e$j.fecha >= '$DATE_FROM' AND pmi".$i."e$j.fecha <= '$DATE_TO'";
						$SQLORDER=" ORDER BY pmi".$i."e$j.fecha DESC";
						$SQL.=", pmi".$i."e$j.valor";
						$insertFecha = false;
					}
					else{
						$SQL.=", pmi".$i."e$j.valor";
					}
				}		
			}
			$SQL.=" FROM";
			$insertComma = true;
			for($i = 0; $i < $L ; $i++){
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
					if($insertComma){
						$SQL.="  medicion_procesada AS pmi".$i."e$j";
						$insertComma = false;
					}
					else{
						$SQL.=", medicion_procesada AS pmi".$i."e$j";
					}
				}		
			}
			$SQL.=$SQLFECHA;
			$colNumbers = 0;
			for($i = 0; $i < $L ; $i++){
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
					$colNumbers++;
					$SQL.="  AND pmi".$i."e$j.tipo_medicion_procesada_id = ".getProcessedMeasurementTypeId($PROCESSEDMEASUREMENTS[$i][$j])." AND pmi".$i."e$j.instrumento_id = ".$INSTRUMENTS[$i][0];	
				}		
			}
			$beforeTable = '';
			for($i = 0; $i < $L ; $i++){
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]); $j++){
				
					if($beforeTable == '')
						$beforeTable = "pmi".$i."e$j";
					else{
						$SQL.="  AND pmi".$i."e$j.fecha = $beforeTable.fecha";	
						$beforeTable = "pmi".$i."e$j";
					}
				}		
			}
			
			$OFFSET = 0;
			if(isset($_GET['offset'])){
				$OFFSET = 200 * $_GET['offset'];
			}
			
			$SQL.=$SQLORDER." LIMIT 200 OFFSET $OFFSET";
			
			//$HTML.=$SQL;
			
			$RES_DATA = consulta_sql($SQL);
			
			for($j = 0; $DATA = mysqli_fetch_array($RES_DATA); $j++){
				if($j%2 == 0)
					$HTML.="<tr>";
				else
					$HTML.="<tr class='odd'>";
				$HTML.="<td>".cambia_fecha_a_normal($DATA[0])."</td>";
				
				for($i = 1; $i <= $colNumbers ; $i++){
					$HTML.="<td>".number_format($DATA[$i], 1, '.', '')."</td>";
				}
				
				$HTML.="</tr>";
			}
			//$HTML.="<tr id='load_buttom_row'><td colspan='".($colNumbers+1)."'><a href='javascript:load_data();'>&#091;Cargar m&aacute;s datos&#093;</a></td></tr>";
			if(!isset($_GET['offset'])){
				$HTML.="</tbody>";
				$HTML.='</table>';
			}
			
		}
		elseif($DETAILS == 'detalle_diario'){
			$DATOS = array();
			$LINE = array();
			$LINE2 = array();
			if(!isset($_GET['offset'])){
				
				$LINE[] = $LINE2[] = 'Fecha';
				$LINE[] = $LINE2[] = 'Hora';
				
				$L = count($INSTRUMENTS);
				for($i = 0; $i < $L ; $i++){
					$LINE[] = ''.$INSTRUMENTS[$i][1].' ('.tilde_to_utf8($INSTRUMENTS[$i][3]).')';
					$LINE2[] = tilde_to_utf8($INSTRUMENTS[$i][3]);
				}
				$DATOS[] = $LINE;
				$DATOS[] = $LINE2;
			}	
			
			$LINE = array();
			
			$SQL = 'SELECT med0.fecha, med0.hora ';
			$L = count($INSTRUMENTS);
			for($i = 0; $i < $L ; $i++){
				$SQL.=", med$i.medicion";
			}
			$SQL.=" FROM";
			
			for($i = 0; $i < $L ; $i++){
				if($i != 0)
					$SQL.=", medicion AS med$i";
				else
					$SQL.=" medicion AS med$i";
			}
			
			$SQL.=" WHERE med0.fecha >= '$DATE_FROM' AND med0.fecha <= '$DATE_TO'";
			
			for($i = 0; $i < ($L-1) ; $i++){
				$SQL.=" AND med$i.fecha = med".($i+1).".fecha AND med$i.hora = med".($i+1).".hora";
			}
			
			for($i = 0; $i < $L ; $i++){
				$SQL.=" AND med$i.instrumento_id = ".$INSTRUMENTS[$i][0];
			}
			
			$OFFSET = 0;
			if(isset($_GET['offset'])){
				$OFFSET = 672 * $_GET['offset'];
			}
			
			$SQL.=" ORDER BY med0.fecha DESC, med0.hora DESC LIMIT 672 OFFSET $OFFSET";
			
			//$HTML.=$SQL;
			
			$RES_DATA = consulta_sql($SQL);
				
				
			
			for($j = 0; $DATA = mysqli_fetch_array($RES_DATA); $j++){
				$LINE[] = "".cambia_fecha_a_normal($DATA[0])."";
				$LINE[] = "".$DATA[1]."";
				
				for($i = 2; $i < ($L+2) ; $i++){
					$LINE[] = number_format($DATA[$i], 1, '.', '');
				}
				
				$DATOS[] = $LINE;
				$LINE = array();
			}
			
		}
		require('../JSON.php');
		$JSON = new Services_JSON();
			
		echo $JSON->encode($DATOS);
	}
	elseif($ACCION == "get_data_instrument"){
		$HTML = '';
		
		$STATION = $_GET['sta'];
		$INSTRUMENT = $_GET['ins'];
		$DATE_FROM = $_GET['fd'];
		$DATE_TO = $_GET['fh'];
		$DETAILS = $_GET['det'];
		$INSDATA = getDataOfInstrument($INSTRUMENT);
		
		if($DETAILS == 'diario'){
			
			$PROCESSEDMEASUREMENTS = array();
			
			$PROCESSEDMEASUREMENTS = getTypeOfProcessedMeasurementOfInstrument($INSTRUMENT);
			
			if(count($PROCESSEDMEASUREMENTS) != 0){
		
				if(!isset($_GET['offset'])){
					$HTML.='<table id="tabla_datos" class="mediagrove" style="width: 100%;">';
					
					$HTML.='<thead>';
					$HTML.='<tr>';
					$HTML.='<th>Fecha</th>';
					
					$NPROCESSEDMEASUREMENTS = count($PROCESSEDMEASUREMENTS);
					
					for($i = 0; $i < $NPROCESSEDMEASUREMENTS ; $i++){
						$HTML.='<th>'.statisticFunctionToWords($PROCESSEDMEASUREMENTS[$i]).' ('.$INSDATA[0].')</th>';
					}
					$HTML.='</tr>';
					
					$HTML.='</thead>';
					$HTML.="<tbody id='body_table'>";
				}
				
				$SQL = 'SELECT';
				$insertFecha = true;
				
				
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS); $j++){
					if($insertFecha){
						$SQL.=" pmie$j.fecha";
						$SQLFECHA=" WHERE pmie$j.fecha >= '$DATE_FROM' AND pmie$j.fecha <= '$DATE_TO'";
						$SQLORDER=" ORDER BY pmie$j.fecha DESC";
						$SQL.=", pmie$j.valor";
						$insertFecha = false;
					}
					else{
						$SQL.=", pmie$j.valor";
					}
				}		
				
				$SQL.=" FROM";
				$insertComma = true;
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS); $j++){
					if($insertComma){
						$SQL.="  medicion_procesada AS pmie$j";
						$insertComma = false;
					}
					else{
						$SQL.=", medicion_procesada AS pmie$j";
					}
				}		
				
				$SQL.=$SQLFECHA;
				$colNumbers = 0;
				
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS); $j++){
					$colNumbers++;
					$SQL.="  AND pmie$j.tipo_medicion_procesada_id = ".getProcessedMeasurementTypeId($PROCESSEDMEASUREMENTS[$j])." AND pmie$j.instrumento_id = ".$INSTRUMENT;	
				}		
				
				$beforeTable = '';
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS); $j++){
				
					if($beforeTable == '')
						$beforeTable = "pmie$j";
					else{
						$SQL.="  AND pmie$j.fecha = $beforeTable.fecha";	
						$beforeTable = "pmie$j";
					}
				}		
				
				
				$OFFSET = 0;
				if(isset($_GET['offset'])){
					$OFFSET = 200 * $_GET['offset'];
				}
				
				$SQL.=$SQLORDER." LIMIT 200 OFFSET $OFFSET";
				
				//$HTML.=$SQL;
				
				$RES_DATA = consulta_sql($SQL);
				
				for($j = 0; $DATA = mysqli_fetch_array($RES_DATA); $j++){
					if($j%2 == 0)
						$HTML.="<tr>";
					else
						$HTML.="<tr class='odd'>";
					$HTML.="<td>".cambia_fecha_a_normal($DATA[0])."</td>";
					
					for($i = 1; $i <= $colNumbers ; $i++){
						$HTML.="<td>".number_format($DATA[$i], 1, '.', '')."</td>";
					}
					
					$HTML.="</tr>";
				}
				$HTML.="<tr id='load_buttom_row'><td colspan='".($colNumbers+1)."'><a href='javascript:load_data();'>&#091;Cargar m&aacute;s datos&#093;</a></td></tr>";
				if(!isset($_GET['offset'])){
					$HTML.="</tbody>";
					$HTML.='</table>';
				}
			}
			else{
				$HTML.="No existen datos diarios para este sensor";
			}
		}
		elseif($DETAILS == 'diario_widget'){
			
			$PROCESSEDMEASUREMENTS = array();
			
			$PROCESSEDMEASUREMENTS = getTypeOfProcessedMeasurementOfInstrument($INSTRUMENT);
			
			if(count($PROCESSEDMEASUREMENTS) != 0){
		
				if(!isset($_GET['offset'])){
					$HTML.='<table id="tabla_datos" class="mediagrove">';
					
					$HTML.='<thead>';
					$HTML.='<tr>';
					$HTML.='<th>Fecha</th>';
					
					$NPROCESSEDMEASUREMENTS = count($PROCESSEDMEASUREMENTS);
					
					for($i = 0; $i < $NPROCESSEDMEASUREMENTS ; $i++){
						$HTML.='<th>'.statisticFunctionToWords($PROCESSEDMEASUREMENTS[$i]).' ('.$INSDATA[0].')</th>';
					}
					$HTML.='</tr>';
					
					$HTML.='</thead>';
					$HTML.="<tbody id='body_table'>";
				}
				
				$SQL = 'SELECT';
				$insertFecha = true;
				
				
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS); $j++){
					if($insertFecha){
						$SQL.=" pmie$j.fecha";
						$SQLFECHA=" WHERE pmie$j.fecha >= '$DATE_FROM' AND pmie$j.fecha <= '$DATE_TO'";
						$SQLORDER=" ORDER BY pmie$j.fecha DESC";
						$SQL.=", pmie$j.valor";
						$insertFecha = false;
					}
					else{
						$SQL.=", pmie$j.valor";
					}
				}		
				
				$SQL.=" FROM";
				$insertComma = true;
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS); $j++){
					if($insertComma){
						$SQL.="  medicion_procesada AS pmie$j";
						$insertComma = false;
					}
					else{
						$SQL.=", medicion_procesada AS pmie$j";
					}
				}		
				
				$SQL.=$SQLFECHA;
				$colNumbers = 0;
				
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS); $j++){
					$colNumbers++;
					$SQL.="  AND pmie$j.tipo_medicion_procesada_id = ".getProcessedMeasurementTypeId($PROCESSEDMEASUREMENTS[$j])." AND pmie$j.instrumento_id = ".$INSTRUMENT;	
				}		
				
				$beforeTable = '';
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS); $j++){
				
					if($beforeTable == '')
						$beforeTable = "pmie$j";
					else{
						$SQL.="  AND pmie$j.fecha = $beforeTable.fecha";	
						$beforeTable = "pmie$j";
					}
				}		
				
				
				$OFFSET = 0;
				if(isset($_GET['offset'])){
					$OFFSET = 100 * $_GET['offset'];
				}
				
				$SQL.=$SQLORDER." LIMIT 100 OFFSET $OFFSET";
				
				//$HTML.=$SQL;
				
				$RES_DATA = consulta_sql($SQL);
				
				for($j = 0; $DATA = mysqli_fetch_array($RES_DATA); $j++){
					if($j%2 == 0)
						$HTML.="<tr>";
					else
						$HTML.="<tr class='odd'>";
					$HTML.="<td>".cambia_fecha_a_normal($DATA[0])."</td>";
					
					for($i = 1; $i <= $colNumbers ; $i++){
						$HTML.="<td valor='".$DATA[$i]."' class='data_box_$INSTRUMENT'>".number_format($DATA[$i], 1, '.', '')."</td>";
					}
					
					$HTML.="</tr>";
				}
				
				if(!isset($_GET['offset'])){
					$HTML.="</tbody>";
					$HTML.='</table>';
				}
			}
			else{
				$HTML.="No existen datos diarios para este sensor";
			}
		}
		elseif($DETAILS == 'detalle_diario'){
		
			if(!isset($_GET['offset'])){
				$HTML.='<table id="tabla_datos" class="mediagrove" style="width: 100%;">';
				
				$HTML.='<thead>';
				$HTML.='<tr>';
				$HTML.='<th>Fecha</th>';
				$HTML.='<th>Hora</th>';
				
				$HTML.='<th>'.$INSDATA[2].' -'.$INSDATA[1].' ('.$INSDATA[0].')</th>';
				$HTML.='<th>Estado</th>';
				$HTML.='</tr>';
				$HTML.='</thead>';
				$HTML.="<tbody id='body_table'>";
			}	
			
			$SQL = "SELECT fecha, hora, medicion, estado FROM medicion WHERE fecha >= '$DATE_FROM' AND fecha <= '$DATE_TO' AND instrumento_id=$INSTRUMENT";
			
			
			$OFFSET = 0;
			if(isset($_GET['offset'])){
				$OFFSET = 672 * $_GET['offset'];
			}
			
			$SQL.=" ORDER BY fecha DESC, hora DESC LIMIT 672 OFFSET $OFFSET";
			
			//$HTML.=$SQL;
			
			$RES_DATA = consulta_sql($SQL);

			for($j = 0; $DATA = mysqli_fetch_array($RES_DATA); $j++){
				if($DATA[3] != 0){
					$HTML.="<tr class='odd3'>";
				}
				elseif($j%2 == 0){
					$HTML.="<tr>";
				}
				else{
					$HTML.="<tr class='odd'>";
				}
					
				$HTML.="<td style='width: 70px;'>".cambia_fecha_a_normal($DATA[0])."</td>";
				$HTML.="<td style='width: 60px;'>".$DATA[1]."</td>";
				$HTML.="<td>".number_format($DATA[2], 1, '.', '')."</td>";
				$HTML.="<td>".stateTraduction($DATA[3])."</td>";
				
				$HTML.="</tr>";
			}
			$HTML.="<tr id='load_buttom_row'><td colspan='4'><a href='javascript:load_data();'>&#091;Cargar m&aacute;s datos&#093;</a></td></tr>";
			if(!isset($_GET['offset'])){
				$HTML.="</tbody>";
				$HTML.='</table>';
			}
		}
		elseif($DETAILS == 'detalle_diario_widget'){
		
			if(!isset($_GET['offset'])){
				$HTML.='<table id="tabla_datos" class="mediagrove"">';
				
				$HTML.='<thead>';
				$HTML.='<tr>';
				$HTML.='<th>Fecha</th>';
				$HTML.='<th>Hora</th>';
				
				$HTML.='<th>'.$INSDATA[2].' -'.$INSDATA[1].' ('.$INSDATA[0].')</th>';
				$HTML.='<th>Estado</th>';
				$HTML.='</tr>';
				$HTML.='</thead>';
				$HTML.="<tbody id='body_table'>";
			}	
			
			$SQL = "SELECT fecha, hora, medicion, estado FROM medicion WHERE fecha >= '$DATE_FROM' AND fecha <= '$DATE_TO' AND instrumento_id=$INSTRUMENT";
			
			
			$OFFSET = 0;
			if(isset($_GET['offset'])){
				$OFFSET = 672 * $_GET['offset'];
			}
			
			$SQL.=" ORDER BY fecha DESC, hora DESC LIMIT 672 OFFSET $OFFSET";
			
			//$HTML.=$SQL;
			
			$RES_DATA = consulta_sql($SQL);

			for($j = 0; $DATA = mysqli_fetch_array($RES_DATA); $j++){
				if($DATA[3] != 0){
					$HTML.="<tr class='odd3'>";
				}
				elseif($j%2 == 0){
					$HTML.="<tr>";
				}
				else{
					$HTML.="<tr class='odd'>";
				}
					
				$HTML.="<td>".cambia_fecha_a_normal($DATA[0])."</td>";
				$HTML.="<td>".$DATA[1]."</td>";
				$HTML.="<td valor='".$DATA[2]."' class='data_box_$INSTRUMENT'>".number_format($DATA[2], 1, '.', '')."</td>";
				$HTML.="<td>".stateTraduction($DATA[3])."</td>";
				
				$HTML.="</tr>";
			}
			if(!isset($_GET['offset'])){
				$HTML.="</tbody>";
				$HTML.='</table>';
			}
		}
		//$HTML.="<script type='text/javascript'></script>";
		//$HTML.='</body></html>';
		
		echo $HTML;
	}
	elseif($ACCION == "get_select_models"){
		$TYPE = $_GET['type'];
		
		$SQL = "SELECT id, nombre, descripcion FROM tipo_modelo WHERE target='$TYPE'";
		
		$RES_TYPE = consulta_sql($SQL);
		
		$HTML = '';
		
		$HTML.= '<select class="form-select" id="select_model">
				<option value="0">Seleccione un Modelo</option>';
		
		while($DAT_TYPE = mysqli_fetch_array($RES_TYPE)){
			$HTML.='<option value="'.$DAT_TYPE[0].'" title="'.$DAT_TYPE[2].'">'.$DAT_TYPE[1].'</option>';
		}
		$HTML.= '</select>';
		
		echo $HTML;
		
	}
	elseif($ACCION == "get_instruments_from_model"){
		$MID = $_GET['mid'];
		
		$SQL = "SELECT 	instrumento.id,
				marca,
				modelo,
				estacion.nombre 
			FROM	instrumento,
				estacion,
				instrumento_has_modelo,
				eve_usuario_has_tipo_de_permiso_usuario, 
				eve_tipo_de_permiso_usuario
			WHERE	instrumento.estacion_id = estacion.id 
			AND 	instrumento.id = instrumento_has_modelo.instrumento_id 
			AND	instrumento_has_modelo.tipo_modelo_id = $MID
			AND 	usuario_id=".$_SESSION['session_usuario_id']." 
			AND 	eve_tipo_de_permiso_usuario_id=eve_tipo_de_permiso_usuario.id 
			AND 	eve_tipo_de_permiso_usuario.value=estacion.id 
			ORDER BY estacion.nombre, modelo";
			
		$RES_INS = consulta_sql($SQL);
		
		$HTML = '';
		
		$HTML.= '<select class="form-select" id="select_essen">
				<option value="0">Seleccione un Instrumento</option>';
		
		while($DAT_INS = mysqli_fetch_array($RES_INS)){
			$HTML.='<option value="'.$DAT_INS[0].'">'.$DAT_INS[2].', '.$DAT_INS[3].'</option>';
		}
		$HTML.= '</select>';
		
		echo $HTML;
		
	}
	elseif($ACCION == "get_instruments_from_model_checkbox"){
		$MID = $_GET['mid'];
		
		$SQL = "SELECT 	instrumento.id,
				marca,
				modelo,
				estacion.nombre 
			FROM	instrumento,
				estacion,
				instrumento_has_modelo,
				eve_usuario_has_tipo_de_permiso_usuario, 
				eve_tipo_de_permiso_usuario
			WHERE	instrumento.estacion_id = estacion.id 
			AND 	instrumento.id = instrumento_has_modelo.instrumento_id 
			AND	instrumento_has_modelo.tipo_modelo_id = $MID
			AND 	usuario_id=".$_SESSION['session_usuario_id']." 
			AND 	eve_tipo_de_permiso_usuario_id=eve_tipo_de_permiso_usuario.id 
			AND 	eve_tipo_de_permiso_usuario.value=estacion.id 
			ORDER BY estacion.nombre, modelo";
			
		$RES_INS = consulta_sql($SQL);
		
		$HTML = '<br />';
		
		while($DAT_STA = mysqli_fetch_array($RES_INS)){
			$HTML.='<label for="available_instrument_'.$DAT_STA[0].'"><input id="available_instrument" name="available_instrument_'.$DAT_STA[0].'" type="checkbox" value="'.$DAT_STA[0].'" title="'.$DAT_STA[2].' - '.$DAT_STA[3].'"/>'.$DAT_STA[2].' - '.$DAT_STA[3].'</label><br/>';
		}
		
		echo $HTML;
		
	}
	elseif($ACCION == "get_stations_from_model"){
		$MID = $_GET['mid'];
		
		/**$SQL = "SELECT 	estacion.id,
				estacion.nombre 
			FROM	estacion,
				estacion_has_modelo 
			WHERE 	estacion.id = estacion_has_modelo.id_estacion 
			AND	estacion_has_modelo.id_tipo_modelo = $MID 
			ORDER BY estacion.nombre";
		*/	
		$SQL = "SELECT 	estacion.id, 
				estacion.nombre
			FROM 	eve_usuario_has_tipo_de_permiso_usuario, 
				eve_tipo_de_permiso_usuario, 
				estacion, 
				estacion_has_modelo 
			WHERE 	usuario_id=".$_SESSION['session_usuario_id']." 
			AND 	eve_tipo_de_permiso_usuario_id=eve_tipo_de_permiso_usuario.id 
			AND 	eve_tipo_de_permiso_usuario.value=estacion.id 
			AND 	estacion.id = estacion_has_modelo.id_estacion 
			AND	estacion_has_modelo.id_tipo_modelo = $MID 
			AND 	eve_tipo_de_permiso_usuario.code LIKE 'STATION_ACCESS_%'";
			
		$RES_STA = consulta_sql($SQL);
		
		$HTML = '';
		
		$HTML.= '<select class="form-select" id="select_essen">
				<option value="0">Seleccione una Estacion</option>';
		
		while($DAT_STA = mysqli_fetch_array($RES_STA)){
			$HTML.='<option value="'.$DAT_STA[0].'">'.$DAT_STA[1].'</option>';
		}
		$HTML.= '</select>';
		
		echo $HTML;
		
	}
	elseif($ACCION == "get_stations_from_model_checkbox"){
		$MID = $_GET['mid'];
			
		$SQL = "SELECT 	estacion.id, 
				estacion.nombre
			FROM 	eve_usuario_has_tipo_de_permiso_usuario, 
				eve_tipo_de_permiso_usuario, 
				estacion, 
				estacion_has_modelo 
			WHERE 	usuario_id=".$_SESSION['session_usuario_id']." 
			AND 	eve_tipo_de_permiso_usuario_id=eve_tipo_de_permiso_usuario.id 
			AND 	eve_tipo_de_permiso_usuario.value=estacion.id 
			AND 	estacion.id = estacion_has_modelo.id_estacion 
			AND	estacion_has_modelo.id_tipo_modelo = $MID 
			AND 	eve_tipo_de_permiso_usuario.code LIKE 'STATION_ACCESS_%'";
			
		$RES_STA = consulta_sql($SQL);
		
		$HTML = '<br />';
		
		while($DAT_STA = mysqli_fetch_array($RES_STA)){
			$HTML.='<label for="available_station_'.$DAT_STA[0].'"><input id="available_station" name="available_station_'.$DAT_STA[0].'" type="checkbox" value="'.$DAT_STA[0].'" title="'.$DAT_STA[1].'"/>'.$DAT_STA[1].'</label><br/>';
		}
		
		echo $HTML;
		
	}
	elseif($ACCION == "get_data_model"){
		$HTML = '';
		
		$ESSEN = $_GET['essen'];
		$DATE_FROM = $_GET['fd'];
		$DATE_TO = $_GET['fh'];
		$TYPE = $_GET['type'];
		$MID = $_GET['mid'];
		$MNAME = $_GET['mname'];
		$MDESC = $_GET['mdesc'];
		$COLS = 2;
		if($TYPE == 'SENSOR')
			$COLS = 3;
		if(!isset($_GET['offset'])){
			$HTML.='<table id="tabla_datos" class="mediagrove" style="width: 100%;">';
			
			$HTML.='<thead>';
			$HTML.='<tr>';
			$HTML.='<th>Fecha</th>';
			
			if($TYPE == 'SENSOR')
				$HTML.='<th>Hora</th>';
				
			$HTML.='<th>Valor ('.$MNAME.', '.$MDESC.')</th>';
			$HTML.='</tr>';
			
			$HTML.='</thead>';
			$HTML.="<tbody id='body_table'>";
		}
		
		$SQL = '';
		if($TYPE == 'SENSOR'){
			$SQL = "SELECT 	fecha, 
					hora, 
					valor,
					unidad 
				FROM 	modelo_procesado_instrumento,
					tipo_modelo
				WHERE 	fecha >= '$DATE_FROM' 
				AND 	fecha <= '$DATE_TO' 
				AND 	instrumento_has_modelo_instrumento_id = $ESSEN 
				AND 	instrumento_has_modelo_tipo_modelo_id = $MID 
				AND	tipo_modelo.id = $MID";
		}
		elseif($TYPE == 'STATION'){
			$SQL = "SELECT 	fecha,
					valor,
					unidad
				FROM 	modelo_procesado_estacion,
					tipo_modelo
				WHERE 	fecha >= '$DATE_FROM' 
				AND 	fecha <= '$DATE_TO' 
				AND 	estacion_has_modelo_id_estacion = $ESSEN 
				AND 	estacion_has_modelo_id_tipo_modelo = $MID 
				AND	tipo_modelo.id = $MID";
		}	
			
		$OFFSET = 0;
		if(isset($_GET['offset'])){
			$OFFSET = 100 * $_GET['offset'];
		}
		
		$SQL.=" ORDER BY fecha DESC LIMIT 100 OFFSET $OFFSET";
		
		$RES_DATA = consulta_sql($SQL);

		for($j = 0; $DATA = mysqli_fetch_array($RES_DATA); $j++){
			if($j%2 == 0){
				$HTML.="<tr>";
			}
			else{
				$HTML.="<tr class='odd'>";
			}
			$HTML.="<td style='width: 70px;'>".cambia_fecha_a_normal($DATA[0])."</td>";
			
			if($TYPE == 'SENSOR'){
				$HTML.="<td style='width: 60px;'>".$DATA[1]."</td>";
				$HTML.="<td>".number_format($DATA[2], 1, '.', '')." ".$DATA[3]."</td>";
			}
			elseif($TYPE == 'STATION'){
				$HTML.="<td>".number_format($DATA[1], 1, '.', '')." ".$DATA[2]."</td>";
			}	
			$HTML.="</tr>";
		}
		$HTML.="<tr id='load_buttom_row'><td colspan='$COLS'><a href='javascript:load_data();'>&#091;Cargar m&aacute;s datos&#093;</a></td></tr>";
		if(!isset($_GET['offset'])){
			$HTML.="</tbody>";
			$HTML.='</table>';
		}
		
		echo $HTML;
	}
	elseif($ACCION == "get_data_type_available"){
		
		$STATION = $_GET['sta'];
		$DETAILS = $_GET['det'];
		$INSTRUMENTS = getInstrumentsOfStation($STATION);
		
		$HTML = '<br/>';
		
		if($DETAILS == 'diario'){
			$L = count($INSTRUMENTS);
			$PROCESSEDMEASUREMENTS = array();
			
			for($i = 0; $i < $L ; $i++){
				$PROCESSEDMEASUREMENTS[$i] = getTypeOfProcessedMeasurementOfInstrument($INSTRUMENTS[$i][0]);
				for($j = 0; $j < count($PROCESSEDMEASUREMENTS[$i]) ; $j++){
					$HTML.='<label for="data_type_available_SEN_'.$INSTRUMENTS[$i][0].'_'.$PROCESSEDMEASUREMENTS[$i][$j].'"><input id="data_type" name="data_type_available_SEN_'.$INSTRUMENTS[$i][0].'_'.$PROCESSEDMEASUREMENTS[$i][$j].'" type="checkbox" value="SEN_'.$INSTRUMENTS[$i][0].'_'.$PROCESSEDMEASUREMENTS[$i][$j].'" title="SEN '.$INSTRUMENTS[$i][1].' - '.statisticFunctionToWordsNoTilde($PROCESSEDMEASUREMENTS[$i][$j]).' ('.$INSTRUMENTS[$i][3].')"/>SEN '.$INSTRUMENTS[$i][1].' - '.statisticFunctionToWords($PROCESSEDMEASUREMENTS[$i][$j]).' ('.$INSTRUMENTS[$i][3].')</label><br/>';
				}
				
				$MODELS = getTypeOfModelOfInstrument($INSTRUMENTS[$i][0]);
				
				for($j = 0; $j < count($MODELS) ; $j++){
					$HTML.='<label for="data_type_available_SEN-MOD_'.$MODELS[$j][0].'_'.$MODELS[$j][1].'"><input id="data_type" name="data_type_available_SEN-MOD_'.$MODELS[$j][0].'_'.$MODELS[$j][1].'" type="checkbox" value="SEN-MOD_'.$INSTRUMENTS[$i][0].'_'.$MODELS[$j][0].'" title="SEN/MOD '.$MODELS[$j][1].' ('.$MODELS[$j][2].')"/>SEN/MOD '.$MODELS[$j][1].' ('.$MODELS[$j][2].')</label><br/>';
				}
				
			}
			
			$MODELS = getTypeOfModelOfStation($STATION);
			
			for($j = 0; $j < count($MODELS) ; $j++){
				$HTML.='<label for="data_type_available_MOD_'.$MODELS[$j][0].'_'.$MODELS[$j][1].'"><input id="data_type" name="data_type_available_MOD_'.$MODELS[$j][0].'_'.$MODELS[$j][1].'" type="checkbox" value="MOD_'.$MODELS[$j][0].'_'.$MODELS[$j][1].'" title="EST/MOD '.$MODELS[$j][1].' ('.$MODELS[$j][2].')"/>EST/MOD '.$MODELS[$j][1].' ('.$MODELS[$j][2].')</label><br/>';
			}
			
			
			
		}
		elseif($DETAILS == 'detalle_diario'){
			$L = count($INSTRUMENTS);
			$PROCESSEDMEASUREMENTS = array();
			
			for($i = 0; $i < $L ; $i++){
				
				$HTML.='<label for="data_type_available_SEN_'.$INSTRUMENTS[$i][0].'"><input id="data_type" name="data_type_available_SEN_'.$INSTRUMENTS[$i][0].'" type="checkbox" value="SEN_'.$INSTRUMENTS[$i][0].'" title="SEN '.$INSTRUMENTS[$i][1].' ('.$INSTRUMENTS[$i][3].')"/>SEN '.$INSTRUMENTS[$i][1].' ('.$INSTRUMENTS[$i][3].')</label><br/>';
				
			}
		}
		echo $HTML.'<br/><br/>[SEN: Sensor]<br/>[SEN/MOD: Modelo de Sensor]<br/>[EST/MOD: Modelo de Estaci&oacute;n]';
	}
	elseif($ACCION == "get_stations_select_from_instrument_type"){
	
		$TIID = $_GET['tiid'];
	
		$SQL = "SELECT estacion.id,estacion.nombre
			FROM eve_usuario_has_tipo_de_permiso_usuario, eve_tipo_de_permiso_usuario, estacion, instrumento 
			WHERE usuario_id=".$_SESSION['session_usuario_id']." 
			AND eve_tipo_de_permiso_usuario_id=eve_tipo_de_permiso_usuario.id 
			AND eve_tipo_de_permiso_usuario.value=estacion.id 
			AND instrumento.tipo_instrumento_id=$TIID 
			AND instrumento.estacion_id=estacion.id 
			AND eve_tipo_de_permiso_usuario.code LIKE 'STATION_ACCESS_%'
			ORDER BY estacion.nombre";
		
		$result_estaciones = consulta_sql($SQL);
		
		$HTML = '';
		
		while($STATION = mysqli_fetch_array($result_estaciones)){
			$HTML.='<label for="available_station_'.$STATION[0].'"><input id="available_station" name="available_station_'.$STATION[0].'" type="checkbox" value="'.$STATION[0].'" title="'.$STATION[1].'"/>'.$STATION[1].'</label><br/>';
		}
		
		echo $HTML;
	}
?>