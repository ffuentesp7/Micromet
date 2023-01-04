$(document).ready(function(e){
	get_select_instrumen_types();
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
	$('#select_detalle').bind('change',function(){
		get_data_type_available();
	});
});

function get_select_instrumen_types(){
	var sid = $('#sid').val();
	
	var url = 'historico.acciones.php?sid='+sid+'&accion=get_select_instruments_types';
	
	$.get(url,'',function(data){
		$('#select_instruments_types_field').html(data);
		$('#select_tipo_instrumento').bind('change',function(){
			get_station_available();
		});
	});
}

function get_data(){
	var sid = $('#sid').val();
	var tiid = $('#select_tipo_instrumento option:selected').val();
	var fd = $('#fecha_desde').val();
	var fh = $('#fecha_hasta').val();
	var detalle = $('#select_detalle option:selected').val();
	var separador = $('#select_separador option:selected').val();
	var filas = $('#select_filas option:selected').val();
	
	variables = new Array();
	i = 0;
	$('#available_station:checked').each(function(){
		valor = $(this).val();
		variables[i] = new Array(valor,$(this).attr('title'));
		i++;
	});
	
	var stationToGet = JSON.stringify(variables);

	if(tiid == 0){
		alert('Debe seleccionar un tipo de instrumento');
		return;
	}
	
	if(i == 0){
		alert('Debe seleccionar a lo menos una estacion.');
		return;
	}
	
	if(Date.parse(fd) > Date.parse(fh)){
		alert('Fecha Desde debe ser anterior a Fecha Hasta');
		return;
	}
	postForm = $('<form></form>').attr('action','csv.php?sid='+sid).attr('target','_blank').attr('method','post').css('display','none').appendTo('body');
	
	inAcc = $('<input></input>').attr('type','hidden').attr('name','accion').attr('value','get_data_instrument');
	inTiid = $('<input></input>').attr('type','hidden').attr('name','tiid').attr('value',tiid);
	inFd = $('<input></input>').attr('type','hidden').attr('name','fd').attr('value',fd);
	inFh = $('<input></input>').attr('type','hidden').attr('name','fh').attr('value',fh);
	inDet = $('<input></input>').attr('type','hidden').attr('name','det').attr('value',detalle);
	inSta = $('<input></input>').attr('type','hidden').attr('name','sta').attr('value',stationToGet);
	inSep = $('<input></input>').attr('type','hidden').attr('name','sep').attr('value',separador);
	inFil = $('<input></input>').attr('type','hidden').attr('name','fil').attr('value',filas);
	
	postForm.append(inAcc).append(inSta).append(inFd).append(inFh).append(inDet).append(inTiid).append(inSep).append(inFil);
	
	postForm.submit();
	
	//var url = 'csv.php?sid='+sid+'&accion=get_data_station&sta='+station+'&fd='+fd+'&fh='+fh+'&det='+detalle+'&types='+typesToGet;
	//alert(url.length);
	//window.open(url);
	
}

function get_station_available(){
	var sid = $('#sid').val();
	var ityp = $('#select_tipo_instrumento option:selected').val();
	
	var url = 'historico.acciones.php?sid='+sid+'&accion=get_stations_select_from_instrument_type&tiid='+ityp;
	$('#estaciones_disponibles').html('<img src="../img/loaders/loader-01.gif" class="leftnoborder"/>');
	$.get(url,'',function(data){
		$('#estaciones_disponibles').html(data);
	});
}
