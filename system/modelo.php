<?php
require('../aut_verifica.inc.php');
require('../funciones.inc.php');
estadisticas('WEB', 'PAGE_VIEW');
estadisticas('USER_USE', 'MODELO');

$SQL = "SELECT nombre,descripcion FROM tipo_modelo WHERE target='" . $_GET['tmd'] . "' AND id=" . $_GET['mid'];

$result_tm = consulta_sql($SQL);

$datos_tm = mysqli_fetch_array($result_tm);

$NOMBRE_TM	= $datos_tm[0];
$TARGET_TM	= $_GET['tmd'];
$MID		= $_GET['mid'];
$DESCRIPCION_TM	= $datos_tm[1];

$PAGE = 'main';
if (isset($_GET['page']))
	$PAGE = $_GET['page'];

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
	<script src="js/modelo.js" type="text/javascript"></script>
	<title>Micromet - Biovision</title>
	<style>
		.scroll {
			max-height: 420px;
			overflow-y: auto;
		}
	</style>
</head>

<!-- Global IE fix to avoid layout crash when single word size wider than column width -->
<!-- Following line MUST remain as a comment to have the proper effect -->
<!--[if IE]><style type="text/css"> body {word-wrap: break-word;}</style><![endif]-->

<body>
	<!-- CONTAINER FOR ENTIRE PAGE -->


	<div class="d-flex" id="wrapper">
		<?php require('../system/navigation_sidebar.inc.php'); ?>


		<!-- C.1 CONTENT -->
		<div class="content" id="page-content-wrapper">
			<?php require('../system/navigation_bar.inc.php'); ?>

			<div class="container-fluid">

				<br>
				<h5 class="alert alert-success" role="alert">Datos Modelos últimos 30 días - <?= $NOMBRE_TM ?></h5>
				<hr>
				<?php
				if ($PAGE == 'tmd') {
				?>
					<!-- CONTENT CELL -->
					<br>
					<div class="row">
						<div class="col-sm-3"></div>
						<div class="col-sm-6">
							<div class="card">
								<div class="card-header">
									<h5 class="sensor" id="top_title">Modelo: <?= $NOMBRE_TM ?></h5>
									<h6><?= $DESCRIPCION_TM ?></h6>
								</div>
								<div class="card-body ">

									<div class="contactform">
										<form name="Form1">
											<div class="form-group">
												<div class="form-group row">
													<div class="col-md-4">
														<label for="select_estacion">Seleccione Estaci&oacute;n:</label>

													</div>
													<div class="col-md-8">
														<span id="select_estacion_field">
															<img class="leftnoborder" src="../img/loaders/loader-01.gif" /></option>
														</span>
													</div>

												</div>

												<!-- <p>
													<label for="select_estacion" class="left">Seleccione Estaci&oacute;n:</label>
													<span id="select_estacion_field">
														<img class="leftnoborder" src="../img/loaders/loader-01.gif" /></option>
													</span>
												</p> -->
												<p>
													<input type="button" class="btn btn-success fw-bold" value="Ver Datos" onclick="getData()" />
												</p>
												<input type="hidden" name="mid" id="mid" value="<?= $MID ?>" />
												<input type="hidden" name="target" id="target" value="<?= $TARGET_TM ?>" />
											</div>
										</form>
									</div>
									<!-- Tabla -->
									<div class="content-1col-nobox scroll">
										<h1 class="document">&nbsp;</h1>
										<span id="cuerpo_datos">
											<br />
											<br />
											<br />
											<br />
											<br />
										</span>
									</div>
								</div>
							</div>
						</div>
						<script type="text/javascript">
							$(document).ready(function() {
								getStationSelectTypeStation();
							});
						</script>
					<?php
				}
					?>
					</div>
			</div>

		</div>

	</div>

	<?php require('../footer.inc.php'); ?>

	<?php require('../system/footpanel.inc.php'); ?>
</body>

</html>