<?php
require('../aut_verifica.inc.php');
require('../funciones.inc.php');
estadisticas('WEB', 'PAGE_VIEW');
estadisticas('USER_USE', 'HISTORICO ESTACION');
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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<!-- JavaScript Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<link rel="stylesheet" type="text/css" href="../css/style.css" />
	<link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
	<?php require_once('../head.link.script.php'); ?>
	<script src="js/historico_instrumento.js" type="text/javascript"></script>
	<title>Micromet - Biovision</title>
</head>

<!-- Global IE fix to avoid layout crash when single word size wider than column width -->
<!-- Following line MUST remain as a comment to have the proper effect -->
<!--[if IE]><style type="text/css"> body {word-wrap: break-word;}</style><![endif]-->

<body>

	<div class="d-flex" id="wrapper">
		<?php require('../system/navigation_sidebar.inc.php'); ?>

		<div class="content" id="page-content-wrapper">
			<?php require('../system/navigation_bar.inc.php'); ?>

			<br>
			<div class="container-fluid">

				<h5 class="alert alert-success" role="alert">Datos Históricos - Instrumentos</h5>
				<hr>

				<div class="form-group row">
					<div class="col-md-3 "> </div>
					<div class="col-md-6 ">
						<div class="card">
							<div class="card-header">
								<h5 class="webtemplate" id="top_title">Hist&oacute;rico Instrumento</h5>
							</div>
							<div class="card-body">
								<form name="Form1">
									<div class="form-group">
										<h6>Seleccione datos (Instrumentos/Sensores de Estaciones)&nbsp;</h6>
										<div class="form-group row">
											<div class="col-md-4">
												<label for="select_estacion">Estaci&oacute;n:</label>
											</div>
											<div class="col-md-8">
												<span id="select_estacion_field">
													<img class="leftnoborder" src="../img/loaders/loader-01.gif" /></option>
												</span>
											</div>
										</div>
										<!-- <p>
											<label for="select_estacion" class="left">Estaci&oacute;n:</label>
											<span id="select_estacion_field">
												<img class="leftnoborder" src="../img/loaders/loader-01.gif" /></option>
											</span>
										</p> -->
										<br>

										<div class="form-group row">
											<div class="col-md-4">
												<label for="select_tipo">Instrumento:</label>
											</div>
											<div class="col-md-8">
												<span id="select_instrumento_field">
													<select class="form-select" id="select_instrumento" name="select_instrumento">
														<option value="0">Seleccione una Estaci&oacute;n</option>
													</select>
												</span>
											</div>
										</div>
										<!-- <p>
											<label for="select_instrumento" class="left">Instrumento:</label>
											<span id="select_instrumento_field">
												<select class="combo" style="width: 400px;" id="select_instrumento" name="select_instrumento">
													<option value="0">Seleccione una Estaci&oacute;n</option>
												</select>
											</span>
										</p> -->
										<br>
										<div class="form-group row">
											<div class="col-md-4">
												<label for="select_detalle">Detalle:</label>
											</div>
											<div class="col-md-8">
												<select class="form-select" id="select_detalle" name="select_detalle">
													<option value="diario">Diario</option>
													<option value="detalle_diario">Detalle Diario</option>
												</select>
											</div>
										</div>
										<!-- <p>
											<label for="select_detalle" class="left">Detalle:</label>
											<select class="combo" style="width: 400px;" id="select_detalle" name="select_detalle">
												<option value="diario">Diario</option>
												<option value="detalle_diario">Detalle Diario</option>
											</select>
										</p> -->
										<br>
										<div class="form-group row">
											<div class="col-md-4">
												<label for="input_fecha_desde">Desde:</label>

											</div>
											<div class="col-md-8">
												<input type="text" class="form-control" id="fecha_desde" value="<?= date('Y-m-d') ?>" />
											</div>

										</div>
										<br>
										<div class="form-group row">
											<div class="col-md-4">
												<label for="input_fecha_hasta">Hasta:</label>
											</div>
											<div class="col-md-8">
												<input type="text" class="form-control" id="fecha_hasta" value="<?= date('Y-m-d') ?>" />
											</div>
										</div>
										<!-- <p>
											<label for="input_fecha_desde" class="left">Desde:</label>
											<input type="text" class="field" id="fecha_desde" style="width: 100px;" value="<?= date('Y-m-d') ?>" />
										</p>
										<p>
											<label for="input_fecha_hasta" class="left">Hasta:</label>
											<input type="text" class="field" id="fecha_hasta" style="width: 100px;" value="<?= date('Y-m-d') ?>" />
										</p> -->
										<p>

											<input id="boton_generar" type="button" class="btn btn-success fw-bold" value="Obtener Datos" onclick="get_data()" />
										</p>
									</div>
								</form>
							</div>

						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<?php require('../footer.inc.php'); ?>
	<?php require('../system/footpanel.inc.php'); ?>
</body>

</html>