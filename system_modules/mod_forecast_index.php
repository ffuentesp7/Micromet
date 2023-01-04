<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	estadisticas('WEB','PAGE_VIEW');
	estadisticas('USER_USE','MOD_FORECAST');	
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
		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="../css/mf54_reset.css" />
  		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="../css/mf54_grid.css" />
  		<link rel="stylesheet" type="text/css" media="screen,projection,print" href="../css/mf54_content.css" />
		<link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
		<?php require_once('../head.link.script.php'); ?>
		<title>Micromet - Biovision</title>
		<script type="text/javascript" src="../system_modules/js/mod_forecast.js"></script>
		<script type="text/javascript">
			
			jQuery(document).ready(function(){
				var sid = $('#sid').val();
				url = 'mod_forecast_functions.php?sid='+sid+'&accion=get_list';
				
				$.get(url,'',function(data){
					$('#lista_pronosticos').html(data);
				});
				
				<?php
					if(isset($_GET['fid'])){
						echo "url = 'mod_forecast_functions.php?sid='+sid+'&accion=get_forecast_by_id&fid=".$_GET['fid']."';";
					}
					else{
						echo "url = 'mod_forecast_functions.php?sid='+sid+'&accion=get_last_forecast';";
					}
				?>
				
				$.get(url,'',function(data){
					$('#ultimo_pronostico').html(data);
				});
				
				jQuery( "#forecast_date" ).datepicker({
					dateFormat : "yy-mm-dd",
					showAnim : "blind",
					changeMonth: true,
					changeYear: true
				});
				
			});
			
			function edit_forecast(fid){
				var sid = $('#sid').val();
				var url = 'mod_forecast_admin.php?sid='+sid+'&page=edit&fid='+fid;
				
				window.location.href=url;
			}
			
			function show_forecast_by_date(){
				var sid = $('#sid').val();
				date = $('#forecast_date').val();
			
				url = 'mod_forecast_functions.php?sid='+sid+'&accion=get_forecast_by_date&date='+date;
				
				$('#ultimo_pronostico').html('<img class="centernoborder" src="../img/loaders/loader-01.gif" />');
				
				$.get(url,'',function(data){
					$('#ultimo_pronostico').html(data);
				});
			}
		</script>
	</head>

<!-- Global IE fix to avoid layout crash when single word size wider than column width -->
<!-- Following line MUST remain as a comment to have the proper effect -->
<!--[if IE]><style type="text/css"> body {word-wrap: break-word;}</style><![endif]-->

	<body>
		<!-- CONTAINER FOR ENTIRE PAGE -->
		<div class="container">

    			 <!-- B. NAVIGATION BAR -->
			 <?php require('../system/navigation_bar.inc.php'); ?>   
  
			<!-- C. MAIN SECTION -->      
			<div class="main">

				<!-- C.1 CONTENT -->
				<div class="content">
					<a id="anchor-heading-1"></a>
					<div class="corner-content-1col-top"></div>                        
					<div class="content-1col-nobox">
						<h1 class="webtemplate" id="top_title">Pron&oacute;stico del Tiempo</h1>
						<h2>&Uacute;ltimo Pronostico:</h2>
						<p>
							<input type="text" id="forecast_date" name="forecast_date" readonly="true" style="width: 90px; text-align: center;" value="<?=date('Y-m-d')?>"/>
							<input type="button" value="Ver" onclick="show_forecast_by_date()"/>
						</p>
						<p id="ultimo_pronostico"><img class="centernoborder" src="../img/loaders/loader-01.gif" /></p>
						<h2>Listado de Pronosticos:</h2>
						<p id="lista_pronosticos"><img class="centernoborder" src="../img/loaders/loader-01.gif" /></p>
					</div> 
					<div class="corner-content-1col-bottom"></div>
    				</div>
    				<!-- C.2 SUBCONTENT-->
				<div class="subcontent">
					<!-- NAVIGATION SIDEBAR -->
					<?php require('../system/navigation_sidebar.inc.php'); ?>   
				</div>
    				<!-- END OF CONTENT -->
    			</div>
			<!-- D. FOOTER -->      
			<?php require('../footer.inc.php');?>       
		</div>
		<!-- D. FOOT PANEL --> 
		<?php require('../system/footpanel.inc.php');?>
	</body>
</html>



