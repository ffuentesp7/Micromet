<?php
require('../aut_verifica.inc.php');
require('../funciones.inc.php');
estadisticas('WEB', 'PAGE_VIEW');
estadisticas('USER_USE', 'INSTRUMENTO');

$SQL = "SELECT nombre,descripcion FROM tipo_instrumento WHERE code='" . $_GET['tipo'] . "' AND id=" . $_GET['tiid'];

$result_ti = consulta_sql($SQL);

$datos_ti = mysqli_fetch_array($result_ti);

$NOMBRE_TI	= $datos_ti[0];
$CODE_TI	= $_GET['tipo'];
$TIID		= $_GET['tiid'];
$DESCRIPCION_TI	= $datos_ti[1];

$PAGE = 'main';
if (isset($_GET['page']))
	$PAGE = $_GET['page'];

$CURRENT_DATA_ACCESS = get_user_permission($_SESSION['session_usuario_id'], 'CURRENT_DATA_ACCESS');
$CURRENT_DATA_ACCESS = ($CURRENT_DATA_ACCESS == 'NULL' ? 0 : $CURRENT_DATA_ACCESS);

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
	<script type="text/javascript">
		var sid = $('#sid').val();
		var insName = '<?= $NOMBRE_TI ?>';
		var insUnit = '';
		var insUnitDay = new Array;
		var code = '<?= $CODE_TI ?>';
		var negative = false;
		var datos = new Array();
		var datosLabel = new Array();
		var fechas = new Array();
		var horas = new Array();
		var horasTodas = new Array();
		var testing = new Array();
		var stationName = '';
		var CDA = <?= $CURRENT_DATA_ACCESS ?>;
		var howmany = 2;

		$(document).ready(function(e) {



		});
	</script>
	<script src="js/instrumento.js" type="text/javascript"></script>
	<!-- CANVAS GRAPH-->
	<script src="../js/libraries/RGraph.common.effects.js"></script>
	<script src="../js/libraries/RGraph.common.key.js"></script>
	<script src="../js/libraries/RGraph.common.core.js"></script>
	<script src="../js/libraries/RGraph.common.tooltips.js"></script>
	<script src="../js/libraries/RGraph.line.js"></script>
	<script src="../js/libraries/RGraph.bar.js"></script>
	<script src="../js/libraries/RGraph.rose.js"></script>

	<style>
		.scroll {
			max-height: 390px;
			overflow-y: auto;
		}
	</style>
</head>

<!-- Global IE fix to avoid layout crash when single word size wider than column width -->
<!-- Following line MUST remain as a comment to have the proper effect -->
<!--[if IE]><style type="text/css"> body {word-wrap: break-word;}</style><![endif]-->

<body>

	<div class="d-flex" id="wrapper">
		<?php require('../system/navigation_sidebar.inc.php'); ?>

		<!-- C.1 CONTENT -->
		<div class="content" id="page-content-wrapper">
			<?php require('../system/navigation_bar.inc.php'); ?>
			<br>
			<div class="container-fluid">
				<h5 class="alert alert-success" role="alert">Datos Sensores últimos 30 días - <?= $NOMBRE_TI ?></h5>
				<hr>
				<?php
				if ($PAGE == 'ti') {
				?>
					<!-- CONTENT CELL -->

					<div class="card">
						<div class="card-header" id="top_title">
							<h5>Tipo de Sensor/Instrumento: <?= $NOMBRE_TI ?></h5>
						</div>
						<div class="card-body">
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
									<input type="hidden" name="tiid" id="tiid" value="<?= $_GET['tiid'] ?>" />
								</div>
							</form>
						</div>
					</div>

					<br>
					<div class="form-group row">
						<div class="col-md-6 ">

							<div class="card">
								<div class="card-header">
									<h5>Gr&aacute;fica: <?= $NOMBRE_TI ?></h5>
								</div>
								<p style="width: 100px; height: 20px; margin: 1px auto 5px auto;">
									<br />
									<img id="graph_loading" class="centernoborder" src="../img/loaders/loader-01.gif" />
								</p>
								<canvas id="chartContainer" width="670" height="300">
									Espere por favor...
								</canvas>

							</div>
						</div>

						<div class="col-md-6 ">
							<div class="corner-content-1col-bottom"></div>
							<a id="anchor-heading-1"></a>
							<div class="corner-content-1col-top"></div>

							<div class="card">
								<div class="card-header">
									<h5>Tabla de datos</h5>
								</div>
								<div class="card-body scroll">
									<h5 class="document" id="top_title_instrumento_">&nbsp;<a href="#" id="link_desactivar_instrumento" style="float: right; display: none;">&#091;Desactivar Instrumento&#093;</a><a href="#" id="link_activar_instrumento" style="float: right;">&#091;Activar Instrumento&#093;</a></h5>
									<span id="cuerpo_datos">
										<br />
										<br />
										<br />
										<br />
										<br />
										<br />
										<br />
										<br />
										<br />
										<br />
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


					<div class="corner-content-1col-bottom"></div>
					<script type="text/javascript">
						$(document).ready(function() {
							$('#graph_loading').hide();
							getStationSelect();
						});
					</script>
				<?php
				}
				?>
			</div>
		</div>

	</div>
	<?php require('../footer.inc.php'); ?>

	<?php require('../system/footpanel.inc.php'); ?>
</body>

</html>