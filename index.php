<?php
require('aut_logout.php');

if (check_mysql()) {
	estadisticas('WEB', 'UNIQUE_PAGE_VIEW');
	$SYSTEM_ENABLE = get_parameter('SYSTEM_ENABLE');
}

// if (!isset($_GET['mobileoff']) && check_mobile_browser())
// 	header('Location: mobile/index.php');

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">


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

	<link rel="stylesheet" type="text/css" href="css/style.css" />

	<link rel="icon" type="image/x-icon" href="./img/favicon.ico" />
	<script src="js/validaciones.js" type="text/javascript"></script>
	<script src="js/jquery.js" type="text/javascript"></script>
	<title>Micromet</title>
</head>



<body>

	<div class="container">

		<!-- A. HEADER -->
		<div class="card">

			<div class="card-header">

				<!-- A.1 SITENAME -->
				<?php require('sitename.inc.php'); ?>

				<!-- A.2 BUTTON NAVIGATION
        				<div class="card-body">
          					<ul>
            						<li><a href="http://translate.google.cl/translate?hl=es&sl=es&tl=en&u=http%3A%2F%2Fwww.citrautalca.cl%2Feve" title="English"><img src="./img/icon_flag_us.gif" alt="Flag" /></a></li>
            						<li><a href="http://translate.google.cl/translate?hl=es&sl=es&tl=de&u=http%3A%2F%2Fwww.citrautalca.cl%2Feve" title="Deutsch"><img src="./img/icon_flag_de.gif" alt="Flag" /></a></li>
          					</ul>


        				<nav class="navbar navbar-expand-lg navbar-light bg-light">
          					<ul>
							<li><a href="mobile" title="">M&oacute;vil</a></li>
							<li><a href="mailto:roaguilar@utalca.cl?subject=Consulta desde EVE" title="">Contacto</a></li>
							<li><a href="#" title="">Acerca de...</a></li>
          					</ul>
						</nav>
						</div>-->


			</div>
		</div>


		<!-- B. NAVIGATION BAR -->
		<?php require_once('menu_index.inc.php') ?>

		<!-- C. MAIN SECTION -->
		<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
			<div class="card border-0 shadow rounded-3 my-5 text-center">
				<h3 class="card-header">Bienvenido a Micromet</h3>

				<!-- C.1 CONTENT -->
				<div class="card-body p-4 p-sm-5">

					<!-- ************************************************************ -->
					<!-- **   3-08. LOGIN FORM                                     ** -->
					<!-- ************************************************************ -->


					<h5 class="login">Acceso a Micromet</h5>

					<div class="loginform">
						<form method="post" action="router.php">
							<fieldset>
								<?php
								if (check_mysql()) {
								?>
									<div class="form-floating mb-3">
										<p><label for="rut_desde_index" class="top">RUT:</label><br />
											<input type="text" name="rut_desde_index" id="rut" class="form-control" value="" onblur="return validaRut(this.value,'rut');" />
										</p>
									</div>
									<p><label for="clave_desde_index" class="top">Contrase&ntilde;a:</label><br />
										<input type="password" name="clave_desde_index" id="clave" tabindex="2" class="form-control" value="" />
									</p>
									<p><input type="submit" name="login" class="btn btn-success btn-login text-uppercase fw-bold" value="ENTRAR" /></p>
									<p><a href="olvido_contrasena.php" id="forgotpsswd_3c">&iquest;Olvid&oacute; su Contrase&ntilde;a?</a></p>
								<?php
								}

								if ($error != "") {
									echo "<p>$error</p>";
								}
								if ($SYSTEM_ENABLE == 'OFF') {
									echo "<p>El Sistema Se encuentra desactivado. S&oacute;lo pueden ingresar administradores.</p>";
								}

								?>

							</fieldset>
						</form>
					</div>
				</div>

			</div>
		</div>

		<?php require('footer.inc.php'); ?>

	</div>
</body>

</html>