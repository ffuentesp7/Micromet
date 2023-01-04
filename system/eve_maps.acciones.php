<?php
	
	require('../funciones.inc.php');
	require('functions/statistic.functions.php');
	
	$ACCION = $_GET['accion'];
	
	if($ACCION == "get_station_live_data"){
		
		$INSTRUMENTS = getInstrumentsOfStation($_GET['eid']);
		$LASTM = getLastMeasurementStation($_GET['eid']);
		
		if(empty($INSTRUMENTS) || empty($LASTM) || $LASTM[0] == 'NaN'){
			echo "<p>No existen datos para mostrar</p>";
			exit(0);			
		}
		
		$HOURDATE = add_seconds($LASTM[2],$LASTM[1],-3600);
		$DATE_FROM = $HOURDATE[1];
		$DATE_TO = $LASTM[1];
		$HOUR_FROM = $HOURDATE[0];
		$HOUR_TO = $LASTM[2];	

		$L = count($INSTRUMENTS);
		$PROCESSEDMEASUREMENTS = array();
		
		for($i = 0; $i < $L ; $i++){
			$PROCESSEDMEASUREMENTS[$i] = getTypeOfProcessedMeasurementOfInstrument($INSTRUMENTS[$i][0]);
		}
	
		if(!isset($_GET['offset'])){
			$HTML='<table id="tabla_datos" class="mediagrove" style="width: 100%;">';
			
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
		
		//$HTML.="<tr id='load_buttom_row'><td colspan='".($colNumbers+1)."'><a href='javascript:load_data();'>&#091;Cargar m&aacute;s datos&#093;</a></td></tr>";
		
		if(!isset($_GET['offset'])){
			$HTML.="</tbody>";
			$HTML.='</table>';
		}
		
		echo $HTML;
	}
	else{
	
	}

?>