$(document).ready(function(e){
	GMAP = initializeStationMap(stationLatitude, stationLongitude);
	setMarkerStation(GMAP,new google.maps.LatLng(stationLatitude, stationLongitude),stationName,stationName);
	get_table(stationID);
});

function get_table(eid){
	var sid = $('#sid').val();

	var url = 'historico.acciones.php?sid='+sid+'&accion=get_data_station&sta='+eid+'&fd='+fd+'&fh='+fh+'&det=diario_estacion_ver';
	
	$.get(url,'',function(data){
		$('#tabla_datos').html(data);
	});
}

function load_valleys(){
	loadVineyardValleys(GMAP);
}