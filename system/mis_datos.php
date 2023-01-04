<?php
require('../aut_verifica.inc.php');
require('../funciones.inc.php');
estadisticas('WEB', 'PAGE_VIEW');
estadisticas('ADMIN_USE', 'INDEX');
$ID = $_SESSION['session_usuario_id'];
$SQL = "SELECT * FROM usuario WHERE id=$ID";

$request_usuario = consulta_sql($SQL);
$datos_usuarios = mysqli_fetch_array($request_usuario);
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
	<script src="js/mis_datos.js" type="text/javascript"></script>
	<title>Micromet - Biovision</title>
</head>

<body>

	<div class="d-flex" id="wrapper">
		<?php require('../system/navigation_sidebar.inc.php'); ?>

		<div class="content" id="page-content-wrapper">
			<?php require('../system/navigation_bar.inc.php'); ?>
			<br>
			<div class="container-fluid">
				<h5 class="alert alert-success" role="alert">Mis Datos</h5>
				<hr>

				<span id="mensaje"></span>
				<div class="form-group row">
					<div class="col-md-3 "> </div>
					<div class="col-md-6 ">
						<div class="card">
							<form>
								<input type="hidden" value="<?= $ID ?>" id="userid" />
								<fieldset>
									<div class="card-header">
										<h5>Datos personales</h5>
									</div>
									<div class="card-body">
										<div class="form-group">
											<div class="form-group row">
												<div class="col-md-4">
													<label for="nombre_usuario">Nombre:</label>
												</div>
												<div class="col-md-8">
													<input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control" value="<?= $datos_usuarios['nombre'] ?>" tabindex="4" />
												</div>
											</div>
											<br>
											<!-- <p>
											<label for="nombre_usuario" class="left">Nombre:</label>
											<input type="text" name="nombre_usuario" id="nombre_usuario" class="field" value="<?= $datos_usuarios['nombre'] ?>" tabindex="4" />
										</p> -->
											<div class="form-group row">
												<div class="col-md-4">
													<label for="rut_usuario">RUT:</label>
												</div>
												<div class="col-md-8">
													<input readonly="true" type="text" name="rut_usuario" id="rut_usuario" class="form-control" value="<?= $datos_usuarios['rut'] ?>" tabindex="4" />
												</div>
											</div>
											<br>
											<!-- <p>
											<label for="rut_usuario" class="left">RUT:</label>
											<input readonly="true" type="text" name="rut_usuario" readonly="true" id="rut_usuario" class="field" value="<?= $datos_usuarios['rut'] ?>" tabindex="4" />
										</p> -->
											<div class="form-group row">
												<div class="col-md-4">
													<label for="email_usuario">Email:</label>
												</div>
												<div class="col-md-8">
													<input type="text" name="email_usuario" id="email_usuario" class="form-control" value="<?= $datos_usuarios['email'] ?>" tabindex="4" />
												</div>
											</div>
											<br>
											<!-- <p>
											<label for="email_usuario" class="left">Email:</label>
											<input type="text" name="email_usuario" id="email_usuario" class="field" value="<?= $datos_usuarios['email'] ?>" tabindex="4" />
										</p> -->
											<div class="form-group row">
												<div class="col-md-4">
													<label for="tel_movil_usuario">Teléfono Móvil:</label>
												</div>
												<div class="col-md-8">
													<input type="text" name="tel_movil_usuario" id="tel_movil_usuario" class="form-control" value="<?= $datos_usuarios['telefono_movil'] ?>" tabindex="4" />
												</div>
											</div>
											<br>
											<!-- <p>
											<label for="tel_movil_usuario" class="left">Tel. M&oacute;vil:</label>
											<input type="text" name="tel_movil_usuario" id="tel_movil_usuario" class="field" value="<?= $datos_usuarios['telefono_movil'] ?>" tabindex="4" />
										</p> -->
											<p>
												<input type="button" name="submit_datos" id="submit_datos" class="btn btn-success fw-bold" value="Actualizar Mis Datos" tabindex="6" onclick="updatePersonalData()" />
											</p>
										</div>
									</div>
								</fieldset>
							</form>
							<form>
								<fieldset>
									<div class="card-header">
										<h5>Actualizar clave de usuario</h5>
									</div>
									<div class="card-body">
										<div class="form-group">
											<div class="form-group row">
												<div class="col-md-4">
													<label for="clave_usuario_antigua">Clave Actual:</label>
												</div>
												<div class="col-md-8">
													<input type="text" name="clave_usuario_antigua" id="clave_usuario_antigua" class="form-control" value="" tabindex="4" />
												</div>
											</div>
											<br>
											<!-- <p>
											<label for="clave_usuario_antigua" class="left">Clave Actual:</label>
											<input type="password" name="clave_usuario_antigua" id="clave_usuario_antigua" class="field" value="" tabindex="4" />
										</p> -->
											<div class="form-group row">
												<div class="col-md-4">
													<label for="clave_usuario_nueva">Clave Nueva:</label>
												</div>
												<div class="col-md-8">
													<input type="text" name="clave_usuario_nueva" id="clave_usuario_nueva" class="form-control" value="" tabindex="4" />
												</div>
											</div>
											<br>
											<!-- <p>
											<label for="clave_usuario_nueva" class="left">Clave Nueva:</label>
											<input type="password" name="clave_usuario_nueva" id="clave_usuario_nueva" class="field" value="" tabindex="4" />
										</p> -->
											<p>
												<input type="button" name="submit_pass" id="submit_pass" class="btn btn-success fw-bold" value="Actualizar Mi Clave" tabindex="6" onclick="updatePersonalPass()" />
											</p>
										</div>
									</div>
								</fieldset>
							</form>
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