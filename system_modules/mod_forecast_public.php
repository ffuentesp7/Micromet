<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<!--  Version: Multiflex-5.4 / Overview                     -->
<!--  Date:    Nov 23, 2010                                 -->
<!--  Design:  www.1234.info                                -->
<!--  Modified:  roaguilar@utalca.cl                        -->
<!--  License: Fully open source without restrictions.      -->
	<head>
		<style>
			body{
				background: #fff;
				font-family: Arial;
			}
			table, td, tr{
				border: 1px solid #eee;
				border-collapse: collapse;
			}
		</style>
		<link type="text/css" href="http://www.citrautalca.cl/eve/js/jquery-ui-1.8.10.custom/css/ui-lightness/jquery-ui-1.8.10.custom.css" rel="stylesheet" />	
		<script type="text/javascript" src="http://www.citrautalca.cl/eve/js/jquery-ui-1.8.10.custom/js/jquery-1.4.4.min.js"></script>
		<script type="text/javascript" src="http://www.citrautalca.cl/eve/js/jquery-ui-1.8.10.custom/js/jquery-ui-1.8.10.custom.min.js"></script>
		<script type="text/javascript" src="http://www.citrautalca.cl/eve/js/jquery-ui-1.8.10.custom/js/jquery.ui.datepicker-es.js"></script>
		<script>
			jQuery(document).ready(function(){
				jQuery( "#forecastdate" ).datepicker({
					dateFormat : "yy-mm-dd",
					showAnim : "blind",
					changeMonth: true,
					changeYear: true
				});
			});
		</script>
	</head>

	<!-- Global IE fix to avoid layout crash when single word size wider than column width -->
	<!-- Following line MUST remain as a comment to have the proper effect -->
	<!--[if IE]><style type="text/css"> body {word-wrap: break-word;}</style><![endif]-->

	<body>
	<div>
	<?php
		$FECHA = date("Y-m-d");
		if(isset($_REQUEST['forecastdate'])){
			$FECHA = $_REQUEST['forecastdate'];
		}
	?>
	<form action="" method="post">
	Fecha: <input type="text" name="forecastdate" id="forecastdate" readonly="true" value="<?=$FECHA?>" style="width: 90px;"/>
	<input type="submit" value="Ver" />
	</form>
<?php
	
	function eve_get_last_forecast(){
	
		require('../funciones.inc.php');
	
		$HTML = '';
		
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
		
		$HTML .= '<table style="width: 100%;">
				<tbody>';
		
		$HTML .= '</tr>';		
		
		if($SQLD = mysqli_fetch_array($SQLR)){
			$HTML.= '<tr>	
					<td colspan="3"><h2>Pron&oacute;stico para el d&iacute;a '.cambia_fecha_a_normal($SQLD[0]).'</h2>por '.$SQLD[26].'</td>
				</tr>';
			
					
			$HTML.='<tr>
					<td rowspan="13" valign="top"><img src="http://www.citrautalca.cl/eve/img/climaicons/big/'.$SQLD[16].'.png"/ class="centernoborder"></td>
					<td colspan="2"><b style="font-size: 26px;">'.utf8_decode($SQLD[15]).'</b></td>
				</tr>';
			
			$HTML.='<tr style="font-size: 14px;">
					<td colspan="2"><b>Datos Meteorol&oacute;gicos:</b></td>
				</tr>';
			$HTML.='<tr style="font-size: 14px;"><td>Temperatura M&iacute;nima:</td><td> '.$SQLD[1].'&deg;C a las '.$SQLD[2].'hrs.</td></tr>
				<tr style="font-size: 14px;"><td>Temperatura M&aacute;xima Ayer:</td><td> '.$SQLD[3].'&deg;C a las '.$SQLD[4].'hrs.</td></tr>
				<tr style="font-size: 14px;"><td>Humedad Relativa del Aire:</td><td> '.$SQLD[5].' &#037;</td></tr>
				<tr style="font-size: 14px;"><td>Presion Atmosf&eacute;rica:</td><td> '.$SQLD[6].' Hectopascales</td></tr>
				<tr style="font-size: 14px;"><td>Evaporaci&oacute;n:</td><td> '.$SQLD[7].' mm.</td></tr>';
			
			$HTML.='<tr style="font-size: 14px;">
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
					<td><img src="http://www.citrautalca.cl/eve/img/climaicons/'.$SQLD[18].'.png"/ class="centernoborder"></td>
					<td colspan="2">
						<p>'.add_days(cambia_fecha_a_normal($SQLD[0]),1).': '.utf8_decode($SQLD[17]).'</p>
					</td>
				</tr>';
			$HTML.='<tr>
					<td><img src="http://www.citrautalca.cl/eve/img/climaicons/'.$SQLD[20].'.png"/ class="centernoborder"></td>
					<td colspan="2">
						<p>'.add_days(cambia_fecha_a_normal($SQLD[0]),2).': '.utf8_decode($SQLD[19]).'</p>
					</td>
				</tr>';
			$HTML.='<tr>
					<td><img src="http://www.citrautalca.cl/eve/img/climaicons/'.$SQLD[22].'.png"/ class="centernoborder"></td>
					<td colspan="2">
						<p>'.add_days(cambia_fecha_a_normal($SQLD[0]),3).': '.utf8_decode($SQLD[21]).'</p>
					</td>
				</tr>';
			$HTML.='<tr>
					<td colspan="3">
						<p>'.utf8_decode($SQLD[23]).'</p>
					</td>
				</tr>';
			
		}
		
		$HTML.= "</tbody></table>";
		
		
		echo $HTML;
	}
	function eve_forecast_by_date($DATE){
	
		require('../funciones.inc.php');
	
		$HTML = '';
		
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
			AND	eve_pronostico.fecha = '$DATE'
			ORDER	BY fecha DESC LIMIT 1";
			
		$SQLR = consulta_sql($SQL);
		
		$HTML .= '<table style="width: 100%;">
				<tbody>';
		
		$HTML .= '</tr>';		
		
		if($SQLD = mysqli_fetch_array($SQLR)){
			$HTML.= '<tr>	
					<td colspan="3"><h2>Pron&oacute;stico para el d&iacute;a '.cambia_fecha_a_normal($SQLD[0]).'</h2>por '.$SQLD[26].'</td>
				</tr>';
			
					
			$HTML.='<tr>
					<td rowspan="13" valign="top"><img src="http://www.citrautalca.cl/eve/img/climaicons/big/'.$SQLD[16].'.png"/ class="centernoborder"></td>
					<td colspan="2"><b style="font-size: 26px;">'.utf8_decode($SQLD[15]).'</b></td>
				</tr>';
			
			$HTML.='<tr style="font-size: 14px;">
					<td colspan="2"><b>Datos Meteorol&oacute;gicos:</b></td>
				</tr>';
			$HTML.='<tr style="font-size: 14px;"><td>Temperatura M&iacute;nima:</td><td> '.$SQLD[1].'&deg;C a las '.$SQLD[2].'hrs.</td></tr>
				<tr style="font-size: 14px;"><td>Temperatura M&aacute;xima Ayer:</td><td> '.$SQLD[3].'&deg;C a las '.$SQLD[4].'hrs.</td></tr>
				<tr style="font-size: 14px;"><td>Humedad Relativa del Aire:</td><td> '.$SQLD[5].' &#037;</td></tr>
				<tr style="font-size: 14px;"><td>Presion Atmosf&eacute;rica:</td><td> '.$SQLD[6].' Hectopascales</td></tr>
				<tr style="font-size: 14px;"><td>Evaporaci&oacute;n:</td><td> '.$SQLD[7].' mm.</td></tr>';
			
			$HTML.='<tr style="font-size: 14px;">
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
					<td><img src="http://www.citrautalca.cl/eve/img/climaicons/'.$SQLD[18].'.png"/ class="centernoborder"></td>
					<td colspan="2">
						<p>'.add_days(cambia_fecha_a_normal($SQLD[0]),1).': '.utf8_decode($SQLD[17]).'</p>
					</td>
				</tr>';
			$HTML.='<tr>
					<td><img src="http://www.citrautalca.cl/eve/img/climaicons/'.$SQLD[20].'.png"/ class="centernoborder"></td>
					<td colspan="2">
						<p>'.add_days(cambia_fecha_a_normal($SQLD[0]),2).': '.utf8_decode($SQLD[19]).'</p>
					</td>
				</tr>';
			$HTML.='<tr>
					<td><img src="http://www.citrautalca.cl/eve/img/climaicons/'.$SQLD[22].'.png"/ class="centernoborder"></td>
					<td colspan="2">
						<p>'.add_days(cambia_fecha_a_normal($SQLD[0]),3).': '.utf8_decode($SQLD[21]).'</p>
					</td>
				</tr>';
			$HTML.='<tr>
					<td colspan="3">
						<p>'.utf8_decode($SQLD[23]).'</p>
					</td>
				</tr>';
			
		}
		
		$HTML.= "</tbody></table>";
		
		
		echo $HTML;
	}
	
	if(isset($_REQUEST['forecastdate'])){
		eve_forecast_by_date($_REQUEST['forecastdate']);
	}
	else{
		eve_get_last_forecast();
	}
?>
	</div>
	</body>
</html>
