$(document).ready(function(e){
	$('#select_tipo').bind('change',function(e){
		$('#select_essen_field').html('');
		get_select_model();	
	});
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

function get_select_model(){
	var sid = $('#sid').val();
	
	var tipo = $('#select_tipo option:selected').val();
	
	if(tipo == 0){
		alert("Seleccione un tipo de modelo");
		return;
	}
		
	if(tipo == 'STATION')
		$('#select_essen_title').html('Estaci&oacute;n:');
	else
		$('#select_essen_title').html('Instrumento:');
	
	
	var url = 'historico.acciones.php?sid='+sid+'&accion=get_select_models&type='+tipo;
	$('#select_model_field').append('<img class="leftnoborder" src="../img/loaders/loader-01.gif" /></option>');
	$.get(url,'',function(data){
		$('#select_model_field').html(data);
		$('#select_model').bind('change',function(e){
			get_select_essen();
		});
	});
}

function get_select_essen(){
	var sid = $('#sid').val();
	var model = $('#select_model option:selected').val();
	
	if(model == 0){
		alert("Debe seleccionar un modelo");
		return;
	}
	
	var tipo = $('#select_tipo option:selected').val();
	
	accion = '';
	if(tipo == 'STATION')
		accion = 'get_stations_from_model_checkbox';
	else
		accion = 'get_instruments_from_model_checkbox';
	
	var url = 'historico.acciones.php?sid='+sid+'&accion='+accion+'&mid='+model;
	$('#select_essen_field').html('<img class="leftnoborder" src="../img/loaders/loader-01.gif" /></option>');
	$.get(url,'',function(data){
		$('#select_essen_field').html(data);
	});
}

function get_data(){
	var sid = $('#sid').val();
	
	var tipo = $('#select_tipo option:selected').val();
	var model = $('#select_model option:selected').val();
	var essen = $('#select_essen option:selected').val();
	var titulo = $('#select_essen option:selected').html();
	var fd = $('#fecha_desde').val();
	var fh = $('#fecha_hasta').val();
	var mname = $('#select_model option:selected').html();
	var mdesc = $('#select_model option:selected').attr('title');
	
	if(tipo == 0 || model == 0 || essen == 0){
		alert("Debe seleccionar todos los datos");
		return;
	}
	if(Date.parse(fd) > Date.parse(fh)){
		alert('Fecha Desde debe ser anterior a Fecha Hasta');
		return;
	}
	
	var url = 'historico.show.php?title='+titulo+'&url=historico.acciones.php?sid='+sid+'@accion=get_data_model@essen='+essen+'@fd='+fd+'@fh='+fh+'@type='+tipo+'@mid='+model+'@mname='+mname+'@mdesc='+mdesc;
	
	window.open(url);
	
}