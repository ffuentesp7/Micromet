<?php
require('../aut_verifica.inc.php');
require('../funciones.inc.php');
check_admin($_SESSION['session_nombre_sesion']);
estadisticas('WEB', 'PAGE_VIEW');
estadisticas('ADMIN_USE', 'PERMISOS');
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
	<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
	<link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
	<?php require_once('../head.link.script.php'); ?>
	<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

	<script src="js/permisos.js" type="text/javascript"></script>
	<title>Micromet - Biovision</title>
</head>


<body>
	<div class="d-flex" id="wrapper">

		<?php require('../system/navigation_sidebar.inc.php'); ?>

		<div class="content" id="page-content-wrapper">
			<?php require('../system/navigation_bar.inc.php'); ?>
			<br>
			<div class="container-fluid">

				<div class="content-1col-nobox">
					<?php

					$PAGE = "main";
					if (isset($_GET['page']))
						$PAGE = $_GET['page'];

					if ($PAGE == "main") {
					?>
						<h5 class="alert alert-success" role="alert">Gestión de Permisos</h5>
						<hr>
						<div class="form-group row">
							<div class="col-md-3 "> </div>
							<div class="col-md-6 ">
								<div class="card">
									<div class="card-header">
										<h5 class="webtemplate" id="top_title">Permisos</h5>
									</div>
									<div class="card-body">
										<table style="width: auto; background-color: #fff;">
											<tr>
												<td class="whitenoborder"><a href="../admin/permisos.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=usuario" onmouseover="javascript: swapText('top_title','Permisos de Usuarios');" onmouseout="javascript: swapText('top_title','Permisos');"><img class="blueborder" src="../img/actionicons/user_permission.png" /></a></td>
												<td class="whitenoborder"><a href="../admin/permisos.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=estacion" onmouseover="javascript: swapText('top_title','Permisos de Estaci&oacute;n');" onmouseout="javascript: swapText('top_title','Permisos');"><img class="blueborder" src="../img/actionicons/station_permission.png" /></a></td>
												<td class="whitenoborder"><a href="../admin/permisos.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=tipousuario" onmouseover="javascript: swapText('top_title','Tipos de Permisos de Usuarios');" onmouseout="javascript: swapText('top_title','Permisos');"><img class="blueborder" src="../img/actionicons/users.png" /></a></td>
												<td class="whitenoborder"><a href="../admin/permisos.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=tipoestacion" onmouseover="javascript: swapText('top_title','Tipos de Permisos de Estaci&oacute;n');" onmouseout="javascript: swapText('top_title','Permisos');"><img class="blueborder" src="../img/actionicons/station.png" /></a></td>
												<td class="whitenoborder"><a href="../admin/permisos.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=ver" onmouseover="javascript: swapText('top_title','Ver Tipos de Permisos');" onmouseout="javascript: swapText('top_title','Permisos');"><img class="blueborder" src="../img/actionicons/permission.png" /></a></td>
											</tr>
										</table>
									</div>
								</div>


							</div>
						</div>
					<?php
					} elseif ($PAGE == "usuario") {
					?>
						<h5 class="alert alert-success" role="alert">Gestión de Permisos - Permisos de Usuario</h5>
						<hr>
						<div class="form-group row">

							<p><a class="btn btn-success" href="../admin/permisos.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=main">Volver</a></p>
							<span id="mensaje"></span>
							<div class="form-group row">
								<div class="col-md-6 ">
									<div class="card">
										<form>
											<fieldset>
												<div class="card-header">
													<h5>Otorgar Permisos</h5>
												</div>
												<div class="card-body">
													<div class="form-group row">
														<div class="col-md-4">
															<label for="nombre_usuario">Nombre:</label>
														</div>
														<div class="col-md-5">
															<input type="text" class="form-control" name="nombre_usuario" id="nombre_usuario" readonly="true" />
														</div>
														<div class="col-md-3">
															<a href="usuarios.lista.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&keepThis=true&TB_iframe=true&height=400&width=500" title="Seleccione Usuario" class="thickbox btn btn-success">Seleccionar Usuario</a>

														</div>
													</div>
													<br>
													<!-- <p>
											<label for="nombre_usuario" class="left">Nombre:</label>
											<input type="text" class="form-control" name="nombre_usuario" id="nombre_usuario" readonly="true" />
											<a href="usuarios.lista.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&keepThis=true&TB_iframe=true&height=400&width=500" title="Seleccione Usuario" class="thickbox btn btn-success">Seleccionar Usuario</a>
										</p> -->
													<div class="form-group row">
														<div class="col-md-4">
															<label for="usuario_id">ID Usuario:</label>
														</div>
														<div class="col-md-8">
															<input readonly="true" type="text" class="form-control" name="usuario_id" id="usuario_id" />

														</div>
													</div>
													<br>
													<!-- <p>
											<label for="usuario_id" class="left">Usuario ID</label>
											<input readonly="true" type="text" class="field" style="width: 75px;" name="usuario_id" id="usuario_id" />
										</p> -->
													<div class="form-group row">
														<div class="col-md-4">
															<label for="permisos">Permiso:</label>
														</div>
														<div class="col-md-6">
															<select name="permisos" id="permisos" class="form-select">
																<option>PERMISO</option>
															</select>
														</div>
														<div class="col-md-2">
															<a href="#" class="btn btn-success" id="boton_otorgar_permiso" title="Otorgar Permiso">Otorgar</a>

														</div>
													</div>
													<!-- <p>
											<label for="permisos" class="left">Permiso:</label>
											<select name="permisos" id="permisos">
												<option>PERMISO</option>
											</select>
											<a href="#" class="btn btn-success" id="boton_otorgar_permiso" title="Otorgar Permiso">Otorgar Permiso</a>
										</p> -->
												</div>
											</fieldset>
										</form>
									</div>
								</div>
								<div class="col-md-6 ">
									<h5 class="webtemplate" id="top_title">Permisos Otorgados</h5>
									<span id="contenido"></span>
									<table style='width: 100%;' id="tabla_permisos_otorgados" class="table table-hover dataTable no-footer">
										<thead>
											<tr>
												<th class='top' scope='col'>Nombre</th>
												<th class='top' scope='col'>C&oacute;digo</th>
												<th class='top' scope='col'>Valor</th>
												<th class='top' scope='col'>Quitar</th>
											</tr>
										</thead>
										<tbody id="body_tabla_permisos_otorgados"></tbody>

									</table>
								</div>

							</div>

						</div>
						<script type="text/javascript">
							$(document).ready(function() {

								$('#boton_otorgar_permiso').bind('click', function(e) {
									giveUserPermission();
								});
								$('#tabla_permisos_otorgados').DataTable();




							});
						</script>
					<?php
					} elseif ($PAGE == "estacion") {
					?>
						<h5 class="alert alert-success" role="alert">Gestión de Permisos - Permisos de Estación</h5>
						<hr>
						<p><a class="btn btn-success" href="../admin/permisos.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=main">Volver</a></p>
						<span id="mensaje"></span>
						<div class="form-group row">
							<div class="col-md-6 ">
								<form>
									<div class="card">
										<div class="card-header">
											<h5>Otorgar Permisos</h5>
										</div>
										<div class="card-body">
											<div class="form-group row">
												<div class="col-md-4">
													<label for="nombre_estacion">Estación:</label>
												</div>
												<div class="col-md-6">
													<input type="text" class="form-control" name="nombre_estacion" id="nombre_estacion" readonly="true" />
												</div>
												<div class="col-md-2">
													<a href="estaciones.lista.php?class=ownpermission&sid=<?= $_SESSION['session_nombre_sesion'] ?>&keepThis=true&TB_iframe=true&height=400&width=500" title="Seleccione Estaci&oacute;n" class="thickbox btn btn-success">Seleccionar</a>

												</div>
											</div>
											<br>
											<!-- <p>
										<label for="nombre_estacion" class="left">Nombre:</label>
										<input type="text" class="field" name="nombre_estacion" id="nombre_estacion" readonly="true" />
										<a href="estaciones.lista.php?class=ownpermission&sid=<?= $_SESSION['session_nombre_sesion'] ?>&keepThis=true&TB_iframe=true&height=400&width=500" title="Seleccione Estaci&oacute;n" class="thickbox">&#091;Seleccionar Estaci&oacute;n&#093;</a>
									</p> -->
											<div class="form-group row">
												<div class="col-md-4">
													<label for="estacion_id">ID Estación:</label>
												</div>
												<div class="col-md-8">
													<input readonly="true" type="text" class="form-control" name="estacion_id" id="estacion_id" />

												</div>
											</div>
											<br>
											<!-- <p>
										<label for="estacion_id" class="left">Estacion ID</label>
										<input readonly="true" type="text" class="field" style="width: 75px;" name="estacion_id" id="estacion_id" />
									</p> -->
											<div class="form-group row">
												<div class="col-md-4">
													<label for="permisos">Permiso:</label>
												</div>
												<div class="col-md-6">
													<select name="permisos" id="permisos" class="form-select">
														<option>PERMISO</option>
													</select>
												</div>
												<div class="col-md-2">
													<a href="#" class="btn btn-success" id="boton_otorgar_permiso" title="Otorgar Permiso">Otorgar</a>

												</div>
											</div>
											<!-- <p>
												<label for="permisos" class="left">Permiso:</label>
												<select name="permisos" id="permisos">
													<option>PERMISO</option>
												</select>
												<a href="#" id="boton_otorgar_permiso" title="Otorgar Permiso">&#091;Otorgar Permiso&#093;</a>
											</p> -->
										</div>
									</div>
								</form>
							</div>
							<div class="col-md-6 ">
								<h5 class="webtemplate" id="top_title">Permisos Otorgados</h5>
								<span id="contenido"></span>
								<table style='width: 100%;' id="tabla_permisos_otorgados">
									<tr>
										<th class='top' scope='col'>Nombre</th>
										<th class='top' scope='col'>C&oacute;digo</th>
										<th class='top' scope='col'>Valor</th>
										<th class='top' scope='col'>Quitar</th>
									</tr>
								</table>
							</div>
						</div>

						<script type="text/javascript">
							$(document).ready(function() {
								$('#boton_otorgar_permiso').bind('click', function(e) {
									giveStationPermission();
								});
							});
						</script>
					<?php
					} elseif ($PAGE == "tipousuario") {
					?>
						<h5 class="alert alert-success" role="alert">Gestión de Permisos - Tipo de Permisos de Usuario</h5>
						<hr>


						<span id="mensaje"></span>
						<div class="form-group row">
							<div class="col-md-3 ">
								<p><a class="btn btn-success" href="../admin/permisos.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=main">Volver</a></p>

							</div>
							<div class="col-md-6 ">
								<div class="card">
									<fieldset>
										<div class="card-header">
											<h5>Datos de Tipo de Permiso</h5>
										</div>
										<div class="card-body">
											<p><a href="estaciones.lista.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&keepThis=true&TB_iframe=true&height=400&width=500" title="Seleccione Estaci&oacute;n" class="thickbox btn btn-success">Obtener desde Estación</a></p>

											<div class="form-group row">
												<div class="col-md-4">
													<label for="select_estacion">Nombre:</label>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control" name="nombre" id="nombre_tipo_permiso" />
												</div>
											</div>
											<br>
											<!-- <p>
										<label for="nombre" class="left">Nombre:</label>
										<input type="text" class="field" name="nombre" id="nombre_tipo_permiso" />
									</p> -->
											<div class="form-group row">
												<div class="col-md-4">
													<label for="codigo">Código:</label>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control" name="codigo" id="codigo_tipo_permiso" />
												</div>
											</div>
											<br>
											<!-- <p>
												<label for="codigo" class="left">C&oacute;digo:</label>
												<input type="text" class="field" name="codigo" id="codigo_tipo_permiso" />
											</p> -->
											<div class="form-group row">
												<div class="col-md-4">
													<label for="valor">Valor:</label>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control" name="valor" id="valor_tipo_permiso" />
												</div>
											</div>
											<!-- <p>
												<label for="valor" class="left">Valor:</label>
												<input type="text" class="field" name="valor" id="valor_tipo_permiso" />
											</p> -->
											<p>
												<input type="button" class="btn btn-success" value="Ingresar" id="boton_ingresar_permiso" />
											</p>
										</div>
									</fieldset>
									</form>
								</div>
							</div>
						</div>
						<script type="text/javascript">
							$(document).ready(function() {
								$('#boton_ingresar_permiso').bind('click', function(e) {
									addUserTypePermission();
								});
							});
						</script>
					<?php
					} elseif ($PAGE == "tipoestacion") {
					?>
						<h5 class="alert alert-success" role="alert">Gestión de Permisos - Tipo de Permisos de Estación</h5>
						<hr>

						<span id="mensaje"></span>
						<div class="form-group row">
							<div class="col-md-3 ">
								<p><a class="btn btn-success" href="../admin/permisos.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=main">Volver</a></p>

							</div>
							<div class="col-md-6 ">
								<div class="card">
									<form>
										<div class="card-header">
											<h5>Datos de Tipo de Permiso</h5>
										</div>

										<div class="card-body">
											<div class="form-group row">
												<div class="col-md-4">
													<label for="nombre">Nombre:</label>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control" name="nombre" id="nombre_tipo_permiso" />
												</div>
											</div>
											<br>
											<!-- <p>
										<label for="nombre" class="left">Nombre:</label>
										<input type="text" class="field" name="nombre" id="nombre_tipo_permiso" />
									</p> -->
											<div class="form-group row">
												<div class="col-md-4">
													<label for="codigo">Código:</label>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control" name="codigo" id="codigo_tipo_permiso" />
												</div>
											</div>
											<br>
											<!-- <p>
										<label for="codigo" class="left">C&oacute;digo:</label>
										<input type="text" class="field" name="codigo" id="codigo_tipo_permiso" />
									</p> -->
											<div class="form-group row">
												<div class="col-md-4">
													<label for="valor">Valor:</label>
												</div>
												<div class="col-md-8">
													<input type="text" class="form-control" name="valor" id="valor_tipo_permiso" />
												</div>
											</div>
											<!-- <p>
										<label for="valor" class="left">Valor:</label>
										<input type="text" class="field" name="valor" id="valor_tipo_permiso" />
									</p> -->
											<p>
												<input type="button" class="btn btn-success" value="Ingresar" id="boton_ingresar_permiso" />
											</p>
										</div>
									</form>
								</div>
							</div>
						</div>
						<script type="text/javascript">
							$(document).ready(function() {
								$('#boton_ingresar_permiso').bind('click', function(e) {
									addStationTypePermission();
								});
							});
						</script>
					<?php
					} elseif ($PAGE == "ver") {
					?>
						<h5 class="alert alert-success" role="alert">Gestión de Permisos - Tipo de Permisos general</h5>
						<hr>
						<!-- <p><a href="../admin/permisos.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=main">Volver</a></p> -->
						<span id="mensaje"></span>
						<div class="form-group row">
							<div class="col-md-4 ">
								<p><a class="btn btn-success" href="../admin/permisos.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=main">Volver</a></p>

								<div class="card">
									<div class="card-header">
										<h5>Datos de Tipo de Permiso</h5>
									</div>
									<div class="card-body">
										<div class="form-group row">
											<div class="col-md-4">
												<label for="tipo_de_permiso">Tipo:</label>
											</div>
											<div class="col-md-8">
												<select class="form-select" name="tipo_de_permiso" id="tipo_de_permiso">
													<option value="usuario">USUARIO</option>
													<option value="estacion">ESTACI&Oacute;N</option>
												</select>
											</div>
										</div>
										<!-- <p>
										<label for="tipo_de_permiso" class="left">Tipo:</label>
										<select name="tipo_de_permiso" id="tipo_de_permiso">
											<option value="usuario">USUARIO</option>
											<option value="estacion">ESTACI&Oacute;N</option>
										</select>
									</p> -->
										<p>
											<input type="button" class="btn btn-success" value="Mostrar" id="boton_mostrar_permisos" />
										</p>
									</div>

								</div>
							</div>
							<div class="col-md-8 ">
								<span id="contenido"></span>
							</div>
						</div>

						<script type="text/javascript">
							$(document).ready(function() {
								$('#boton_mostrar_permisos').bind('click', function(e) {
									seePermissions();
								

								});
							});
						</script>
					<?php
					} elseif ($PAGE == "edit") {
						$SQL = "SELECT id,nombre,code,value FROM eve_tipo_de_permiso_" . $_GET['tipo'] . " WHERE id=" . $_GET['id'];

						$result_tipo_de_permiso = consulta_sql($SQL);

						$datos_tipo_de_permiso = mysqli_fetch_array($result_tipo_de_permiso);

					?>
						<h5 class="alert alert-success" role="alert">Gestión de Permisos - Editar Tipo de Permiso</h5>
						<hr>

						
						<span id="mensaje"></span>
						<div class="form-group row">
					<div class="col-md-3 ">
					<p><a class="btn btn-success" href="../admin/permisos.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>&page=main">Volver</a></p>
						 </div>
					<div class="col-md-6 ">
								<div class="card">
									<div class="card-header"><h5>Datos de Tipo de Permiso</h5></div>
									<div class="card-body">
									<div class="form-group row">
											<div class="col-md-4">
												<label for="nombre">Nombre:</label>
											</div>
											<div class="col-md-8">
											<input type="text" class="form-control" name="nombre" id="nombre_tipo_permiso" value="<?= $datos_tipo_de_permiso['nombre'] ?>" />

											</div>
										</div>
										<br>
									<!-- <p>
										<label for="nombre" class="left">Nombre:</label>
										<input type="text" class="field" name="nombre" id="nombre_tipo_permiso" value="<?= $datos_tipo_de_permiso['nombre'] ?>" />
									</p> -->
									<div class="form-group row">
											<div class="col-md-4">
												<label for="codigo">Código:</label>
											</div>
											<div class="col-md-8">
											<input type="text" class="form-control" name="codigo" id="codigo_tipo_permiso" value="<?= $datos_tipo_de_permiso['code'] ?>" />

											</div>
										</div>
										<br>
									<!-- <p>
										<label for="codigo" class="left">C&oacute;digo:</label>
										<input readonly="true" type="text" class="field" name="codigo" id="codigo_tipo_permiso" value="<?= $datos_tipo_de_permiso['code'] ?>" />
									</p> -->
									<div class="form-group row">
											<div class="col-md-4">
												<label for="valor">Valor:</label>
											</div>
											<div class="col-md-8">
											<input type="text" class="form-control" name="valor" id="valor_tipo_permiso" value="<?= $datos_tipo_de_permiso['value'] ?>" />

											</div>
										</div>
										<br>
									<!-- <p>
										<label for="valor" class="left">Valor:</label>
										<input type="text" class="field" name="valor" id="valor_tipo_permiso" value="<?= $datos_tipo_de_permiso['value'] ?>" />
									</p> -->
									<p>
										<input type="button" class="btn btn-success" value="Actualizar" id="boton_actualizar_permiso" />
									</p>
									<input type="hidden" id="tipo_de_permiso" value="<?= $_GET['tipo']; ?>" />
									</div>
					</div>
					</div>
						</div>
						<script type="text/javascript">
							$(document).ready(function() {
								$('#boton_actualizar_permiso').bind('click', function(e) {
									updateTypePermission('<?= $datos_tipo_de_permiso['id'] ?>', '<?= $_GET['tipo']; ?>');
								});
							});
						</script>
					<?php
					}
					?>
				</div>
				<div class="corner-content-1col-bottom"></div>
			</div>
			<!-- C.2 SUBCONTENT-->
			<div class="subcontent">
				<!-- NAVIGATION SIDEBAR -->
			</div>
			<!-- END OF CONTENT -->
		</div>
		<!-- D. FOOTER -->
	</div>
	<!-- D. FOOT PANEL -->
	<?php require('../footer.inc.php'); ?>

	<?php require('../system/footpanel.inc.php'); ?>
</body>

</html>