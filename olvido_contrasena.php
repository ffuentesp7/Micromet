<?php
	require('aut_logout.php');
	if(check_mysql()){
		estadisticas('WEB','UNIQUE_PAGE_VIEW');
		estadisticas('USER','PASS_REMEMBER');
	}
	
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
		<link rel="icon" type="image/x-icon" href="./img/favicon.ico" />
		<script src="js/validaciones.js" type="text/javascript"></script>
		<script src="js/jquery.js" type="text/javascript"></script>
		<script src="olvido_contrasena.js" type="text/javascript"></script>
		<title>Micromet - Biovision</title>
	</head>

<!-- Global IE fix to avoid layout crash when single word size wider than column width -->
<!-- Following line MUST remain as a comment to have the proper effect -->
<!--[if IE]><style type="text/css"> body {word-wrap: break-word;}</style><![endif]-->

	<body>
		<!-- CONTAINER FOR ENTIRE PAGE -->
		<div class="container">

    			<!-- A. HEADER -->         
			<div class="corner-page-top"></div>        
			<div class="header">
				<div class="header-top">
        
        				<!-- A.1 SITENAME -->      
        				<?php require('sitename.inc.php'); ?>
    
   
				</div>
			</div>
    			<div class="corner-page-bottom"></div>    
    
    			<!-- B. NAVIGATION BAR -->
			<?php require_once('menu_index.inc.php') ?>    
  
			<!-- C. MAIN SECTION -->      
			<div class="main">
				<h5 class="pagetitle">Renovar Contrase&ntilde;a Olvidada</h5>

				<!-- C.1 CONTENT -->
				<div class="content">

				<!-- ************************************************************ -->
				<!-- **   3-08. LOGIN FORM                                     ** -->
				<!-- ************************************************************ --> 
					
					
					  <!-- CONTENT CELL (Subcells NOT boxes) -->                
					<a id="anchor-grid-901"></a>
					<div class="corner-content-1col-top"></div>                        
					<div class="content-1col-nobox">
						<!-- 3-COLUMN -->          
						<!-- LEFT Column-->
						<div class="content-3col-nobox-leftcolumn">
							<h1></h1>
							<p>Al presionar el bot&oacute;n "Renovar Contrase&ntilde;a" se le enviar&aacute; un correo electr&oacute;nico a la casilla registrada para confirmar la operaci&oacute;n.</p>
							<p>Luego deber&aacute; hacer click en el enlace del correo electronico para confimar la operaci&oacute;n y recibir la nueva contrase&ntilde;a.</p>
						</div>         
						<!-- MIDDLE Column -->          
						<div class="content-3col-nobox-middlecolumn">            
							<h5 class="login">Renovar Contrase&ntilde;a</h5>
							<div class="loginform" id="loginform">
								<form> 
									<fieldset>
										<?php
										if(check_mysql()){
											?>
											<p><label for="rut_pass" class="top">RUT:</label><br />
											<input type="text" name="rut_pass" id="rut_pass" tabindex="1" class="field" value="" onblur="return validaRut(this.value,'rut_pass');" /></p>
											<p><label for="codigo_pass" class="top">C&oacute;digo de Seguridad:</label><br />
											<img src="captcha.php" border="0" alt="captchaimagen" />
											<input type="password" name="codigo_pass" id="codigo_pass" tabindex="2" class="field" value="" /></p>
											<p><input id="boton_exe" type="button" name="login" class="button" style="width: auto;" value="RENOVAR CONTRASE&Ntilde;A" /></p>
											<script type="text/javascript">
												$("#boton_exe").bind("click",function(e){
													send_request();
												});
											</script>
											<?php
										}
										?>
									</fieldset>
								</form>
							</div>
						</div>          
						<!-- RIGHT Column -->          
						<div class="content-3col-nobox-rightcolumn">
							<h1></h1>      
						</div>                    
					</div> 
					<div class="corner-content-1col-bottom"></div>       
            				<!-- END OF CONTENT -->
    				</div>
    			</div>
			<!-- D. FOOTER -->      
			<?php require('footer.inc.php');?>
		</div> 
	</body>
</html>



