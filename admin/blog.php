<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	check_admin($_SESSION['session_nombre_sesion']);
	estadisticas('WEB','PAGE_VIEW');
	estadisticas('ADMIN_USE','BLOG');
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
  		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="../css/mf54_content.css" />
		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="../css/mf54_grid.css" />
		<link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
		<?php require_once('../head.link.script.php'); ?>
		<script src="js/blog.js"></script>
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
						if($_GET['page'] == "main"){
						?>
						<h1 class="webtemplate" id="top_title">Blogging</h1>
						<table style="width: auto; background-color: #fff;">
							<tr>
								<td class="whitenoborder"><a href="../admin/blog.php?sid=<?=$_SESSION['session_nombre_sesion']?>&page=add" onmouseover="javascript: swapText('top_title','Agregar Entrada');" onmouseout="javascript: swapText('top_title','Blogging');"><img class="blueborder" src="../img/actionicons/written.png" /></a></td>
								<td class="whitenoborder"><p>Agregar Entrada al Blog</p></td>
							</tr>
						</table>
						<div class="contactform">
							<form method="post" action="index.html">
								<fieldset><legend>&nbsp;BUSCAR ENTRADA POR FECHA&nbsp;</legend>
									<p>
										<label for="querytext" class="left">Fecha:</label>
										<input type="text" class="field" name="querytext" id="querytext" style="width: 70px;" />
									</p>
								</fieldset>
							</form>
						</div>
						<span id="mensaje"></span>
						<span id="tabla"><img class="centernoborder" src="../img/loaders/loader-01.gif" /></span>
						<script type="text/javascript">
							$(document).ready(function(){
								var sid = $('#sid').val();
								var url = 'blog.acciones.php?sid='+sid+'&accion=tabla&query=';
								
								$.get(url,'',function(data){
									$('#tabla').html(data);
								});
								
								$('#querytext').bind('change',function(e){
									var query = $(this).val();
									var url = 'blog.acciones.php?sid='+sid+'&accion=tabla&query='+query;
									
									$.get(url,'',function(data){
										$('#tabla').html(data);
									});
								});
								
								$('#querytext').datepicker({
									dateFormat : "yy-mm-dd",
									showAnim : "blind",
									changeMonth: true,
									changeYear: true,
									maxDate: new Date()
									
								});
								
							});
						</script>
						<?php
						}
						else if($_GET['page'] == "add"){
						?>
						<h1 class="document" id="top_title">Agregar Entrada al blog</h1>
						<p><a href="../admin/blog.php?sid=<?=$_SESSION['session_nombre_sesion']?>&page=main">Volver</a></p>
						<script>
							$(document).ready(function(){
							
								$('#fecha').datepicker({
									dateFormat : "yy-mm-dd",
									showAnim : "blind",
									changeMonth: true,
									changeYear: true,
									maxDate: new Date()
									
								});
								
								
							});
						</script>
						<span id="mensaje"></span>
						<div class="contactform">
							<form>
								<fieldset><legend>&nbsp;NUEVA ENTRADA&nbsp;</legend>
									<p>
										<label for="titulo" class="left">T&iacute;tulo:</label>
										<input type="text" name="titulo" id="titulo" class="field" value="" tabindex="4" style="width: 450px;"/>
									</p>
									<p>
										<textarea id="contenido" class="contenido" style="width: 590px; height: 400px;"></textarea>
									</p>
									<p>
										<label for="sistema" class="left">Sistema:</label>
										<select name="sistema" id="sistema" class="combo">
											<?php 
												$SQL = "SELECT id, nombre FROM eve_sistema ORDER BY id";
												$request_sistema = consulta_sql($SQL);
												$HTML = '';
												while($datos_sistema = mysqli_fetch_array($request_sistema)){
													$HTML.='<option value="'.$datos_sistema[0].'">'.$datos_sistema[1].'</option>';
												}
												echo $HTML;
											?>
										</select>
									</p>
									<p>
										<label for="fecha" class="left">Fecha:</label>
										<input type="text" name="fecha" id="fecha" class="field" value="<?=date("Y-m-d");?>" tabindex="4" style="width: 100px;" readonly="true"/>
									</p>
									<p>
										<label for="hora" class="left">Hora:</label>
										<input type="text" name="hora" id="hora" class="field" value="<?=date("H:i:s");?>" readonly="true" tabindex="4" style="width: 60px;"/>
									</p>
									<p>
										<input type="button" style="width: 150px;" name="submit" id="submit_1" class="button" value="Agregar Entrada" tabindex="6" onclick="addEntry()" />
									</p>
								</fieldset>
							</form>
						</div>
						<?php
						}
						else if($_GET['page'] == "edit"){
						
							$ID = $_GET['enid'];
							$SQL = "SELECT * FROM eve_blog WHERE id=$ID";
							
							$request_blog = consulta_sql($SQL);
							$datos_blog = mysqli_fetch_array($request_blog);
						
						?>
						<h1 class="document" id="top_title">Actualizar Entrada</h1>
						<p><a href="../admin/blog.php?sid=<?=$_SESSION['session_nombre_sesion']?>&page=main">Volver</a></p>
						<span id="mensaje"></span>
						<script>
							$(document).ready(function(){
								$("#sistema option[value=<?=$datos_blog['sistema']?>]").attr("selected","selected");
								
								$('#fecha').datepicker({
									dateFormat : "yy-mm-dd",
									showAnim : "blind",
									changeMonth: true,
									changeYear: true,
									maxDate: new Date()
									
								});
							});
						</script>
						<div class="contactform">
							<form>
								<fieldset><legend>&nbsp;ACTUALIZAR ENTRADA&nbsp;</legend>
									<p>
										<label for="titulo" class="left">T&iacute;tulo:</label>
										<input type="text" name="titulo" id="titulo" class="field" value="<?=$datos_blog['titulo']?>" tabindex="4" style="width: 450px;"/>
									</p>
									<p>
										<textarea id="contenido" class="contenido" style="width: 590px; height: 400px;"><?=$datos_blog['contenido']?></textarea>
									</p>
									<p>
										<label for="sistema" class="left">Sistema:</label>
										<select name="sistema" id="sistema" class="combo">
											<?php 
												$SQL = "SELECT id, nombre FROM eve_sistema ORDER BY id";
												$request_sistema = consulta_sql($SQL);
												$HTML = '';
												while($datos_sistema = mysqli_fetch_array($request_sistema)){
													$HTML.='<option value="'.$datos_sistema[0].'">'.$datos_sistema[1].'</option>';
												}
												echo $HTML;
											?>
										</select>
									</p>
									<p>
										<label for="fecha" class="left">Fecha:</label>
										<input type="text" name="fecha" id="fecha" class="field" value="<?=$datos_blog['fecha']?>" tabindex="4" style="width: 100px;" readonly="true"/>
									</p>
									<p>
										<label for="hora" class="left">Hora:</label>
										<input type="text" name="hora" id="hora" class="field" value="<?=$datos_blog['hora']?>" readonly="true" tabindex="4" style="width: 60px;"/>
									</p>
									<p>
										<input type="button" style="width: 150px;" name="submit" id="submit_1" class="button" value="Actualizar Entrada" tabindex="6" onclick="updateEntry()" />
									</p>
								</fieldset>
								<input type="hidden" name="enid" id="enid" value="<?=$ID?>" />
								<input type="hidden" name="usid" id="usid" value="<?=$datos_blog['usuario_id']?>" />
							</form>
						</div>
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



