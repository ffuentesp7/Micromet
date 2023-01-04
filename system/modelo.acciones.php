<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	require('../system/functions/statistic.functions.php');
	require('../system/functions/instrument.type.php');
	require('../system/functions/convert.unit.php');
	

	$ACCION = $_GET['accion'];
	
	if($ACCION == "getstationsselect"){
	
		$MID = $_GET['mid'];
		$TARGET = $_GET['target'];
	
		$SQL = '';
		
		if($TARGET == 'STATION')
			$SQL = "SELECT estacion.nombre,estacion.id
				FROM eve_usuario_has_tipo_de_permiso_usuario, eve_tipo_de_permiso_usuario, estacion, tipo_modelo, estacion_has_modelo
				WHERE usuario_id=".$_SESSION['session_usuario_id']." 
				AND eve_tipo_de_permiso_usuario_id=eve_tipo_de_permiso_usuario.id 
				AND eve_tipo_de_permiso_usuario.value=estacion.id 
				AND tipo_modelo.id=$MID 
				AND estacion_has_modelo.id_estacion=estacion.id
				AND estacion_has_modelo.id_tipo_modelo=tipo_modelo.id
				AND eve_tipo_de_permiso_usuario.code LIKE 'STATION_ACCESS_%' 
				ORDER BY estacion.nombre";
		elseif($TARGET == 'SENSOR')
			$SQL = "SELECT estacion.nombre,estacion.id,instrumento.modelo,instrumento.id
				FROM eve_usuario_has_tipo_de_permiso_usuario, eve_tipo_de_permiso_usuario, estacion, instrumento, tipo_modelo, instrumento_has_modelo
				WHERE usuario_id=".$_SESSION['session_usuario_id']." 
				AND eve_tipo_de_permiso_usuario_id=eve_tipo_de_permiso_usuario.id 
				AND eve_tipo_de_permiso_usuario.value=estacion.id
				AND instrumento.estacion_id=estacion.id
				AND tipo_modelo.id=$MID 
				AND instrumento_has_modelo.instrumento_id=instrumento.id
				AND instrumento_has_modelo.tipo_modelo_id=tipo_modelo.id
				AND eve_tipo_de_permiso_usuario.code LIKE 'STATION_ACCESS_%' 
				ORDER BY estacion.nombre";
		
		$result_estaciones = consulta_sql($SQL);
		
		$HTML = '<select class="form-select" id="select_estacion" name="select_estacion">';
		
		while($datos_estaciones = mysqli_fetch_array($result_estaciones)){
			
			if($TARGET == 'SENSOR'){
				$HTML.= '<option value="'.$datos_estaciones[3].'-'.$datos_estaciones[1].'">';
				$HTML.= $datos_estaciones[2].' - '.$datos_estaciones[0];
			}
			else{
				$HTML.= '<option value="'.$datos_estaciones[1].'">';
				$HTML.= $datos_estaciones[0];
			}
			$HTML.= '</option>';
		}
		$HTML.= '</select>';
		
		echo $HTML;
	}
	elseif($ACCION == "getdata"){
		$CURRENT_DATA_ACCESS = get_user_permission($_SESSION['session_usuario_id'],'CURRENT_DATA_ACCESS');
		$MID = $_GET['mid'];
		$EID  = $_GET['eid'];
		$TARGET = $_GET['target'];
		
		$days = 14;
		if($CURRENT_DATA_ACCESS == '1')
			$days = 30;
		
		if($TARGET == 'STATION'){
		
			$SQL = "SELECT 	DISTINCT 
					fecha,
					valor,
					estacion.nombre,
					tipo_modelo.nombre,
					tipo_modelo.descripcion,
					tipo_modelo.unidad
				FROM 	estacion,
					estacion_has_modelo,
					modelo_procesado_estacion,
					tipo_modelo
				WHERE 	tipo_modelo.id=$MID
				AND	tipo_modelo.target='$TARGET'
				AND	estacion_has_modelo.id_tipo_modelo=tipo_modelo.id
				AND	estacion_has_modelo.id_estacion=estacion.id
				AND	estacion_has_modelo.id_tipo_modelo=modelo_procesado_estacion.estacion_has_modelo_id_tipo_modelo
				AND	estacion_has_modelo.id_estacion=modelo_procesado_estacion.estacion_has_modelo_id_estacion
				AND	estacion.id=$EID
				ORDER BY fecha DESC LIMIT $days";
				
			$result_modelo = consulta_sql($SQL);
			
			$HTML = '';
			$datos_modelo = mysqli_fetch_array($result_modelo);
			
			$HTML .= '<table class="mediagrove">
					<caption>Estaci&oacute;n: '.$datos_modelo[2].'. Modelo '.$datos_modelo[3].'</caption>
					<thead>
						<tr>
							<th scope="col">Fecha</th>
							<th scope="col">Valor ('.$datos_modelo[5].')</th>
						</tr>
					</thead>
					<tbody>';
			$i = 0;
			do{
				if(($i%2) == 0)
					$HTML .= '<tr class="data_row_'.$MID.'" valor="'.number_format($datos_modelo[1]*1, 1, '.', '').'">';
				else
					$HTML .= '<tr class="odd data_row_'.$MID.'" valor="'.number_format($datos_modelo[1]*1, 1, '.', '').'">';
				$HTML .= '	<td>'.cambia_fecha_a_normal($datos_modelo[0]).'</td>
						<td>'.number_format($datos_modelo[1]*1, 1, '.', '').'</td>
					</tr>';
				$i++;
			}
			while($datos_modelo = mysqli_fetch_array($result_modelo));
			
			$HTML .= '</tbody>';
			$HTML .= '<tfoot><tr><td colspan="3">&Uacute;ltimos '.$days.' d&iacute;as registrados.</td></tr><tfoot></table>';
			
			/*$HTML .= '	<script type="text/javascript">
						$(document).ready(function(){
							$(".data_row_'.$TIID.'").each(function(e){
								var valor = $(this).attr("valor");
								$(this).mouseover(function(h){
									$.changeInstrumentValue({instrumentValue: valor});
								});
							});
						});
					</script>';
			*/
			echo $HTML;
		}
		else{
		
			$SPLIT = explode("-",$EID);
			
			$EID = $SPLIT[1];
			$IID = $SPLIT[0];
			
			$SQL = "SELECT 	DISTINCT 
					fecha,
					hora,
					valor,
					estacion.nombre,
					tipo_modelo.nombre,
					tipo_modelo.descripcion,
					tipo_modelo.unidad
				FROM 	estacion,
					instrumento_has_modelo,
					modelo_procesado_instrumento,
					tipo_modelo,
					instrumento
				WHERE 	tipo_modelo.id=$MID
				AND	tipo_modelo.target='$TARGET'
				AND	instrumento_has_modelo.tipo_modelo_id=tipo_modelo.id
				AND	instrumento_has_modelo.instrumento_id=instrumento.id
				AND	instrumento.estacion_id=estacion.id
				AND	instrumento.id=$IID
				AND	instrumento_has_modelo.tipo_modelo_id=modelo_procesado_instrumento.instrumento_has_modelo_tipo_modelo_id 
				AND	instrumento_has_modelo.instrumento_id=modelo_procesado_instrumento.instrumento_has_modelo_instrumento_id 
				AND	estacion.id=$EID
				ORDER BY fecha DESC LIMIT $days";
				
			$result_modelo = consulta_sql($SQL);
			
			$HTML = '';
			$datos_modelo = mysqli_fetch_array($result_modelo);
			
			$HTML .= '<table class="mediagrove">
					<caption>Estaci&oacute;n: '.$datos_modelo[3].'. Modelo '.$datos_modelo[4].'</caption>
					<thead>
						<tr>
							<th scope="col">Fecha</th>
							<th scope="col">Hora</th>
							<th scope="col">Valor ('.$datos_modelo[6].')</th>
						</tr>
					</thead>
					<tbody>';
			$i = 0;
			do{
				if(($i%2) == 0)
					$HTML .= '<tr class="data_row_'.$MID.'" valor="'.number_format($datos_modelo[2]*1, 1, '.', '').'">';
				else
					$HTML .= '<tr class="odd data_row_'.$MID.'" valor="'.number_format($datos_modelo[2]*1, 1, '.', '').'">';
				$HTML .= '	<td>'.cambia_fecha_a_normal($datos_modelo[0]).'</td>
						<td>'.$datos_modelo[1].'</td>
						<td>'.number_format($datos_modelo[2]*1, 1, '.', '').'</td>
					</tr>';
				$i++;
			}
			while($datos_modelo = mysqli_fetch_array($result_modelo));
			
			$HTML .= '</tbody>';
			$HTML .= '<tfoot><tr><td colspan="3">&Uacute;ltimos '.$days.' d&iacute;as registrados.</td></tr><tfoot></table>';
			
			echo $HTML;
		}

	}
	elseif($ACCION == "getdata_json"){
		$CURRENT_DATA_ACCESS = get_user_permission($_SESSION['session_usuario_id'],'CURRENT_DATA_ACCESS');
		$MID = $_GET['mid'];
		$EID  = $_GET['eid'];
		$TARGET = $_GET['target'];
		
		$DATOS = array();
		
		$days = 14;
		if($CURRENT_DATA_ACCESS == '1')
			$days = 30;
		
		if($TARGET == 'STATION'){
		
			$SQL = "SELECT 	DISTINCT 
					fecha,
					valor,
					estacion.nombre,
					tipo_modelo.nombre,
					tipo_modelo.descripcion,
					tipo_modelo.unidad
				FROM 	estacion,
					estacion_has_modelo,
					modelo_procesado_estacion,
					tipo_modelo
				WHERE 	tipo_modelo.id=$MID
				AND	tipo_modelo.target='$TARGET'
				AND	estacion_has_modelo.id_tipo_modelo=tipo_modelo.id
				AND	estacion_has_modelo.id_estacion=estacion.id
				AND	estacion_has_modelo.id_tipo_modelo=modelo_procesado_estacion.estacion_has_modelo_id_tipo_modelo
				AND	estacion_has_modelo.id_estacion=modelo_procesado_estacion.estacion_has_modelo_id_estacion
				AND	estacion.id=$EID
				ORDER BY fecha DESC LIMIT $days";
				
			$result_modelo = consulta_sql($SQL);
			
			$datos_modelo = mysqli_fetch_array($result_modelo);

			do{	
				$DATOS[] = array(cambia_fecha_a_normal($datos_modelo[0]),number_format($datos_modelo[1]*1, 1, '.', ''),tilde_to_utf8($datos_modelo[5]));
			}
			while($datos_modelo = mysqli_fetch_array($result_modelo));
	
		}
		else{
		
			$SPLIT = explode("-",$EID);
			
			$EID = $SPLIT[1];
			$IID = $SPLIT[0];
			
			$SQL = "SELECT 	DISTINCT 
					fecha,
					hora,
					valor,
					estacion.nombre,
					tipo_modelo.nombre,
					tipo_modelo.descripcion,
					tipo_modelo.unidad
				FROM 	estacion,
					instrumento_has_modelo,
					modelo_procesado_instrumento,
					tipo_modelo,
					instrumento
				WHERE 	tipo_modelo.id=$MID
				AND	tipo_modelo.target='$TARGET'
				AND	instrumento_has_modelo.tipo_modelo_id=tipo_modelo.id
				AND	instrumento_has_modelo.instrumento_id=instrumento.id
				AND	instrumento.estacion_id=estacion.id
				AND	instrumento.id=$IID
				AND	instrumento_has_modelo.tipo_modelo_id=modelo_procesado_instrumento.instrumento_has_modelo_tipo_modelo_id 
				AND	instrumento_has_modelo.instrumento_id=modelo_procesado_instrumento.instrumento_has_modelo_instrumento_id 
				AND	estacion.id=$EID
				ORDER BY fecha DESC LIMIT $days";
				
			$result_modelo = consulta_sql($SQL);
			
			$datos_modelo = mysqli_fetch_array($result_modelo);
			
			do{
				$DATOS[] = array(cambia_fecha_a_normal($datos_modelo[0]),number_format($datos_modelo[2]*1, 1, '.', ''),tilde_to_utf8($datos_modelo[6]));
			}
			while($datos_modelo = mysqli_fetch_array($result_modelo));
			
		}
		
		$DATOS_ = array();
		for($j = (count($DATOS) - 1); $j >= 0; $j--){
			$DATOS_[] = $DATOS[$j];
		}
		
		
		require('../JSON.php');
		$JSON = new Services_JSON();
			
		echo $JSON->encode($DATOS_);
	}
	

?>