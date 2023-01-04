<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	require('../system/functions/statistic.functions.php');
	estadisticas('WEB','PAGE_VIEW');
	estadisticas('USER_USE','INSTRUMENTO_VER');
	$ESTACION = getDataOfStation($_GET['eid']);
	$INSTRUMENTO = getDataOfInstrument($_GET['iid']);
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<!--  Version: Multiflex-5.4 / Overview                     -->
<!--  Date:    Nov 23, 2010                                 -->
<!--  Design:  www.1234.info                                -->
<!--  Modified:  roaguilar@utalca.cl                        -->
<!--  License: Fully open source without restrictions.      -->
	<head>
  		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="expires" content="3600" />
		<meta name="revisit-after" content="2 days" />
		<meta name="robots" content="index,follow" />
		
		<meta name="copyright" content="Centro de Investigación y Transferencia en Riego y Agroclimatología, Universidad de Talca" />
		
		<meta name="distribution" content="global" />
		<meta name="description" content="Micromet" />
		<meta name="keywords" content="vizualización, agua, agricultura, Talca, universidad, agroclimatología, climatología" />
		<!-- CSS only -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<!-- JavaScript Bundle with Popper -->
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
		<link rel="stylesheet" type="text/css" href="../css/style.css" />
		<link rel="icon" type="image/x-icon" href="../img/favicon.ico" />
		<?php require_once('../head.link.script.php'); ?>
			
		<!-- CANVAS GRAPH-->
		<script src="../js/libraries/RGraph.common.effects.js" ></script>
		<script src="../js/libraries/RGraph.common.key.js" ></script>
		<script src="../js/libraries/RGraph.common.core.js" ></script>
		<script src="../js/libraries/RGraph.common.tooltips.js" ></script>
		<script src="../js/libraries/RGraph.line.js" ></script>
		<script src="../js/libraries/RGraph.bar.js" ></script>
		<script src="../js/libraries/RGraph.rose.js" ></script>
		
		<title>Micromet - Biovision</title>
		<script type="text/javascript">
			stationName		= '<?=utf8_decode(tilde_to_utf8($ESTACION[1]))?>';
			stationLatitude 	= <?=$ESTACION[3]?>;
			stationLongitude 	= <?=$ESTACION[4]?>;
			stationID		= <?=$ESTACION[0]?>;
			fh			= '<?=$ESTACION[6]?>';
			fd			= '<?=cambia_fecha_a_mysql(add_days(cambia_fecha_a_normal($ESTACION[6]), -1))?>';
			code			= '<?=$_GET['tipo']?>';
			instrumentID		= <?=$_GET['iid']?>;
		</script>
		<script type="text/javascript" src="js/instrumento_ver.js"></script>
		<script type="text/javascript">
		
			var negative = false;

			var datos = new Array();
			var fechas = new Array();
			var horas = new Array();
			var horasTodas = new Array();
			var testing = new Array();
			
			$(document).ready(function(e){
				var sid = $('#sid').val();
				
				var url = 'json_data_response.php?sid='+sid+'&accion=get_data_instrument&ins='+instrumentID+'&sta='+stationID+'&fd='+fd+'&fh='+fh+'&det=detalle_diario_widget';
				var hours;
				var dates;
				var numbers;
				$.getJSON(url,'',function(data){
					graphData = data;
					copy_array(datos,graphData, 2);
					copy_labels_array(horas,graphData, 1, graphData, 0);
					copy_labels_array2(horasTodas,graphData, 1, graphData, 0);
					<?php 
					if($_GET['tipo'] == 'RAIN'){
					?>
					start_bar_graph();
					<?php
					}elseif($_GET['tipo'] == 'WINDDIR'){
					?>
					start_rose_graph();
					<?php
					}else{
					?>
					start_line_graph();
					<?php
					}
					?>
				});
				
				$('#fecha_desde').val(fd);
				$('#fecha_hasta').val(fh);
				$('#fecha_desde').datepicker({
					dateFormat : "yy-mm-dd",
					showAnim : "blind",
					changeMonth: true,
					changeYear: true,
					maxDate: new Date()
					
				});
				$('#fecha_hasta').datepicker({
					dateFormat : "yy-mm-dd",
					showAnim : "blind",
					changeMonth: true,
					changeYear: true,
					maxDate: new Date()
				});
				
			});
			
			function updateGraph(){
				var sid = $('#sid').val();
				fd = $('#fecha_desde').val();
				fh = $('#fecha_hasta').val();
				var url = 'json_data_response.php?sid='+sid+'&accion=get_data_instrument&ins='+instrumentID+'&sta='+stationID+'&fd='+fd+'&fh='+fh+'&det=detalle_diario_widget';
				datos = new Array();
				fechas = new Array();
				horas = new Array();
				horasTodas = new Array();
				testing = new Array();
				$.getJSON(url,'',function(data){
					graphData = data;
					copy_array(datos,graphData, 2);
					copy_labels_array_update(horas,graphData, 1, graphData, 0);
					copy_labels_array2(horasTodas,graphData, 1, graphData, 0);
					
					<?php 
					if($_GET['tipo'] == 'RAIN'){
					?>
					start_bar_graph();
					<?php
					}elseif($_GET['tipo'] == 'WINDDIR'){
					?>
					start_rose_graph();
					<?php
					}else{
					?>
					start_line_graph();
					activateInstrument();
					<?php
					}
					?>
				});
			}
			
			
			function tooltipsFunc(idx){
				
				$.changeInstrumentValue({instrumentValue: datos[idx]});
				
				return 'Fecha Hora: '+horasTodas[idx]+'<br />'+
				       'Valor: '+datos[idx]+'<?=utf8_decode(tilde_to_utf8($INSTRUMENTO[0]))?><br />';
			}
			
			function copy_array(arr1, arr2, arr2index){
				//var arr1 = new Array();
				for(i = 0; i < arr2.length; i++) {
					arr1.push(parseFloat(arr2[i][arr2index]));
				}
				return arr1;
			}
			
			function copy_labels_array(arr1, arr2, arr2index, arr3, arr3index){
				//var arr1 = new Array();
				for(i = 0; i < arr2.length; i++) {
					if(i % 12 == 0)
						arr1.push(arr3[i][arr3index]+' '+arr2[i][arr2index]);
					else
						arr1.push('');
				}
				return arr1;
			}
			
			function copy_labels_array_update(arr1, arr2, arr2index, arr3, arr3index){
				//var arr1 = new Array();
				var spaces = Math.floor(arr2.length / 12);
				
				for(i = 0; i < arr2.length; i++) {
					if(i % spaces == 0)
						arr1.push(arr3[i][arr3index]+' '+arr2[i][arr2index]);
					else
						arr1.push('');
				}
				return arr1;
			}
			
			function copy_labels_array2(arr1, arr2, arr2index, arr3, arr3index){
				//var arr1 = new Array();
				for(i = 0; i < arr2.length; i++) {
					arr1.push(arr3[i][arr3index]+' '+arr2[i][arr2index]);
				}
				return arr1;
			}
			
			
			function start_line_graph(){
				
				var line1 = new RGraph.Line('chartContainer', datos);
				line1.Set('chart.background.grid', true);
				line1.Set('chart.linewidth', 5);
				line1.Set('chart.gutter.left', 65);
				line1.Set('chart.gutter.bottom', 85);
				line1.Set('chart.hmargin', 5);
				if (!document.all || RGraph.isIE9up()) {
					line1.Set('chart.shadow', true);
				}
				line1.Set('chart.tickmarks', null);
				line1.Set('chart.units.post', '<?=utf8_decode(tilde_to_utf8($INSTRUMENTO[0]))?>');
				line1.Set('chart.colors', ['#F27F00']);
				line1.Set('chart.background.grid.autofit', true);
				line1.Set('chart.background.grid.autofit.numhlines', 10);
				line1.Set('chart.curvy', false);
				
				for(i = 0; i < datos.length; i++) {
					if(datos[i] < 0)
						negative = true;
				}

				if(negative) line1.Set('chart.xaxispos', 'center');

				line1.Set('chart.text.angle', 45);
				line1.Set('chart.curvy.factor', 0.5); // This is the default
				line1.Set('chart.animation.unfold.initial',0);
				line1.Set('chart.labels',horas);
				line1.Set('chart.text.size',8);
				line1.Set('chart.title',stationName+' - <?=$_GET['name']?>');
				line1.Set('chart.tooltips.effect', 'fade');
				line1.Set('chart.tooltips', tooltipsFunc);
				
				if (RGraph.isOld()) {
					line1.Draw();
				} else {
					RGraph.Effects.Fade.In(line1);
                			RGraph.Effects.jQuery.Reveal(line1);
					RGraph.Effects.Line.jQuery.Trace(line1);
				}
			}
			
			function start_bar_graph(){
				
				var bar = new RGraph.Bar('chartContainer', datos);

				bar.Set('chart.background.grid', true);
				bar.Set('chart.key.background', 'rgb(255,255,255)');
				bar.Set('chart.gutter.left', 65);
				bar.Set('chart.gutter.bottom', 85);
				bar.Set('chart.hmargin', 5);
				if (!document.all || RGraph.isIE9up()) {
					bar.Set('chart.shadow', true);
				}
				bar.Set('chart.tickmarks', null);
				bar.Set('chart.units.post', '<?=utf8_decode(tilde_to_utf8($INSTRUMENTO[0]))?>');
				bar.Set('chart.colors', ['blue']);
				bar.Set('chart.background.grid.autofit', true);
				bar.Set('chart.background.grid.autofit.numhlines', 10);
				bar.Set('chart.curvy', false);
				bar.Set('chart.text.angle', 45);
				bar.Set('chart.curvy.factor', 0.5); // This is the default
				bar.Set('chart.animation.unfold.initial',0);
				bar.Set('chart.labels',horas);
				bar.Set('chart.text.size',8);
				bar.Set('chart.title',stationName+' - <?=$_GET['name']?>');
				
				if (RGraph.isOld()) {
					bar.Draw();
				} else {
					//bar.Draw();
					RGraph.Effects.Fade.In(bar);
                			RGraph.Effects.jQuery.Reveal(bar);
				}
			}
			
			function start_rose_graph(){
				var datos2 = new Array([0,22.5],[0,45],[0,45],[0,45],[0,45],[0,45],[0,45],[0,45],[0,22.5]);
				
				for(i = 0; i < datos.length; i++){
					if((datos[i] >= 0 && datos[i] < 22.5) || (datos[i] >= 337.5)){
						datos2[0][0]++;
						datos2[8][0]++;
					}
					if(datos[i] >= 22.5 && datos[i] < 67.5)
						datos2[1][0]++;
					else if(datos[i] >= 67.5 && datos[i] < 112.5)
						datos2[2][0]++;
					else if(datos[i] >= 112.5 && datos[i] < 157.5)
						datos2[3][0]++;
					else if(datos[i] >= 157.5 && datos[i] < 202.5)
						datos2[4][0]++;
					else if(datos[i] >= 202.5 && datos[i] < 247.5)
						datos2[5][0]++;
					else if(datos[i] >= 247.5 && datos[i] < 292.5)
						datos2[6][0]++;
					else if(datos[i] >= 292.5 && datos[i] < 337.5)
						datos2[7][0]++;	
				}
				
				var rose = new RGraph.Rose('chartContainer', datos2);

				rose.Set('chart.colors.alpha', 0.5);
            			rose.Set('chart.labels', ['N','NE','E','SE','S','SO','O','NO']);
            			rose.Set('chart.labels.position', 'edge');
            			rose.Set('chart.gutter.bottom', 35);
            			rose.Set('chart.variant', 'non-equi-angular');
            			//rose.Set('chart.margin', 5);
            			rose.Set('chart.title',stationName+' - <?=$_GET['name']?>');
				
				if (RGraph.isOld()) {
					rose.Draw();
				} else {
					RGraph.Effects.Fade.In(rose);
                			RGraph.Effects.jQuery.Reveal(rose);
				}
			}
			
		</script>
		<style>
			.scroll {
				max-height: 540px;
				overflow-y: auto;
			}
		</style>
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
				<h5 class="alert alert-success" role="alert"> <?=$ESTACION[1] .' - '. $_GET['name'] ?></h5>
				<hr>
					 
					<div class="form-group row">
						<div class="col-md-6 ">            
							<div class="card">
							<div class="card-header">
								<h5 class="webtemplate" id="top_title"><?=$_GET['name']?></h5>
							</div>      
								<div class="card-body">
									<h5>Gr&aacute;fico</h5>
									<h6 class="document" id="top_title_instrumento_">&nbsp;<a href="#" id="link_desactivar_instrumento" style="float: right; display: none;">&#091;Desactivar Instrumento&#093;</a><a href="#" id="link_activar_instrumento" style="float: right;">&#091;Activar Instrumento&#093;</a></h6>

									<canvas id="chartContainer" width="670" height="300">
										Espere por favor...
									</canvas>
									<p>
										<table style="width: 400px; margin: 10px auto 5px auto;">
											<tr>
												<td>
													<label for="input_fecha_desde" class="left">Desde:</label>
													<input type="text" class="field" id="fecha_desde" style="width: 100px;text-align:center;" readonly="readonly"/><br/>
												</td>
												<td>
													<label for="input_fecha_hasta" class="left">Hasta:</label>
													<input type="text" class="field" id="fecha_hasta" style="width: 100px;text-align:center;" value="" readonly="readonly" /><br/>
												</td>
											</tr>
											<tr>
												<td colspan=2>
														<input type="button" value="Ver Datos" class="btn btn-success fw-bold" onclick="updateGraph()"/>	
												</td>
											</tr>
										</table>
										Nota: Los datos s&oacute;lo se actualizar&aacute;n en el gr&aacute;fico, para ver los datos tabulados utilice Hist&oacute;rico
									</p>
								</div>
							</div>
						</div>
						<div class="col-md-6 "> 
							<div class="card">
								<div class="card-header">
								<h5>&Uacute;ltimos datos:</h5>
								</div>
								<div class="card-body scroll">
									<div id="tabla_datos">
										<img src="../img/loaders/loader-01.gif" class="centernoborder"/>
									</div>	
									<br>
									<br>
									<br>
									<br>
									<br>
									<br>
									<br>
									<br>
								</div>
							</div> 
						</div>
					</div>
    			</div>  
			</div>  
		</div>
		<?php require('../footer.inc.php');?>       

		<!-- D. FOOT PANEL --> 
		<?php require('../system/footpanel.inc.php');?>
	</body>
</html>



