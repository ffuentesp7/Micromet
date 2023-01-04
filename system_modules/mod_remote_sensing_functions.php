<?php
	require('../aut_verifica.inc.php');
	require_once('../funciones.inc.php');
	require('mod_remote_sensing/phenology.inc.php');

	$ACCION = $_REQUEST['accion'];
	$EToMODELID = 1;
	//set_time_limit ( 120 );
	if($ACCION == 'get_data_from_latlon'){
		
		$TABLE = $_REQUEST['table'];
		$COL = $_REQUEST['col'];
		$LAT = 0;//$_REQUEST['lat'];
		$LON = 0;//$_REQUEST['lon'];
		$ETo = $_REQUEST['eto'];
		$ESP = $_REQUEST['especie'];
		
		$COLS = '';
		
		foreach ($PHENOLOGY as $ESPECIE => $VALUE){
			foreach ($VALUE as $FEN => $FENVAL){
				$COLS.= ', '.$FENVAL['columna'];
			}
		}
		
		
		$SQL = "SELECT lat, lon $COLS, ABS( $LAT - lat ) AS dlat, ABS( $LON - lon ) AS dlon
			FROM (
			
			SELECT lat, lon $COLS, ABS( $LAT - lat ) AS dlat, ABS( $LON - lon ) AS dlon
			FROM $TABLE
			WHERE lat >= $LAT
			AND lon >= $LON
			ORDER BY lat, lon
			LIMIT 3	) AS t
			
			UNION ALL (
			
			SELECT lat, lon $COLS, ABS( $LAT - lat ) AS dlat, ABS( $LON - lon ) AS dlon
			FROM $TABLE
			WHERE lat < $LAT
			AND lon < $LON
			ORDER BY lat DESC , lon DESC 
			LIMIT 3 )
			ORDER BY dlat, dlon
			LIMIT 1";
		//echo $SQL;
		$rdata = consulta_sql_jsat($SQL);
		
		$HTML = "";
			
		if($data = mysqli_fetch_array($rdata)){
			$HTML.= "Evapotranspiraci&oacute;n: ".number_format($data[$COL]*$ETo, 2, '.', '')." mm/d&iacute;a<br/>Kc: ".number_format($data[$COL]*1.0, 2, '.', '')."||";
			$HTML.='<table id="tabla_datos" class="mediagrove" style="width: 300px;">';
			$HTML.="<tr>";
			$HTML.="<th>Latitud:</th><td>".$data['lat']."</td>";
			$HTML.="</tr>";
			$HTML.="<tr>";
			$HTML.="<th>Longitud:</th><td>".$data['lon']."</td>";
			$HTML.="</tr>";
			$HTML.="<tr>";
			$HTML.="<th>Evapotranspiraci&oacute;n Real:</th><td>".number_format($data[$COL]*$ETo, 2, '.', '')." mm/d&iacute;a</td>";
			$HTML.="</tr>";
			$HTML.="<tr>";
			$HTML.="<th>Kc:</th><td>".number_format($data[$COL]*1.0, 2, '.', '')."</td>";
			$HTML.="</tr>";
			$HTML.="</table>||";
			
			$HTML.='<table id="tabla_fenologia" class="mediagrove" style="width: 300px;">';
			$HTML.="<tr>";
			$HTML.="<th colspan='3'><p>$ESP</p></th>";
			$HTML.="</tr>";
			$HTML.="<tr>";
			$HTML.="<th>Fenolog&iacute;a</th><th>Kc</th><th>Imagen</th>";
			$HTML.="</tr>";
			$HTML.="<tr>";
			foreach ($PHENOLOGY as $ESPECIE => $VALUE){
				foreach ($VALUE as $FEN => $FENVAL){
					if($FENVAL['columna'] == $COL){
						$HTML.="<tr class='odd4'>";
						$HTML.="<th><b>$FEN:</b></th><td><b>".number_format($data[$FENVAL['columna']], 2, '.', '')."</b></td>";
						$HTML.="<td><a href='".$FENVAL['imagen_full']."' title='$FEN' class='thickbox'><img width='50px' height='50px' src='".$FENVAL['imagen_small']."'/></a></td>";
						$HTML.="</tr>";
						$HTML.="<tr>";
					}
					else{
						$HTML.="<tr>";
						$HTML.="<th>$FEN:</th><td>".number_format($data[$FENVAL['columna']], 2, '.', '')."</td>";
						$HTML.="<td><a href='".$FENVAL['imagen_full']."' title='$FEN' class='thickbox'><img width='50px' height='50px' src='".$FENVAL['imagen_small']."'/></a></td>";
						$HTML.="</tr>";
						$HTML.="<tr>";
					}
				}
			}
			$HTML.="</table>||".number_format($data[$COL]*1.0, 2, '.', '');
		}
		
		echo $HTML;
		
	}
	elseif($ACCION == 'get_data_from_latlon_for_graph'){
		
		$TABLE = $_REQUEST['table'];
		$COL = $_REQUEST['col'];
		$LAT = 0;//$_REQUEST['lat'];
		$LON = 0;//$_REQUEST['lon'];
		$ETo = $_REQUEST['eto'];
		$ESP = $_REQUEST['especie'];
		
		$COLS = '';
		
		foreach ($PHENOLOGY as $ESPECIE => $VALUE){
			foreach ($VALUE as $FEN => $FENVAL){
				$COLS.= ', '.$FENVAL['columna'];
			}
		}
		
		
		$SQL = "SELECT lat, lon $COLS, ABS( $LAT - lat ) AS dlat, ABS( $LON - lon ) AS dlon
			FROM (
			
			SELECT lat, lon $COLS, ABS( $LAT - lat ) AS dlat, ABS( $LON - lon ) AS dlon
			FROM $TABLE
			WHERE lat >= $LAT
			AND lon >= $LON
			ORDER BY lat, lon
			LIMIT 3	) AS t
			
			UNION ALL (
			
			SELECT lat, lon $COLS, ABS( $LAT - lat ) AS dlat, ABS( $LON - lon ) AS dlon
			FROM $TABLE
			WHERE lat < $LAT
			AND lon < $LON
			ORDER BY lat DESC , lon DESC 
			LIMIT 3 )
			ORDER BY dlat, dlon
			LIMIT 1";
		
		$rdata = consulta_sql_jsat($SQL);
		
		$HTML = "";
			
		if($data = mysqli_fetch_array($rdata)){
			foreach ($PHENOLOGY as $ESPECIE => $VALUE){
				foreach ($VALUE as $FEN => $FENVAL){
					if($FENVAL['columna'] == $COL){
						$HTML.="<tr class='odd4'>";
						$HTML.="<th><b>$FEN:</b></th><td><b>".number_format($data[$FENVAL['columna']], 2, '.', '')."</b></td>";
						$HTML.="<td><a href='".$FENVAL['imagen_full']."' title='$FEN' class='thickbox'><img width='50px' height='50px' src='".$FENVAL['imagen_small']."'/></a></td>";
						$HTML.="</tr>";
						$HTML.="<tr>";
					}
					else{
						$HTML.="<tr>";
						$HTML.="<th>$FEN:</th><td>".number_format($data[$FENVAL['columna']], 2, '.', '')."</td>";
						$HTML.="<td><a href='".$FENVAL['imagen_full']."' title='$FEN' class='thickbox'><img width='50px' height='50px' src='".$FENVAL['imagen_small']."'/></a></td>";
						$HTML.="</tr>";
						$HTML.="<tr>";
					}
				}
			}
			$HTML.="</table>";
		}
		
		echo $HTML;
		
	}
	elseif($ACCION == 'upload_kmz'){
		$archivo 	= $_FILES["kmz"]["tmp_name"]; 
		$tamanio 	= $_FILES["kmz"]["size"];
		$tipo_archivo   = $_FILES["kmz"]["type"];
		$nombre  	= $_FILES["kmz"]["name"];
		
		$tipo		= $_REQUEST["tipo"];
		$fecha		= $_REQUEST["fecha"];
		$tabla		= $_REQUEST["tabla"];
		
		$status = "";
		
		$destino = 'mod_remote_sensing/kmz/'.$nombre;
		
		if ($archivo != "") {
			if (copy($_FILES['kmz']['tmp_name'],$destino)) {
				
				$SQL = "INSERT INTO `JSATImages` (`fecha`, `tipo`, `tabla`, `kmz`) VALUES ('$fecha', '$tipo', '$tabla', '$nombre')";
				
				if(consulta_sql_jsat($SQL)){
					$status = "0";
				}
				else{
					$status = "1";
				}
				
			} else {
				$status = "2";
			}
		} else {
			$status = "3";
		}
		
		header("Location: mod_remote_sensing_admin.php?sid=".$_SESSION['session_nombre_sesion']."&status=".$status);
		
	}
	elseif($ACCION == 'get_image_type'){
		$fecha = $_REQUEST['fecha'];
		
		$SQL = "SELECT tipo, tabla, kmz FROM JSATImages WHERE fecha = '$fecha'";
		
		$RDATA = consulta_sql_jsat($SQL);
		
		$HTML = "";
		
		while($DATA = mysqli_fetch_array($RDATA)){
			$HTML.="<option value='".$DATA[0]."|$fecha|".$DATA[1]."|".$DATA[2]."''>".$DATA[0]."</option>";
		}
		echo $HTML;
	}
	elseif($ACCION == 'get_daily_eto'){
		$fecha = $_REQUEST['fecha'];
		$eid = $_REQUEST['eid'];
		
		
		$SQL = "SELECT valor
				FROM modelo_procesado_estacion
				WHERE 	fecha = '$fecha'
				AND 	estacion_has_modelo_id_estacion=$eid
				AND 	estacion_has_modelo_id_tipo_modelo=$EToMODELID ";
		
		$RDATA = consulta_sql($SQL);
		
		$HTML = "No existe ETo para este d&iacute;a";
		
		while($DATA = mysqli_fetch_array($RDATA)){
			$HTML=number_format($DATA[0], 1, '.', '');
		}
		echo $HTML;
	}
	elseif($ACCION == 'json_kc_graph'){
		
		$TABLE = $_REQUEST['table'];
		$COL = $_REQUEST['col'];
		$LAT = $_REQUEST['lat'];
		$LON = $_REQUEST['lon'];
		
		$FECHA_ACTUAL = date('Y-m-d');
		$ANIO_ACTUAL = date('Y');
		$MES_ACTUAL = date('m');
		$ANIO_ANTERIOR = $ANIO_ACTUAL - 1;
		
		$COLS = '';
		$PREP_DATA = array(); 
		foreach ($PHENOLOGY as $ESPECIE => $VALUE){
			foreach ($VALUE as $FEN => $FENVAL){
				$COLS.= ', '.$FENVAL['columna'];				
				
				$MESX = explode('-',$FENVAL['inicio']);
				
				$PREP_DATA[] = array(get_month_in_words($MESX[0]),0,$FENVAL['kc']);
			}
		}
		
			$SQL = "SELECT lat, lon $COLS, ABS( $LAT - lat ) AS dlat, ABS( $LON - lon ) AS dlon
			FROM (
			
			SELECT lat, lon $COLS, ABS( $LAT - lat ) AS dlat, ABS( $LON - lon ) AS dlon
			FROM $TABLE
			WHERE lat >= $LAT
			AND lon >= $LON
			ORDER BY lat, lon
			LIMIT 3	) AS t
			
			UNION ALL (
			
			SELECT lat, lon $COLS, ABS( $LAT - lat ) AS dlat, ABS( $LON - lon ) AS dlon
			FROM $TABLE
			WHERE lat < $LAT
			AND lon < $LON
			ORDER BY lat DESC , lon DESC 
			LIMIT 3 )
			ORDER BY dlat, dlon
			LIMIT 1";
				
			$result_medicion = consulta_sql_jsat($SQL);
			
			while($datos_medicion = mysqli_fetch_array($result_medicion)){
				for($i = 0; $i < count($PHENOLOGY['Vid Vinifera']); $i++){
					$PREP_DATA[$i][1] = number_format($datos_medicion[$i+2], 2, ".", "");
				}
			}
						
			require('../JSON.php');
			$JSON = new Services_JSON();
				
			echo $JSON->encode($PREP_DATA);
	}elseif($ACCION == 'get_cropsectors_table'){
		$UID = $_SESSION['session_usuario_id'];
		$NOCROPS = true;
		
		$SQL = "SELECT
						id,
						cuartel,
						cultivo,
						variedad 
				FROM 	eve_mod_remote_sensing_cropsector
				WHERE 	usuario_id=$UID
				ORDER BY cuartel";
				
		$SQLR = consulta_sql($SQL);
		$HTML = "<table class='mediagrove'>
					<thead>
						<tr>
							<th>Cuartel</th>
							<th>Cultivo</th>
							<th>Variedad</th>
							<th>Editar</th>
							<th>Borrar</th>
						</tr>
					</thead>
					<tbody>";
		while($SQLD = mysqli_fetch_array($SQLR)){
			$HTML .= "<tr>
						<td>".$SQLD['cuartel']."</td>
						<td>".$SQLD['cultivo']."</td>
						<td>".$SQLD['variedad']."</td>
						<td><input class='button' type='button' value='Editar' onclick='set_cropsector_to_edit(".$SQLD['id'].")'/></td>
						<td><input class='button' type='button' value='Borrar' onclick='delete_cropsector(".$SQLD['id'].")'/></td>
					</tr>";
			$NOCROPS = false;
		}
		if($NOCROPS){
			$HTML .= "<tr>
						<td colspan='5'>A&uacute;n no existen cuarteles, presione \"Nueva Configuraci&oacute;n de Cuartel\" para agregar uno.</td>
					</tr>";
		}
		
		$HTML .= "</tbody>
					</table>";
					
		echo $HTML;			
	}
	elseif($ACCION == "save_cropsector"){
		
		$UID = $_SESSION['session_usuario_id'];
		
		$cuartel_nombre = $_REQUEST['cuartel_nombre'];
		$cultivo_nombre = $_REQUEST['cultivo_nombre'];
		$variedad_nombre = $_REQUEST['variedad_nombre'];
		
		$cropsector_id = $_REQUEST['cropsector_id'];
		
		$dist_en_ileras = ($_REQUEST['dist_en_ileras'] == '' ? 0 : $_REQUEST['dist_en_ileras']);
		$dist_so_ileras = ($_REQUEST['dist_so_ileras'] == '' ? 0 : $_REQUEST['dist_so_ileras']);
		$crit_riego = ($_REQUEST['crit_riego'] == '' ? 0 : $_REQUEST['crit_riego']);
		$estr1_textura = ($_REQUEST['estr1_textura'] == '' ? '' : $_REQUEST['estr1_textura']);
		$estr1_grosor = ($_REQUEST['estr1_grosor'] == '' ? 0 : $_REQUEST['estr1_grosor']);
		$estr1_cc = ($_REQUEST['estr1_cc'] == '' ? 0 : $_REQUEST['estr1_cc']);
		$estr1_pmp = ($_REQUEST['estr1_pmp'] == '' ? 0 : $_REQUEST['estr1_pmp']);	
		$estr2_textura = ($_REQUEST['estr2_textura'] == '' ? '' : $_REQUEST['estr2_textura']);
		$estr2_grosor = ($_REQUEST['estr2_grosor'] == '' ? 0 : $_REQUEST['estr2_grosor']);
		$estr2_cc = ($_REQUEST['estr2_cc'] == '' ? 0 : $_REQUEST['estr2_cc']);
		$estr2_pmp = ($_REQUEST['estr2_pmp'] == '' ? 0 : $_REQUEST['estr2_pmp']);
		$estr3_textura = ($_REQUEST['estr3_textura'] == '' ? '' : $_REQUEST['estr3_textura']);
		$estr3_grosor = ($_REQUEST['estr3_grosor'] == '' ? 0 : $_REQUEST['estr3_grosor']);
		$estr3_cc = ($_REQUEST['estr3_cc'] == '' ? 0 : $_REQUEST['estr3_cc']);
		$estr3_pmp = ($_REQUEST['estr3_pmp'] == '' ? 0 : $_REQUEST['estr3_pmp']);
		$ancho_moj = ($_REQUEST['ancho_moj'] == '' ? 0 : $_REQUEST['ancho_moj']);
		$caud_emis = ($_REQUEST['caud_emis'] == '' ? 0 : $_REQUEST['caud_emis']);
		$num_emis_planta = ($_REQUEST['num_emis_planta'] == '' ? 0 : $_REQUEST['num_emis_planta']);
		$efis_riego = ($_REQUEST['efis_riego'] == '' ? 0 : $_REQUEST['efis_riego']);
		$coef_unif = ($_REQUEST['coef_unif'] == '' ? 0 : $_REQUEST['coef_unif']);
		
		$SQL = "UPDATE eve_mod_remote_sensing_cropsector SET
					cuartel='$cuartel_nombre',
					cultivo='$cultivo_nombre',
					variedad='$variedad_nombre',
					dist_entre_hileras=$dist_en_ileras,
					dist_sobre_hileras=$dist_so_ileras,
					criterio_riego=$crit_riego,
					estrata_1_grosor=$estr1_grosor,
					estrata_1_textura='$estr1_textura',
					estrata_1_cc=$estr1_cc,
					estrata_1_pmp=$estr1_pmp,
					estrata_2_grosor=$estr2_grosor,
					estrata_2_textura='$estr2_textura',
					estrata_2_cc=$estr2_cc,
					estrata_2_pmp=$estr2_pmp,
					estrata_3_grosor=$estr3_grosor,
					estrata_3_textura='$estr3_textura',
					estrata_3_cc=$estr3_cc,
					estrata_3_pmp=$estr3_pmp,
					ancho_mojado=$ancho_moj,
					caudal_emisor=$caud_emis,
					numero_emisores_por_planta=$num_emis_planta,
					eficiencia_riego=$efis_riego,
					coeficiente_uniformidad=$coef_unif
				WHERE id=$cropsector_id";
						
		if($cropsector_id == 0){
			$SQL = "INSERT INTO eve_mod_remote_sensing_cropsector (
			usuario_id,
			cuartel,
			cultivo,
			variedad,
			dist_entre_hileras,
			dist_sobre_hileras,
			criterio_riego,
			estrata_1_grosor,
			estrata_1_textura,
			estrata_1_cc,
			estrata_1_pmp,
			estrata_2_grosor,
			estrata_2_textura,
			estrata_2_cc,
			estrata_2_pmp,
			estrata_3_grosor,
			estrata_3_textura,
			estrata_3_cc,
			estrata_3_pmp,
			ancho_mojado,
			caudal_emisor,
			numero_emisores_por_planta,
			eficiencia_riego,
			coeficiente_uniformidad)
		VALUES (
			$UID,
			'$cuartel_nombre',
			'$cultivo_nombre',
			'$variedad_nombre',
			$dist_en_ileras,
			$dist_so_ileras,
			$crit_riego,
			$estr1_grosor,
			'$estr1_textura',
			$estr1_cc,
			$estr1_pmp,
			$estr2_grosor,
			'$estr2_textura',
			$estr2_cc,
			$estr2_pmp,
			$estr3_grosor,
			'$estr3_textura',
			$estr3_cc,
			$estr3_pmp,
			$ancho_moj,
			$caud_emis,
			$num_emis_planta,
			$efis_riego,
			$coef_unif)";
		}
		echo comando_sql($SQL);
		
	}elseif($ACCION == "set_cropsector_to_edit"){
		require('Cuartel.class.php');
		$cid = $_REQUEST['cid'];
		
		$CUARTEL = new Cuartel($cid);
		
		$HTML = $CUARTEL->cuartel_nombre.'||';
		$HTML .= $CUARTEL->cultivo_nombre.'||';
		$HTML .= $CUARTEL->variedad_nombre.'||';
			  
		$HTML .= $CUARTEL->dist_en_ileras.'||';
		$HTML .= $CUARTEL->dist_so_ileras.'||';
		$HTML .= $CUARTEL->crit_riego.'||';
		$HTML .= $CUARTEL->estr1_textura.'||';
		$HTML .= $CUARTEL->estr1_grosor.'||';
		$HTML .= $CUARTEL->estr1_cc.'||';
		$HTML .= $CUARTEL->estr1_pmp.'||';	
		$HTML .= $CUARTEL->estr2_textura.'||';
		$HTML .= $CUARTEL->estr2_grosor.'||';
		$HTML .= $CUARTEL->estr2_cc.'||';
		$HTML .= $CUARTEL->estr2_pmp.'||';
		$HTML .= $CUARTEL->estr3_textura.'||';
		$HTML .= $CUARTEL->estr3_grosor.'||';
		$HTML .= $CUARTEL->estr3_cc.'||';
		$HTML .= $CUARTEL->estr3_pmp.'||';
		$HTML .= $CUARTEL->ancho_moj.'||';
		$HTML .= $CUARTEL->caud_emis.'||';
		$HTML .= $CUARTEL->num_emis_planta.'||';
		$HTML .= $CUARTEL->efis_riego.'||';
		$HTML .= $CUARTEL->coef_unif.'||';
		
		echo $HTML;
		
	}elseif($ACCION == "delete_cropsector"){
		$UID = $_SESSION['session_usuario_id'];
		$cropsector_id = $_REQUEST['cid'];
		
		$SQL = "DELETE FROM eve_mod_remote_sensing_cropsector 
					WHERE id = $cropsector_id
					AND usuario_id=$UID";
		echo comando_sql($SQL);
	}
?>
