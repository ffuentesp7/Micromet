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
		<script src="http://www.meteochile.cl/js/reg07.js" type="text/javascript"></script>
		<script type="text/javascript">
			var fecha_obs = new Array();
			var indice_obs = new Array();
			var hora_obs = new Array();
			var imagen = new Array();
			var fecha_pro = new Array();
			var indice_pro = new Array();
			var observacion = new Array();
			var recomendacion = new Array();
		</script>
		
		<script src="http://www.meteochile.cl/js/uv_talca.js" type="text/javascript"></script>
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
				<h1 class="pagetitle">Pron&oacute;sticos de Meteochile</h1>

				<!-- C.1 CONTENT -->
				<div class="content">

				<!-- ************************************************************ -->
				<!-- **   3-08. LOGIN FORM                                     ** -->
				<!-- ************************************************************ --> 
					
					<a id="anchor-grid-501"></a>
					<div class="corner-content-1col-top"></div>                        
					<div class="content-1col-nobox">
						<h1>Pron&oacute;stico del Tiempo para la Regi&oacute;n del Maule</h1>
						<h2 id="nombre_ciudad"></h2>  
						<p>
							<span id="pronostico_tiempo"></span>
							<script type="text/javascript">
								function getForecastData(id){
									var ciudadesNombre 	= ciudades.split('|');
									itemNumber = id;
									if(id == '')
										itemNumber 		= Math.round(ciudadesNombre.length * Math.random());
									var temperaturasCiudad 	= temperaturas[ciudadesNombre[itemNumber]].split('|');
									var pronosticosCiudad	= pronosticos[ciudadesNombre[itemNumber]].split('|');
									var iconosCiudad	= iconos[ciudadesNombre[itemNumber]].split('|');
									var fechasCiudad	= fechas[ciudadesNombre[itemNumber]].split('|');
									
									html = "<table style='width: 800px; table-layout: auto; margin: 0 auto 0 auto;'>";
									
									for(i = 0; i < 5 ; i++){
										html+= "<tr>";
										html+= "<th class='top'>"+fechasCiudad[i]+"</th>";
										
										var maxMin = temperaturasCiudad[i].split('/');
										
										if(maxMin[0] != ''){
											html+= "<td>m&iacute;n. "+maxMin[0]+" &deg;C <br /> m&aacute;x. "+maxMin[1]+" &deg;C </td>";	
										}
										else{
											html+= "<td>m&aacute;x. "+maxMin[1]+" &deg;C </td>";
										}
										
										html+= "<td><img class='centernoborder' src='img/climaicons/"+iconosCiudad[i].replace('gif','png')+"' /></td>";
										html+= "<td>"+pronosticosCiudad[i]+"</td>";
										html+= "</tr>";
									}
									html += "</table>";
									
									html += "<table style='width: 800px; margin: 0 auto 0 auto;'>";
									html+= "<tr>";
									for(i = 0; i < 7 ; i++){
										
										html+= "<th class='top'><a href='javascript:getForecastData(\""+i+"\")' title='Ver pron&oacute;stico para "+ciudadesNombre[i]+"'>"+ciudadesNombre[i]+"</a></th>";
										
									}
									html+= "</tr>";
									html += "</table>";
									
									$('#nombre_ciudad').html('Pron&oacute;stico para la ciudad de '+ciudadesNombre[itemNumber]);
									$('#pronostico_tiempo').html(html);
								}
						
								$(document).ready(function(){
									getForecastData('');
								});
							</script>
						</p>
						<p><a target="_blank" href="http://www.meteochile.cl/pronostico.html">meteochile.cl</a></p>
						
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



