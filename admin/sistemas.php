<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	check_admin($_SESSION['session_nombre_sesion']);
	estadisticas('WEB','PAGE_VIEW');
	estadisticas('ADMIN_USE','SISTEMAS');
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
		<script src="js/sistemas.js"></script>
		<script src="../js/jwysiwyg/jquery.wysiwyg.js"></script>
		<link rel="stylesheet" type="text/css" href="../js/jwysiwyg/jquery.wysiwyg.css" />
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
						<h1 class="webtemplate" id="top_title">Sistemas</h1>
						<table style="width: auto; background-color: #fff;">
							<tr>
								<td class="whitenoborder"><a href="../admin/sistemas.php?sid=<?=$_SESSION['session_nombre_sesion']?>&page=add" onmouseover="javascript: swapText('top_title','Agregar Sistema');" onmouseout="javascript: swapText('top_title','Sistemas');"><img class="blueborder" src="../img/actionicons/system_add.png" /></a></td>
								<td class="whitenoborder"><p>Agregar Sistema</p></td>
							</tr>
						</table>
						<div class="contactform">
							<form method="post" action="index.html">
								<fieldset><legend>&nbsp;BUSCAR SISTEMAS&nbsp;</legend>
									<p>
										<label for="querytext" class="left">Nombre:</label>
										<input type="text" class="field" name="querytext" id="querytext" />
									</p>
								</fieldset>
							</form>
						</div>
						<span id="mensaje"></span>
						<span id="tabla"><img class="centernoborder" src="../img/loaders/loader-01.gif" /></span>
						<script type="text/javascript">
							$(document).ready(function(){
								var sid = $('#sid').val();
								var url = 'sistemas.acciones.php?sid='+sid+'&accion=tabla&query=';
								
								$.get(url,'',function(data){
									$('#tabla').html(data);
								});
								
								$('#querytext').bind('keyup',function(e){
									var query = $(this).val();
									var url = 'sistemas.acciones.php?sid='+sid+'&accion=tabla&query='+query;
									
									$.get(url,'',function(data){
										$('#tabla').html(data);
									});
								});
								
							});
						</script>
						<?php
						}
						else if($_GET['page'] == "add"){
						?>
						<h1 class="document" id="top_title">Agregar Sistema</h1>
						<p><a href="../admin/sistemas.php?sid=<?=$_SESSION['session_nombre_sesion']?>&page=main">Volver</a></p>
						<script>
							$(document).ready(function(){
								$("#pagina_sistema").wysiwyg();
							});
						</script>
						<span id="mensaje"></span>
						<div class="contactform">
							<form>
								<fieldset><legend>&nbsp;DATOS DEL SISTEMA&nbsp;</legend>
									<p>
										<label for="nombre_sistema" class="left">Nombre:</label>
										<input type="text" name="nombre_sistema" id="nombre_sistema" class="field" value="" tabindex="4" style="width: 450px;"/>
									</p>
									<p>
										<textarea id="pagina_sistema" class="pagina_sistema" style="width: 590px; height: 400px;"></textarea>
									</p>
									<p>
										<input type="button" style="width: 150px;" name="submit" id="submit_1" class="button" value="Agregar Sistema" tabindex="6" onclick="addSys()" />
									</p>
								</fieldset>
							</form>
						</div>
						<?php
						}
						else if($_GET['page'] == "edit"){
						
							$ID = $_GET['sysid'];
							$SQL = "SELECT * FROM eve_sistema WHERE id=$ID";
							
							$request_sistema = consulta_sql($SQL);
							$datos_sistema = mysqli_fetch_array($request_sistema);
						
						?>
						<h1 class="document" id="top_title">Actualizar Usuario</h1>
						<p><a href="../admin/sistemas.php?sid=<?=$_SESSION['session_nombre_sesion']?>&page=main">Volver</a></p>
						<span id="mensaje"></span>
						<script>
							$(document).ready(function(){
								$("#pagina_sistema").wysiwyg();
							});
						</script>
						<div class="contactform">
							<form>
								<fieldset><legend>&nbsp;DATOS DEL PAR&Aacute;METRO&nbsp;</legend>
									<p>
										<label for="nombre_sistema" class="left">Nombre:</label>
										<input type="text" name="nombre_sistema" id="nombre_sistema" class="field" value="<?=$datos_sistema['nombre']?>" tabindex="4" />
									</p>
									<p>
										<textarea id="pagina_sistema" class="pagina_sistema" style="width: 590px; height: 400px;"><?=stripslashes($datos_sistema['pag_principal'])?></textarea>
									</p>
									<p>
										<input type="button" style="width: 150px;" name="submit" id="submit_1" class="button" value="Actualizar Sistema" tabindex="6" onclick="updateSys()" />
									</p>
								</fieldset>
								<input type="hidden" name="sysid" id="sysid" value="<?=$ID?>" />
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



