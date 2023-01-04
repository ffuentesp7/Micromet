<?php
require('../aut_verifica.inc.php');
require('../funciones.inc.php');
check_admin($_SESSION['session_nombre_sesion']);
estadisticas('WEB', 'PAGE_VIEW');
estadisticas('ADMIN_USE', 'INDEX');
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
	<div class="d-flex" id="wrapper">
		<?php require('../system/navigation_sidebar.inc.php'); ?>

		<!-- B. NAVIGATION BAR -->

		<!-- C. MAIN SECTION -->
		<div class="content" id="page-content-wrapper">
			<?php require('../system/navigation_bar.inc.php'); ?>

			<br>
			<div class="container-fluid">
				<h5 class="alert alert-success" role="alert">Panel de Administración</h5>
				<hr>
				<div class="row">
					<div class="col-sm-3"></div>
					<div class="col-sm-6">
						<div class="card">
							<h5 class="card-header" id="top_title">Panel de Administraci&oacute;n</h5>
							<div class="card-body align-items-center d-flex justify-content-center">
								<table style="width: auto; background-color: #fff;">
									<tr>
										<td class="whitenoborder"><a href="../admin/usuarios.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=main" onmouseover="javascript: swapText('top_title','Administraci&oacute;n de Usuarios');" onmouseout="javascript: swapText('top_title','Panel de Administraci&oacute;n');"><img class="blueborder" src="../img/adminmenu/users.png" /></a></td>
										<td class="whitenoborder"><a href="../admin/estaciones.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=main" onmouseover="javascript: swapText('top_title','Administraci&oacute;n de Estaciones');" onmouseout="javascript: swapText('top_title','Panel de Administraci&oacute;n');"><img class="blueborder" src="../img/adminmenu/station.png" /></a></td>
										<td class="whitenoborder"><a href="../admin/permisos.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>" onmouseover="javascript: swapText('top_title','Administraci&oacute;n de Permisos');" onmouseout="javascript: swapText('top_title','Panel de Administraci&oacute;n');"><img class="blueborder" src="../img/adminmenu/keys.png" /></a></td>
										<td class="whitenoborder"><a href="../admin/estadisticas.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>" onmouseover="javascript: swapText('top_title','Visualizaci&oacute;n de Estad&iacute;sticas');" onmouseout="javascript: swapText('top_title','Panel de Administraci&oacute;n');"><img class="blueborder" src="../img/adminmenu/statistics.png" /></a></td>
										<td class="whitenoborder"><a href="../admin/bitacora.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>" onmouseover="javascript: swapText('top_title','Bit&aacute;cora Autom&aacute;tica de Eventos');" onmouseout="javascript: swapText('top_title','Panel de Administraci&oacute;n');"><img class="blueborder" src="../img/adminmenu/chat.png" /></a></td>
									</tr>
									<tr>
										<td class="whitenoborder"><a href="../admin/parametros.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=main" onmouseover="javascript: swapText('top_title','Par&aacute;metros');" onmouseout="javascript: swapText('top_title','Panel de Administraci&oacute;n');"><img class="blueborder" src="../img/adminmenu/tag.png" /></a></td>
										<td class="whitenoborder"><a href="../admin/areas.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=main" onmouseover="javascript: swapText('top_title','&Aacute;reas de Estaciones');" onmouseout="javascript: swapText('top_title','Panel de Administraci&oacute;n');"><img class="blueborder" src="../img/adminmenu/area.png" /></a></td>
										<td class="whitenoborder"><a href="../admin/estaciones.descarga.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=main" onmouseover="javascript: swapText('top_title','Descarga de Estaciones');" onmouseout="javascript: swapText('top_title','Panel de Administraci&oacute;n');"><img class="blueborder" src="../img/adminmenu/station2.png" /></a></td>
										<td class="whitenoborder"><a href="../admin/bitacora_escrita.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=main" onmouseover="javascript: swapText('top_title','Bit&aacute;cora de Eventos');" onmouseout="javascript: swapText('top_title','Panel de Administraci&oacute;n');"><img class="blueborder" src="../img/adminmenu/chat2.png" /></a></td>
										<td class="whitenoborder"><a href="../admin/calibracion.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=main" onmouseover="javascript: swapText('top_title','Calibraci&oacute;n de Instrumentos');" onmouseout="javascript: swapText('top_title','Panel de Administraci&oacute;n');"><img class="blueborder" src="../img/adminmenu/station3.png" /></a></td>
									</tr>
									<tr>
										<td class="whitenoborder"><a href="../admin/sistemas.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=main" onmouseover="javascript: swapText('top_title','Sistemas');" onmouseout="javascript: swapText('top_title','Panel de Administraci&oacute;n');"><img class="blueborder" src="../img/adminmenu/system.png" /></a></td>
										<td class="whitenoborder"><a href="../admin/blog.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=main" onmouseover="javascript: swapText('top_title','Blogging de P&aacute;gina Principal');" onmouseout="javascript: swapText('top_title','Panel de Administraci&oacute;n');"><img class="blueborder" src="../img/adminmenu/blog.png" /></a></td>
										<td class="whitenoborder"></td>
										<td class="whitenoborder"></td>
										<td class="whitenoborder"></td>
									</tr>
								</table>
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