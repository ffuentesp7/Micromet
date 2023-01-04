<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	estadisticas('WEB','PAGE_VIEW');
	estadisticas('USER_USE','MOD_PHENOLOGY');
	
	$TARGET_TM	= 'SENSOR';
	$MID		= 3;
	$MES 		= date('m');
	$ANIO		= date('Y');
	$FECHAINICIO	= '2000-09-01';
	
	if($MES >= 9 && $MES <= 12)
		$FECHAINICIO = $ANIO.'-09-01';
	elseif($MES >= 1 && $MES <= 8)
		$FECHAINICIO = ($ANIO-1).'-09-01';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
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
  		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="../css/mf54_grid.css" />
  		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="../css/mf54_content.css" />
		<link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
		<?php require_once('../head.link.script.php'); ?>
		
		<!-- CANVAS GRAPH-->
		<script src="../js/libraries/RGraph.common.effects.js" ></script>
		<script src="../js/libraries/RGraph.common.key.js" ></script>
		<script src="../js/libraries/RGraph.common.core.js" ></script>
		<script src="../js/libraries/RGraph.common.tooltips.js" ></script>
		<script src="../js/libraries/RGraph.line.js" ></script>
		<script src="../js/libraries/RGraph.bar.js" ></script>
		<script src="../js/libraries/RGraph.rose.js" ></script>
		<title>Micromet - Biovision</title>
		<script type="text/javascript" src="../system_modules/js/mod_phenology.js"></script>
		<style>
		#demo-frame > div.demo { padding: 10px !important; }
		.scroll-pane { overflow: auto; width: 94%; float:left; margin-left: 20px;}
		.scroll-content { width: 2460px; float: left; }
		.scroll-content-item { width: 107px; height: 170px; float: left; margin: 10px; font-size: 12px; text-align: center; }
		.scroll-content-item-current { border: 3px solid #F64B28;}
		* html .scroll-content-item { display: inline; } /* IE6 float double margin bug */
		.scroll-bar-wrap { clear: left; padding: 0 4px 0 2px; margin: 0 -1px -1px -1px; }
		.scroll-bar-wrap .ui-slider { background: none; border:0; height: 2em; margin: 0 auto;  }
		.scroll-bar-wrap .ui-handle-helper-parent { position: relative; width: 100%; height: 100%; margin: 0 auto; }
		.scroll-bar-wrap .ui-slider-handle { top:.2em; height: 1.5em; }
		.scroll-bar-wrap .ui-slider-handle .ui-icon { margin: -8px auto 0; position: relative; top: 50%; }
		</style>
		<script type="text/javascript">
		var MID = <?=$MID?>;
		var ACTUALMONTH = '<?=date('m');?>';
		jQuery(document).ready(function(){
			var sid = $('#sid').val();
			getStationSelectTypeStation();
			
			jQuery( "#gdd_date" ).datepicker({
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
		<!-- CONTAINER FOR ENTIRE PAGE -->
		<div class="container">

    			 <!-- B. NAVIGATION BAR -->
			 <?php require('../system/navigation_bar.inc.php'); ?>   
  
			<!-- C. MAIN SECTION -->      
			<div class="main">

				<!-- C.1 CONTENT -->
				<div class="content">
					<a id="anchor-heading-1"></a>
					<div class="corner-content-1col-top"></div>                        
					<div class="content-1col-nobox">
						<h1 class="webtemplate" id="top_title">Modelos de Fenolog&iacute;a en Vid</h1>
						<div class="contactform">
							<form name="Form1">
								<fieldset><legend>&nbsp;OBTENER DATOS&nbsp;</legend>
									<p>
										<label for="gdd_date" class="left">Fecha Inicio:</label>
										<input type="text" id="gdd_date" name="gdd_date" readonly="true" style="width: 90px; text-align: center;" value="<?=$FECHAINICIO?>"/>
									</p>
									<p>
										<label for="select_estacion" class="left">Seleccione Estaci&oacute;n:</label>
										<span id="select_estacion_field">
											<img class="leftnoborder" src="../img/loaders/loader-01.gif" /></option>
										</span>
									</p>
									<p>
										<input type="button" class="button" value="Graficar Datos" onclick="load_data_graph()" />
									</p>
									<input type="hidden" name="mid" id="mid" value="<?=$MID?>" />
									<input type="hidden" name="target" id="target" value="<?=$TARGET_TM?>" />
								</fieldset>
							</form>
						</div>
						<h3>Grados D&iacute;a Acumulados: <span id="gda_number">0</span>&deg;C</h3>
						<br/>
						<canvas id="chartContainer" width="670" height="300">
							Espere por favor...
						</canvas>
						
						<h2>Vid Vin&iacute;fera en General*:</h2>
						<div class="demo">

							<div id="scroll-pane" class="scroll-pane ui-widget ui-widget-header ui-corner-all">
								<div id="scroll-content" class="scroll-content">
									<div id="1phenology-index-1" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/01.jpg" title="(1) Yema Invernal" class="thickbox">
											<img src="mod_phenology/small/01.jpg"/>
										</a>
										<br/>
										(1) Yema Invernal
									</div>
									<div id="1phenology-index-3" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/03.jpg" title="(3) Yema Algodonosa, lanosidad parda visible." class="thickbox">
											<img src="mod_phenology/small/03.jpg"/>
										</a>
										<br/>
										(3) Yema Algodonosa
									</div>
									<div id="1phenology-index-5" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/05.jpg" title="(5) Roseta de puntas de hojas visible" class="thickbox">
											<img src="mod_phenology/small/05.jpg"/>
										</a>
										<br/>
										(5) Roseta de puntas de hojas visible
									</div>
									<div id="1phenology-index-7" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/07.jpg" title="(7) Primera hoja separada de la punta del brote" class="thickbox">
											<img src="mod_phenology/small/07.jpg"/>
										</a>
										<br/>
										(7) Primera hoja separada
									</div>
									<div id="1phenology-index-9" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/09.jpg" title="(9) 2 a 3 hojas separadas, brotes de 2 a 4 cm de largo" class="thickbox">
											<img src="mod_phenology/small/09.jpg"/>
										</a>
										<br/>
										(9) 2 a 3 hojas separadas
									</div>
									<div id="1phenology-index-12" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/12.jpg" title="(12) 5 hojas separadas, brotes de 10 cm de largo, inflorescencia clara" class="thickbox">
											<img src="mod_phenology/small/12.jpg"/>
										</a>
										<br/>
										(12) 5 hojas separadas
									</div>
									<div id="1phenology-index-15" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/15.jpg" title="(15) Flores en grupos compactos, 8 hojas separadas, r&aacute;pido crecimiento de brotes" class="thickbox">
											<img src="mod_phenology/small/15.jpg"/>
										</a>
										<br/>
										(15) Flores en grupos compactos
									</div>
									<div id="1phenology-index-17" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/17.jpg" title="(17) Flores separadas, 12 hojas separadas, inflorescencia desarrollada" class="thickbox">
											<img src="mod_phenology/small/17.jpg"/>
										</a>
										<br/>
										(17) Flores separadas
									</div>
									<div id="1phenology-index-19" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/19.jpg" title="(19) Comienzo floraci&oacute;n (ca&iacute;da de la primera cal&iacute;ptra floral), aproximadamente 16 hojas separadas" class="thickbox">
											<img src="mod_phenology/small/19.jpg"/>
										</a>
										<br/>
										(19) Comienzo floraci&oacute;n
									</div>
									<div id="1phenology-index-23" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/23.jpg" title="(23) Plena Floraci&oacute;n, 50&#37; ca&iacute;da de cal&iacute;ptra floral, 17 a 20 hojas separadas" class="thickbox">
											<img src="mod_phenology/small/23.jpg"/>
										</a>
										<br/>
										(23) Plena Floraci&oacute;n
									</div>
									<div id="1phenology-index-25" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/25.jpg" title="(25) 80&#037; ca&iacute;da de cal&iacute;ptra floral" class="thickbox">
											<img src="mod_phenology/small/25.jpg"/>
										</a>
										<br/>
										(25) 80&#037; ca&iacute;da de cal&iacute;ptra floral
									</div>
									<div id="1phenology-index-27" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/27.jpg" title="(27) Cuaja. Bayas j&oacute;venes creciendo (> 2mm de di&aacute;metro), racimo en &aacute;ngulo recto respecto al brote" class="thickbox">
											<img src="mod_phenology/small/27.jpg"/>
										</a>
										<br/>
										(27) Cuaja. Bayas j&oacute;venes creciendo
									</div>
									<div id="1phenology-index-29" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/29.jpg" title="(29) Bayas de 4mm de di&aacute;metro, racimos tienden a inclinarse hacia abajo" class="thickbox">
											<img src="mod_phenology/small/29.jpg"/>
										</a>
										<br/>
										(29) Bayas de 4mm de di&aacute;metro
									</div>
									<div id="1phenology-index-31" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/31.jpg" title="(31) Bayas tama&ntilde;o guisante (7mm de di&aacute;metro)" class="thickbox">
											<img src="mod_phenology/small/31.jpg"/>
										</a>
										<br/>
										(31) Bayas tama&ntilde;o guisante (7mm)
									</div>
									<div id="1phenology-index-33" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/33.jpg" title="(33) Bayas a&uacute;n duras y verdes" class="thickbox">
											<img src="mod_phenology/small/33.jpg"/>
										</a>
										<br/>
										(33) Bayas a&uacute;n duras y verdes
									</div>
									<div id="1phenology-index-34" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/34.jpg" title="(34) Bayas comienzan a ablandarse y &deg;Brix comienza a aumentar" class="thickbox">
											<img src="mod_phenology/small/34.jpg"/>
										</a>
										<br/>
										(34) Bayas comienzan a ablandarse
									</div>
									<div id="1phenology-index-35" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/35.jpg" title="(35) Pinta, bayas comienzan a colorearse y a ensanchar" class="thickbox">
											<img src="mod_phenology/small/35.jpg"/>
										</a>
										<br/>
										(35) Pinta, bayas comienzan a colorearse
									</div>
									<div id="1phenology-index-36" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/36.jpg" title="(36) Bayas con &deg;Brix intermedios" class="thickbox">
											<img src="mod_phenology/small/36.jpg"/>
										</a>
										<br/>
										(36) Bayas con &deg;Brix intermedios
									</div>
									<div id="1phenology-index-38" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/38.jpg" title="(38) Bayas en madurez de cosecha (22&deg;Brix)" class="thickbox">
											<img src="mod_phenology/small/38.jpg"/>
										</a>
										<br/>
										(38) Bayas en madurez de cosecha (22&deg;Brix)
									</div>
								</div>
								<div class="scroll-bar-wrap ui-widget-content ui-corner-bottom">
									<div id="scroll-bar" class="scroll-bar"></div>
								</div>
							</div>
							
						</div><!-- End demo -->
						<h2>Vid Vin&iacute;fera Cabernet Sauvignon**:</h2>
						<div class="demo">

							<div id="scroll-pane2" class="scroll-pane ui-widget ui-widget-header ui-corner-all">
								<div id="scroll-content2" class="scroll-content">
									<div id="2phenology-index-1" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/01.jpg" title="(1) Yema Invernal" class="thickbox">
											<img src="mod_phenology/small/01.jpg"/>
										</a>
										<br/>
										(1) Yema Invernal
									</div>
									<div id="2phenology-index-3" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/03.jpg" title="(3) Yema Algodonosa, lanosidad parda visible." class="thickbox">
											<img src="mod_phenology/small/03.jpg"/>
										</a>
										<br/>
										(3) Yema Algodonosa
									</div>
									<div id="2phenology-index-5" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/05.jpg" title="(5) Roseta de puntas de hojas visible" class="thickbox">
											<img src="mod_phenology/small/05.jpg"/>
										</a>
										<br/>
										(5) Roseta de puntas de hojas visible
									</div>
									<div id="2phenology-index-7" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/07.jpg" title="(7) Primera hoja separada de la punta del brote" class="thickbox">
											<img src="mod_phenology/small/07.jpg"/>
										</a>
										<br/>
										(7) Primera hoja separada
									</div>
									<div id="2phenology-index-9" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/09.jpg" title="(9) 2 a 3 hojas separadas, brotes de 2 a 4 cm de largo" class="thickbox">
											<img src="mod_phenology/small/09.jpg"/>
										</a>
										<br/>
										(9) 2 a 3 hojas separadas
									</div>
									<div id="2phenology-index-12" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/12.jpg" title="(12) 5 hojas separadas, brotes de 10 cm de largo, inflorescencia clara" class="thickbox">
											<img src="mod_phenology/small/12.jpg"/>
										</a>
										<br/>
										(12) 5 hojas separadas
									</div>
									<div id="2phenology-index-15" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/15.jpg" title="(15) Flores en grupos compactos, 8 hojas separadas, r&aacute;pido crecimiento de brotes" class="thickbox">
											<img src="mod_phenology/small/15.jpg"/>
										</a>
										<br/>
										(15) Flores en grupos compactos
									</div>
									<div id="2phenology-index-17" class="scroll-content-item ui-widget-header scroll-content-item-current">
										<a href="mod_phenology/full/17.jpg" title="(17) Flores separadas, 12 hojas separadas, inflorescencia desarrollada" class="thickbox">
											<img src="mod_phenology/small/17.jpg"/>
										</a>
										<br/>
										(17) Flores separadas
									</div>
									<div id="2phenology-index-19" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/19.jpg" title="(19) Comienzo floraci&oacute;n (ca&iacute;da de la primera cal&iacute;ptra floral), aproximadamente 16 hojas separadas" class="thickbox">
											<img src="mod_phenology/small/19.jpg"/>
										</a>
										<br/>
										(19) Comienzo floraci&oacute;n
									</div>
									<div id="2phenology-index-23" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/23.jpg" title="(23) Plena Floraci&oacute;n, 50&#37; ca&iacute;da de cal&iacute;ptra floral, 17 a 20 hojas separadas" class="thickbox">
											<img src="mod_phenology/small/23.jpg"/>
										</a>
										<br/>
										(23) Plena Floraci&oacute;n
									</div>
									<div id="2phenology-index-25" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/25.jpg" title="(25) 80&#037; ca&iacute;da de cal&iacute;ptra floral" class="thickbox">
											<img src="mod_phenology/small/25.jpg"/>
										</a>
										<br/>
										(25) 80&#037; ca&iacute;da de cal&iacute;ptra floral
									</div>
									<div id="2phenology-index-27" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/27.jpg" title="(27) Cuaja. Bayas j&oacute;venes creciendo (> 2mm de di&aacute;metro), racimo en &aacute;ngulo recto respecto al brote" class="thickbox">
											<img src="mod_phenology/small/27.jpg"/>
										</a>
										<br/>
										(27) Cuaja. Bayas j&oacute;venes creciendo
									</div>
									<div id="2phenology-index-29" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/29.jpg" title="(29) Bayas de 4mm de di&aacute;metro, racimos tienden a inclinarse hacia abajo" class="thickbox">
											<img src="mod_phenology/small/29.jpg"/>
										</a>
										<br/>
										(29) Bayas de 4mm de di&aacute;metro
									</div>
									<div id="2phenology-index-31" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/31.jpg" title="(31) Bayas tama&ntilde;o guisante (7mm de di&aacute;metro)" class="thickbox">
											<img src="mod_phenology/small/31.jpg"/>
										</a>
										<br/>
										(31) Bayas tama&ntilde;o guisante (7mm)
									</div>
									<div id="2phenology-index-33" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/33.jpg" title="(33) Bayas a&uacute;n duras y verdes" class="thickbox">
											<img src="mod_phenology/small/33.jpg"/>
										</a>
										<br/>
										(33) Bayas a&uacute;n duras y verdes
									</div>
									<div id="2phenology-index-34" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/34.jpg" title="(34) Bayas comienzan a ablandarse y &deg;Brix comienza a aumentar" class="thickbox">
											<img src="mod_phenology/small/34.jpg"/>
										</a>
										<br/>
										(34) Bayas comienzan a ablandarse
									</div>
									<div id="2phenology-index-35" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/35.jpg" title="(35) Pinta, bayas comienzan a colorearse y a ensanchar" class="thickbox">
											<img src="mod_phenology/small/35.jpg"/>
										</a>
										<br/>
										(35) Pinta, bayas comienzan a colorearse
									</div>
									<div id="2phenology-index-36" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/36.jpg" title="(36) Bayas con &deg;Brix intermedios" class="thickbox">
											<img src="mod_phenology/small/36.jpg"/>
										</a>
										<br/>
										(36) Bayas con &deg;Brix intermedios
									</div>
									<div id="2phenology-index-38" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/38.jpg" title="(38) Bayas en madurez de cosecha (22&deg;Brix)" class="thickbox">
											<img src="mod_phenology/small/38.jpg"/>
										</a>
										<br/>
										(38) Bayas en madurez de cosecha (22&deg;Brix)
									</div>
								</div>
								<div class="scroll-bar-wrap ui-widget-content ui-corner-bottom">
									<div id="scroll-bar2" class="scroll-bar"></div>
								</div>
							</div>
							
						</div><!-- End demo -->	
						<h2>Vid Vin&iacute;fera Merlot**:</h2>
						<div class="demo">

							<div id="scroll-pane3" class="scroll-pane ui-widget ui-widget-header ui-corner-all">
								<div id="scroll-content3" class="scroll-content">
									<div id="3phenology-index-1" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/01.jpg" title="(1) Yema Invernal" class="thickbox">
											<img src="mod_phenology/small/01.jpg"/>
										</a>
										<br/>
										(1) Yema Invernal
									</div>
									<div id="3phenology-index-3" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/03.jpg" title="(3) Yema Algodonosa, lanosidad parda visible." class="thickbox">
											<img src="mod_phenology/small/03.jpg"/>
										</a>
										<br/>
										(3) Yema Algodonosa
									</div>
									<div id="3phenology-index-5" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/05.jpg" title="(5) Roseta de puntas de hojas visible" class="thickbox">
											<img src="mod_phenology/small/05.jpg"/>
										</a>
										<br/>
										(5) Roseta de puntas de hojas visible
									</div>
									<div id="3phenology-index-7" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/07.jpg" title="(7) Primera hoja separada de la punta del brote" class="thickbox">
											<img src="mod_phenology/small/07.jpg"/>
										</a>
										<br/>
										(7) Primera hoja separada
									</div>
									<div id="3phenology-index-9" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/09.jpg" title="(9) 2 a 3 hojas separadas, brotes de 2 a 4 cm de largo" class="thickbox">
											<img src="mod_phenology/small/09.jpg"/>
										</a>
										<br/>
										(9) 2 a 3 hojas separadas
									</div>
									<div id="3phenology-index-12" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/12.jpg" title="(12) 5 hojas separadas, brotes de 10 cm de largo, inflorescencia clara" class="thickbox">
											<img src="mod_phenology/small/12.jpg"/>
										</a>
										<br/>
										(12) 5 hojas separadas
									</div>
									<div id="3phenology-index-15" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/15.jpg" title="(15) Flores en grupos compactos, 8 hojas separadas, r&aacute;pido crecimiento de brotes" class="thickbox">
											<img src="mod_phenology/small/15.jpg"/>
										</a>
										<br/>
										(15) Flores en grupos compactos
									</div>
									<div id="3phenology-index-17" class="scroll-content-item ui-widget-header scroll-content-item-current">
										<a href="mod_phenology/full/17.jpg" title="(17) Flores separadas, 12 hojas separadas, inflorescencia desarrollada" class="thickbox">
											<img src="mod_phenology/small/17.jpg"/>
										</a>
										<br/>
										(17) Flores separadas
									</div>
									<div id="3phenology-index-19" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/19.jpg" title="(19) Comienzo floraci&oacute;n (ca&iacute;da de la primera cal&iacute;ptra floral), aproximadamente 16 hojas separadas" class="thickbox">
											<img src="mod_phenology/small/19.jpg"/>
										</a>
										<br/>
										(19) Comienzo floraci&oacute;n
									</div>
									<div id="3phenology-index-23" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/23.jpg" title="(23) Plena Floraci&oacute;n, 50&#37; ca&iacute;da de cal&iacute;ptra floral, 17 a 20 hojas separadas" class="thickbox">
											<img src="mod_phenology/small/23.jpg"/>
										</a>
										<br/>
										(23) Plena Floraci&oacute;n
									</div>
									<div id="3phenology-index-25" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/25.jpg" title="(25) 80&#037; ca&iacute;da de cal&iacute;ptra floral" class="thickbox">
											<img src="mod_phenology/small/25.jpg"/>
										</a>
										<br/>
										(25) 80&#037; ca&iacute;da de cal&iacute;ptra floral
									</div>
									<div id="3phenology-index-27" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/27.jpg" title="(27) Cuaja. Bayas j&oacute;venes creciendo (> 2mm de di&aacute;metro), racimo en &aacute;ngulo recto respecto al brote" class="thickbox">
											<img src="mod_phenology/small/27.jpg"/>
										</a>
										<br/>
										(27) Cuaja. Bayas j&oacute;venes creciendo
									</div>
									<div id="3phenology-index-29" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/29.jpg" title="(29) Bayas de 4mm de di&aacute;metro, racimos tienden a inclinarse hacia abajo" class="thickbox">
											<img src="mod_phenology/small/29.jpg"/>
										</a>
										<br/>
										(29) Bayas de 4mm de di&aacute;metro
									</div>
									<div id="3phenology-index-31" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/31.jpg" title="(31) Bayas tama&ntilde;o guisante (7mm de di&aacute;metro)" class="thickbox">
											<img src="mod_phenology/small/31.jpg"/>
										</a>
										<br/>
										(31) Bayas tama&ntilde;o guisante (7mm)
									</div>
									<div id="3phenology-index-33" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/33.jpg" title="(33) Bayas a&uacute;n duras y verdes" class="thickbox">
											<img src="mod_phenology/small/33.jpg"/>
										</a>
										<br/>
										(33) Bayas a&uacute;n duras y verdes
									</div>
									<div id="3phenology-index-34" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/34.jpg" title="(34) Bayas comienzan a ablandarse y &deg;Brix comienza a aumentar" class="thickbox">
											<img src="mod_phenology/small/34.jpg"/>
										</a>
										<br/>
										(34) Bayas comienzan a ablandarse
									</div>
									<div id="3phenology-index-35" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/35.jpg" title="(35) Pinta, bayas comienzan a colorearse y a ensanchar" class="thickbox">
											<img src="mod_phenology/small/35.jpg"/>
										</a>
										<br/>
										(35) Pinta, bayas comienzan a colorearse
									</div>
									<div id="3phenology-index-36" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/36.jpg" title="(36) Bayas con &deg;Brix intermedios" class="thickbox">
											<img src="mod_phenology/small/36.jpg"/>
										</a>
										<br/>
										(36) Bayas con &deg;Brix intermedios
									</div>
									<div id="3phenology-index-38" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/38.jpg" title="(38) Bayas en madurez de cosecha (22&deg;Brix)" class="thickbox">
											<img src="mod_phenology/small/38.jpg"/>
										</a>
										<br/>
										(38) Bayas en madurez de cosecha (22&deg;Brix)
									</div>
								</div>
								<div class="scroll-bar-wrap ui-widget-content ui-corner-bottom">
									<div id="scroll-bar3" class="scroll-bar"></div>
								</div>
							</div>
						</div><!-- End demo -->		
						<h2>Vid Vin&iacute;fera Chardonnay**:</h2>
						<div class="demo">

							<div id="scroll-pane4" class="scroll-pane ui-widget ui-widget-header ui-corner-all">
								<div id="scroll-content4" class="scroll-content">
									<div id="4phenology-index-1" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/01.jpg" title="(1) Yema Invernal" class="thickbox">
											<img src="mod_phenology/small/01.jpg"/>
										</a>
										<br/>
										(1) Yema Invernal
									</div>
									<div id="4phenology-index-3" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/03.jpg" title="(3) Yema Algodonosa, lanosidad parda visible." class="thickbox">
											<img src="mod_phenology/small/03.jpg"/>
										</a>
										<br/>
										(3) Yema Algodonosa
									</div>
									<div id="4phenology-index-5" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/05.jpg" title="(5) Roseta de puntas de hojas visible" class="thickbox">
											<img src="mod_phenology/small/05.jpg"/>
										</a>
										<br/>
										(5) Roseta de puntas de hojas visible
									</div>
									<div id="4phenology-index-7" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/07.jpg" title="(7) Primera hoja separada de la punta del brote" class="thickbox">
											<img src="mod_phenology/small/07.jpg"/>
										</a>
										<br/>
										(7) Primera hoja separada
									</div>
									<div id="4phenology-index-9" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/09.jpg" title="(9) 2 a 3 hojas separadas, brotes de 2 a 4 cm de largo" class="thickbox">
											<img src="mod_phenology/small/09.jpg"/>
										</a>
										<br/>
										(9) 2 a 3 hojas separadas
									</div>
									<div id="4phenology-index-12" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/12.jpg" title="(12) 5 hojas separadas, brotes de 10 cm de largo, inflorescencia clara" class="thickbox">
											<img src="mod_phenology/small/12.jpg"/>
										</a>
										<br/>
										(12) 5 hojas separadas
									</div>
									<div id="4phenology-index-15" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/15.jpg" title="(15) Flores en grupos compactos, 8 hojas separadas, r&aacute;pido crecimiento de brotes" class="thickbox">
											<img src="mod_phenology/small/15.jpg"/>
										</a>
										<br/>
										(15) Flores en grupos compactos
									</div>
									<div id="4phenology-index-17" class="scroll-content-item ui-widget-header scroll-content-item-current">
										<a href="mod_phenology/full/17.jpg" title="(17) Flores separadas, 12 hojas separadas, inflorescencia desarrollada" class="thickbox">
											<img src="mod_phenology/small/17.jpg"/>
										</a>
										<br/>
										(17) Flores separadas
									</div>
									<div id="4phenology-index-19" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/19.jpg" title="(19) Comienzo floraci&oacute;n (ca&iacute;da de la primera cal&iacute;ptra floral), aproximadamente 16 hojas separadas" class="thickbox">
											<img src="mod_phenology/small/19.jpg"/>
										</a>
										<br/>
										(19) Comienzo floraci&oacute;n
									</div>
									<div id="4phenology-index-23" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/23.jpg" title="(23) Plena Floraci&oacute;n, 50&#37; ca&iacute;da de cal&iacute;ptra floral, 17 a 20 hojas separadas" class="thickbox">
											<img src="mod_phenology/small/23.jpg"/>
										</a>
										<br/>
										(23) Plena Floraci&oacute;n
									</div>
									<div id="4phenology-index-25" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/25.jpg" title="(25) 80&#037; ca&iacute;da de cal&iacute;ptra floral" class="thickbox">
											<img src="mod_phenology/small/25.jpg"/>
										</a>
										<br/>
										(25) 80&#037; ca&iacute;da de cal&iacute;ptra floral
									</div>
									<div id="4phenology-index-27" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/27.jpg" title="(27) Cuaja. Bayas j&oacute;venes creciendo (> 2mm de di&aacute;metro), racimo en &aacute;ngulo recto respecto al brote" class="thickbox">
											<img src="mod_phenology/small/27.jpg"/>
										</a>
										<br/>
										(27) Cuaja. Bayas j&oacute;venes creciendo
									</div>
									<div id="4phenology-index-29" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/29.jpg" title="(29) Bayas de 4mm de di&aacute;metro, racimos tienden a inclinarse hacia abajo" class="thickbox">
											<img src="mod_phenology/small/29.jpg"/>
										</a>
										<br/>
										(29) Bayas de 4mm de di&aacute;metro
									</div>
									<div id="4phenology-index-31" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/31.jpg" title="(31) Bayas tama&ntilde;o guisante (7mm de di&aacute;metro)" class="thickbox">
											<img src="mod_phenology/small/31.jpg"/>
										</a>
										<br/>
										(31) Bayas tama&ntilde;o guisante (7mm)
									</div>
									<div id="4phenology-index-33" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/33.jpg" title="(33) Bayas a&uacute;n duras y verdes" class="thickbox">
											<img src="mod_phenology/small/33.jpg"/>
										</a>
										<br/>
										(33) Bayas a&uacute;n duras y verdes
									</div>
									<div id="4phenology-index-34" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/34.jpg" title="(34) Bayas comienzan a ablandarse y &deg;Brix comienza a aumentar" class="thickbox">
											<img src="mod_phenology/small/34.jpg"/>
										</a>
										<br/>
										(34) Bayas comienzan a ablandarse
									</div>
									<div id="4phenology-index-35" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/35.jpg" title="(35) Pinta, bayas comienzan a colorearse y a ensanchar" class="thickbox">
											<img src="mod_phenology/small/35.jpg"/>
										</a>
										<br/>
										(35) Pinta, bayas comienzan a colorearse
									</div>
									<div id="4phenology-index-36" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/36.jpg" title="(36) Bayas con &deg;Brix intermedios" class="thickbox">
											<img src="mod_phenology/small/36.jpg"/>
										</a>
										<br/>
										(36) Bayas con &deg;Brix intermedios
									</div>
									<div id="4phenology-index-38" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/38.jpg" title="(38) Bayas en madurez de cosecha (22&deg;Brix)" class="thickbox">
											<img src="mod_phenology/small/38.jpg"/>
										</a>
										<br/>
										(38) Bayas en madurez de cosecha (22&deg;Brix)
									</div>
								</div>
								<div class="scroll-bar-wrap ui-widget-content ui-corner-bottom">
									<div id="scroll-bar4" class="scroll-bar"></div>
								</div>
							</div>
						</div><!-- End demo -->	
						<h2>Vid Vin&iacute;fera Sauvignon Blanc**:</h2>
						<div class="demo">

							<div id="scroll-pane5" class="scroll-pane ui-widget ui-widget-header ui-corner-all">
								<div id="scroll-content5" class="scroll-content">
									<div id="5phenology-index-1" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/01.jpg" title="(1) Yema Invernal" class="thickbox">
											<img src="mod_phenology/small/01.jpg"/>
										</a>
										<br/>
										(1) Yema Invernal
									</div>
									<div id="5phenology-index-3" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/03.jpg" title="(3) Yema Algodonosa, lanosidad parda visible." class="thickbox">
											<img src="mod_phenology/small/03.jpg"/>
										</a>
										<br/>
										(3) Yema Algodonosa
									</div>
									<div id="5phenology-index-5" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/05.jpg" title="(5) Roseta de puntas de hojas visible" class="thickbox">
											<img src="mod_phenology/small/05.jpg"/>
										</a>
										<br/>
										(5) Roseta de puntas de hojas visible
									</div>
									<div id="5phenology-index-7" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/07.jpg" title="(7) Primera hoja separada de la punta del brote" class="thickbox">
											<img src="mod_phenology/small/07.jpg"/>
										</a>
										<br/>
										(7) Primera hoja separada
									</div>
									<div id="5phenology-index-9" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/09.jpg" title="(9) 2 a 3 hojas separadas, brotes de 2 a 4 cm de largo" class="thickbox">
											<img src="mod_phenology/small/09.jpg"/>
										</a>
										<br/>
										(9) 2 a 3 hojas separadas
									</div>
									<div id="5phenology-index-12" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/12.jpg" title="(12) 5 hojas separadas, brotes de 10 cm de largo, inflorescencia clara" class="thickbox">
											<img src="mod_phenology/small/12.jpg"/>
										</a>
										<br/>
										(12) 5 hojas separadas
									</div>
									<div id="5phenology-index-15" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/15.jpg" title="(15) Flores en grupos compactos, 8 hojas separadas, r&aacute;pido crecimiento de brotes" class="thickbox">
											<img src="mod_phenology/small/15.jpg"/>
										</a>
										<br/>
										(15) Flores en grupos compactos
									</div>
									<div id="5phenology-index-17" class="scroll-content-item ui-widget-header scroll-content-item-current">
										<a href="mod_phenology/full/17.jpg" title="(17) Flores separadas, 12 hojas separadas, inflorescencia desarrollada" class="thickbox">
											<img src="mod_phenology/small/17.jpg"/>
										</a>
										<br/>
										(17) Flores separadas
									</div>
									<div id="5phenology-index-19" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/19.jpg" title="(19) Comienzo floraci&oacute;n (ca&iacute;da de la primera cal&iacute;ptra floral), aproximadamente 16 hojas separadas" class="thickbox">
											<img src="mod_phenology/small/19.jpg"/>
										</a>
										<br/>
										(19) Comienzo floraci&oacute;n
									</div>
									<div id="5phenology-index-23" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/23.jpg" title="(23) Plena Floraci&oacute;n, 50&#37; ca&iacute;da de cal&iacute;ptra floral, 17 a 20 hojas separadas" class="thickbox">
											<img src="mod_phenology/small/23.jpg"/>
										</a>
										<br/>
										(23) Plena Floraci&oacute;n
									</div>
									<div id="5phenology-index-25" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/25.jpg" title="(25) 80&#037; ca&iacute;da de cal&iacute;ptra floral" class="thickbox">
											<img src="mod_phenology/small/25.jpg"/>
										</a>
										<br/>
										(25) 80&#037; ca&iacute;da de cal&iacute;ptra floral
									</div>
									<div id="5phenology-index-27" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/27.jpg" title="(27) Cuaja. Bayas j&oacute;venes creciendo (> 2mm de di&aacute;metro), racimo en &aacute;ngulo recto respecto al brote" class="thickbox">
											<img src="mod_phenology/small/27.jpg"/>
										</a>
										<br/>
										(27) Cuaja. Bayas j&oacute;venes creciendo
									</div>
									<div id="5phenology-index-29" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/29.jpg" title="(29) Bayas de 4mm de di&aacute;metro, racimos tienden a inclinarse hacia abajo" class="thickbox">
											<img src="mod_phenology/small/29.jpg"/>
										</a>
										<br/>
										(29) Bayas de 4mm de di&aacute;metro
									</div>
									<div id="5phenology-index-31" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/31.jpg" title="(31) Bayas tama&ntilde;o guisante (7mm de di&aacute;metro)" class="thickbox">
											<img src="mod_phenology/small/31.jpg"/>
										</a>
										<br/>
										(31) Bayas tama&ntilde;o guisante (7mm)
									</div>
									<div id="5phenology-index-33" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/33.jpg" title="(33) Bayas a&uacute;n duras y verdes" class="thickbox">
											<img src="mod_phenology/small/33.jpg"/>
										</a>
										<br/>
										(33) Bayas a&uacute;n duras y verdes
									</div>
									<div id="5phenology-index-34" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/34.jpg" title="(34) Bayas comienzan a ablandarse y &deg;Brix comienza a aumentar" class="thickbox">
											<img src="mod_phenology/small/34.jpg"/>
										</a>
										<br/>
										(34) Bayas comienzan a ablandarse
									</div>
									<div id="5phenology-index-35" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/35.jpg" title="(35) Pinta, bayas comienzan a colorearse y a ensanchar" class="thickbox">
											<img src="mod_phenology/small/35.jpg"/>
										</a>
										<br/>
										(35) Pinta, bayas comienzan a colorearse
									</div>
									<div id="5phenology-index-36" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/36.jpg" title="(36) Bayas con &deg;Brix intermedios" class="thickbox">
											<img src="mod_phenology/small/36.jpg"/>
										</a>
										<br/>
										(36) Bayas con &deg;Brix intermedios
									</div>
									<div id="5phenology-index-38" class="scroll-content-item ui-widget-header">
										<a href="mod_phenology/full/38.jpg" title="(38) Bayas en madurez de cosecha (22&deg;Brix)" class="thickbox">
											<img src="mod_phenology/small/38.jpg"/>
										</a>
										<br/>
										(38) Bayas en madurez de cosecha (22&deg;Brix)
									</div>
								</div>
								<div class="scroll-bar-wrap ui-widget-content ui-corner-bottom">
									<div id="scroll-bar5" class="scroll-bar"></div>
								</div>
							</div>
						</div><!-- End demo -->	
							
						<div class="demo-description">
							<p>* Coombe, B.G. 1995. Growth stages of the grapevine. Aust. J. Grape and Wine Res. 1:100-110. <a href="mod_phenology/coombe1995.pdf" target="_blank">[PDF]</a></p>
							<p>** Ortega-Farias, S. 2000. Development of models for predicting phenology and evolution of maturity in cv. Cabernet Sauvignon and Chardonnay grapevines. Agricultura T&eacute;cnica 62(1:27-37). <a href="mod_phenology/ortega2000.pdf" target="_blank">[PDF]</a></p>
						</div><!-- End demo-description -->
					</div> 
					<div class="corner-content-1col-bottom"></div>
    				</div>
    				<!-- C.2 SUBCONTENT-->
				<div class="subcontent">
					<!-- NAVIGATION SIDEBAR -->
					<?php require('../system/navigation_sidebar.inc.php'); ?>   
				</div>
    				<!-- END OF CONTENT -->
    			</div>
			<!-- D. FOOTER -->      
			<?php require('../footer.inc.php');?>       
		</div>
		<!-- D. FOOT PANEL --> 
		<?php require('../system/footpanel.inc.php');?>
	</body>
</html>



