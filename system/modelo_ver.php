<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	estadisticas('WEB','PAGE_VIEW');
	estadisticas('USER_USE','MODELO_VER');
	
	$SQL = "SELECT nombre,descripcion,unidad FROM tipo_modelo WHERE target='".$_GET['tmd']."' AND id=".$_GET['mid'];
	
	$result_tm = consulta_sql($SQL);
	
	$datos_tm = mysqli_fetch_array($result_tm);
	
	$NOMBRE_TM	= $datos_tm[0];
	$TARGET_TM	= $_GET['tmd'];
	$MID		= $_GET['mid'];
	$IDS		= $_GET['ids'];
	$DESCRIPCION_TM	= $datos_tm[1];
	$UNIDAD		= $datos_tm[2];
	
	$PAGE = 'main';
	if(isset($_GET['page']))
		$PAGE = $_GET['page'];
	
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
		<script src="js/modelo.js" type="text/javascript"></script>
		
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
		
			var datos = new Array();
			var fechas = new Array();
			var fechasAll = new Array();
			var horas = new Array();
			var testing = new Array();
			var unit = '<?=$UNIDAD?>';

			$(document).ready(function(e){
				var sid = $('#sid').val();
				
				var url = 'modelo.acciones.php?sid='+sid+'&accion=getdata_json&target=<?=$TARGET_TM?>&mid=<?=$MID?>&eid=<?=$IDS?>';
				var hours;
				var dates;
				var numbers;
				$.getJSON(url,'',function(data){
					graphData = data;
					copy_array(datos,graphData, 1);
					copy_labels_array2(fechas,graphData, 0);
					get_unit(graphData, 2);
					//alert(datos);
					start_line_graph();
				});
			});
			
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
			
			function copy_labels_array2(arr1, arr2, arr2index){
				//var arr1 = new Array();
				for(i = 0; i < arr2.length; i++) {
					arr1.push(arr2[i][arr2index]);
				}
				return arr1;
			}
			
			function get_unit(arr1,arr1index){
				for(i = 0; i < arr1.length; i++) {
					if(arr1[i][arr1index] != ''){
						unit = arr1[i][arr1index];
						break;
					}
				}
			}
			
			function tooltipsFunc(idx){
				return 'Fecha: '+fechas[idx]+'<br />'+
				       'Valor: '+datos[idx]+unit+'<br />';
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
				line1.Set('chart.units.post', unit);
				line1.Set('chart.colors', ['#F27F00']);
				line1.Set('chart.background.grid.autofit', true);
				line1.Set('chart.background.grid.autofit.numhlines', 10);
				line1.Set('chart.curvy', false);
				line1.Set('chart.text.angle', 45);
				line1.Set('chart.curvy.factor', 0.5); // This is the default
				line1.Set('chart.animation.unfold.initial',0);
				line1.Set('chart.labels',fechas);
				line1.Set('chart.text.size',8);
				line1.Set('chart.title','<?=$NOMBRE_TM?>');
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
				bar.Set('chart.curvy', true);
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
		<?php require('../system/navigation_bar.inc.php'); ?>   

		<div class="d-flex" id="wrapper">
			<?php require('../system/navigation_sidebar.inc.php'); ?>   
 
			<div class="content" id="page-content-wrapper">

				<!-- C.1 CONTENT -->
				<div class="container-flex">
					<?php
					if($PAGE == 'tmd'){
					?>                    
					<h5 class="sensor" id="top_title">Modelo: <?=$NOMBRE_TM?></h5>
					<h6><?=$DESCRIPCION_TM?></h6>  
					<div class="form-group row">
						<div class="col-md-6 ">            
							<div class="card">
								<div class="card-header">
									<h6>Gr&aacute;fico</h6>
								</div>
								<div class="card-body">
									<canvas id="chartContainer" width="670" height="300">
										Espere por favor...
									</canvas>
								</div> 
							</div>
						</div>
						<div class="col-md-6 ">          
							<div class="card">
								<div class="card-header"><h5 class="document" >&nbsp;</h5></div>
								<div class="card-body scroll">
									<span id="cuerpo_datos">
										<br />
										<br />
										<br />
										<br />
										<br />
									</span>
								</div>
							</div> 
						</div>
					</div>
					<div class="corner-content-1col-bottom"></div>
					<script type="text/javascript">
						$(document).ready(function(){
							getDataAuto('<?=$IDS?>',<?=$MID?>,'<?=$TARGET_TM?>');
						});
					</script>
					<?php
					}
					?>
				</div>
			</div>     
		</div>
		<?php require('../footer.inc.php');?>       
		<?php require('../system/footpanel.inc.php');?>
	</body>
</html>



