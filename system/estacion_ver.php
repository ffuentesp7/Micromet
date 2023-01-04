<?php
require('../aut_verifica.inc.php');
require('../funciones.inc.php');
require('../system/functions/statistic.functions.php');
estadisticas('WEB', 'PAGE_VIEW');
estadisticas('USER_USE', 'ESTACION_VER');
$ESTACION = getDataOfStation($_GET['eid']);
$INSTRUMENTS = getInstrumentsOfStation($ESTACION[0]);
?>

<!DOCTYPE HTML>
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
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<script type="text/javascript" src="https://maps.google.com/maps/api/js?sensor=false"></script>
	<?php require_once('../head.link.script.php'); ?>
	<script src="../js/googleMaps.js" type="text/javascript"></script>
	<title>Micromet - Biovision</title>
	<script type="text/javascript">
		stationName = '<?= $ESTACION[1] ?>';
		stationLatitude = <?= $ESTACION[3] ?>;
		stationLongitude = <?= $ESTACION[4] ?>;
		stationID = <?= $ESTACION[0] ?>;
		fh = '<?= $ESTACION[6] ?>';
		fd = '<?= cambia_fecha_a_mysql(add_days(cambia_fecha_a_normal($ESTACION[6]), -7)) ?>';
	</script>
	<script type="text/javascript" src="js/estacion_ver.js"></script>
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
				<h5 class="alert alert-success" role="alert">Ver estación - <?= $_GET['name'] ?></h5>
				<hr>

				<div class="form-group row">

					<div class="col-md-6">
						<div class="card">
							<div class="card-header ">
								<h5>Ubicaci&oacute;n Geogr&aacute;fica:</h5>
							</div>
							<div class="card-body">
								<p id="StationMap" style="height: 450px; width: auto; margin: 20px;"></p>
								<p style="width: 590px; margin: 20px;">
									<input type="button" class="btn btn-success fw-bold" value="Cargar Valles Vitivin&iacute;colas en el Mapa" style="width: auto;" onclick="load_valleys();" />
								</p>
							</div>
						</div>
					</div>

					<div class="col-md-6">
						<div class="card">
							<div class="card-header ">
								<h5>&Uacute;ltimos datos:</h5>
							</div>
							<div class="card-body">
								<div id="tabla_datos" style="height: auto; width: auto; margin: 20px; overflow: auto;">
									<img src="../img/loaders/loader-01.gif" class="centernoborder" />
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