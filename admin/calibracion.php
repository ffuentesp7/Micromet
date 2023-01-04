<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	check_admin($_SESSION['session_nombre_sesion']);
	estadisticas('WEB','PAGE_VIEW');
	estadisticas('ADMIN_USE','PERMISOS');
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
		<script src="js/calibracion.js" type="text/javascript"></script>
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
						<?php
						
						$PAGE = "main";
						if(isset($_GET['page']))
							$PAGE = $_GET['page'];
						
						if( $PAGE == "main"){
						?>
						<h1 class="webtemplate" id="top_title">Calibraci&oacute;n</h1>
						<table style="width: auto; background-color: #fff;">
							<tr>
								<td class="whitenoborder"><a href="../admin/calibracion.php?sid=<?=$_SESSION['session_nombre_sesion']?>&page=cs" onmouseover="javascript: swapText('top_title','Script de Calibraci&oacute;n');" onmouseout="javascript: swapText('top_title','Calibraci&oacute;n');"><img class="blueborder" src="../img/actionicons/script.png" /></a></td>
								<td class="whitenoborder"><a href="../admin/calibracion.php?sid=<?=$_SESSION['session_nombre_sesion']?>&page=sensor" onmouseover="javascript: swapText('top_title','Calibraci&oacute;n de Instrumentos');" onmouseout="javascript: swapText('top_title','Calibraci&oacute;n');"><img class="blueborder" src="../img/actionicons/station3.png" /></a></td>
							</tr>
						</table>
						<?php
						}
						elseif( $PAGE == "sensor"){
						?>
						<h1 class="webtemplate" id="top_title">Calibraci&oacute;n de Instrumentos</h1>
						<p><a href="../admin/calibracion.php?sid=<?=$_SESSION['session_nombre_sesion']?>&page=main">Volver</a></p>
						<span id="mensaje"></span>
						<div class="contactform">
							<form>
								<fieldset><legend>&nbsp;Datos de Calibraci&oacute;n&nbsp;</legend>
									<p>
										<label for="nombre_instrumento" class="left">Instrumento:</label>
										<input type="text" class="field" name="nombre_instrumento" id="nombre_instrumento" readonly="true" />
										<a href="instrumentos.lista.php?sid=<?=$_SESSION['session_nombre_sesion']?>&keepThis=true&TB_iframe=true&height=400&width=700" title="Seleccione Instrumento" class="thickbox">&#091;Seleccionar Instrumento&#093;</a>
									</p>
									<p>
										<label for="codigo" class="left">Script:</label>
										<select name="script" class="combo" style="width: 300px;" id="script_id">
											<option value="0">Seleccione un Script de Calibraci&oacute;n</option>
											<?php
											$SQL = "SELECT id, name, filename, description FROM calibration_script ORDER BY name";
											
											$RES = consulta_sql($SQL);
											
											$HTML = '';
											while($DATA = mysqli_fetch_array($RES)){
												$HTML.='<option value="'.$DATA[0].'" title="'.$DATA[3].' ('.$DATA[2].')">'.$DATA[1].'</option>';
											}
											echo $HTML;
											?>
										</select>
									</p>
									<p>
										<label for="valor_a" class="left">Valor a:</label>
										<input type="text" class="field" style="width: 50px;" name="valor_a" id="valor_a" value="0.0" />
									</p>
									<p>
										<label for="valor_b" class="left">Valor b:</label>
										<input type="text" class="field" style="width: 50px;" name="valor_b" id="valor_b" value="0.0" />
									</p>
									<p>
										<label for="valor_c" class="left">Valor c:</label>
										<input type="text" class="field" style="width: 50px;" name="valor_c" id="valor_c" value="0.0" />
									</p>
									<p>
										<label for="valor_d" class="left">Valor d:</label>
										<input type="text" class="field" style="width: 50px;" name="valor_d" id="valor_d" value="0.0" />
									</p>
									<p>
										<label for="valor_e" class="left">Valor e:</label>
										<input type="text" class="field" style="width: 50px;" name="valor_e" id="valor_e" value="0.0" />
									</p>
									<p>
										<input type="button" class="button" style="width: auto;" value="Ingresar / Actualizar" id="boton_ingresar_calibracion" onclick="setCalibrationForInstrument()" />
									</p>
									<br /><br />
									<p>
										<input type="button" id="boton_quitar_calibracion" style="display: none;" class="buttonred" style="width: auto;" value="Quitar Calibraci&oacute;n" onclick="unsetCalibrationForInstrument()" />
									</p>
								</fieldset>
								<input type="hidden" id="instrumento_id" name="instrumento_id" value="0" />
							</form>
						</div>
						<script type="text/javascript">
							$(document).ready(function(){
								$('#boton_ingresar_permiso').bind('click',function(e){
									addUserTypePermission();
								});
							});
						</script>
						<?php
						}
						elseif( $PAGE == "cs"){
						?>
						<h1 class="webtemplate" id="top_title">Script de Calibraci&oacute;n</h1>
						<p><a href="../admin/calibracion.php?sid=<?=$_SESSION['session_nombre_sesion']?>&page=main">Volver</a></p>
						<span id="mensaje"></span>
						<div class="contactform">
							<form>
								<fieldset><legend>&nbsp;Datos del Script de Calibraci&oacute;n&nbsp;</legend>
									<p>
										<label for="nombre" class="left">Nombre:</label>
										<input type="text" class="field" name="nombre" id="nombre"/>
									</p>
									<p>
										<label for="descripcion" class="left">Descripci&oacute;n:</label>
										<input type="text" class="field" name="descripcion" id="descripcion" />
									</p>
									<p>
										<label for="archivo" class="left">Archivo:</label>
										<input type="text" class="field" name="archivo" id="archivo" />
									</p>
									<p>
										<input type="button" class="button" style="width: auto;" id="button_new_cs" value="Ingresar" onclick="newCalibrationScript()" />
										<input type="button" class="button" style="width: auto; display: none;" id="button_upd_cs" value="Actualizar" onclick="updateCalibrationScript()" />
										<input type="button" class="button" style="width: auto; display: none;" id="button_rst_cs" value="Resetear" onclick="resetFieldOfCalibrationScript()" />
									</p>
									<p></p>
								</fieldset>
								<input type="hidden" id="csid" value="0" name="csid" />
							</form>
						</div>
						<table style="width: 90%">
							<tbody id="tableofscripts">
							</tbody>
						</table>
						<script type="text/javascript">
							$(document).ready(function(){
							
								$('#boton_ingresar_permiso').bind('click',function(e){
									
								});
								
								getScriptList();
							});
						</script>
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



