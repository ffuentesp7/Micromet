<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	require('boletines_actualizar_semanas.php');
	estadisticas('WEB','PAGE_VIEW');
	estadisticas('USER_USE','BOLETINES_AREA');
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
		<script src="js/boletines.js" type="text/javascript"></script>
		<title>Micromet - Biovision</title>
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
						<h1 class="acrobat" id="top_title">Boletines - Meteovid por &Aacute;rea</h1>
						<h2>Selecci&oacute;n de Bolet&iacute;n:</h2>
						<div class="contactform">
							<form name="Form1">
								<fieldset><legend>&nbsp;DATOS DEL BOLET&Iacute;N&nbsp;</legend>
									<p>
										<label for="select_area" class="left">&Aacute;rea:</label>
										<span id="select_area_field">
											<img class="leftnoborder" src="../img/loaders/loader-01.gif" /></option>
										</span>
									</p>
									<p>
										<label for="select_boletin" class="left">Bolet&iacute;n:</label>
										<span id="select_boletin_field">
											<img class="leftnoborder" src="../img/loaders/loader-01.gif" /></option>
										</span>
									</p>
									<p>
										<label for="select_detalle" class="left">Detalle:</label>
										<select class="combo" style="width: 400px;" id="select_detalle" name="select_detalle">
											<option value="semanal">Resumen Semanal</option>
											<option value="diario">Resumen Diario</option>
										</select>
									</p>
									<p>
										
										<input id="boton_generar" type="button" class="button" value="Generar Bolet&iacute;n" />(*)
									</p>
									<br />
									<p>(*)Debe tener permitidos los elementos emergentes en su navegador.</p>
								</fieldset>
							</form>
						</div>
						<script type="text/javascript">
						$(document).ready(function(){
							getAreaSelect();
							getNewsletterSelect();
							$('#boton_generar').bind('click',function(e){
								getMeteovidNewsletter();
							});
						});
					</script>
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



