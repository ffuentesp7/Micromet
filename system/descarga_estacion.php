<?php
require('../aut_verifica.inc.php');
require('../funciones.inc.php');
estadisticas('WEB', 'PAGE_VIEW');
estadisticas('USER_USE', 'DESCARGA ESTACION');
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
	<script src="js/descarga_estacion.js" type="text/javascript"></script>
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

				<h5 class="alert alert-success" role="alert">Datos Históricos - Datos de estación</h5>
				<hr>
				<div class="form-group row">
					<div class="col-md-3 "> </div>
					<div class="col-md-6 ">
						<div class="card">
							<div class="card-header">
								<h5>Descarga de datos de estación</h5>
							</div>
							<div class="card-body">
								<div class="contactform">
									<form name="Form1">
										<div class="form-group">
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
											<br>
											<!-- <p>
												<label for="select_estacion" class="left">Estaci&oacute;n:</label>
												<span id="select_estacion_field">
													<img class="leftnoborder" src="../img/loaders/loader-01.gif" /></option>
												</span>
											</p> -->

											<div class="form-group row">
												<div class="col-md-4">
													<label for="select_tipo">Detalle:</label>
												</div>
												<div class="col-md-8">
													<select class="form-select" id="select_detalle" name="select_detalle">
														<option value="diario">Diario</option>
														<option value="detalle_diario">Detalle Diario</option>
													</select>
												</div>
											</div>
											<br>
											<!-- <p>
												<label for="select_detalle" class="left">Detalle:</label>
												<select class="combo" style="width: 400px;" id="select_detalle" name="select_detalle">
													<option value="diario">Diario</option>
													<option value="detalle_diario">Detalle Diario</option>
												</select>
											</p> -->
											<div class="form-group row">
												<div class="col-md-4">
													<label for="select_tipo">Datos Disponibles:</label>
												</div>
												<div class="col-md-8">
													<div class="d-grid gap-2">
														<button id="btnGroupDrop1" type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown">
															Seleccionar
														</button>
														<ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
															<p id="tipos_de_datos_disponibles"></p>

														</ul>
													</div>

												</div>
											</div>


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
											<br>
											<div class="form-group row">
												<div class="col-md-4">
													<label for="select_separador">Separador:</label>
												</div>
												<div class="col-md-8">
													<select class="form-select" id="select_separador" name="select_separador">
													<option value="semicolon">Punto y Coma (Excel)</option>
													<option value="comma">Coma (OpenOffice)</option>
													<option value="tab">Tabulador</option>
													</select>
												</div>
											</div>
											
											<!-- <p>
												<label for="select_separador" class="left">Separador:</label>
												<select class="combo" style="width: 400px;" id="select_separador" name="select_separador">
													<option value="semicolon">Punto y Coma (Excel)</option>
													<option value="comma">Coma (OpenOffice)</option>
													<option value="tab">Tabulador</option>
												</select>
											</p> -->

											<br>
											<div class="form-group row">
												<div class="col-md-4">
													<label for="select_separador_dec">Separador de decimales:</label>
												</div>
												<div class="col-md-8">
													<select class="form-select" id="select_separador_dec" name="select_separador_dec">
													<option value="point">Punto</option>
													<option value="comma">Coma</option>
													</select>
												</div>
											</div>
											<!-- <p>
												<label for="select_separador_dec" class="left">Sep. de Dec.:</label>
												<select class="combo" style="width: 400px;" id="select_separador_dec" name="select_separador_dec">
													<option value="point">Punto</option>
													<option value="comma">Coma</option>
												</select>
											</p> -->

											<br>
											<div class="form-group row">
												<div class="col-md-4">
													<label for="select_separador_mil">Separador de miles:</label>
												</div>
												<div class="col-md-8">
													<select class="form-select" id="select_separador_mil" name="select_separador_mil">
													<option value="nosep">Sin Separador</option>
													<option value="comma">Coma</option>
													<option value="point">Punto</option>
													</select>
												</div>
											</div>
											<!-- <p>
												<label for="select_separador_mil" class="left">Sep. de Miles:</label>
												<select class="combo" style="width: 400px;" id="select_separador_mil" name="select_separador_mil">
													<option value="nosep">Sin Separador</option>
													<option value="comma">Coma</option>
													<option value="point">Punto</option>
												</select>
											</p> -->

											<br>
											<div class="form-group row">
												<div class="col-md-4">
													<label for="select_filas">M&aacute;ximo Filas:</label>
												</div>
												<div class="col-md-8">
													<select class="form-select" id="select_filas" name="select_filas">
													<option value="65535">65535 (Excel 2003 y OpenOffice Calc)</option>
													<option value="1048576">1048576 (Excel 2007)</option>
													</select>
												</div>
											</div>
											<!-- <p>
												<label for="select_filas" class="left">M&aacute;ximo Filas:</label>
												<select class="combo" style="width: 400px;" id="select_filas" name="select_filas">
													<option value="65535">65535 (Excel 2003 y OpenOffice Calc)</option>
													<option value="1048576">1048576 (Excel 2007)</option>
												</select>
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
	</div>
	<!-- D. FOOTER -->
	<?php require('../footer.inc.php'); ?>

	<!-- D. FOOT PANEL -->
	<?php require('../system/footpanel.inc.php'); ?>
</body>

</html>