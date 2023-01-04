<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	estadisticas('WEB','PAGE_VIEW');
	estadisticas('USER_USE','INDEX');

	$SQL = "SELECT * FROM eve_sistema WHERE id=".$_SESSION['session_usuario_sistema'];
							
	$request_sistema = consulta_sql($SQL);
	$datos_sistema = mysqli_fetch_array($request_sistema);

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
		<!-- CSS only -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<!-- JavaScript Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
			
		<link rel="stylesheet" type="text/css" href="../css/style.css" />

		<link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
		<script type="text/javascript">
			var sid_index = '<?=$_SESSION['session_nombre_sesion']?>';
		</script>
		<?php require_once('../head.link.script.php'); ?>
		
		<!--script type="text/javascript" src="../js/jQuerySlider/themes/3/jquery-slider-datos-en-vivo-index.js"></script-->
		<link rel="stylesheet" type="text/css" href="../js/jQuerySlider/themes/3/slider.css" />
		<title>Micromet - Biovision</title>

	</head>

	<body>

		<main>



  

			<div class="d-flex" id="wrapper">


				<?php require('../system/navigation_sidebar.inc.php'); ?>   

				<div class="content" id="page-content-wrapper">
			 <?php require('../system/navigation_bar.inc.php'); ?>   
             
					<div class="container-fluid">                     
						<div class="card-body d-flex flex-column align-items-center">
							<!-- <h2 class="webtemplate" id="top_title"><?=$datos_sistema['nombre']?></h2> -->
							<p><?=$datos_sistema['pag_principal']?></p>
						</div>
						</div>   
					
					<?php
						$SQL = "SELECT 	titulo,
								contenido,
								hora,
								fecha,
								nombre 
							FROM 	eve_blog,
								usuario 
							WHERE 	(eve_blog.sistema = 0
							OR 	eve_blog.sistema=".$_SESSION['session_usuario_sistema'].") 
							AND 	usuario.id = eve_blog.usuario_id 
							ORDER BY fecha DESC, hora DESC 
							LIMIT 10";
							
						$RES = consulta_sql($SQL);
							
						$HTML = '';
						while($BLOGDATA = mysqli_fetch_array($RES)){
							$HTML.="<div class=\"corner-content-1col-top\"></div>
								<div class=\"content-1col-nobox\">
									<h1 class=\"blog\" id=\"top_title\">".$BLOGDATA['titulo']."</h1>
									<h5>el ".cambia_fecha_a_normal($BLOGDATA['fecha'])." a las ".$BLOGDATA['hora']."hrs. por ".$BLOGDATA['nombre']."</h5>
									<p>".$BLOGDATA['contenido']."</p>
								</div>
								<div class=\"corner-content-1col-bottom\"></div>";
						}
						echo $HTML;	
					?>
					</div>

			</div>
			<!-- D. FOOTER -->      
			<?php require('../footer.inc.php');?>       
		
		<!-- D. FOOT PANEL --> 
		<?php require('../system/footpanel.inc.php');?>
	</body>
</html>



