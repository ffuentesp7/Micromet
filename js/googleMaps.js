//OBJECT VARIABLES
var markerImageStation = new google.maps.MarkerImage(
	"../img/gmaps/station_marker.png",
	new google.maps.Size(32,32),
	new google.maps.Point(0,0),
	new google.maps.Point(0, 32),
	new google.maps.Size(25,25)
);

var markerImageOrangeFlag = new google.maps.MarkerImage(
	"../img/gmaps/flag_orange.png",
	new google.maps.Size(32,32),
	new google.maps.Point(0,0),
	new google.maps.Point(0, 32),
	new google.maps.Size(25,25)
);

var markerImageHand = new google.maps.MarkerImage(
	"../img/gmaps/draw_smudge.png",
	new google.maps.Size(32,32),
	new google.maps.Point(0,0),
	new google.maps.Point(0, 32),
	new google.maps.Size(25,25)
);

var markerImageStation2 = new google.maps.MarkerImage(
	"img/gmaps/station_marker.png",
	new google.maps.Size(32,32),
	new google.maps.Point(0,0),
	new google.maps.Point(0, 32),
	new google.maps.Size(25,25)
);

var markerImageStationOffline = new google.maps.MarkerImage(
	"img/gmaps/station_offline.png",
	new google.maps.Size(32,32),
	new google.maps.Point(0,0),
	new google.maps.Point(0, 32),
	new google.maps.Size(25,25)
);

var valleysKMLFile = new Array(
		'http://www.citrautalca.cl/eve/kml/valles/aconcagua.kml',
		'http://www.citrautalca.cl/eve/kml/valles/biobio.kml',
		'http://www.citrautalca.cl/eve/kml/valles/cachapoal.kml',
		'http://www.citrautalca.cl/eve/kml/valles/casablanca.kml',
		'http://www.citrautalca.cl/eve/kml/valles/choapa.kml',
		'http://www.citrautalca.cl/eve/kml/valles/colchagua1.kml',
		'http://www.citrautalca.cl/eve/kml/valles/colchagua2.kml',
		'http://www.citrautalca.cl/eve/kml/valles/curico1.kml',
		'http://www.citrautalca.cl/eve/kml/valles/curico2.kml',
		'http://www.citrautalca.cl/eve/kml/valles/elqui.kml',
		'http://www.citrautalca.cl/eve/kml/valles/itata.kml',
		'http://www.citrautalca.cl/eve/kml/valles/leyda1.kml',
		'http://www.citrautalca.cl/eve/kml/valles/leyda2.kml',
		'http://www.citrautalca.cl/eve/kml/valles/limari.kml',
		'http://www.citrautalca.cl/eve/kml/valles/maipo.kml',
		'http://www.citrautalca.cl/eve/kml/valles/malleco.kml',
		'http://www.citrautalca.cl/eve/kml/valles/maule.kml'
	);

var valleysKML = new Array();

//FUNCTIONS
function initializeMap(latitude, longitude, mapZoom, element) {
	var latlng = new google.maps.LatLng(latitude, longitude);
	var myOptions = {
		zoom: mapZoom,
		center: latlng,
		mapTypeId: google.maps.MapTypeId.HYBRID
	};
	var map = new google.maps.Map(document.getElementById(element),myOptions);
	return map;
}

function initializeStationMap(latitude, longitude){
	return initializeMap(latitude, longitude, 10,"StationMap");
}

function setMarkerStation(GMAP,positionLatLng,title,infoWindowContent){
	
	var marker = new google.maps.Marker({
		position	: positionLatLng,
		title		: title,
		map		: GMAP,
		icon		: markerImageStation 
	});
	
	if(infoWindowContent != ''){
		var infowindow = new google.maps.InfoWindow({
			content: infoWindowContent
		});
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(GMAP,marker);
		});
	}	
}

function setMarkerStation2(GMAP,latitude, longitude,title,infoWindowContent){
	var latlng = new google.maps.LatLng(latitude, longitude);
	var marker = new google.maps.Marker({
		position	: latlng,
		title		: title,
		map		: GMAP,
		icon		: markerImageStation2 
	});
	
	if(infoWindowContent != ''){
		var infowindow = new google.maps.InfoWindow({
			content: infoWindowContent
		});
		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open(GMAP,marker);
		});
	}
}

function loadVineyardValleys(GMAP){
	
	for(i = 0; i < valleysKMLFile.length; i++){
		valleysKML[i] = new google.maps.KmlLayer(valleysKMLFile[i],{
			preserveViewport : true
		});
		valleysKML[i].setMap(GMAP);
	}

}