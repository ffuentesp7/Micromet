<?php
	require('../aut_verifica.inc.php');
	require_once('../funciones.inc.php');

	$ACCION = $_REQUEST['accion'];
	
	if($ACCION == 'get_list'){
		$HTML = '';
		
		$PERMISO = get_user_permission($_SESSION['session_usuario_id'],'MOD_FORECAST_ADMIN');
		
		if($PERMISO == '1')
			$HTML .= '<a href="mod_forecast_admin.php?sid='.$_GET['sid'].'&page=add">[NUEVO PRONOSTICO]</a>';
		
		$SQL = "SELECT 	id,
				fecha, 
				temp_min, 
				temp_min_hora, 
				temp_max_ayer,
				temp_max_hora, 
				hum_rel_aire, 
				presion_atmosferica, 
				evaporacion, 
				pp_ultima_lluvia, 
				pp_total_a_la_fecha, 
				pp_normal_a_la_fecha, 
				pp_superavit, 
				pp_superavir_porcentaje, 
				pp_deficit, 
				pp_deficit_porcentaje, 
				pronostico_hoy, 
				pronostico_hoy_imagen, 
				pronostico_1_dia, 
				pronostico_1_dia_imagen, 
				pronostico_2_dia, 
				pronostico_2_dia_imagen, 
				pronostico_3_dia, 
				pronostico_3_dia_imagen, 
				observaciones, 
				usuario_id
			FROM	eve_pronostico 
			ORDER	BY fecha DESC, id DESC
			LIMIT	30";
			
		$SQLR = consulta_sql($SQL);
		
		$HTML .= '<table>
				<tbody>
					<tr>
						<th class="top" scope="col">&#035;</th>
						<th class="top" scope="col">Fecha</th>
						<th class="top" scope="col">T&deg; M&iacute;nima</th>
						<th class="top" scope="col">T&deg; M&aacute;xima Ayer</th>
						<th class="top" scope="col">Humedad Relativa del Aire</th>';
		if($PERMISO == '1')
			$HTML .= '		<th class="top" scope="col">Editar</th>
						<th class="top" scope="col">Borrar</th>';
		
		$HTML .= '</tr>';		
		
		while($SQLD = mysqli_fetch_array($SQLR)){
			$HTML.= '<tr id="forecast_'.$SQLD[0].'">
					<td>'.$SQLD[0].'</td>
					<td><a href="mod_forecast_index.php?sid='.$_GET['sid'].'&fid='.$SQLD[0].'">'.cambia_fecha_a_normal($SQLD[1]).'</a></td>
					<td>'.$SQLD[2].'&deg;C</td>
					<td>'.$SQLD[4].'&deg;C</td>
					<td>'.$SQLD[6].'&#037;</td>';
			if($PERMISO == '1')
				$HTML .='	<td><input type="button" class="button" value="Editar" onclick="edit_forecast('.$SQLD[0].')"/></td>
						<td><input type="button" class="button" value="Borrar" onclick="delete_forecast('.$SQLD[0].')"/></td>';
					
			$HTML .='<tr>';
		}
		
		$HTML.= "</tbody></table>";
		
		
		echo $HTML;
		
	}elseif($ACCION == 'insert_forecast'){
		
		require_once('../twitter/twitter.func.php');
		
		$fecha 		= $_REQUEST['fecha'];
		$temp_min 	= $_REQUEST['temp_min'];
		$temp_min_hora 	= $_REQUEST['temp_min_hora'];
		$temp_max_ay 	= $_REQUEST['temp_max_ay'];
		$temp_max_ay_hora = $_REQUEST['temp_max_ay_hora'];
		$humedad 	= $_REQUEST['humedad'];
		$presion 	= $_REQUEST['presion'];
		$evaporacion 	= $_REQUEST['evaporacion'];
		$pp_ultima 	= $_REQUEST['pp_ultima'];
		$pp_total 	= $_REQUEST['pp_total'];
		$pp_normal 	= $_REQUEST['pp_normal'];
		$pp_superavit 	= $_REQUEST['pp_superavit'];
		$pp_superavit_por = $_REQUEST['pp_superavit_por'];
		$pp_deficit 	= $_REQUEST['pp_deficit'];
		$pp_deficit_por = $_REQUEST['pp_deficit_por'];
		$prono 		= $_REQUEST['prono'];
		$prono_clima 	= $_REQUEST['prono_clima'];
		$prono1 	= $_REQUEST['prono1'];
		$prono1_clima 	= $_REQUEST['prono1_clima'];
		$prono2 	= $_REQUEST['prono2'];
		$prono2_clima 	= $_REQUEST['prono2_clima'];
		$prono3 	= $_REQUEST['prono3'];
		$prono3_clima 	= $_REQUEST['prono3_clima'];
		$obser 		= $_REQUEST['obser'];
		
		if($pp_ultima == '')
			$pp_ultima = '-9999';
		
		if($pp_total == '')
			$pp_total = '-9999';
		
		if($pp_normal == '')
			$pp_normal = '-9999';
		
		if($pp_superavit == '')
			$pp_superavit = '-9999';
		
		if($pp_superavit_por == '')
			$pp_superavit_por = '-9999';
		
		if($pp_deficit == '')
			$pp_deficit = '-9999';
		
		if($pp_deficit_por == '')
			$pp_deficit_por = '-9999';
		
		$SQL = "INSERT INTO eve_pronostico (	fecha, 
							temp_min, 
							temp_min_hora, 
							temp_max_ayer,
							temp_max_hora, 
							hum_rel_aire, 
							presion_atmosferica, 
							evaporacion, 
							pp_ultima_lluvia, 
							pp_total_a_la_fecha, 
							pp_normal_a_la_fecha, 
							pp_superavit, 
							pp_superavir_porcentaje, 
							pp_deficit, 
							pp_deficit_porcentaje, 
							pronostico_hoy, 
							pronostico_hoy_imagen, 
							pronostico_1_dia, 
							pronostico_1_dia_imagen, 
							pronostico_2_dia, 
							pronostico_2_dia_imagen, 
							pronostico_3_dia, 
							pronostico_3_dia_imagen, 
							observaciones, 
							usuario_id) 
						VALUES ('$fecha', 
							$temp_min, 
							'$temp_min_hora', 
							$temp_max_ay, 
							'$temp_max_ay_hora', 
							$humedad, 
							$presion, 
							$evaporacion, 
							$pp_ultima, 
							$pp_total, 
							$pp_normal, 
							$pp_superavit, 
							$pp_superavit_por, 
							$pp_deficit, 
							$pp_deficit_por, 
							'$prono', 
							'$prono_clima', 
							'$prono1', 
							'$prono1_clima', 
							'$prono2', 
							'$prono2_clima', 
							'$prono3', 
							'$prono3_clima',
							'$obser',
							".$_SESSION['session_usuario_id'].")";
		//echo $SQL;
		if(comando_sql($SQL)){
			
			$tweet = "Pronóstico para Talca ".cambia_fecha_a_normal($fecha).": ".substr($prono,0,70).'... @Utalca http://goo.gl/rUiGM';
			twitter_save($tweet,$fecha);
			echo 1;
		}
		else{
			echo 0;
		}
	}
	elseif($ACCION == 'update_forecast'){
		
		$fid 		= $_REQUEST['fid'];
		$fecha 		= $_REQUEST['fecha'];
		$temp_min 	= $_REQUEST['temp_min'];
		$temp_min_hora 	= $_REQUEST['temp_min_hora'];
		$temp_max_ay 	= $_REQUEST['temp_max_ay'];
		$temp_max_ay_hora = $_REQUEST['temp_max_ay_hora'];
		$humedad 	= $_REQUEST['humedad'];
		$presion 	= $_REQUEST['presion'];
		$evaporacion 	= $_REQUEST['evaporacion'];
		$pp_ultima 	= $_REQUEST['pp_ultima'];
		$pp_total 	= $_REQUEST['pp_total'];
		$pp_normal 	= $_REQUEST['pp_normal'];
		$pp_superavit 	= $_REQUEST['pp_superavit'];
		$pp_superavit_por = $_REQUEST['pp_superavit_por'];
		$pp_deficit 	= $_REQUEST['pp_deficit'];
		$pp_deficit_por = $_REQUEST['pp_deficit_por'];
		$prono 		= $_REQUEST['prono'];
		$prono_clima 	= $_REQUEST['prono_clima'];
		$prono1 	= $_REQUEST['prono1'];
		$prono1_clima 	= $_REQUEST['prono1_clima'];
		$prono2 	= $_REQUEST['prono2'];
		$prono2_clima 	= $_REQUEST['prono2_clima'];
		$prono3 	= $_REQUEST['prono3'];
		$prono3_clima 	= $_REQUEST['prono3_clima'];
		$obser 		= $_REQUEST['obser'];
		
		if($pp_ultima == '')
			$pp_ultima = '-9999';
		
		if($pp_total == '')
			$pp_total = '-9999';
		
		if($pp_normal == '')
			$pp_normal = '-9999';
		
		if($pp_superavit == '')
			$pp_superavit = '-9999';
		
		if($pp_superavit_por == '')
			$pp_superavit_por = '-9999';
		
		if($pp_deficit == '')
			$pp_deficit = '-9999';
		
		if($pp_deficit_por == '')
			$pp_deficit_por = '-9999';
		
		$SQL = "UPDATE eve_pronostico SET 	fecha = '$fecha',
							temp_min = $temp_min,
							temp_min_hora = '$temp_min_hora',
							temp_max_ayer = $temp_max_ay,
							temp_max_hora = '$temp_max_ay_hora', 
							hum_rel_aire = $humedad, 
							presion_atmosferica = $presion, 
							evaporacion = $evaporacion, 
							pp_ultima_lluvia = $pp_ultima, 
							pp_total_a_la_fecha = $pp_total, 
							pp_normal_a_la_fecha = $pp_normal, 
							pp_superavit = $pp_superavit, 
							pp_superavir_porcentaje = $pp_superavit_por, 
							pp_deficit = $pp_deficit, 
							pp_deficit_porcentaje = $pp_deficit_por, 
							pronostico_hoy = '$prono', 
							pronostico_hoy_imagen = '$prono_clima', 
							pronostico_1_dia = '$prono1', 
							pronostico_1_dia_imagen = '$prono1_clima', 
							pronostico_2_dia = '$prono2', 
							pronostico_2_dia_imagen = '$prono2_clima', 
							pronostico_3_dia = '$prono3', 
							pronostico_3_dia_imagen = '$prono3_clima', 
							observaciones = '$obser' 
						WHERE 	id = $fid";
		//echo $SQL;
		if(comando_sql($SQL)){
			echo 1;
		}
		else{
			echo 0;
		}
		
	}
	elseif($ACCION == 'delete_forecast'){
		
		$fid = $_REQUEST['fid'];
		
		$SQL = "DELETE FROM eve_pronostico WHERE id = $fid";
		//echo $SQL;
		if(comando_sql($SQL)){
			echo 1;
		}
		else{
			echo 0;
		}
		
	}
	elseif($ACCION == 'get_last_forecast'){
	
		$HTML = '';
		
		$PERMISO = get_user_permission($_SESSION['session_usuario_id'],'MOD_FORECAST_ADMIN');
		
		$SQL = "SELECT 	fecha, 
				temp_min, 
				temp_min_hora, 
				temp_max_ayer,
				temp_max_hora, 
				hum_rel_aire, 
				presion_atmosferica, 
				evaporacion, 
				pp_ultima_lluvia, 
				pp_total_a_la_fecha, 
				pp_normal_a_la_fecha, 
				pp_superavit, 
				pp_superavir_porcentaje, 
				pp_deficit, 
				pp_deficit_porcentaje, 
				pronostico_hoy, 
				pronostico_hoy_imagen, 
				pronostico_1_dia, 
				pronostico_1_dia_imagen, 
				pronostico_2_dia, 
				pronostico_2_dia_imagen, 
				pronostico_3_dia, 
				pronostico_3_dia_imagen, 
				observaciones, 
				usuario_id,
				eve_pronostico.id,
				usuario.nombre 
			FROM	eve_pronostico,
				usuario 
			WHERE	usuario_id=usuario.id 
			ORDER	BY fecha DESC LIMIT 1";
			
		$SQLR = consulta_sql($SQL);
		
		$HTML .= '<table style="width: 600px;">
				<tbody>';
		
		$HTML .= '</tr>';		
		
		if($SQLD = mysqli_fetch_array($SQLR)){
			$HTML.= '<tr>	
					<td colspan="3"><h2>Pron&oacute;stico para el d&iacute;a '.cambia_fecha_a_normal($SQLD[0]).'</h2>por '.$SQLD[26].'</td>
				</tr>';
			
					
			$HTML.='<tr>
					<td rowspan="13" valign="top"><img src="../img/climaicons/big/'.$SQLD[16].'.png"/ class="centernoborder"></td>
					<td colspan="2"><b>'.utf8_decode($SQLD[15]).'</b></td>
				</tr>';
			
			$HTML.='<tr>
					<td colspan="2"><b>Datos Meteorol&oacute;gicos:</b></td>
				</tr>';
			$HTML.='<tr><td>Temperatura M&iacute;nima:</td><td> '.$SQLD[1].'&deg;C a las '.$SQLD[2].'hrs.</td></tr>
				<tr><td>Temperatura M&aacute;xima Ayer:</td><td> '.$SQLD[3].'&deg;C a las '.$SQLD[4].'hrs.</td></tr>
				<tr><td>Humedad Relativa del Aire:</td><td> '.$SQLD[5].' &#037;</td></tr>
				<tr><td>Presion Atmosf&eacute;rica:</td><td> '.$SQLD[6].' Hectopascales</td></tr>
				<tr><td>Evaporaci&oacute;n:</td><td> '.$SQLD[7].' mm.</td></tr>';
			
			$HTML.='<tr>
					<td colspan="2"><b>Precipitaciones:</b></td>
				</tr>';
			
			if($SQLD[8] == -9999)
				$SQLD[8] = ' ';
			
			if($SQLD[9] == -9999)
				$SQLD[9] = ' ';
			
			if($SQLD[10] == -9999)
				$SQLD[10] = ' ';
			
			if($SQLD[11] == -9999)
				$SQLD[11] = ' ';
				
			if($SQLD[12] == -9999)
				$SQLD[12] = ' ';
				
			if($SQLD[13] == -9999)
				$SQLD[13] = ' ';
				
			if($SQLD[14] == -9999)
				$SQLD[14] = ' ';
				
			$HTML.='<tr><td>&Uacute;ltima Lluvia: </td><td>'.$SQLD[8].' mm.</td></tr>';
			$HTML.='<tr><td>Total a la fecha: </td><td>'.$SQLD[9].' mm.</td></tr>';
			$HTML.='<tr><td>Normal a la fecha: </td><td>'.$SQLD[10].' mm.</td></tr>';
			$HTML.='<tr><td>Superavit: </td><td>'.$SQLD[11].' mm. eq. al '.$SQLD[12].'&#037;</td></tr>';
			$HTML.='<tr><td>D&eacute;ficit: </td><td>'.$SQLD[13].' mm. eq. al '.$SQLD[14].'&#037;</td></tr>';
			$HTML.='<tr>
					<td colspan="3"><b>Pron&oacute;sticos para los pr&oacute;ximos d&iacute;as:</b></td>
				</tr>';
			$HTML.='<tr>
					<td><img src="../img/climaicons/'.$SQLD[18].'.png"/ class="centernoborder"></td>
					<td colspan="2">
						<p>'.add_days(cambia_fecha_a_normal($SQLD[0]),1).': '.utf8_decode($SQLD[17]).'</p>
					</td>
				</tr>';
			$HTML.='<tr>
					<td><img src="../img/climaicons/'.$SQLD[20].'.png"/ class="centernoborder"></td>
					<td colspan="2">
						<p>'.add_days(cambia_fecha_a_normal($SQLD[0]),2).': '.utf8_decode($SQLD[19]).'</p>
					</td>
				</tr>';
			$HTML.='<tr>
					<td><img src="../img/climaicons/'.$SQLD[22].'.png"/ class="centernoborder"></td>
					<td colspan="2">
						<p>'.add_days(cambia_fecha_a_normal($SQLD[0]),3).': '.utf8_decode($SQLD[21]).'</p>
					</td>
				</tr>';
			$HTML.='<tr>
					<td colspan="3">
						<p>'.utf8_decode($SQLD[23]).'</p>
					</td>
				</tr>';
			if($PERMISO == '1')
				$HTML .='<tr><td colspan="3"><input type="button" class="button" value="Editar" onclick="edit_forecast('.$SQLD[25].')"/></td></tr>';
			
		}
		
		$HTML.= "</tbody></table>";
		
		
		echo $HTML;
		
	}elseif($ACCION == 'get_forecast_by_id'){
	
		$FID = $_REQUEST['fid'];
	
		$HTML = '';
		
		$PERMISO = get_user_permission($_SESSION['session_usuario_id'],'MOD_FORECAST_ADMIN');
		
		$SQL = "SELECT 	fecha, 
				temp_min, 
				temp_min_hora, 
				temp_max_ayer,
				temp_max_hora, 
				hum_rel_aire, 
				presion_atmosferica, 
				evaporacion, 
				pp_ultima_lluvia, 
				pp_total_a_la_fecha, 
				pp_normal_a_la_fecha, 
				pp_superavit, 
				pp_superavir_porcentaje, 
				pp_deficit, 
				pp_deficit_porcentaje, 
				pronostico_hoy, 
				pronostico_hoy_imagen, 
				pronostico_1_dia, 
				pronostico_1_dia_imagen, 
				pronostico_2_dia, 
				pronostico_2_dia_imagen, 
				pronostico_3_dia, 
				pronostico_3_dia_imagen, 
				observaciones, 
				usuario_id,
				usuario.nombre
			FROM	eve_pronostico,
				usuario  
			WHERE 	eve_pronostico.id = $FID 
			AND	usuario_id = usuario.id
			ORDER	BY fecha DESC LIMIT 1";
			
		$SQLR = consulta_sql($SQL);
		
		$HTML .= '<table style="width: 600px;">
				<tbody>';
		
		$HTML .= '</tr>';		
		
		if($SQLD = mysqli_fetch_array($SQLR)){
			$HTML.= '<tr>	
					<td colspan="3"><h2>Pron&oacute;stico para el d&iacute;a '.cambia_fecha_a_normal($SQLD[0]).'</h2> por '.$SQLD[25].'</td>
				</tr>';
			
					
			$HTML.='<tr>
					<td rowspan="13" valign="top"><img src="../img/climaicons/big/'.$SQLD[16].'.png"/ class="centernoborder"></td>
					<td colspan="2"><b>'.utf8_decode($SQLD[15]).'</b></td>
				</tr>';
			
			$HTML.='<tr>
					<td colspan="2"><b>Datos Meteorol&oacute;gicos:</b></td>
				</tr>';
			$HTML.='<tr><td>Temperatura M&iacute;nima:</td><td> '.$SQLD[1].'&deg;C a las '.$SQLD[2].'hrs.</td></tr>
				<tr><td>Temperatura M&aacute;xima Ayer:</td><td> '.$SQLD[3].'&deg;C a las '.$SQLD[4].'hrs.</td></tr>
				<tr><td>Humedad Relativa del Aire:</td><td> '.$SQLD[5].' &#037;</td></tr>
				<tr><td>Presion Atmosf&eacute;rica:</td><td> '.$SQLD[6].' Hectopascales</td></tr>
				<tr><td>Evaporaci&oacute;n:</td><td> '.$SQLD[7].' mm.</td></tr>';
			
			$HTML.='<tr>
					<td colspan="2"><b>Precipitaciones:</b></td>
				</tr>';
			if($SQLD[8] == -9999)
				$SQLD[8] = ' ';
			
			if($SQLD[9] == -9999)
				$SQLD[9] = ' ';
			
			if($SQLD[10] == -9999)
				$SQLD[10] = ' ';
			
			if($SQLD[11] == -9999)
				$SQLD[11] = ' ';
				
			if($SQLD[12] == -9999)
				$SQLD[12] = ' ';
				
			if($SQLD[13] == -9999)
				$SQLD[13] = ' ';
				
			if($SQLD[14] == -9999)
				$SQLD[14] = ' ';
			$HTML.='<tr><td>&Uacute;ltima Lluvia: </td><td>'.$SQLD[8].' mm.</td></tr>';
			$HTML.='<tr><td>Total a la fecha: </td><td>'.$SQLD[9].' mm.</td></tr>';
			$HTML.='<tr><td>Normal a la fecha: </td><td>'.$SQLD[10].' mm.</td></tr>';
			$HTML.='<tr><td>Superavit: </td><td>'.$SQLD[11].' mm. eq. al '.$SQLD[12].'&#037;</td></tr>';
			$HTML.='<tr><td>D&eacute;ficit: </td><td>'.$SQLD[13].' mm. eq. al '.$SQLD[14].'&#037;</td></tr>';
			$HTML.='<tr>
					<td colspan="3"><b>Pron&oacute;sticos para los pr&oacute;ximos d&iacute;as:</b></td>
				</tr>';
			$HTML.='<tr>
					<td><img src="../img/climaicons/'.$SQLD[18].'.png"/ class="centernoborder"></td>
					<td colspan="2">
						<p>'.add_days(cambia_fecha_a_normal($SQLD[0]),1).': '.utf8_decode($SQLD[17]).'</p>
					</td>
				</tr>';
			$HTML.='<tr>
					<td><img src="../img/climaicons/'.$SQLD[20].'.png"/ class="centernoborder"></td>
					<td colspan="2">
						<p>'.add_days(cambia_fecha_a_normal($SQLD[0]),2).': '.utf8_decode($SQLD[19]).'</p>
					</td>
				</tr>';
			$HTML.='<tr>
					<td><img src="../img/climaicons/'.$SQLD[22].'.png"/ class="centernoborder"></td>
					<td colspan="2">
						<p>'.add_days(cambia_fecha_a_normal($SQLD[0]),3).': '.utf8_decode($SQLD[21]).'</p>
					</td>
				</tr>';
			$HTML.='<tr>
					<td colspan="3">
						<p>'.utf8_decode($SQLD[23]).'</p>
					</td>
				</tr>';
				
			if($PERMISO == '1')
				$HTML .='<tr><td colspan="3"><input type="button" class="button" value="Editar" onclick="edit_forecast('.$FID.')"/></td></tr>';
			
		}
		
		$HTML.= "</tbody></table>";
		
		
		echo $HTML;
		
	}elseif($ACCION == 'get_forecast_by_date'){
	
		$DATE = $_REQUEST['date'];
	
		$HTML = '';
		
		$PERMISO = get_user_permission($_SESSION['session_usuario_id'],'MOD_FORECAST_ADMIN');
		
		$SQL = "SELECT 	fecha, 
				temp_min, 
				temp_min_hora, 
				temp_max_ayer,
				temp_max_hora, 
				hum_rel_aire, 
				presion_atmosferica, 
				evaporacion, 
				pp_ultima_lluvia, 
				pp_total_a_la_fecha, 
				pp_normal_a_la_fecha, 
				pp_superavit, 
				pp_superavir_porcentaje, 
				pp_deficit, 
				pp_deficit_porcentaje, 
				pronostico_hoy, 
				pronostico_hoy_imagen, 
				pronostico_1_dia, 
				pronostico_1_dia_imagen, 
				pronostico_2_dia, 
				pronostico_2_dia_imagen, 
				pronostico_3_dia, 
				pronostico_3_dia_imagen, 
				observaciones, 
				usuario_id,
				usuario.nombre,
				eve_pronostico.id
			FROM	eve_pronostico,
				usuario  
			WHERE 	eve_pronostico.fecha = '$DATE' 
			AND	usuario_id = usuario.id
			ORDER	BY fecha DESC LIMIT 1";
			
		$SQLR = consulta_sql($SQL);
		
		$HTML .= '<table style="width: 600px;">
				<tbody>';
		
		$HTML .= '</tr>';		
		
		if($SQLD = mysqli_fetch_array($SQLR)){
			$HTML.= '<tr>	
					<td colspan="3"><h2>Pron&oacute;stico para el d&iacute;a '.cambia_fecha_a_normal($SQLD[0]).'</h2> por '.$SQLD[25].'</td>
				</tr>';
			
					
			$HTML.='<tr>
					<td rowspan="13" valign="top"><img src="../img/climaicons/big/'.$SQLD[16].'.png"/ class="centernoborder"></td>
					<td colspan="2"><b>'.utf8_decode($SQLD[15]).'</b></td>
				</tr>';
			
			$HTML.='<tr>
					<td colspan="2"><b>Datos Meteorol&oacute;gicos:</b></td>
				</tr>';
			$HTML.='<tr><td>Temperatura M&iacute;nima:</td><td> '.$SQLD[1].'&deg;C a las '.$SQLD[2].'hrs.</td></tr>
				<tr><td>Temperatura M&aacute;xima Ayer:</td><td> '.$SQLD[3].'&deg;C a las '.$SQLD[4].'hrs.</td></tr>
				<tr><td>Humedad Relativa del Aire:</td><td> '.$SQLD[5].' &#037;</td></tr>
				<tr><td>Presion Atmosf&eacute;rica:</td><td> '.$SQLD[6].' Hectopascales</td></tr>
				<tr><td>Evaporaci&oacute;n:</td><td> '.$SQLD[7].' mm.</td></tr>';
			
			$HTML.='<tr>
					<td colspan="2"><b>Precipitaciones:</b></td>
				</tr>';
			if($SQLD[8] == -9999)
				$SQLD[8] = ' ';
			
			if($SQLD[9] == -9999)
				$SQLD[9] = ' ';
			
			if($SQLD[10] == -9999)
				$SQLD[10] = ' ';
			
			if($SQLD[11] == -9999)
				$SQLD[11] = ' ';
				
			if($SQLD[12] == -9999)
				$SQLD[12] = ' ';
				
			if($SQLD[13] == -9999)
				$SQLD[13] = ' ';
				
			if($SQLD[14] == -9999)
				$SQLD[14] = ' ';

			$HTML.='<tr><td>&Uacute;ltima Lluvia: </td><td>'.$SQLD[8].' mm.</td></tr>';
			$HTML.='<tr><td>Total a la fecha: </td><td>'.$SQLD[9].' mm.</td></tr>';
			$HTML.='<tr><td>Normal a la fecha: </td><td>'.$SQLD[10].' mm.</td></tr>';
			$HTML.='<tr><td>Superavit: </td><td>'.$SQLD[11].' mm. eq. al '.$SQLD[12].'&#037;</td></tr>';
			$HTML.='<tr><td>D&eacute;ficit: </td><td>'.$SQLD[13].' mm. eq. al '.$SQLD[14].'&#037;</td></tr>';
			
			$HTML.='<tr>
					<td colspan="3"><b>Pron&oacute;sticos para los pr&oacute;ximos d&iacute;as:</b></td>
				</tr>';
			$HTML.='<tr>
					<td><img src="../img/climaicons/'.$SQLD[18].'.png"/ class="centernoborder"></td>
					<td colspan="2">
						<p>'.add_days(cambia_fecha_a_normal($SQLD[0]),1).': '.utf8_decode($SQLD[17]).'</p>
					</td>
				</tr>';
			$HTML.='<tr>
					<td><img src="../img/climaicons/'.$SQLD[20].'.png"/ class="centernoborder"></td>
					<td colspan="2">
						<p>'.add_days(cambia_fecha_a_normal($SQLD[0]),2).': '.utf8_decode($SQLD[19]).'</p>
					</td>
				</tr>';
			$HTML.='<tr>
					<td><img src="../img/climaicons/'.$SQLD[22].'.png"/ class="centernoborder"></td>
					<td colspan="2">
						<p>'.add_days(cambia_fecha_a_normal($SQLD[0]),3).': '.utf8_decode($SQLD[21]).'</p>
					</td>
				</tr>';
			$HTML.='<tr>
					<td colspan="3">
						<p>'.utf8_decode($SQLD[23]).'</p>
					</td>
				</tr>';
				
			if($PERMISO == '1')
				$HTML .='<tr><td colspan="3"><input type="button" class="button" value="Editar" onclick="edit_forecast('.$SQLD[26].')"/></td></tr>';
			
		}
		
		$HTML.= "</tbody></table>";
		
		
		echo $HTML;
		
	}
	
?>