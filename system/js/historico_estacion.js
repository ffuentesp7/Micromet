var detalleGral = 'detalle_diario';
var nombreVariables = [];
var colors = ['#F27F00','#B3CAEF','#C8C8C8','#68C623','#0000FF','#FF00FF','#FFFF00','#00FFFF'];

var datos = new Array();
var datosLabel = new Array();
var fechas = new Array();
var horas = new Array();
var horasTodas = new Array();
var testing = new Array();
var insUnitDay = new Array;
var datosGrafico;

$(document).ready(function(e){
	get_select_station();
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

function get_select_station(){
	var sid = $('#sid').val();
	
	var url = 'historico.acciones.php?sid='+sid+'&accion=get_select_stations';
	
	$.get(url,'',function(data){
		$('#select_estacion_field').html(data);
	});
}

function get_data(){
	var sid = $('#sid').val();
	var station = $('#select_estacion option:selected').val();
	var stationName = $('#select_estacion option:selected').html();
	var fd = $('#fecha_desde').val();
	var fh = $('#fecha_hasta').val();
	var detalle = detalleGral = $('#select_detalle option:selected').val();
	console.log(station);
	if(station == 0){
		alert('Debe seleccionar una estacion');
		return;
	}
	
	if(Date.parse(fd) > Date.parse(fh)){
		alert('Fecha Desde debe ser anterior a Fecha Hasta');
		return;
	}
	
	var url = 'historico.show.php?title='+stationName+'&url=historico.acciones.php?sid='+sid+'@accion=get_data_station@sta='+station+'@fd='+fd+'@fh='+fh+'@det='+detalle;
	//getDataGraph();
	window.open(url);
}

function getDataGraph(){
	$('#graph_loading').show();
	horas = [];
	
	var sid = $('#sid').val();
	var fd = $('#fecha_desde').val();
	var fh = $('#fecha_hasta').val();
	var detalle = $('#select_detalle option:selected').val();

	var eid 	= $('#select_estacion option:selected').val();
	stationID       = eid;
	stationName 	= $('#select_estacion option:selected').html();
	
	var url = 'historico.acciones.php?sid='+sid+'&accion=get_data_station_json_graph&sta='+eid+'&fd='+fd+'&fh='+fh+'&det='+detalle;
	
	var hours;
	var dates;
	var numbers;
	$.getJSON(url,'',function(data){
		graphData = data;
		
		if(detalleGral == 'detalle_diario'){
			data_extractor(datos,graphData);
			variable_names_extractor(nombreVariables,graphData)
			variable_name_selection(nombreVariables);
			copy_unit_day(graphData);
			copy_labels_array3(horas,graphData, 0);
			copy_labels_array4(horasTodas,graphData, 0);
			
		}
		$('#graph_loading').hide();
	});
}

function tooltipsFunc(idx){
	return 'Fecha Hora: '+horasTodas[idx]+'<br />'+
	       'Valor: '+datos[idx]+insUnit+'<br />';
}

function tooltipsFuncWithoutHours(idx){
	return 'Fecha: '+horasTodas[idx]+'<br />'+
	       'Valor: '+datosLabel[idx]+insUnitDay[idx]+'<br />';
	       
}

function copy_array(arr1, arr2, arr2index){
	//var arr1 = new Array();
	for(i = 0; i < arr2.length; i++) {
		arr1.push(parseFloat(arr2[i][arr2index]));
	}
	return arr1;
}

function variable_names_extractor(arr1, arr2){
	var line = [];
	
	if(detalleGral == 'detalle_diario'){
		for(var i = 0 ; i < 2; i++){
			for(j = 2; j < arr2[i].length; j++){
				line.push(arr2[i][j]);
			}
				
			arr1[i] = RGraph.array_clone(line);
			line = [];
		}
	}
	return arr1;
}

function data_extractor(arr1, arr2){
	
	var line = [];
	howmany = arr2[0].length;
	
	if(detalleGral == 'detalle_diario'){
		for(var i = 2 ; i < arr2[0].length; i++){
			for(j = 4; j < arr2.length; j++){
				
				line.push(arr2[j][i]);
				datosLabel.push(arr2[j][i]);
				if(arr2[j][i] < 0)
					negative = true;
				
			}
				
			arr1[i - 2] = RGraph.array_clone(line);
			line = [];
		}
	}
	return arr1;
}

function variable_name_selection(arr1){
	
	var html = "";
	for(i = 0; i < arr1[0].length; i++){
		if( i%2 == 0)
			html += "<tr>";
		else
			html += "<tr class='odd'>";
		html += "<td onclick='check_variable("+i+")'>"+arr1[0][i]+"</td>";
		html += "<td><input type='checkbox' id='checkbox_variable_"+i+"' value='"+i+"' onclick='change_graph_data("+i+")' /></td>";
		html += "</tr>";
	}
	$('#tbody_variables').html(html);
}

function check_variable(id){
	
	if($("#checkbox_variable_"+id).is(':checked'))
		$("#checkbox_variable_"+id).attr('checked',false);
	else	
		$("#checkbox_variable_"+id).attr('checked',true);
	
	change_graph_data(id);
}

function change_graph_data(id){
	if($("#checkbox_variable_"+id).is(':checked')){
		
	}
	else{
		
	}
	
}


function copy_unit(arr1,index){
	insUnit = arr1[0][index];
}

function copy_unit_day(arr1){
	
	for(var i = howmany + 1 ; i < (howmany * 2 + 1); i++){
		for(j = 0; j < arr1.length; j++)
			insUnitDay.push(arr1[j][i]);
	}
	
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

function copy_labels_array2(arr1, arr2, arr2index, arr3, arr3index){
	//var arr1 = new Array();
	for(i = 0; i < arr2.length; i++) {
		arr1.push(arr3[i][arr3index]+' '+arr2[i][arr2index]);
	}
	return arr1;
}

function copy_labels_array3(arr1, arr2, arr2index){
	//var arr1 = new Array();
	for(i = 0; i < arr2.length; i++) {
		if(i % 2 == 0)
			arr1.push(arr2[i][arr2index]);
		else
			arr1.push('');
	}
	return arr1;
}

function copy_labels_array4(arr1, arr2, arr2index){
	//var arr1 = new Array();
	for(var i = 1 ; i < (howmany + 1); i++){
		for(j = 0; j < arr2.length; j++)
			arr1.push(arr2[j][arr2index]);
	}

	return arr1;
}

function getGraph(){
	
	if(!window.__rgraph_line__){
	
		window.__rgraph_line__ = new RGraph.Line('chartContainer', datosGrafico);
		window.__rgraph_line__.Set('chart.background.grid', true);
		window.__rgraph_line__.Set('chart.linewidth', 5);
		window.__rgraph_line__.Set('chart.gutter.left', 65);
		window.__rgraph_line__.Set('chart.gutter.bottom', 85);
		window.__rgraph_line__.Set('chart.hmargin', 5);
		if (!document.all || RGraph.isIE9up()) {
			window.__rgraph_line__.Set('chart.shadow', true);
		}
		window.__rgraph_line__.Set('chart.tickmarks', null);
		window.__rgraph_line__.Set('chart.units.post', insUnit);
	
		window.__rgraph_line__.Set('chart.background.grid.autofit', true);
		window.__rgraph_line__.Set('chart.background.grid.autofit.numhlines', 10);
		window.__rgraph_line__.Set('chart.curvy', false);
	
		if(negative) window.__rgraph_line__.Set('chart.xaxispos', 'center');
	
		window.__rgraph_line__.Set('chart.text.angle', 45);
		window.__rgraph_line__.Set('chart.key', nombreVariables[0]);
		window.__rgraph_line__.Set('chart.key.position', 'gutter');
		window.__rgraph_line__.Set('chart.curvy.factor', 0.5); // This is the default
		window.__rgraph_line__.Set('chart.animation.unfold.initial',0);
		window.__rgraph_line__.Set('chart.labels',horas);
		window.__rgraph_line__.Set('chart.tickmarks', 'circle');
		window.__rgraph_line__.Set('chart.text.size',8);
		window.__rgraph_line__.Set('chart.title',stationName);
		window.__rgraph_line__.Set('chart.tooltips.effect', 'fade');
		window.__rgraph_line__.Set('chart.tooltips', tooltipsFuncWithoutHours);
	}
	
	return window.__rgraph_line__;
}

function drawGraph(){
	
	window.__rgraph_line__.original_data[0] = datosGrafico;
	
	if (RGraph.isOld()) {
		window.__rgraph_line__.Draw();
	} else {
		RGraph.Effects.Fade.In(window.__rgraph_line__);
		RGraph.Effects.jQuery.Reveal(window.__rgraph_line__);
		RGraph.Effects.Line.jQuery.Trace(window.__rgraph_line__);
	}
}
