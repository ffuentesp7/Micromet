<?php
	require('../aut_verifica.inc.php');
	require_once('../funciones.inc.php');

	$ACCION = $_REQUEST['accion'];
	
	if($ACCION == "getdata_json"){
		$CURRENT_DATA_ACCESS = get_user_permission($_SESSION['session_usuario_id'],'CURRENT_DATA_ACCESS');
		$MID = $_GET['mid'];
		$EID  = $_GET['eid'];
		$TARGET = $_GET['target'];
		$FECHA = $_GET['startdate'];
		
		$DATOS = array();
		
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
			AND 	fecha >= '$FECHA' 
			ORDER BY fecha";
			
		$result_modelo = consulta_sql($SQL);
		
		$datos_modelo = mysqli_fetch_array($result_modelo);
		
		$GDA = 0;
		do{
			$GDA+=$datos_modelo[2];
			$DATOS[] = array(cambia_fecha_a_normal($datos_modelo[0]),number_format($GDA*1, 1, '.', ''),tilde_to_utf8($datos_modelo[6]));
		}
		while($datos_modelo = mysqli_fetch_array($result_modelo));
			
		/*		
		$DATOS_ = array();
		for($j = (count($DATOS) - 1); $j >= 0; $j--){
			$DATOS_[] = $DATOS[$j];
		}*/
		
		
		require('../JSON.php');
		$JSON = new Services_JSON();
			
		echo $JSON->encode($DATOS);
	}
	
?>