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
		$("#select_estacion").change(function(){
			get_instruments();
		});
	});
}

function get_instruments(){
	var sid = $('#sid').val();
	var eid = $('#select_estacion option:selected').val();
	
	if(eid != 0){
	
		var url = 'historico.acciones.php?sid='+sid+'&accion=get_select_instruments&eid='+eid;
		
		$.get(url,'',function(data){
			$('#select_instrumento_field').html(data);
		});
	}
}

function get_data(){
	var sid = $('#sid').val();
	var station = $('#select_estacion option:selected').val();
	var instrument = $('#select_instrumento option:selected').val();
	var titulo = $('#select_instrumento option:selected').html()+', '+$('#select_estacion option:selected').html();
	var fd = $('#fecha_desde').val();
	var fh = $('#fecha_hasta').val();
	var detalle = $('#select_detalle option:selected').val();
	
	if(station == 0){
		alert('Debe seleccionar una estacion');
		return;
	}
	
	if(instrument == 0){
		alert('Debe seleccionar un instrumento');
		return;
	}
	
	if(Date.parse(fd) > Date.parse(fh)){
		alert('Fecha Desde debe ser anterior a Fecha Hasta');
		return;
	}
	
	var url = 'historico.show.php?title='+titulo+'&url=historico.acciones.php?sid='+sid+'@accion=get_data_instrument@sta='+station+'@fd='+fd+'@fh='+fh+'@det='+detalle+'@ins='+instrument;
	
	window.open(url);
}