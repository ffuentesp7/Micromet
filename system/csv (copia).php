<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	require('../JSON.php');
	require('./functions/statistic.functions.php');
	set_time_limit(0);
	header("Content-type: text/html");
	if(!isset($_SESSION['process_csv'])){
		$_SESSION['process_csv'] = true;
	}
	elseif($_SESSION['process_csv']){
		header("Content-type: text/html");
		echo "<h2>Ya esta procesando un archivo, por favor espere.</h2>";	
	}
	else{
		$_SESSION['process_csv'] = true;
		$json = new Services_JSON();
		
		$ACCION = $_REQUEST['accion'];
		
		if($ACCION == "get_data_station"){
			$STATION = $_REQUEST['sta'];
			$FROM = $_REQUEST['fd'];
			$TO = $_REQUEST['fh'];
			$DET = $_REQUEST['det'];
			$SEP = $_REQUEST['sep'];
			$MAXFILAS = $_REQUEST['fil'];
			
			$TYPES = $json->decode(str_replace("\\","",utf8_encode($_REQUEST['types'])), true);
			
			$LTYPES = count($TYPES);
			$DATA = array();
			
			if($DET == 'diario'){
				/*
				$TYPES[] = ['TIPO DE VARIABLE {SEN,SEN-MOD,MOD}',CODIGO {TIPO SEN: ID INS, TIPO SEN-MOD, ID INS, TIPO MOD: ID MOD}, CODIGO {TIPO SEN: PROCE MEASUR NAME, TIPO SEN-MOD: ID MOD, TIPO MOD: MOD NAME }, {NOMBRE VARIABLE}];
				*/
				
				//HEADER
				$HEADER = array();
				$HEADER[] = 'Fecha';
				for($i = 0; $i < $LTYPES; $i++){
					$HEADER[] = utf8_decode($TYPES[$i][3]);
				}
				$DATA[] = $HEADER;
				
				$INSERTDATE = $FROM;
				for($i = 0; retorna_unix($INSERTDATE,"00:00:00") <= retorna_unix($TO,"00:00:00"); $i++){
					$INSERTDATE = add_days_mysql($FROM, $i);
					$DATA[] = array(cambia_fecha_a_normal($INSERTDATE));
				}
				
				for($i = 0; $i < $LTYPES; $i++){
					$VDATA = array();
					if($TYPES[$i][0] == 'SEN'){
						$SQL = "SELECT 	fecha,
								valor 
							FROM 	medicion_procesada,
								tipo_medicion_procesada 
							WHERE 	instrumento_id=".$TYPES[$i][1]." 
							AND	tipo_medicion_procesada_id=tipo_medicion_procesada.id 
							AND	tipo_medicion_procesada.nombre='".$TYPES[$i][2]."' 
							AND	fecha >= '$FROM' 
							AND	fecha <= '$TO' 
							ORDER BY fecha";
					}
					elseif($TYPES[$i][0] == 'SEN-MOD'){
						$SQL = "SELECT 	fecha,
								valor 
							FROM 	modelo_procesado_instrumento
							WHERE 	instrumento_has_modelo_instrumento_id=".$TYPES[$i][1]." 
							AND	instrumento_has_modelo_tipo_modelo_id=".$TYPES[$i][2]." 
							AND	fecha >= '$FROM' 
							AND	fecha <= '$TO' 
							ORDER BY fecha";
					}
					elseif($TYPES[$i][0] == 'MOD'){
						$SQL = "SELECT 	fecha,
								valor 
							FROM 	modelo_procesado_estacion
							WHERE 	estacion_has_modelo_id_estacion=$STATION 
							AND	estacion_has_modelo_id_tipo_modelo=".$TYPES[$i][1]." 
							AND	fecha >= '$FROM' 
							AND	fecha <= '$TO' 
							ORDER BY fecha";						
					}
					$RESP = consulta_sql($SQL);
						
					$ADATA = array();
					while($DATA_SQL = mysqli_fetch_array($RESP)){
						$ADATA[] = array(cambia_fecha_a_normal($DATA_SQL[0]),floatval($DATA_SQL[1]));
					}
					
					$z = 0;
					for($j = 1; $j < count($DATA); $j++){
						$NAN = true;
						for($k = $z; $k < count($ADATA); $k++){
							if($DATA[$j][0] == $ADATA[$k][0]){
								$DATA[$j][] = $ADATA[$k][1];
								$z = $k;
								$NAN = false;
								break;
							}
						}
						if($NAN)
							$DATA[$j][] = "NaN";
					}
					
				}
				for($j = 1; $j < count($DATA); $j++){
					$NAN = 0;
					for($i = 1; $i <= $LTYPES; $i++){
						if($DATA[$j][$i] == "NaN"){
							$NAN++;
						}
					}
					if($NAN == $LTYPES){
						$DATA[$j][0] = "NaN";
					}
				}
				
			}
			elseif($DET == 'detalle_diario'){
				//HEADER
				$HEADER = array();
				$HEADER[] = 'Fecha';
				$HEADER[] = 'Hora';
				for($i = 0; $i < $LTYPES; $i++){
					$HEADER[] = utf8_decode($TYPES[$i][2]);
				}
				$DATA[] = $HEADER;
				for($i = 0; $i < $LTYPES; $i++){
					$VDATA = array();
					
					if(count($DATA) == 1){
						$SQL = "SELECT 	DISTINCT
								fecha,
								hora
							FROM 	medicion 
							WHERE	fecha >= '$FROM' 
							AND	fecha <= '$TO' 
							ORDER BY fecha, hora";
					}
					else{
						$SQL = "SELECT 	fecha,
								hora,
								medicion
							FROM 	medicion
							WHERE 	instrumento_id=".$TYPES[$i][1]." 
							AND	fecha >= '$FROM' 
							AND	fecha <= '$TO' 
							ORDER BY fecha, hora";
					}
						
					$RESP = consulta_sql($SQL);
						
					if(count($DATA) == 1){
						while($DATA_SQL = mysqli_fetch_array($RESP)){
							$DATA[] = array(cambia_fecha_a_normal($DATA_SQL[0]),$DATA_SQL[1],floatval($DATA_SQL[2]));
						}
						$i--;
					}
					else{
						$ADATA = array();
						while($DATA_SQL = mysqli_fetch_array($RESP)){
							$ADATA[] = array(cambia_fecha_a_normal($DATA_SQL[0]),$DATA_SQL[1],floatval($DATA_SQL[2]));
						}
						$z = 0;
						for($j = 1; $j < count($DATA); $j++){
							$NAN = true;
							for($k = $z; $k < count($ADATA); $k++){
								if($DATA[$j][0] == $ADATA[$k][0] && $DATA[$j][1] == $ADATA[$k][1]){
									$DATA[$j][] = $ADATA[$k][2];
									$z = $k;
									$NAN = false;
									break;
								}
							}
							if($NAN)
								$DATA[$j][] = "NaN";
						}
					}
				}
				for($j = 1; $j < count($DATA); $j++){
					$NAN = 0;
					for($i = 2; $i <= $LTYPES+1; $i++){
						if($DATA[$j][$i] == "NaN"){
							$NAN++;
						}
					}
					if($NAN == $LTYPES){
						$DATA[$j][0] = "NaN";
					}
				}
			}
			header("Content-Description: File Transfer");
			header("Content-Type: application/force-download;  charset= iso 8859-2");
			header("Content-Disposition: attachment; filename=ES$STATION-".date('YmdHis').".csv");
			for($i = 0; $i < count($DATA) && $i < $MAXFILAS; $i++){
				if($DATA[$i][0] != "NaN"){
					for($j = 0; $j < count($DATA[$i]); $j++){
						if($SEP == 'comma')
							echo $DATA[$i][$j].',';
						elseif($SEP == 'semicolon')
							echo $DATA[$i][$j].';';
						elseif($SEP == 'tab')
							echo $DATA[$i][$j]."\t";
					}
					echo "\n";
				}
			}
		}
		elseif($ACCION == "get_data_instrument"){
			$TIID = $_REQUEST['tiid'];
			$FROM = $_REQUEST['fd'];
			$TO = $_REQUEST['fh'];
			$DET = $_REQUEST['det'];
			$SEP = $_REQUEST['sep'];
			$MAXFILAS = $_REQUEST['fil'];
			
			$TYPES = $json->decode(str_replace("\\","",utf8_encode($_REQUEST['sta'])), true);
			
			$LTYPES = count($TYPES);
			$LPMTYPES = 0;
			$DATA = array();
			
			if($DET == 'diario'){
				/*
				$TYPES[] = 	[0] id estacion
						[1] nombre estacion;
				*/
				//HEADER
				$HEADER = array();
				$HEADER[] = 'Fecha';
				for($i = 0; $i < $LTYPES; $i++){
				
					$PM = getTypeOfProcessedMeasurementOfInstrument(getInstrumetId($TYPES[$i][0],$TIID));
				
					if(count($PM) > 0)
						$HEADER[] = utf8_decode($TYPES[$i][1]);
					
					for($j = 1; $j < count($PM); $j++)
						$HEADER[] = '';
				}
				$DATA[] = $HEADER;
				$HEADER = array();
				$HEADER[] = '';
				for($i = 0; $i < $LTYPES; $i++){
				
					$PM = getTypeOfProcessedMeasurementOfInstrument(getInstrumetId($TYPES[$i][0],$TIID));
					
					for($j = 0; $j < count($PM); $j++){
						$HEADER[] = statisticFunctionToWordsNoTilde($PM[$j]);
						$LPMTYPES++;
					}
				}
				$DATA[] = $HEADER;
				
				
				$INSERTDATE = $FROM;
				for($i = 0; retorna_unix($INSERTDATE,"00:00:00") <= retorna_unix($TO,"00:00:00"); $i++){
					$INSERTDATE = add_days_mysql($FROM, $i);
					$DATA[] = array(cambia_fecha_a_normal($INSERTDATE));
				}
				
				for($i = 0; $i < $LTYPES; $i++){
					$VDATA = array();
					
					$IID = getInstrumetId($TYPES[$i][0],$TIID);
					$PM = getTypeOfProcessedMeasurementOfInstrument($IID);
					
					for($l = 0; $l < count($PM); $l++){
						$SQL = "SELECT 	fecha,
								valor 
							FROM 	medicion_procesada,
								tipo_medicion_procesada 
							WHERE 	instrumento_id=$IID 
							AND	tipo_medicion_procesada_id=tipo_medicion_procesada.id 
							AND	tipo_medicion_procesada.nombre='".$PM[$l]."' 
							AND	fecha >= '$FROM' 
							AND	fecha <= '$TO' 
							ORDER BY fecha";
						
						$RESP = consulta_sql($SQL);
						
						$ADATA = array();
						while($DATA_SQL = mysqli_fetch_array($RESP)){
							$ADATA[] = array(cambia_fecha_a_normal($DATA_SQL[0]),floatval($DATA_SQL[1]));
						}
						
						$z = 0;
						for($j = 2; $j < count($DATA); $j++){
							$NAN = true;
							for($k = $z; $k < count($ADATA); $k++){
								if($DATA[$j][0] == $ADATA[$k][0]){
									$DATA[$j][] = $ADATA[$k][1];
									$z = $k;
									$NAN = false;
									break;
								}
							}
							if($NAN)
								$DATA[$j][] = "NaN";
						}
					}
				}
				for($j = 2; $j < count($DATA); $j++){
					$NAN = 0;
					for($i = 1; $i <= $LPMTYPES; $i++){
						if($DATA[$j][$i] == "NaN"){
							$NAN++;
						}
					}
					if($NAN == $LPMTYPES){
						$DATA[$j][0] = "NaN";
					}
				}
				
			}
			elseif($DET == 'detalle_diario'){
				//HEADER
				$HEADER = array();
				$HEADER[] = 'Fecha';
				$HEADER[] = 'Hora';
				for($i = 0; $i < $LTYPES; $i++){
					$HEADER[] = utf8_decode($TYPES[$i][1]);
				}
				$DATA[] = $HEADER;
				for($i = 0; $i < $LTYPES; $i++){
					$VDATA = array();
					$IID = getInstrumetId($TYPES[$i][0],$TIID);
					
					if(count($DATA) == 1){
						$SQL = "SELECT 	DISTINCT
								fecha,
								hora
							FROM 	medicion 
							WHERE	fecha >= '$FROM' 
							AND	fecha <= '$TO' 
							ORDER BY fecha, hora";
					}
					else{
						$SQL = "SELECT 	fecha,
								hora,
								medicion
							FROM 	medicion
							WHERE 	instrumento_id=$IID 
							AND	fecha >= '$FROM' 
							AND	fecha <= '$TO' 
							ORDER BY fecha, hora";
					}
						
					$RESP = consulta_sql($SQL);
						
					if(count($DATA) == 1){
						while($DATA_SQL = mysqli_fetch_array($RESP)){
							$DATA[] = array(cambia_fecha_a_normal($DATA_SQL[0]),$DATA_SQL[1]);
						}
						$i--;
					}
					else{
						$ADATA = array();
						while($DATA_SQL = mysqli_fetch_array($RESP)){
							$ADATA[] = array(cambia_fecha_a_normal($DATA_SQL[0]),$DATA_SQL[1],floatval($DATA_SQL[2]));
						}
						$z = 0;
						for($j = 1; $j < count($DATA); $j++){
							$NAN = true;
							for($k = $z; $k < count($ADATA); $k++){
								if($DATA[$j][0] == $ADATA[$k][0] && $DATA[$j][1] == $ADATA[$k][1]){
									$DATA[$j][] = $ADATA[$k][2];
									$z = $k;
									$NAN = false;
									break;
								}
							}
							if($NAN)
								$DATA[$j][] = "NaN";
						}
					}
				}
				for($j = 1; $j < count($DATA); $j++){
					$NAN = 0;
					for($i = 2; $i <= $LTYPES+1; $i++){
						if($DATA[$j][$i] == "NaN"){
							$NAN++;
						}
					}
					if($NAN == $LTYPES){
						$DATA[$j][0] = "NaN";
					}
				}
				
			}
			header("Content-Description: File Transfer");
			header("Content-Type: application/force-download;  charset= iso 8859-2");
			header("Content-Disposition: attachment; filename=INS$TIID-".date('YmdHis').".csv");
			for($i = 0; $i < count($DATA) && $i < $MAXFILAS; $i++){
				if($DATA[$i][0] != "NaN"){
					for($j = 0; $j < count($DATA[$i]); $j++){
						if($SEP == 'comma')
							echo $DATA[$i][$j].',';
						elseif($SEP == 'semicolon')
							echo $DATA[$i][$j].';';
						elseif($SEP == 'tab')
							echo $DATA[$i][$j]."\t";
					}
					echo "\n";
				}
			}
		}
		else{
			header("Content-type: text/html");
			echo "<h2>Error en los parametros.</h2>";
		}
		$_SESSION['process_csv'] = false;
	}
	
?>