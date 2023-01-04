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
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
		<?php require_once('../head.link.script.php'); ?>
        <script type="text/javascript" src="../js/msdropdown/js/jquery.dd.js"></script>
		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="../js/msdropdown/dd.css" />
		<script src="../js/googleMaps.js" type="text/javascript"></script>
		<script src="../js/libraries/RGraph.common.effects.js" ></script>
		<script src="../js/libraries/RGraph.common.key.js" ></script>
		<script src="../js/libraries/RGraph.common.core.js" ></script>
		<script src="../js/libraries/RGraph.common.tooltips.js" ></script>
		<script src="../js/libraries/RGraph.line.js" ></script>
		<script src="../js/libraries/RGraph.bar.js" ></script>
		<script src="../js/libraries/RGraph.rose.js" ></script>
		<script src="js/mod_remote_sensing.js" type="text/javascript"></script>
		<title>Micromet - Biovision</title>
		
		<script type="text/javascript">
            var GMAP;
			$(document).ready(function(e){
				get_select_station();
				var sid = $('#sid').val();
				//$('#boton_cargar_datos_mapa').hide();
				//$('#boton_borrar_datos_mapa').hide();
				$('#fecha_imagen').datepicker({
					dateFormat : "yy-mm-dd",
					showAnim : "blind",
					maxDate: new Date(),
					numberOfMonths: [1, 2],
                    onSelect: getETo
				});
				GMAP = initializeMap(-35.426528, -71.666106, 8, "general_map");
				ET = new google.maps.KmlLayer('http://www.citrautalca.cl/eve/system_modules/mod_remote_sensing/kmz/LE72330852012028EDC00_SanClementeET24.kmz',{
					preserveViewport : true
				}); 
				ET.setMap(GMAP);
                                

				setMarkerRemoteSensig(GMAP,-35.426528, -71.666106,'Arrastre y suelte para obtener datos','tabla_datos','tabla_fenologia');
			
				url = 'mode_remote_sensing_functions.php?sid='+sid+'&accion=json_kc_graph';
			
                $("#phenology").msDropDown({visibleRows:5, rowHeight:48});
            
			});
			
			
			function goImage(){
                ETSnClemente = new google.maps.KmlLayer('http://www.citrautalca.cl/eve/system_modules/mod_remote_sensing/kmz/LE72330852012028EDC00_SanClementeET24.kmz',{
					preserveViewport : true
				}); 
				ETSnClemente.setMap(GMAP);
            }
			
			<?php
				/*$SQL = "SELECT fecha, tipo, tabla, kmz FROM JSATImages ORDER BY fecha DESC, tipo";
				
				$RDATA = consulta_sql_jsat($SQL);
				
				$HTML = "var fechasDisponibles = [";
				
				while($DATA = mysqli_fetch_array($RDATA)){
					$HTML.="'".$DATA['fecha']."',";
					
				}
				$HTML.="''];";
				
				echo $HTML;
                */
			?>
                        
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
						<h1 class="webtemplate" id="top_title">Sensoramiento Remoto y Programaci&oacute;n de Riego</h1>
						<h2>Seleccione su cuartel:</h2>
                        <table style="width: 300px; margin: 5px auto 5px auto;">
							<tr>
								<td class="whitenoborder">Cuartel:</td>
								<td class="whitenoborder">
									<select id="cuartel_select" style="width: 350px;">
										<?php
											$UID = $_SESSION['session_usuario_id'];
                                            $NOCROPS = true;
                                            $HTML="";
                                            $SQL = "SELECT
                                                            id,
                                                            cuartel,
                                                            cultivo,
                                                            variedad 
                                                    FROM 	eve_mod_remote_sensing_cropsector
                                                    WHERE 	usuario_id=$UID
                                                    ORDER BY cuartel";
                                                    
                                            $SQLR = consulta_sql($SQL);
                                            
                                            while($SQLD = mysqli_fetch_array($SQLR)){
                                                $HTML .= "<option value='".$SQLD['id']."'>".$SQLD['cuartel']." (".$SQLD['cultivo'].", ".$SQLD['variedad'].")</option>";
                                                $NOCROPS = false;
                                            }
                                            if($NOCROPS){
                                                $HTML = "<option>No existen cuarteles aun</option>";
                                            }
                                            echo $HTML;
										?>
									</select>
								</td>
							</tr>
                            <tr>
                                <td class="whitenoborder" colspan="2"><a href="mod_remote_sensing_cropsector.php?sid=<?=$_SESSION['session_nombre_sesion']?>">Agregar, editar o borrar cuarteles</a></td>
                            </tr>
						</table>
                        <h2>Seleccione la fecha para obtener ETo:</h2>
						<table style="width: 300px; margin: 5px auto 5px auto;">
							<tr>
								<td class="whitenoborder">Estaci&oacute;n:</td>
								<td class="whitenoborder">
										<span id="select_estacion_field">
											<img class="leftnoborder" src="../img/loaders/loader-01.gif" /></option>
										</span>
								</td>
							</tr>
							<tr>
								<td class="whitenoborder">Fecha:</td>
								<td class="whitenoborder"><input type="text" id="fecha_imagen" style="width: 100px; text-align: center;" value="<?php echo date('Y-m-d',mktime(0, 0, 0, date("m")  , date("d")-1, date("Y"))); ?>"/></td>
							</tr>
							<tr>
								<td class="whitenoborder">Especie - Estado Fenol&oacute;gico:</td>
								<td class="whitenoborder">
									<select id="phenology" style="width: 350px;">
										<?php
											foreach ($PHENOLOGY as $ESPECIE => $VALUE){
												foreach ($VALUE as $FEN => $FENVAL){
													echo "<option value='$ESPECIE' title='".$FENVAL['imagen_small']."' inicio='".$FENVAL['inicio']."' termino='".$FENVAL['termino']."' c='".$FENVAL['columna']."' t='".$FENVAL['tabla']."'>$ESPECIE - $FEN</option>";
												}
											}
										?>
									</select>
								</td>
							</tr>
							<tr>
								<td class="whitenoborder">ETo diaria (mm/d&iacute;a):</td>
								<td class="whitenoborder"><p  style="width: 300px; text-align: left;" id="eto_diaria"></p></td>
							</tr>
							<tr>
								<td class="whitenoborder" id="button_load_box"><input type="button" id="boton_cargar_datos_mapa" style="width: auto;" class="button" value="Cargar Datos en Mapa" onclick="loadDataInMap()"/></td>
								<td class="whitenoborder" id="button_load_box"><input type="button" id="boton_borrar_datos_mapa" style="width: auto;" class="button" value="Borrar Capas" onclick="clearKMZOverlays()"/></td>
							</tr>
						</table>
						<h2>Ubicaci&oacute;n Geogr&aacute;fica:</h2>
						<table style="width: 400px; margin: 5px auto 5px auto;">
							<tr>
								<td class="whitenoborder">Latitud:</td>
								<td class="whitenoborder"><input type="text" id="latitud" style="width: 100px; text-align: center;" value="-35.426528"/></td>
								<td class="whitenoborder"></td>
							</tr>
							<tr>
								<td class="whitenoborder">Longitud:</td>
								<td class="whitenoborder"><input type="text" id="longitud" style="width: 100px; text-align: center;" value="-71.666106"/></td>
								<td class="whitenoborder"><input type="button" id="boton_cargar_coordenadas" style="width: auto;" class="button" value="Buscar Coordenadas en el Mapa" onclick="changeHandMarkerPosition()"/></td>
							</tr>
						</table>
						<p id="general_map" style="height: 450px; width: 750px; margin: 20px auto 20px auto;"></p>
					</div>
					<div class="corner-content-1col-bottom"></div>
					<div class="content-1col-box">
						<a id="anchor-heading-1"></a>
						<div class="content-2col-box-leftcolumn">
								  
							<!-- Subcell -->
							<div class="corner-content-2col-top"></div>          
							<div class="content-2col-box">
								<h2>Datos de la ubicaci&oacute;n seleccionada:</h2>
								<span id="tabla_datos"></span>
							</div>
							<div class="corner-content-2col-bottom"></div>
							
							<!-- Subcell -->
							<div class="corner-content-2col-top"></div>          
							<div class="content-2col-box">
								<h2>Gr&aacute;fico de Coeficiente de Cultivo:</h2>
								<canvas id="chartContainer" width="470" height="300">
									Espere por favor...
								</canvas>
							</div>
							<div class="corner-content-2col-bottom"></div>
						</div>
						<div class="content-2col-box-rightcolumn">
						  
							<!-- Subcell -->
							<div class="corner-content-2col-top"></div>          
							<div class="content-2col-box">
								<h2>Fenolog&iacute;a de la ubicaci&oacute;n seleccionada:</h2>
								<span id="tabla_fenologia"></span>
							</div>
							<div class="corner-content-2col-bottom"></div>  
						</div>
					</div>
                    <div class="corner-content-1col-top"></div>                      
					<div class="content-1col-nobox">
						<h1 class="webtemplate" id="top_title">Programaci&oacute;n de Riego</h1>
                        <span id="irrigation_table"></span>
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



