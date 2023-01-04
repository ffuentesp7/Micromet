<?php
require('../aut_verifica.inc.php');
require('../funciones.inc.php');
estadisticas('WEB', 'PAGE_VIEW');
estadisticas('USER_USE', 'HISTORICO DESCARGA');
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
	<?php require_once('../head.link.script.php'); ?>
	<title>Micromet - Biovision</title>
</head>

<!-- Global IE fix to avoid layout crash when single word size wider than column width -->
<!-- Following line MUST remain as a comment to have the proper effect -->
<!--[if IE]><style type="text/css"> body {word-wrap: break-word;}</style><![endif]-->

<body>
	<!-- CONTAINER FOR ENTIRE PAGE -->


	<!-- B. NAVIGATION BAR -->

	<div class="d-flex" id="wrapper">
		<?php require('../system/navigation_sidebar.inc.php'); ?>

		<!-- C. MAIN SECTION -->


		<!-- C.1 CONTENT -->
		<div class="content" id="page-content-wrapper">
			<?php require('../system/navigation_bar.inc.php'); ?>
			<br>
			<div class="container-fluid">

				<!-- CONTENT CELL -->


				<h5 class="alert alert-success" role="alert">Datos Históricos - Descarga</h5>
				<hr>
				<h3 class="webtemplate text-center" id="top_title">Descarga de Datos</h3>


				<br>

				<div class="form-group row">
					<div class="col-md-4 text-center">
						<div class="card shadow-sm">
							<div class="card-header">
								<h5 class="card-title">Datos de estación</h5>
							</div>
							<div class="card-body">
								<a href="../system/descarga_estacion.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>" onmouseover="javascript: swapText('top_title','Descarga de Datos de Estaci&oacute;n');" onmouseout="javascript: swapText('top_title','Descarga de Datos');"><img class="blueborder" src="../img/adminmenu/station.png" /></a>
							</div>
						</div>
					</div>

					<div class="col-md-4 text-center">
						<div class="card shadow-sm">
							<div class="card-header">
								<h5 class="card-title">Datos de Instrumento</h5>
							</div>
							<div class="card-body">
								<a href="../system/descarga_instrumento.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>" onmouseover="javascript: swapText('top_title','Descarga de Datos desde Instrumentos');" onmouseout="javascript: swapText('top_title','Descarga de Datos');"><img class="blueborder" src="../img/adminmenu/device.png" /></a>
							</div>
						</div>
					</div>

					<div class="col-md-4 text-center">
						<div class="card shadow-sm">
							<div class="card-header">
								<h5 class="card-title">Resultado de modelos</h5>
							</div>

							<div class="card-body">
								<a href="#" title="Esta funcion aun no esta disponible" onmouseover="javascript: swapText('top_title','Descarga de Resultados de Modelos');" onmouseout="javascript: swapText('top_title','Descarga de Datos');"><img class="blueborder" src="../img/adminmenu/model.png" aria-disabled="" /></a>

							</div>
						</div>
					</div>

				</div>


			</div>
		</div>
	</div>

	<!-- D. FOOTER -->
	<?php require('../footer.inc.php'); ?>
	<!-- D. FOOT PANEL -->
	<?php require('../system/footpanel.inc.php'); ?>
</body>

</html>