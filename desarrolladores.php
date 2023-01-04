<?php
	require('aut_logout.php');
	
	if(check_mysql()){
		estadisticas('WEB','UNIQUE_PAGE_VIEW');
		$SYSTEM_ENABLE = get_parameter('SYSTEM_ENABLE');
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
		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="./css/mf54_reset.css" />
		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="./css/mf54_grid_nosidebar.css" />
		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="./css/mf54_content_nosidebar.css" />
		<link rel="icon" type="image/x-icon" href="./img/favicon.ico" />
		<script src="js/validaciones.js" type="text/javascript"></script>
		<script src="js/jquery.js" type="text/javascript"></script>
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
    
        				<!-- A.2 BUTTON NAVIGATION -->
        				<div class="navbutton">
          					<ul>
            						<li><a href="http://translate.google.cl/translate?hl=es&sl=es&tl=en&u=http%3A%2F%2Fwww.citrautalca.cl%2Feve" title="English"><img src="./img/icon_flag_us.gif" alt="Flag" /></a></li>
            						<li><a href="http://translate.google.cl/translate?hl=es&sl=es&tl=de&u=http%3A%2F%2Fwww.citrautalca.cl%2Feve" title="Deutsch"><img src="./img/icon_flag_de.gif" alt="Flag" /></a></li>
          					</ul>
        				</div>

					<!-- A.3 GLOBAL NAVIGATION -->
        				<div class="navglobal">
          					<ul>
            						<li><a href="#" title="">Acerca de...</a></li>
							<li><a href="#" title="">Contacto</a></li>							            
          					</ul>
        				</div>        
      				</div>
    			</div>
    			<div class="corner-page-bottom"></div>    
    
    			<!-- B. NAVIGATION BAR -->
			<?php require_once('menu_index.inc.php') ?>    
  
			<!-- C. MAIN SECTION -->      
			<div class="main">

				<!-- C.1 CONTENT -->
				<div class="content">

				<!-- ************************************************************ -->
				<!-- **   3-08. LOGIN FORM                                     ** -->
				<!-- ************************************************************ --> 
					
					<!-- CONTENT CELL -->                        
					<a id="anchor-text-1"></a>
					<div class="corner-content-1col-top"></div>                        
					<div class="content-1col-nobox">
						<h1>Desarrolladores</h1>
						<h2>CITRA</h2>
						<h4>Centro de Investigaci&oacute;n y Transferencia en Riego y Agroclimatolog&iacute;a</h4>
						<p style="text-align: justify;"><b><img src="img/logo-citra-new.png" border="0" width="100" height="100" style="float: left; border: 0;" />Misi&oacute;n</b>	
							Realizar investigaci&oacute;n cient&iacute;fica y aplicada en el &aacute;mbito del riego, modelamiento biomatem&aacute;tico y agricultura de precisi&oacute;n; transferir sus resultados al sector productivo y apoyar la docencia de pre-grado y post-grado en la Facultad de Ciencias Agrarias de la Universidad de Talca.
						</p>
						<p style="text-align: justify;"><b>Visi&oacute;n</b>
							Posicionarse como un Centro de referencia Nacional e Internacional, que contribuya a la optimizaci&oacute;n del uso del agua a nivel predial a trav&eacute;s de la incorporaci&oacute;n de t&eacute;cnicas de manejo con alto nivel tecnol&oacute;gico, no solo para la obtenci&oacute;n de altos rendimientos y calidad de los productos agr&iacute;colas sino tambi&eacute;n minimizar sus costos y preservar el medio ambiente.</p>
						
						<p class="demo"></p>   
					
						
					</div> 
					<div class="corner-content-1col-bottom"></div>  

            				<!-- END OF CONTENT -->
    				</div>
    			</div>
			<!-- D. FOOTER -->      
			<?php require('footer.inc.php');?>
			<!--[if lt IE 9]>
				<div style='border: 1px solid #F7941D; background: #FEEFDA; text-align: center; clear: both; height: 75px; position: relative; margin-bottom: 30px;'>
					<div style='position: absolute; right: 3px; top: 3px; font-family: courier new; font-weight: bold;'><a href='#' onclick='javascript:this.parentNode.parentNode.style.display="none"; return false;'><img src='img/noie6/ie6nomore-cornerx.jpg' style='border: none;' alt='Cierra este aviso'/></a></div>
						<div style='width: 640px; margin: 0 auto; text-align: left; padding: 0; overflow: hidden; color: black;'>
						<div style='width: 75px; float: left;'><img src='img/noie6/ie6nomore-warning.jpg' alt='Aviso' style="border: none;"/></div>
						<div style='width: 275px; float: left; font-family: Arial, sans-serif;'>
						<div style='font-size: 14px; font-weight: bold; margin-top: 2px;'>Usted est&aacute; usando un navegador desactualizado.</div>
						<div style='font-size: 12px; margin-top: 1px; line-height: 12px;'>Para tener una mejor experiencia en Eve, por favor, actualice su navegador a la ultima versi&oacute;n o c&aacute;mbielo por una de estas alternativas.</div>
					</div>
						<div style='width: 60px; float: left;'><a href='http://www.mozilla-europe.org/es/firefox/' target='_blank'><img src='img/noie6/ie6nomore-firefox.jpg' style='border: none;' alt='Descargar la ultima version de Firefox'/></a></div>
						<div style='width: 60px; float: left;'><a href='http://windows.microsoft.com/es-ES/windows/downloads?T1=downloadsIE' target='_blank'><img src='img/noie6/ie6nomore-ie.jpg' style='border: none;' alt='Descargar la ultima version de Internet Explorer'/></a></div>
						<div style='width: 60px; float: left;'><a href='http://www.apple.com/es/safari/download/' target='_blank'><img src='img/noie6/ie6nomore-safari.jpg' style='border: none;' alt='Descargar la ultima version de Safari'/></a></div>
						<div style='width: 60px; float: left;'><a href='http://www.opera.com/browser/download/' target='_blank'><img src='img/noie6/ie6nomore-opera.jpg' style='border: none;' alt='Descargar la ultima version de Opera'/></a></div>
						<div style='float: left;'><a href='http://www.google.com/chrome?hl=es' target='_blank'><img src='img/noie6/ie6nomore-chrome.jpg' style='border: none;' alt='Descargar la ultima version de  Google Chrome'/></a></div>
					</div>
				</div>
			<![endif]-->
		</div> 
	</body>
</html>



