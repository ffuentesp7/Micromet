<?php
require('../aut_verifica.inc.php');
require('../funciones.inc.php');
check_admin($_SESSION['session_nombre_sesion']);
estadisticas('WEB', 'PAGE_VIEW');
estadisticas('ADMIN_USE', 'USUARIOS');
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

	<script src="js/usuarios.js" type="text/javascript"></script>
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

				<div class="content-1col-nobox">

					<?php
					if ($_GET['page'] == "main") {
					?>
						<h5 class="alert alert-success" role="alert">Gestión de Usuarios</h5>
						<hr>
						<a class="btn btn-success" href="../admin/usuarios.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=add"><img class="blueborder" src="../img/actionicons/user_add.png" />Agregar Usuario</a>

						<span id="mensaje"></span>
						<div class="row">
							<div class="col-sm-12">
								<span id="tabla"></span>
							</div>
						</div>

						<script type="text/javascript">
							$(document).ready(function() {
								var sid = $('#sid').val();
								var url = 'usuarios.acciones.php?sid=' + sid + '&accion=tabla&query=';

								$.get(url, '', function(data) {
									$('#tabla').html(data);
									$('#t1').DataTable();

								});

							});
						</script>
					<?php
					} else if ($_GET['page'] == "add") {
					?>
						<h5 class="alert alert-success" role="alert">Gestión de Usuarios - Agregar Usuario</h5>
						<hr>
						<span id="mensaje"></span>
						<div class="form-group row">
							<div class="col-md-3 ">
								<p><a class="btn btn-success" href="../admin/usuarios.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=main">Volver</a></p>
							</div>
							<div class="col-md-6 ">
								<div class="card">
									<div class="card-header">
										<h5>Datos de Usuario</h5>
									</div>
									<div class="card-body">

										<div class="form-group row">
											<div class="col-md-4">
												<label for="nombre_usuario">Nombre:</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="nombre_usuario" id="nombre_usuario" class="form-control" value="" tabindex="4" />
											</div>
										</div>
										<br>
										<div class="form-group row">
											<div class="col-md-4">
												<label for="rut_usuario">RUT:</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="rut_usuario" id="rut_usuario" class="form-control" value="" tabindex="4" />
											</div>
										</div>
										<br>
										<!-- <p>
											<label for="rut_usuario" class="left">RUT:</label>
											<input type="text" name="rut_usuario" id="rut_usuario" class="field" value="" tabindex="4" />
										</p> -->
										<div class="form-group row">
											<div class="col-md-4">
												<label for="email_usuario">Email:</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="email_usuario" id="email_usuario" class="form-control" value="" tabindex="4" />
											</div>
										</div>
										<br>
										<!-- <p>
											<label for="email_usuario" class="left">Email:</label>
											<input type="text" name="email_usuario" id="email_usuario" class="field" value="" tabindex="4" />
										</p> -->
										<div class="form-group row">
											<div class="col-md-4">
												<label for="tel_movil_usuario">Teléfono Móvil:</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="tel_movil_usuario" id="tel_movil_usuario" class="form-control" value="+569" tabindex="4" />
											</div>
										</div>
										<br>
										<!-- <p>
											<label for="tel_movil_usuario" class="left">Tel. M&oacute;vil:</label>
											<input type="text" name="tel_movil_usuario" id="tel_movil_usuario" class="field" value="+569" tabindex="4" />
										</p> -->
										<div class="form-group row">
											<div class="col-md-4">
												<label for="clave_usuario">Clave:</label>
											</div>
											<div class="col-md-8">
												<input type="text" name="clave_usuario" id="clave_usuario" class="form-control" value="<?php echo genpass(); ?>" tabindex="4" />
											</div>
										</div>
										<br>
										<!-- <p>
											<label for="clave_usuario" class="left">Clave:</label>
											<input type="text" name="clave_usuario" id="clave_usuario" class="field" value="<?php echo genpass(); ?>" tabindex="4" />
										</p> -->
										<div class="form-group row">
											<div class="col-md-4">
												<label for="aviso_sensor_usuario">Aviso Sensor:</label>
											</div>
											<div class="col-md-8">
												<select class="form-select" id="aviso_sensor_usuario" name="aviso_sensor_usuario">
													<option value="0">NO</option>
													<option value="1">SI</option>
												</select>
											</div>
										</div>
										<br>
										<!-- <p>
											<label for="aviso_sensor_usuario" class="left">Aviso Sensor:</label>
											<select name="aviso_sensor_usuario" id="aviso_sensor_usuario" class="combo">
												<option value="0">NO</option>
												<option value="1">SI</option>
											</select>
										</p> -->
										<div class="form-group row">
											<div class="col-md-4">
												<label for="administrador_usuario">Usuario Administrador:</label>
											</div>
											<div class="col-md-8">
												<select class="form-select" id="administrador_usuario" name="administrador_usuario">
													<option value="0">NO</option>
													<option value="1">SI</option>
												</select>
											</div>
										</div>
										<br>
										<!-- <p>
											<label for="administrador_usuario" class="left">Administrador:</label>
											<select name="administrador_usuario" id="administrador_usuario" class="combo">
												<option value="0">NO</option>
												<option value="1">SI</option>
											</select>
										</p> -->
										<div class="form-group row">
											<div class="col-md-4">
												<label for="sistema_usuario">Aviso Sensor:</label>
											</div>
											<div class="col-md-8">
												<select class="form-select" id="sistema_usuario" name="sistema_usuario">
													<?php
													$SQL = "SELECT id, nombre FROM eve_sistema ORDER BY id";
													$request_sistema = consulta_sql($SQL);
													$HTML = '';
													while ($datos_sistema = mysqli_fetch_array($request_sistema)) {
														$HTML .= '<option value="' . $datos_sistema[0] . '">' . $datos_sistema[1] . '</option>';
													}
													echo $HTML;
													?>
												</select>
											</div>
										</div>
										<br>
										<!-- <p>
											<label for="sistema_usuario" class="left">Sistema:</label>
											<select name="sistema_usuario" id="sistema_usuario" class="combo">
												<?php
												/*$SQL = "SELECT id, nombre FROM eve_sistema ORDER BY id";
												$request_sistema = consulta_sql($SQL);
												$HTML = '';
												while ($datos_sistema = mysqli_fetch_array($request_sistema)) {
													$HTML .= '<option value="' . $datos_sistema[0] . '">' . $datos_sistema[1] . '</option>';
												}
												echo $HTML;*/
												?>
											</select>
										</p> -->
										<div class="form-group row">
											<div class="col-md-4">
												<label for="enviar_email_usuario">Enviar Email:</label>
											</div>
											<div class="col-md-8">
												<select class="form-select" id="enviar_email_usuario" name="enviar_email_usuario">
													<option value="0">NO</option>
													<option value="1">SI</option>
												</select>
											</div>
										</div>
										<br>
										<!-- <p>
											<label for="enviar_email_usuario" class="left">Enviar Email:</label>
											<input type="checkbox" name="enviar_email_usuario" id="enviar_email_usuario" value="1" />
										</p> -->
										<p>
											<input type="button" name="submit" id="submit_1" class="btn btn-success" value="Agregar Usuario" tabindex="6" onclick="addUser()" />
										</p>
									</div>
								</div>
							</div>
						</div>
						<script type="text/javascript">
							$(document).ready(function() {
								$('#rut_usuario').bind('blur', function(e) {
									if (!validaRut($(this).val(), 'rut_usuario')) {
										$(this).val('');
										alert('Por favor, ingrese un RUT válido');
										$(this).focus();
									}
								});
							});
						</script>
					<?php
					} else if ($_GET['page'] == "edit") {

						$ID = $_GET['userid'];
						$SQL = "SELECT * FROM usuario WHERE id=$ID";

						$request_usuario = consulta_sql($SQL);
						$datos_usuarios = mysqli_fetch_array($request_usuario);

					?>
						<h5 class="alert alert-success" role="alert">Gestión de Usuarios - Editar Usuario</h5>
						<hr>

						<span id="mensaje"></span>
						<script>
							$(document).ready(function() {
								$('#sistema_usuario option[value=<?= $datos_usuarios['sistema'] ?>]').attr('selected', 'selected');
							});
						</script>


						<div class="form-group row">
							<div class="col-md-3 ">
								<p><a class="btn btn-success" href="../admin/usuarios.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=main">Volver</a></p>
							</div>
							<div class="col-md-6 ">
								<div class="card">
									<form>
										<input type="hidden" value="<?= $ID ?>" id="userid" />
										<fieldset>
											<div class="card-header">
												<h5>Actualizar datos de usuario</h5>
											</div>
											<div class="card-body">
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
														<input type="text" name="rut_usuario" id="rut_usuario" class="form-control" value="<?= $datos_usuarios['rut'] ?>" tabindex="4" />
													</div>
												</div>
												<br>
												<!-- <p>
												<label for="rut_usuario" class="left">RUT:</label>
												<input type="text" name="rut_usuario" readonly="true" id="rut_usuario" class="field" value="<?= $datos_usuarios['rut'] ?>" tabindex="4" />
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



												<div class="form-group row">
													<div class="col-md-4">
														<label for="aviso_sensor_usuario">Aviso Sensor:</label>
													</div>
													<div class="col-md-8">
														<select class="form-select" id="aviso_sensor_usuario" name="aviso_sensor_usuario">
															<option value="0" <?php if ($datos_usuarios['aviso_sensor'] == 0) echo 'selected="selected"' ?>>NO</option>
															<option value="1" <?php if ($datos_usuarios['aviso_sensor'] == 1) echo 'selected="selected"' ?>>SI</option>
														</select>
													</div>
												</div>
												<br>

												<div class="form-group row">
													<div class="col-md-4">
														<label for="administrador_usuario">Usuario Administrador:</label>
													</div>
													<div class="col-md-8">
														<select class="form-select" id="administrador_usuario" name="administrador_usuario">
															<option value="0" <?php if ($datos_usuarios['administrador'] == 0) echo 'selected="selected"' ?>>NO</option>
															<option value="1" <?php if ($datos_usuarios['administrador'] == 1) echo 'selected="selected"' ?>>SI</option>
														</select>
													</div>
												</div>
												<br>

												<div class="form-group row">
													<div class="col-md-4">
														<label for="sistema_usuario">Sistema:</label>
													</div>
													<div class="col-md-8">
														<select class="form-select" id="sistema_usuario" name="sistema_usuario">
															<?php
															$SQL = "SELECT id, nombre FROM eve_sistema ORDER BY id";
															$request_sistema = consulta_sql($SQL);
															$HTML = '';
															while ($datos_sistema = mysqli_fetch_array($request_sistema)) {
																$HTML .= '<option value="' . $datos_sistema[0] . '">' . $datos_sistema[1] . '</option>';
															}
															echo $HTML;
															?>
														</select>
													</div>
												</div>
												<br>




												<!-- <p>
												<label for="aviso_sensor_usuario" class="left">Aviso Sensor:</label>
												<select name="aviso_sensor_usuario" id="aviso_sensor_usuario" class="combo">
													<option value="0" <?php if ($datos_usuarios['aviso_sensor'] == 0) echo 'selected="selected"' ?>>NO</option>
													<option value="1" <?php if ($datos_usuarios['aviso_sensor'] == 1) echo 'selected="selected"' ?>>SI</option>
												</select>
											</p>
											<p>
												<label for="administrador_usuario" class="left">Administrador:</label>
												<select name="administrador_usuario" id="administrador_usuario" class="combo">
													<option value="0" <?php if ($datos_usuarios['administrador'] == 0) echo 'selected="selected"' ?>>NO</option>
													<option value="1" <?php if ($datos_usuarios['administrador'] == 1) echo 'selected="selected"' ?>>SI</option>
												</select>
											</p>
											<p>
												<label for="sistema_usuario" class="left">Sistema:</label>
												<select name="sistema_usuario" id="sistema_usuario" class="combo">
													<?php
													$SQL = "SELECT id, nombre FROM eve_sistema ORDER BY id";
													$request_sistema = consulta_sql($SQL);
													$HTML = '';
													while ($datos_sistema = mysqli_fetch_array($request_sistema)) {
														$HTML .= '<option value="' . $datos_sistema[0] . '">' . $datos_sistema[1] . '</option>';
													}
													echo $HTML;
													?>
												</select>
											</p> -->
												<p>
													<input type="button" name="submit" id="submit_1" class="btn btn-success" value="Actualizar Usuario" tabindex="6" onclick="updateUser()" />
												</p>
										</fieldset>
									</form>
									<form>
										<fieldset>
											<div class="card-header">
												<h5>ACTUALIZAR CLAVE DE USUARIO</h5>
											</div>
											<div class="card-body">
												<div class="form-group row">
													<div class="col-md-4">
														<label for="clave_usuario">Clave:</label>
													</div>
													<div class="col-md-8">
														<input type="text" name="clave_usuario" id="clave_usuario" class="form-control" value="<?php echo genpass(); ?>" tabindex="4" />
													</div>
												</div>

												<br>
												<!-- <p>
												<label for="clave_usuario" class="left">Clave:</label>
												<input type="text" name="clave_usuario" id="clave_usuario" class="field" value="<?php echo genpass(); ?>" tabindex="4" />
											</p> -->
												<p>
													<input type="button" name="submit" id="submit_1" class="btn btn-success" value="Actualizar Clave" tabindex="6" onclick="updatePassUser()" />
												</p>
											</div>
										</fieldset>
									</form>
								</div>
							</div>
						</div>
				</div>
				<script type="text/javascript">
					$(document).ready(function() {
						$('#rut_usuario').bind('blur', function(e) {
							if (!validaRut($(this).val(), 'rut_usuario')) {
								$(this).val('');
								alert('Por favor, ingrese un RUT válido');
								$(this).focus();
							}
						});
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