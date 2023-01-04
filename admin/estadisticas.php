<?php
require('../aut_verifica.inc.php');
require('../funciones.inc.php');
check_admin($_SESSION['session_nombre_sesion']);
estadisticas('WEB', 'PAGE_VIEW');
estadisticas('ADMIN_USE', 'ESTADISTICAS');
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
				<h5 class="alert alert-success" role="alert">Estadísticas</h5>
				<hr>
				<div class="content-1col-nobox">

					<div class="form-group row">
						<div class="col-md-4 ">
							<div class="card">
								<div class="card-header">
									<h5>Tipo de estadística</h5>
								</div>

								<div class="card-body">
									<div class="form-group row">
										<div class="col-md-4">
											<label for="tipo_estadistica">Tipo:</label>
										</div>
										<div class="col-md-8">
											<select id="tipo_estadistica" name="tipo_estadistica" class="form-select">
												<?php
												$SQL = "SELECT DISTINCT tipo FROM eve_estadistica ORDER BY tipo";

												$result_estadistica = consulta_sql($SQL);

												while ($datos_estadistica = mysqli_fetch_array($result_estadistica)) {
													echo "<option value=\"" . $datos_estadistica[0] . "\">" . $datos_estadistica[0] . "</option>";
												}

												?>
											</select>
										</div>
									</div>
									<!-- <p>
									<label for="tipo_estadistica" class="left">Tipo:</label>
									<select id="tipo_estadistica" name="tipo_estadistica">
										<?/*php
										$SQL = "SELECT DISTINCT tipo FROM eve_estadistica ORDER BY tipo";

										$result_estadistica = consulta_sql($SQL);

										while ($datos_estadistica = mysqli_fetch_array($result_estadistica)) {
											echo "<option value=\"" . $datos_estadistica[0] . "\">" . $datos_estadistica[0] . "</option>";
										}

										*/?>
									</select>
								</p> -->
									<p>
										<input style="width: 150px;" type="button" class="btn btn-success" id="consultar_stadistica" name="consultar_estadistica" value="Buscar Estad&iacute;sticas" />
									</p>
								</div>
							</div>
						</div>
						<div class="col-md-8 ">
							<div id="contenido_estadistica"></div>

						</div>
					</div>
					<script type="text/javascript">
						$(document).ready(function() {
							$('#consultar_stadistica').bind('click', function(e) {
								$('#contenido_estadistica').html('<img class="centernoborder" src="../img/loaders/loader-01.gif" />');
								var sid = $('#sid').val();
								var tipo = $('#tipo_estadistica option:selected').val();

								var url = 'estadisticas.acciones.php?sid=' + sid + '&accion=tabla&tipo=' + tipo;

								$.get(url, '', function(data) {
									$('#contenido_estadistica').html(data);
									$('#tabla_estadistica').DataTable();
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