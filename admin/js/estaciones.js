function setLabelsFromStationForGetStatus(nombre,eid){
	var sid = $('#sid').val();
	
	$('#nombre_estacion').val(nombre);
	$('#eid').val(eid);

	$('#fbloader_image').show();
	tb_remove();
	
	url = 'estaciones.acciones.php?sid='+sid+'&accion=getdatasource&eid='+eid;
	
	$.get(url,'',function(data){
		$('#fuente_de_datos').val(data);
	});
	
	var info = $('#informacion_estacion option:selected').val();
	
	url = 'estaciones.acciones.php?sid='+sid+'&accion='+info+'&eid='+eid;
	
	$.get(url,'',function(data){
		$('#estacion_contenido').html(data);
	});
	
	
	$('#fbloader_image').hide();
}

$(document).ready(function(e){
	get_select_station();

});
function get_select_station(){
	var sid = $('#sid').val();
	
	var url = '../system/historico.acciones.php?sid='+sid+'&accion=get_select_stations_admin';
	
	$.get(url,'',function(data){
		$('#select_estacion_field').html(data);
	});
}

function changeTypeInfo(){
	var eid = $('#eid').val();
	var sid = $('#sid').val();
	$('#fbloader_image').show();
	var info = $('#informacion_estacion option:selected').val();
	
	url = 'estaciones.acciones.php?sid='+sid+'&accion='+info+'&eid='+eid;
	
	$.get(url,'',function(data){
		$('#estacion_contenido').html(data);
	});
	
	$('#fbloader_image').hide();
}

function getStationsDownloadInfo(){
	var sid = $('#sid').val();
	
	$('#contenido').html('<img class="centernoborder" src="../img/loaders/loader-01.gif" id="fbloader_image" />');
	
	url = 'estaciones.acciones.php?sid='+sid+'&accion=downloadinfo';
	
	$.get(url,'',function(data){
		$('#contenido').html(data);
	});
}