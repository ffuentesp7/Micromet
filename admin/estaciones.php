<?php
require('../aut_verifica.inc.php');
require('../funciones.inc.php');
check_admin($_SESSION['session_nombre_sesion']);
estadisticas('WEB', 'PAGE_VIEW');
estadisticas('ADMIN_USE', 'ESTACIONES');
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
	<script src="js/estaciones.js" type="text/javascript"></script>

	<title>Micromet - Biovision</title>
</head>


<body>
	<div class="d-flex" id="wrapper">
		<?php require('../system/navigation_sidebar.inc.php'); ?>

		<div class="content" id="page-content-wrapper">
			<?php require('../system/navigation_bar.inc.php'); ?>
			<br>
			<div class="container-fluid">
				<h5 class="alert alert-success" role="alert">Estaciones</h5>
				<hr>

				<div class="form-group row">

					<div class="col-md-6 ">
						<div class="card">
							<div class="card-header">
								<h5>Estación</h5>
							</div>

							<div class="card-body">
								<div class="form-group row">
									<div class="col-md-4">
										<label for="nombre_estacion">Estaci&oacute;n:</label>
									</div>
									<div class="col-md-8">
										<span id="select_estacion_field">
											<img class="leftnoborder" src="../img/loaders/loader-01.gif" /></option>
										</span>
									</div>
								</div>


								<!-- <p>
									<label for="nombre_estacion" class="left">Nombre de Estaci&oacute;n:</label>
									<input class="field" type="text" readonly="true" name="nombre_estacion" id="nombre_estacion" />
									<a href="estaciones.lista.php?class=stationsetdata&sid=<?/*= $_SESSION['session_nombre_sesion']*/ ?>&keepThis=true&TB_iframe=true&height=400&width=500" title="Seleccione Estaci&oacute;n" class="thickbox">&#091;Seleccionar Estaci&oacute;n&#093;</a>
								</p> -->


								<br>
								<div class="form-group row">
									<div class="col-md-4">
										<label for="">Fuente de Datos:</label>
									</div>
									<div class="col-md-8">
										<input name="fuente_de_datos" type="text" id="fuente_de_datos" class="form-control" readonly="true" />
									</div>
								</div>
								<br />
								<!-- <p>
									<label for="fuente_de_datos" class="left">Fuente de Datos:</label>
									<input name="fuente_de_datos" type="text" id="fuente_de_datos" class="field" readonly="true" />
								</p> -->
								<div class="form-group row">
									<div class="col-md-4">
										<label for="informacion_estacion">Información:</label>
									</div>
									<div class="col-md-8">
										<select class="form-select" id="informacion_estacion" name="informacion_estacion">
											<option value="datosestacion">DATOS ESTACI&Oacute;N</option>
											<option value="instrumentos">INSTRUMENTOS</option>
											<option value="modelos">MODELOS</option>
										</select>
									</div>
									<!-- <label for="informacion_estacion" class="left">Informaci&oacute;n:</label>
								<select name="informacion_estacion" id="informacion_estacion">
									<option value="datosestacion">DATOS ESTACI&Oacute;N</option>
									<option value="instrumentos">INSTRUMENTOS</option>
									<option value="modelos">MODELOS</option>
								</select> -->
								</div>
							</div>

						</div>
					</div>
					<div class="col-md-6 ">
						<div class="card">
							<div class="card-header">
								<h5>Datos</h5>
							</div>
							<div class="card-body">
								<input id="eid" type="hidden" name="eid" value="0" />
								<div id="estacion_contenido"><img class="centernoborder" style="display: none;" src="../img/loaders/loader-01.gif" id="fbloader_image" /></div>
								<script type="text/javascript">
									$(document).ready(function() {

										$('#informacion_estacion').bind('change', function(e) {
											changeTypeInfo();
										});
									});
								</script>
							</div>

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

<script>
	$('#select_estacion_field').html(data);
</script>