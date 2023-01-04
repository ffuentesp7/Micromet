<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	check_admin($_SESSION['session_nombre_sesion']);
	estadisticas('WEB','PAGE_VIEW');
	estadisticas('ADMIN_USE','BITACORA ESCRITA');
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
		<script src="../js/jwysiwyg/jquery.wysiwyg.js"></script>
		<link rel="stylesheet" type="text/css" href="../js/jwysiwyg/jquery.wysiwyg.css" />
		<script type="text/javascript" src="js/bitacora_escrita.js"></script>
		<script>
			$(document).ready(function(){
				$('#fecha_insert').datepicker("setDate", "<?=date("Y-m-d")?>");
				$('#fecha1').datepicker("setDate", "<?=cambia_fecha_a_mysql(add_days(date("d/m/Y"), -14))?>");
				$('#fecha2').datepicker("setDate", "<?=date("Y-m-d")?>");
				get_log();
			});
		
			
		</script>
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
						<h1 class="webtemplate" id="top_title">Bit&aacute;cora Escrita</h1>
						<div class="contactform">
							<form>
								<fieldset><legend>&nbsp;ESCRIBIR EN LA BITACORA&nbsp;</legend>
									<p>
										<textarea class="field" name="evento" id="evento" style="height: 150px; width: 580px;"></textarea>
									</p>
									<p>
										<label for="fecha" class="left">Fecha:</label>
										<input type="text" class="field" name="fecha" id="fecha_insert" style="width: 70px;" />
									</p>
									<input type="button" class="button" value="[AGREGAR INFORMACI&Oacute;N A LA BITACORA]" style="width: auto;" onclick="add_log();" />
									<img id="loader_add_log" class="centernoborder" src="../img/loaders/loader-01.gif" />
								</fieldset>
							</form>
						</div>
					</div> 
					<div class="corner-content-1col-bottom"></div>
					<div class="corner-content-1col-top"></div>                        
					<div class="content-1col-nobox">
						<h1 id="top_title">Eventos</h1>
						<div class="contactform">
							<form>
								<fieldset><legend>&nbsp;REVISAR BITACORA DE EVENTOS&nbsp;</legend>
									<p>
										<label for="fecha1" class="left" style="width: 150px;">Fechas (Desde - Hasta)</label>
										<input type="text" class="field" name="fecha1" id="fecha1" style="width: 70px;" />&nbsp;-&nbsp;
										<input type="text" class="field" name="fecha2" id="fecha2" style="width: 70px;" />
										<a href="javascript:print_log()">&#091;imprimir&#093;</a>
									</p>
								</fieldset>
							</form>
						</div>
						<span style="text-align: center;" id="contenido_bitacora">
							<img class="centernoborder" src="../img/loaders/loader-01.gif" />
						</span>
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



