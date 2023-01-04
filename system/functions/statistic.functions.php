<?php
	
	/*RETORNA VALOR,HORA,NUMERO DE DATOS PROCESADOS EN UN ARRAY*/
	function getProcessedMeasurement($instrumentId,$statistic,$date){
		$SQL = "SELECT 	valor, 
				hora, 
				numero_datos_usados  
			FROM 	medicion_procesada, 
				tipo_medicion_procesada
			WHERE	medicion_procesada.instrumento_id=$instrumentId 
			AND 	medicion_procesada.tipo_medicion_procesada_id=tipo_medicion_procesada.id 
			AND	tipo_medicion_procesada.nombre='$statistic' 
			AND	medicion_procesada.fecha='$date'";
			
		$RETURNDATA = array('NaN','NaN','NaN');
		
		$result = consulta_sql($SQL);
		
		if($data = mysqli_fetch_array($result)){
			$RETURNDATA[0] = $data[0];
			$RETURNDATA[1] = $data[1];
			$RETURNDATA[2] = $data[2];
		}
		
		return $RETURNDATA;
	}
	/*RETORNA LA ULTIMA FECHA QUE CONTIENE DATOS PROCESADOS PARA EL INSTRUMENTO DADO Y EL TIPO
	DE DATO PROCESADO*/
	function getLastProcessedMeasurementDate($instrumentId,$statistic){
		$SQL = "SELECT 	fecha  
			FROM 	medicion_procesada, 
				tipo_medicion_procesada
			WHERE	medicion_procesada.instrumento_id=$instrumentId 
			AND 	medicion_procesada.tipo_medicion_procesada_id=tipo_medicion_procesada.id 
			AND	tipo_medicion_procesada.nombre='$statistic' 
			ORDER BY fecha DESC LIMIT 1";
			
		$RETURNDATA = 'NaN';
		
		$result = consulta_sql($SQL);
		
		if($data = mysqli_fetch_array($result)){
			$RETURNDATA = $data[0];
		}
		
		return $RETURNDATA;
	}
	
	/*RETORNA EL DATO PROCESADO PARA EL RANGO DE FECHA DADO DESDE dateIntit HASTA dateFinish
	PARA EL INSTRUMENTO Y EL TIPO DE MEDICION PROCESADA*/
	function getProcessedMeasurementRange($instrumentId,$statistic,$dateInit,$dateFinish){
		//echo 'getProcessedMeasurementRange';
		$STAT = '';
		switch($statistic){
			case "AVGDAY": $STAT = "AVG"; break;
			case "MINDAY": $STAT = "MIN"; break;
			case "MAXDAY": $STAT = "MAX"; break;
			case "SUMDAY": $STAT = "SUM"; break;
		}
	
		$SQL = "SELECT 	$STAT(valor), 
				COUNT(VALOR), 
				MIN(numero_datos_usados) 
			FROM 	medicion_procesada, 
				tipo_medicion_procesada
			WHERE	medicion_procesada.instrumento_id=$instrumentId 
			AND 	medicion_procesada.tipo_medicion_procesada_id=tipo_medicion_procesada.id 
			AND	tipo_medicion_procesada.nombre='$statistic' 
			AND	medicion_procesada.fecha>='$dateInit' 
			AND 	medicion_procesada.fecha<='$dateFinish' 
			GROUP BY medicion_procesada.instrumento_id";
			
		$RETURNDATA = array('NaN','NaN','NaN');
		
		$result = consulta_sql($SQL);
		
		if($data = mysqli_fetch_array($result)){
			$RETURNDATA[0] = $data[0];
			$RETURNDATA[1] = $data[1];
			$RETURNDATA[2] = getNumDaysWithDeficientData($instrumentId,$statistic,$dateInit,$dateFinish);
		}
		
		return $RETURNDATA;
	}
	
	function getNumDaysWithDeficientData($instrumentId,$statistic,$dateInit,$dateFinish){
		//echo 'getProcessedMeasurementRange';
		$USEDDATA = intval(get_parameter('MAX_DEFICIENT_DATA_PER_DAY'));
		
		$SQL = "SELECT 	COUNT(numero_datos_usados) 
			FROM 	medicion_procesada, 
				tipo_medicion_procesada
			WHERE	medicion_procesada.instrumento_id=$instrumentId 
			AND 	medicion_procesada.tipo_medicion_procesada_id=tipo_medicion_procesada.id 
			AND	tipo_medicion_procesada.nombre='$statistic' 
			AND	medicion_procesada.fecha>='$dateInit' 
			AND 	medicion_procesada.fecha<='$dateFinish'
			AND	numero_datos_usados < $USEDDATA 
			GROUP BY medicion_procesada.instrumento_id";
			
		$RETURNDATA = 0;
		
		$result = consulta_sql($SQL);
		
		if($data = mysqli_fetch_array($result)){
			$RETURNDATA = $data[0];
		}
		
		return $RETURNDATA;
	}
	
	/*RETORNA LOS TIPOS DE MEDICION PROCESADA QUE TIENE EL INSTRUMENTO EN UN ARRAY*/
	function getTypeOfProcessedMeasurementOfInstrument($instrumentId){
		$SQL = "SELECT 	DISTINCT 
				tipo_medicion_procesada.nombre  
			FROM 	medicion_procesada, 
				tipo_medicion_procesada
			WHERE	medicion_procesada.instrumento_id=$instrumentId 
			AND 	medicion_procesada.tipo_medicion_procesada_id=tipo_medicion_procesada.id";
			
		$RETURNDATA = array();
		
		$result = consulta_sql($SQL);
		
		while($data = mysqli_fetch_array($result)){
			$RETURNDATA[] = $data[0];
		}
		
		return $RETURNDATA;
	}
	
	/*RETORNA LOS TIPOS DE MODELOS (id,nombre) QUE TIENE LA ESTACION EN UN ARRAY*/
	function getTypeOfModelOfStation($stationId){
		$SQL = "SELECT 	DISTINCT 
				tipo_modelo.id,
				tipo_modelo.nombre,
				tipo_modelo.unidad 
			FROM 	estacion_has_modelo, 
				tipo_modelo
			WHERE	id_tipo_modelo=tipo_modelo.id 
			AND 	id_estacion=$stationId";
			
		$RETURNDATA = array();
		
		$result = consulta_sql($SQL);
		
		while($data = mysqli_fetch_array($result)){
			$RETURNDATA[] = $data;
		}
		
		return $RETURNDATA;
	}
	
	/*RETORNA LOS TIPOS DE MODELOS (id,nombre) QUE TIENE EL INSTRUMENTO EN UN ARRAY*/
	function getTypeOfModelOfInstrument($instrumentId){
		$SQL = "SELECT 	DISTINCT 
				tipo_modelo.id,
				tipo_modelo.nombre,
				tipo_modelo.unidad  
			FROM 	instrumento_has_modelo, 
				tipo_modelo
			WHERE	tipo_modelo_id=tipo_modelo.id 
			AND 	instrumento_id=$instrumentId";
			
		$RETURNDATA = array();
		
		$result = consulta_sql($SQL);
		
		while($data = mysqli_fetch_array($result)){
			$RETURNDATA[] = $data;
		}
		
		return $RETURNDATA;
	}

	/*RETORNA EL VALOR DE UN MODELO DADO POR model PARA LA FECHA date DE LA ESTACION
	stationId*/
	function getProcessedModel($stationId,$model,$date){
		$SQL = "SELECT 	valor
			FROM 	modelo_procesado_estacion, 
				tipo_modelo,
				estacion_has_modelo 
			WHERE 	tipo_modelo.target='STATION'
			AND 	tipo_modelo.nombre='$model' 
			AND 	estacion_has_modelo.id_tipo_modelo=tipo_modelo.id 
			AND 	estacion_has_modelo.id_estacion=$stationId 
			AND 	modelo_procesado_estacion.estacion_has_modelo_id_estacion=estacion_has_modelo.id_estacion 
			AND 	modelo_procesado_estacion.estacion_has_modelo_id_tipo_modelo=estacion_has_modelo.id_tipo_modelo 
			AND 	modelo_procesado_estacion.fecha='$date'";
			
		$RETURNDATA = 'NaN';
		
		$result = consulta_sql($SQL);
		
		if($data = mysqli_fetch_array($result)){
			$RETURNDATA = $data[0];
		}
		
		return $RETURNDATA;
	}
	
	/*Retorna TRUE si la estacion tiene activado el modelo entregado,
	de lo contrario retorna FALSE*/
	function getTypeOfProcessedModel($stationId,$model){
		$SQL = "SELECT 	id
			FROM 	tipo_modelo,
				estacion_has_modelo 
			WHERE 	tipo_modelo.target='STATION'
			AND 	tipo_modelo.nombre='$model' 
			AND 	estacion_has_modelo.id_tipo_modelo=tipo_modelo.id 
			AND 	estacion_has_modelo.id_estacion=$stationId";
			
		$RETURNDATA = 'FALSE';
		
		$result = consulta_sql($SQL);
		
		if($data = mysqli_fetch_array($result)){
			$RETURNDATA = "TRUE";
		}
		
		return $RETURNDATA;
	}
	
	/*ENTREGA EL VALOR DE UN MODELO PARA EL RANGO DE FECHAS DADO DESDE dateInit HASTA
	dateFinish PARA LA ESTACION stationId, EL MODELO model USANDO LA FUNCION ESTADISTICA
	function [SUM, MIN, MAX, AVG]*/
	function getProcessedModelRange($stationId,$model,$function,$dateInit,$dateFinish){
		$SQL = "SELECT 	$function(valor)
			FROM 	modelo_procesado_estacion, 
				tipo_modelo,
				estacion_has_modelo 
			WHERE 	tipo_modelo.target='STATION'
			AND 	tipo_modelo.nombre='$model' 
			AND 	estacion_has_modelo.id_tipo_modelo=tipo_modelo.id 
			AND 	estacion_has_modelo.id_estacion=$stationId 
			AND 	modelo_procesado_estacion.estacion_has_modelo_id_estacion=estacion_has_modelo.id_estacion 
			AND 	modelo_procesado_estacion.estacion_has_modelo_id_tipo_modelo=estacion_has_modelo.id_tipo_modelo 
			AND 	modelo_procesado_estacion.fecha>='$dateInit' 
			AND 	modelo_procesado_estacion.fecha<='$dateFinish' 
			GROUP BY tipo_modelo.id";
			
		$RETURNDATA = 'NaN';
		
		$result = consulta_sql($SQL);
		
		if($data = mysqli_fetch_array($result)){
			$RETURNDATA = $data[0];
		}
		
		return $RETURNDATA;
	}
	
	/*RETORNA EL ID DEL INSTRUMENTO CORRESPONDIENTE AL TIPO DE INSTRUMENTO
	DE LA ESTACION DADA*/
	function getInstrumetId($stationId,$instrumentType){
		$SQL = "SELECT 	instrumento.id 
			FROM 	instrumento  
			WHERE	instrumento.estacion_id=$stationId 
			AND 	tipo_instrumento_id=$instrumentType";
		
		$RETURNDATA = 'NaN';
		
		$result = consulta_sql($SQL);
		
		if($data = mysqli_fetch_array($result)){
			$RETURNDATA = $data[0];
		}
		
		return $RETURNDATA;
	}
	
	/*DEVUELVE EL INTERVALO DE MEDICION ACTUAL DE LOS DATOS DEL INSTRUMENTO DADO*/
	function getMeasuringInterval($instrumentId){
		$SQL = "SELECT fecha,hora FROM medicion WHERE instrumento_id=$instrumentId ORDER by fecha DESC, hora DESC LIMIT 2";
		
		$result = consulta_sql($SQL);
		if(mysqli_num_rows($result) > 0)
		{
			$RETURNDATA = 0;
			
			$CAL = array();
			
			while($data = mysqli_fetch_array($result)){
				$CAL[] = $data;
			}
			
			$SEG = retorna_unix($CAL[0][0],$CAL[0][1]) - retorna_unix($CAL[1][0],$CAL[1][1]);
			
			$MIN = round($SEG*1.0 / 60);
			
			return $MIN*1.0;
		}
		else{
			return 0*1.0;
		}
		
	}
	
	/*RETORNA EL NOMBRE DE LA FUNCION ESTADISTICA PARA SER PUESTO EN TABLAS*/
	function statisticFunctionToWords($statistic){
		$STAT = '';
		switch($statistic){
			case "AVGDAY": $STAT = "Media"; break;
			case "MINDAY": $STAT = "M&iacute;n"; break;
			case "MAXDAY": $STAT = "M&aacute;x"; break;
			case "SUMDAY": $STAT = "Acumulado"; break;
		}
		
		return $STAT;
	}
	
	/*RETORNA EL NOMBRE DE LA FUNCION ESTADISTICA PARA SER PUESTO EN TABLAS*/
	function statisticFunctionToWordsNoTilde($statistic){
		$STAT = '';
		switch($statistic){
			case "AVGDAY": $STAT = "Med"; break;
			case "MINDAY": $STAT = "Min"; break;
			case "MAXDAY": $STAT = "Max"; break;
			case "SUMDAY": $STAT = "Ac"; break;
		}
		
		return $STAT;
	}
	
	/*RETORNA LOS ID DE LOS INSTRUMENTOS ASOCIADOS A LA ESTACION*/
	function getInstrumentsOfStation($stationId){
		$SQL = "SELECT 	id,
				modelo,
				marca,
				unidad
			FROM 	instrumento  
			WHERE	estacion_id=$stationId 
			ORDER BY tipo_instrumento_id";
		
		$RETURNDATA = array();
		
		$result = consulta_sql($SQL);
		
		while($data = mysqli_fetch_array($result)){
			$RETURNDATA[] = array($data[0],$data[1],$data[2],$data[3]);
		}
		
		return $RETURNDATA;
	}
	
	//RETORNA EL ID DEL TIPO DE MEDICION PROCESADA
	function getProcessedMeasurementTypeId($typeName){
		$SQL = "SELECT 	id
			FROM 	tipo_medicion_procesada 
			WHERE	nombre='$typeName'";
		
		$RETURNDATA = 'NaN';
		
		$result = consulta_sql($SQL);
		
		if($data = mysqli_fetch_array($result)){
			$RETURNDATA = $data[0];
		}
		
		return $RETURNDATA;
	}
	
	//RETORNA LOS DATOS DE UN INSTRUMENTO EN UN ARRAY
	function getDataOfInstrument($instrumentId){
		$SQL = "SELECT 	unidad,
				marca,
				modelo,
				adcon_id,
				ubicacion_nombre,
				observacion,
				fecha_instalacion,
				tipo_instrumento_id,
				estacion_id,
				responsable_id,
				revisar_datos
			FROM 	instrumento 
			WHERE	id=$instrumentId";
			
		$RETURNDATA = array();
		
		$result = consulta_sql($SQL);
		
		if($data = mysqli_fetch_array($result)){
			for($i = 0; $i < 11; $i++){
				$RETURNDATA[] = $data[$i];
			}
		}
		
		return $RETURNDATA;
	}
	
	//RETORNA EL ESTADO DE UN DATO EN PALABRAS
	function stateTraduction($state){
		switch($state){
			case 0:
				return 'Normal';
				break;
			case 1:	
				return 'Inv&aacute;lido';
				break;
			case 2:	
				return 'Perdido';
				break;
			case 4:	
				return 'Parcial';
				break;
			default:
				return 'Desconocido';
				break;
		}
	}
	/*
	[0] id
	[1] nombre
	[2] adcon_id
	[3] latitud
	[4] longitud
	[5] altura
	[6] ultima fecha
	[7] ultima hora
	[8] intentos de descarga
	[9] estado
	*/
	function getDataOfStation($stationId){
		$SQL = "SELECT 	id,
				nombre,
				adcon_id,
				latitud,
				longitud,
				altura,
				ultima_fecha,
				ultima_hora,
				intentos_de_descarga,
				estado
			FROM 	estacion 
			WHERE	id=$stationId";
			
		$RETURNDATA = array();
		
		$result = consulta_sql($SQL);
		
		if($data = mysqli_fetch_array($result)){
			for($i = 0; $i < 10; $i++){
				$RETURNDATA[] = $data[$i];
			}
		}
		
		return $RETURNDATA;
	}
	
	//RETORNA LA ULTIMA MEDICION REGISTRADA PARA EL INSTRUMENTO
	function getLastMeasurement($instrumentId){
		$SQL = "SELECT 	medicion,
				fecha, 
				hora, 
				estado  
			FROM 	medicion
			WHERE	instrumento_id=$instrumentId 
			ORDER BY fecha DESC, hora DESC LIMIT 1";
			
		$RETURNDATA = array('NaN','NaN','NaN','NaN');
		
		$result = consulta_sql($SQL);
		
		if($data = mysqli_fetch_array($result)){
			$RETURNDATA[0] = $data[0];
			$RETURNDATA[1] = $data[1];
			$RETURNDATA[2] = $data[2];
			$RETURNDATA[3] = $data[3];
		}
		
		return $RETURNDATA;
	}
	
	//RETORNA LA ULTIMA MEDICION REGISTRADA PARA LA ESTACION
	function getLastMeasurementStation($stationId){
		$SQL = "SELECT 	medicion,
				fecha, 
				hora, 
				medicion.estado  
			FROM 	medicion,
				instrumento,
				estacion
			WHERE	instrumento_id=instrumento.id
			AND	instrumento.estacion_id=$stationId 
			ORDER BY fecha DESC, hora DESC LIMIT 1";
			
		$RETURNDATA = array('NaN','NaN','NaN','NaN');
		
		$result = consulta_sql($SQL);
		
		if($data = mysqli_fetch_array($result)){
			$RETURNDATA[0] = $data[0];
			$RETURNDATA[1] = $data[1];
			$RETURNDATA[2] = $data[2];
			$RETURNDATA[3] = $data[3];
		}
		
		return $RETURNDATA;
	}
	
	function getStationLiveData($EID){
		$INSTRUMENTS = getInstrumentsOfStation($EID);
		$LASTM = getLastMeasurementStation($EID);
		
		if(empty($INSTRUMENTS) || empty($LASTM) || $LASTM[0] == 'NaN'){
			return "<p>No existen datos para mostrar</p>";
			exit(0);			
		}
		
		$HOURDATE = add_seconds($LASTM[2],$LASTM[1],-3600);
		$DATE_FROM = $HOURDATE[1];
		$DATE_TO = $LASTM[1];
		$HOUR_FROM = $HOURDATE[0];
		$HOUR_TO = $LASTM[2];	
		
		
		
		$HTML='<table class="mediagrove" style="width: 100%;">';
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
		$HTML.='<tbody>';
		
		$SQL = "SELECT ins0.fecha, ins0.hora";
		
		for($i = 0; $i < $L; $i++){
			$SQL.=", ins$i.medicion";
		}
		$SQL.=" FROM medicion AS ins0";
		for($i = 1; $i < $L; $i++){
			$SQL.=" LEFT OUTER JOIN medicion AS ins$i ON ins".($i-1).".fecha=ins$i.fecha AND ins".($i-1).".hora=ins$i.hora";
		}
		$SQL.=" WHERE";
		for($i = 0; $i < $L; $i++){
			if($i == 0)
				$SQL.=" ins$i.instrumento_id = ".$INSTRUMENTS[$i][0];
			else
				$SQL.=" AND ins$i.instrumento_id = ".$INSTRUMENTS[$i][0];
		}
		$SQL.=" AND ins0.fecha >= '$DATE_FROM' AND ins0.fecha <= '$DATE_TO' AND ins0.hora >= '$HOUR_FROM' AND ins0.hora <= '$HOUR_TO'";
		$SQL.=" ORDER BY ins0.fecha, ins0.hora DESC";
		
		$RES_DATA = consulta_sql($SQL);
		
		for($j = 0; $DATA = mysqli_fetch_array($RES_DATA); $j++){
			if($j%2 == 0)
				$HTML.="<tr>";
			else
				$HTML.="<tr class='odd'>";
				
			$HTML.="<td style=\"width: 70px;\">".cambia_fecha_a_normal($DATA[0])."</td>";
			$HTML.="<td style=\"width: 60px;\">".$DATA[1]."</td>";
			
			for($i = 2; $i < ($L+2) ; $i++){
				$HTML.="<td>".number_format($DATA[$i], 1, '.', '')."</td>";
			}
			
			$HTML.="</tr>";
		}
		$HTML.="</tbody>";
		$HTML.='</table>';
		
		return $HTML;	
	}
	
	function getActiveStationModels(){
		
		$SQL = "SELECT 	estacion.id 
		FROM 	eve_usuario_has_tipo_de_permiso_usuario, 
			eve_tipo_de_permiso_usuario, 
			estacion
		WHERE 	usuario_id=".$_SESSION['session_usuario_id']." 
		AND 	eve_tipo_de_permiso_usuario_id=eve_tipo_de_permiso_usuario.id 
		AND 	eve_tipo_de_permiso_usuario.value=estacion.id  
		ORDER BY estacion.nombre";
		
		$SQLR = consulta_sql($SQL);
		
		$MODELS = array();
		
		while($SQLD = mysqli_fetch_array($SQLR)){
			$MOD = getTypeOfModelOfStation($SQLD[0]);
			
			if(count($MOD) > 0 && count($MODELS) <= 0){
				$MODELS[] = $MOD[0];
			}
			
			for($i = 0; $i < count($MOD); $i++){
				$flag = false;
				
				for($j = 0; $j < count($MODELS); $j++){					
					if($MOD[$i][0] == $MODELS[$j][0]){
						$flag = true;
					}
				}
				if(!$flag){
					$MODELS[] = $MOD[$i];
				}
			}
		}
		
		return $MODELS;
	}
	
?>