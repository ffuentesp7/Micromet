<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	estadisticas('WEB','PAGE_VIEW');
	estadisticas('USER_USE','INDEX');
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
						<h1 class="webtemplate" id="top_title">adDI Key - C&oacute;digo adDI (ADaM Database Interface)</h1>
						<h2>Su C&oacute;digo adDI es:</h2>
						<div style="width: 300px; height: 50px; background: #E28C2F; border: 1px #C8C8C8 solid; margin: 1px auto 1px auto; font-size: 25px;">
							<p style="margin: 5px auto 5px auto; width: 200px; height: 40px; text-align: center;">
							<?php
							$result_key = consulta_sql("SELECT llave, fechahora, hash FROM addi WHERE usuario_id=".$_SESSION['session_usuario_id']);
							$key = '';
							$fechahora = '';
							$hash = '';
							if(mysqli_num_rows($result_key) == 0){
								$key = genpassnumber();
								$fechahora = date('Y-m-d H:i:s');
								$hash = md5($key.$fechahora);
								$SQL = "INSERT INTO `addi` (`usuario_id`, `llave`, `fechahora`, `hash`) VALUES (".$_SESSION['session_usuario_id']." ,'$key', '$fechahora','$hash')";
								if(comando_sql($SQL) > 0){
									echo $key;
								}
								else{
									echo "Error";
								}
							}
							else{
								if($data_key = mysqli_fetch_array($result_key)){
										
									$key = $data_key[0];
									$fechahora = $data_key[1];
									$fechahoraactual = date('Y-m-d H:i:s');
									$hash = $data_key[2];
									
									
									$unix_fecha_key = strtotime($fechahora);
									$unix_fecha_act = strtotime($fechahoraactual);
									
									if(($unix_fecha_act - $unix_fecha_key) < 604800){
										echo $key;	
									}
									else{
										$key = genpassnumber();
										$fechahora = date('Y-m-d H:i:s');
										$hash = md5($key.$fechahora);
										$SQL = "UPDATE `addi` SET `llave`='$key' , `fechahora`= '$fechahora', `hash`='$hash' WHERE usuario_id=".$_SESSION['session_usuario_id'];
										if(comando_sql($SQL) > 0){
											echo $key;
										}
										else{
											echo "Error";
										}
									}
									
								}
							}
							?>
							</p>
						</div>
						<p style="text-align: justify;">Este c&oacute;digo se utiliza para conectar a la base de datos las herramientas proporcionadas en EVE para el calculo
						de modelos, la carga y descarga de datos y otras herramientas desde la base de datos de ADaM. Este c&oacute;digo tiene una validez de 7 d&iacute;as
						a partir de la siguiente fecha: <?=$fechahora?>. Cuando su adDI Key expire deber&aacute; ingresar aqu&iacute; para obtener un nuevo c&oacute;digo.</p>
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



