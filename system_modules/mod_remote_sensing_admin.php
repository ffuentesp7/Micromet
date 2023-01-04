<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	require('../system/functions/statistic.functions.php');
	estadisticas('WEB','PAGE_VIEW');
	estadisticas('USER_USE','MOD_REMOTE_SENSING');
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
  		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="../css/mf54_grid.css" />
  		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="../css/mf54_content.css" />
		<link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<?php require_once('../head.link.script.php'); ?>	
		<title>Micromet - Biovision</title>
		<script type="text/javascript">
			$(document).ready(function(e){
				var datePickerFecha = $('#fecha').datepicker({
					dateFormat : "yy-mm-dd",
					showAnim : "blind",
					changeMonth: true,
					changeYear: true,
					maxDate: new Date()
				});
				<?php
				if(isset($_GET["status"])){
					switch($_GET["status"]){
						case 0:
							echo "success('La imagen fue ingresada con &eacute;xito');";
							break;
						case 1:
							echo "error('Error al integrar la imagen');";
							break;
						case 2:
							echo "error('Error al subir el archivo');";
							break;
						case 3:
							echo "error('Error en el archivo');";
							break;
					}					
				}
				?>
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
					 <!-- CONTENT CELL -->                
					<a id="anchor-heading-1"></a>
					<div class="corner-content-1col-top"></div>                        
					<div class="content-1col-nobox">
						<h1 class="webtemplate" id="top_title">Sensoramiento Remoto - Administraci�n</h1>
						<h2>Subir un KMZ:</h2>
						<?php
						if(!isset($_GET["status"])){
						?>
						<div class="contactform">
							<form id="image_form" enctype="multipart/form-data" action="mod_remote_sensing_functions.php" method="post">
								<fieldset><legend>&nbsp;DATOS DE LA IMAGEN&nbsp;</legend>
									<p>
										<label for="fecha" class="left">Fecha:</label>
										<input type="text" name="fecha" id="fecha" class="field" value="" tabindex="4" style="width: 100px;" />
									</p>
									<p>
										<label for="tabla" class="left">Nombre Tabla:</label>
										<input type="text" name="tabla" id="tabla" class="field" value="" tabindex="4" />
									</p>
									<p>
										<label for="tipo" class="left">Tipo:</label>
										<select name="tipo" id="tipo" class="combo">
											<option value="LANDSAT7">Landsat 7</option>
											<option value="LANDSAT5">Landsat 5</option>
											<option value="MODIS">MODIS</option>
										</select>
									</p>
									<p>
										<label for="kmz" class="left">KMZ:</label>
										<input type="file" name="kmz" id="kmz" class="field" value="" tabindex="4" />
									</p>
									<p>
										<input type="submit" name="submit" id="submit_image" class="button" value="Agregar Imagen" tabindex="6" />
									</p>
								</fieldset>
								<input type="hidden" name="sid" id="form_sid" value="<?=$_SESSION['session_nombre_sesion']?>"/>
								<input type="hidden" name="accion" id="accion" value="upload_kmz"/>
							</form>
						</div>
						<?php
						}
						else{
						?>
						<p><a href="mod_remote_sensing_admin.php?sid=<?=$_SESSION['session_nombre_sesion']?>">Volver</a></p>
						<?php
						}
						?>
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



