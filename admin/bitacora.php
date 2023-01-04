<?php
require('../aut_verifica.inc.php');
require('../funciones.inc.php');
check_admin($_SESSION['session_nombre_sesion']);
estadisticas('WEB', 'PAGE_VIEW');
estadisticas('ADMIN_USE', 'BITACORA');
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

	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />


	<link rel="stylesheet" type="text/css" href="../css/style.css" />
	<link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
	<?php require_once('../head.link.script.php'); ?>
	<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

	<title>Micromet - Biovision</title>
</head>

<body>
	<div class="d-flex" id="wrapper">

		<?php require('../system/navigation_sidebar.inc.php'); ?>


		<div class="content" id="page-content-wrapper">
			<?php require('../system/navigation_bar.inc.php'); ?>
			<br>

			<div class="container-fluid">
				<h5 class="alert alert-success" role="alert">Bitácora automática de eventos</h5>
				<hr>
				<div class="form-group row">

					<div class="col-md-2 ">


						<div class="card">
							<div class="card-header">
								<h5>Datos</h5>
							</div>

							<div class="card-body">
								<div class="form-group row">
									<div class="col-md-4">
										<label for="mes_query">Mes:</label>
									</div>
									<div class="col-md-8">
										<select name="mes_query" id="mes_query" class="form-select">
											<option value="01">Enero</option>
											<option value="02">Febrero</option>
											<option value="03">Marzo</option>
											<option value="04">Abril</option>
											<option value="05">Mayo</option>
											<option value="06">Junio</option>
											<option value="07">Julio</option>
											<option value="08">Agosto</option>
											<option value="09">Septiembre</option>
											<option value="10">Octubre</option>
											<option value="11">Noviembre</option>
											<option value="12">Diciembre</option>
										</select>
									</div>
								</div>
								<br>
								<!-- <p>
									<label for="mes_query" class="left">Mes:</label>
									<select name="mes_query" id="mes_query">
										<option value="01">Enero</option>
										<option value="02">Febrero</option>
										<option value="03">Marzo</option>
										<option value="04">Abril</option>
										<option value="05">Mayo</option>
										<option value="06">Junio</option>
										<option value="07">Julio</option>
										<option value="08">Agosto</option>
										<option value="09">Septiembre</option>
										<option value="10">Octubre</option>
										<option value="11">Noviembre</option>
										<option value="12">Diciembre</option>
									</select>
								</p> -->
								<div class="form-group row">
									<div class="col-md-4">
										<label for="anio_query">Año:</label>
									</div>
									<div class="col-md-8">
									<select name="anio_query" id="anio_query" class="form-select">
										<?php
										for ($anio = date("Y"); $anio > 2008; $anio--) {
											echo "<option value=\"$anio\">$anio</option>";
										}
										?>
									</select>
									</div>
								</div>
								<br>
								<!-- <p>
									<label for="anio_query" class="left">A&ntilde;o:</label>
									<select name="anio_query" id="anio_query">
										<?/*php
										for ($anio = date("Y"); $anio > 2008; $anio--) {
											echo "<option value=\"$anio\">$anio</option>";
										}*/
										?>
									</select>
								</p> -->

								<p>
									<input type="button" class="btn btn-success" id="enviar_query" value="Buscar Registros" />
								</p>
							</div>
						</div>
					</div>
					<div class="col-md-10 ">

						<div id="bitacora_contenido"><img class="centernoborder" src="../img/loaders/loader-01.gif" /></div>

					</div>
					<script type="text/javascript">
						$(document).ready(function() {

							var sid = $('#sid').val();

							var url = 'bitacora.acciones.php?sid=' + sid + '&accion=tabla&mes_query=0&anio_query=0';

							$.get(url, '', function(data) {
								$('#bitacora_contenido').html(data);
								$('#tabla_bitacora').DataTable();

							});

							$('#enviar_query').bind('click', function(e) {
								$('#bitacora_contenido').html('<img class="centernoborder" src="../img/loaders/loader-01.gif" />');

								var sid = $('#sid').val();

								var mes = $('#mes_query option:selected').val();
								var anio = $('#anio_query option:selected').val();

								var url = 'bitacora.acciones.php?sid=' + sid + '&accion=tabla&mes_query=' + mes + '&anio_query=' + anio;

								$.get(url, '', function(data) {
									$('#bitacora_contenido').html(data);
									$('#tabla_bitacora').DataTable();

								});
							});

						});
					</script>
				</div>

			</div>


		</div>

	</div>

	<?php require('../footer.inc.php'); ?>

	<?php require('../system/footpanel.inc.php'); ?>
</body>

</html>