<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	require('../system/functions/statistic.functions.php');
	estadisticas('WEB','PAGE_VIEW');
	estadisticas('USER_USE','MOD_REMOTE_SENSING');
	require('mod_remote_sensing/phenology.inc.php');
?>

<!DOCTYPE HTML>
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<!--  Version: Multiflex-5.4 / Overview                     -->
<!--  Date:    Nov 23, 2010                                 -->
<!--  Design:  www.1234.info                                -->
<!--  Modified:  roaguilar@utalca.cl                        -->
<!--  License: Fully open source without restrictions.      -->
	<head>
  		<meta http-equiv="content-type" content="text/html; charset=iso 8859-2" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="expires" content="3600" />
		<meta name="revisit-after" content="2 days" />
		<meta name="robots" content="index,follow" />
		
		<meta name="copyright" content="Micromet - Biovisión" />
		
		<meta name="distribution" content="global" />
		<meta name="description" content="Micromet" />
		<meta name="keywords" content="vizualizaci�n, agua, agricultura, agroclimatolog�a, climatolog�a" />
		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="../css/mf54_reset.css" />
  		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="../css/mf54_grid_nosidebar.css" />
		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="../css/mf54_content_nosidebar.css" />
		<link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
		<?php require_once('../head.link.script.php'); ?>
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<script src="js/mod_remote_sensing.js" type="text/javascript"></script>
		<title>Micromet - Biovision</title>
		
		<script type="text/javascript">
			$(document).ready(function(e){
				get_cropsector_table();
				
			});
     
			function toggle_new_cropsector(){
				$('#nuevo_cuartel_tables').toggle('slow');
				set_fields_to_new_cropsector();
			}
		</script>
		<script type="text/javascript" src="js/mod_remote_sensing.js"></script>
	</head>

<!-- Global IE fix to avoid layout crash when single word size wider than column width -->
<!-- Following line MUST remain as a comment to have the proper effect -->
<!--[if IE]><style type="text/css"> body {word-wrap: break-word;}</style><![endif]-->

	<body>
		<!-- CONTAINER FOR ENTIRE PAGE -->
		<div class="container">

    			 <!-- B. NAVIGATION BAR -->
			 <?php require('../system/navigation_bar.inc.php'); ?>   
  
			<!-- C. MAIN SECTION -->      
			<div class="main">

				<!-- C.1 CONTENT -->
				<div class="content">
					 <!-- CONTENT CELL -->                
					<a id="anchor-heading-1"></a>
					<div class="corner-content-1col-top"></div>                      						                     
					<div class="content-1col-nobox">
						<h1 class="webtemplate" id="top_title">Cultivos y Cuarteles</h1>
						<span id="tabla_cuarteles"></span>
						<p><a href="#" onclick="toggle_new_cropsector()">Nueva Configuraci&oacute;n de Cuartel</a></p>
						<span style="display: none" id="nuevo_cuartel_tables">
							<table class="mediagrove">
								<thead>
									<tr>
										<th colspan="2">
											Propiedades del Cuartel
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><p>Cuartel:&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_nombre" name="cuartel_nombre"/></td>
									</tr>
									<tr>
										<td><p>Cultivo:&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cultivo_nombre" name="cultivo_nombre"/></td>
									</tr>
									<tr>
										<td><p>Variedad:&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="variedad_nombre" name="variedad_nombre"/></td>
									</tr>
									<tr>
										<td><p>Distancia Entre Hileras (m):&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_dist_en_ileras" name="cuartel_dist_en_ileras" value="4"/></td>
									</tr>
									<tr>
										<td><p>Distancia Sobre Hileras (m):&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_dist_so_ileras" name="cuartel_dist_so_ileras" value="2"/></td>
									</tr>
									<tr>
										<td><p>Criterio de Riego (&#037;) (Min 15%):&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_crit_riego" name="cuartel_crit_riego" value="20"/></td>
									</tr>
								</tbody>
							</table>
							<table class="mediagrove">
								<thead>
									<tr>
										<th colspan="2">
											Propiedades del Suelo
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td colspan="2"><p>Estrata 1</p></td>
									</tr>
									<tr>
										<td><p>&nbsp;&nbsp;&nbsp;Grosor (cm):&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_estr1_grosor" name="cuartel_estr1_grosor" value="60"/></td>
									</tr>
									<tr>
										<td><p>&nbsp;&nbsp;&nbsp;Textura:&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_estr1_textura" name="cuartel_estr1_textura" value=""/></td>
									</tr>
									<tr>
										<td><p>&nbsp;&nbsp;&nbsp;Capacidad de Campo (&#037;&theta;):&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_estr1_cc" name="cuartel_estr1_cc" value="35"/></td>
									</tr>
									<tr>
										<td><p>&nbsp;&nbsp;&nbsp;Punto de Marchitez Permanente (&#037;&theta;):&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_estr1_pmp" name="cuartel_estr1_pmp" value="12"/></td>
									</tr>
									<tr>
										<td colspan="2"><p>Estrata 2</p></td>
									</tr>
									<tr>
										<td><p>&nbsp;&nbsp;&nbsp;Grosor (cm):&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_estr2_grosor" name="cuartel_estr2_grosor" value=""/></td>
									</tr>
									<tr>
										<td><p>&nbsp;&nbsp;&nbsp;Textura:&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_estr2_textura" name="cuartel_estr2_textura" value=""/></td>
									</tr>
									<tr>
										<td><p>&nbsp;&nbsp;&nbsp;Capacidad de Campo (&#037;&theta;):&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_estr2_cc" name="cuartel_estr2_cc" value=""/></td>
									</tr>
									<tr>
										<td><p>&nbsp;&nbsp;&nbsp;Punto de Marchitez Permanente (&#037;&theta;):&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_estr2_pmp" name="cuartel_estr2_pmp" value=""/></td>
									</tr>
									<tr>
										<td colspan="2"><p>Estrata 3</p></td>
									</tr>
									<tr>
										<td><p>&nbsp;&nbsp;&nbsp;Grosor (cm):&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_estr3_grosor" name="cuartel_estr3_grosor" value=""/></td>
									</tr>
									<tr>
										<td><p>&nbsp;&nbsp;&nbsp;Textura:&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_estr3_textura" name="cuartel_estr3_textura" value=""/></td>
									</tr>
									<tr>
										<td><p>&nbsp;&nbsp;&nbsp;Capacidad de Campo (&#037;&theta;):&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_estr3_cc" name="cuartel_estr3_cc" value=""/></td>
									</tr>
									<tr>
										<td><p>&nbsp;&nbsp;&nbsp;Punto de Marchitez Permanente (&#037;&theta;):&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_estr3_pmp" name="cuartel_estr3_pmp" value=""/></td>
									</tr>
								</tbody>
								
							</table>
							<table class="mediagrove">
								<thead>
									<tr>
										<th colspan="2">
											Propiedades del Sistema de Riego
										</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td><p>Ancho de Mojado (cm):&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_ancho_moj" name="cuartel_ancho_moj" value="400"/></td>
									</tr>
									<tr>
										<td><p>Caudal del Emisor (l h<sup>-1</sup>):&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_caud_emis" name="cuartel_caud_emis" value="17.5"/></td>
									</tr>
									<tr>
										<td><p>N&uacute;mero de Emisores por Planta:&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_num_emis_planta" name="cuartel_num_emis_planta" value="1"/></td>
									</tr>
									<tr>
										<td><p>Eficiencia de Riego (fracci&oacute;n):&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_efis_riego" name="cuartel_efis_riego" value="0.85"/></td>
									</tr>
									<tr>
										<td><p>Coeficiente de Uniformidad:&nbsp;</p></td>
										<td>&nbsp;<input type="text" id="cuartel_coef_unif" name="cuartel_coef_unif" value="1"/></td>
									</tr>
								</tbody>
							</table>
							<table>
								<tr>
									<td><input type="hidden" id="cropsector_id" value="0" /><input class="button" type="button" style="width: auto;" value="Guardar Cuartel" onclick="save_cropsector()"  /></td>
								</tr>
							</table>
						</span>
					</div>
					<div class="corner-content-1col-bottom"></div>
				</div>
			</div>
			<!-- D. FOOTER -->      
			<?php require('../footer.inc.php');?>       
		</div>
		<!-- D. FOOT PANEL --> 
		<?php require('../system/footpanel.inc.php');?>
	</body>
</html>



