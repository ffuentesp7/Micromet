var loadinImg = '<img class="centernoborder" src="../img/loaders/loader-01.gif" />';
var buttonLoadMap = '<input type="button" id="boton_cargar_datos_mapa" style="width: auto;" class="button" value="Cargar Datos en Mapa" onclick="loadDataInMap()"/>';
var infowindow = new google.maps.InfoWindow({
                    content: ''
                });
var kmzArray = [];
var ubicacionKMZ = 'http://www.citrautalca.cl/eve/system_modules/mod_remote_sensing/kmz/';
var handMarker;
var datos = new Array();
var datosTooltip = new Array();
var etiquetas = new Array();
var etiquetasTooltip = new Array();
var negative = false;
var actualKc = 0;

function setMarkerRemoteSensig(GMAP,latitude, longitude,title,idLatLon,idFenologia){
    var latlng = new google.maps.LatLng(latitude, longitude);
    handMarker = new google.maps.Marker({
        position	: latlng,
        title		: title,
        map			: GMAP,
        icon		: markerImageHand,
        draggable	: true
    });
    
    google.maps.event.addListener(handMarker, 'dragend', function(event) {
        var sid = $('#sid').val();
		
		columna = $('#phenology option:selected').attr('c');
		tabla = $('#phenology option:selected').attr('t');
		especie = $('#phenology option:selected').val();
        var latLon = event.latLng;
        jQuery('#'+idLatLon).html(loadinImg);
		jQuery('#'+idFenologia).html(loadinImg);
        
        infowindow.close();
        infowindow.setContent(loadinImg);
        infowindow.open(GMAP,handMarker);
        
        jQuery('#latitud').val(latLon.lat());
        jQuery('#longitud').val(latLon.lng());
		eto = jQuery('#eto_diaria').html();
        
        url = 'mod_remote_sensing_functions.php';
        $.get(url,
              { 
                sid    : sid,
                accion : 'get_data_from_latlon',
                table  : tabla,
				col    : columna,
                lat    : latLon.lat(),
                lon    : latLon.lng(),
				eto    : eto,
				especie: especie
            },
            function(data){
                    //alert(data);
                d = data.split('||');
                jQuery('#'+idLatLon).html(d[1]);
				jQuery('#'+idFenologia).html(d[2]);
                infowindow.setContent(d[0]);
                actualKc = d[3];
                infowindow.open(GMAP,handMarker);
				thickboxLoader();
        });
		datos = new Array();
        etiquetas = new Array();
        $.getJSON(url,
	        {
		        sid 	: sid,
		        accion	: 'json_kc_graph',
                table  : tabla,
		        col    : columna,
		        lat    : latLon.lat(),
                lon    : latLon.lng()
	        },function(data){
		        data_extractor(datos, data);
		        copy_array_txt(etiquetas, data, 0);
		        start_line_graph();
                make_irrigration_table();
            });
         });	
}

function available(date) {
    dmy = date.getFullYear()+"-"+ putZero(date.getMonth()+1) + "-" +putZero(date.getDate());

    if ($.inArray(dmy, fechasDisponibles) != -1) {
        return [true, "","Imagen Disponible"];
    }
    else {
        return [false,"","No disponible"];
    }
}

function getImageType(date){
    var sid = jQuery('#sid').val();
    loading('Se estan cargando los tipos');
    jQuery('#boton_cargar_datos_mapa').hide();
    jQuery('#tipo_de_imagen').html('');
    url = 'mod_remote_sensing_functions.php';
    $.get(url,
        { 
            sid    : sid,
            accion : 'get_image_type',
            fecha  : date
        },
        function(data){
            jQuery('#tipo_de_imagen').html(data);
            jQuery('#boton_cargar_datos_mapa').show();
            $('#boton_borrar_datos_mapa').show();
            stopLoading();
        });
}

function getETo(date){
    
	var sid = jQuery('#sid').val();
	var eid = jQuery('#select_estacion option:selected').val();
	
	url = 'mod_remote_sensing_functions.php';
    $.get(url,
          { 
            sid    : sid,
            accion : 'get_daily_eto',
			fecha  : date,
			eid    : eid
        },
        function(data){
            jQuery('#eto_diaria').html(data);
    }); 			
					
}

function get_select_station(){
	var sid = $('#sid').val();
	
	var url = '../system/historico.acciones.php?sid='+sid+'&accion=get_select_stations';
	
	$.get(url,'',function(data){
		$('#select_estacion_field').html(data);
	});
}

function loadDataInMap(){
    clearKMZOverlays();
    //deleteKMZOverlays();
    //var datos = jQuery('#tipo_de_imagen option:selected').val().split('|');
    //alert(ubicacionKMZ+datos[3]);
    ET = new google.maps.KmlLayer(ubicacionKMZ+'L720120112.kmz',{
            preserveViewport : true
    });
    jQuery('#button_load_box').html('Cargando Capas... '+loadinImg);
    ET.setMap(GMAP);
    kmzArray.push(ET);
    google.maps.event.addListener(ET, 'status_changed', function(kmlEvent) {
        var KMLstatus = ET.getStatus();
        if(google.maps.KmlLayerStatus.OK == KMLstatus){
            jQuery('#button_load_box').html(buttonLoadMap);
        }
        else{
            jQuery('#button_load_box').html('Cargando Capas... '+loadinImg);
        }
    });
}

function clearKMZOverlays() {
    if (kmzArray) {
        for (i in kmzArray) {
            kmzArray[i].setMap(null);
        }
    }
}

function deleteKMZOverlays() {
    if (kmzArray) {
        for (i in kmzArray) {
            kmzArray[i].setMap(null);
        }
        kmzArray.length = 0;
    }
}

function changeHandMarkerPosition(){
    
    lat = jQuery('#latitud').val();
    lon = jQuery('#longitud').val();
    eto = jQuery('#eto_diaria').html();
    if(!validaNumero(lat) || !validaNumero(lon)){
        alert('Debe ingresar las coordenadas!');
        return;        
    }
    
    var latlng = new google.maps.LatLng(lat, lon);
    var idLatLon = 'tabla_datos';
    var idFenologia = 'tabla_fenologia';
    handMarker.setPosition(latlng);
    var sid = $('#sid').val();
    columna = $('#phenology option:selected').attr('c');
    tabla = $('#phenology option:selected').attr('t');
	especie = $('#phenology option:selected').val();
    var latLon = latlng;
    jQuery('#'+idLatLon).html(loadinImg);
	jQuery('#'+idFenologia).html(loadinImg);
    
    infowindow.close();
    infowindow.setContent(loadinImg);
    infowindow.open(GMAP,handMarker);
    
    jQuery('#latitud').val(latLon.lat());
    jQuery('#longitud').val(latLon.lng());
    
    url = 'mod_remote_sensing_functions.php';
    $.get(url,
          { 
            sid    : sid,
            accion : 'get_data_from_latlon',
            table  : tabla,
            col    : columna,
            lat    : latLon.lat(),
            lon    : latLon.lng(),
			eto    : eto,
			especie: especie
        },
        function(data){
                    //alert(data);
            d = data.split('||');
            jQuery('#'+idLatLon).html(d[1]);
			jQuery('#'+idFenologia).html(d[2]);
            infowindow.setContent(d[0]);
            actualKc = d[3];
            infowindow.open(GMAP,handMarker);
			thickboxLoader();
    });
	datos = new Array();
    etiquetas = new Array();
    datosTooltip = new Array();
    etiquetasTooltip = new Array();
	$.getJSON(url,
		{
            sid 	: sid,
			accion	: 'json_kc_graph',
			table  : tabla,
            col    : columna,
            lat    : latLon.lat(),
            lon    : latLon.lng()
        },function(data){
			data_extractor(datos, data);
			copy_array_txt(etiquetas, data, 0);
            copy_array_txt(etiquetasTooltip, data, 0);
            copy_array_txt(etiquetasTooltip, data, 0);
			start_line_graph();
            make_irrigration_table();
	}); 
	
}

function copy_array(arr1, arr2, arr2index){
    //var arr1 = new Array();
    for(i = 0; i < arr2.length; i++) {
	    arr1.push(parseFloat(arr2[i][arr2index]));
    }
    return arr1;
}

function data_extractor(arr1, arr2){
	
	var line = [];
	howmany = arr2[0].length;
	
	
    for(var i = 1 ; i < arr2[0].length; i++){
        for(j = 0; j < arr2.length; j++){
            datosTooltip.push(arr2[j][i]);
            line.push(parseFloat(arr2[j][i]));
            if(arr2[j][i] < 0)
                negative = true;
        }
        
    arr1[i - 1] = RGraph.array_clone(line);
    line = [];
}

	return arr1;
}

function copy_array_2_col(arr1, arr2, arr2index1, arr2index2){
    //var arr1 = new Array();
    for(i = 0; i < arr2.length; i++) {
	    arr1.push(new Array(parseFloat(arr2[i][arr2index1]),parseFloat(arr2[i][arr2index2])));
    }
    return arr1;
}

function copy_array_txt(arr1, arr2, arr2index){
    //var arr1 = new Array();
    for(i = 0; i < arr2.length; i++) {
	    arr1.push(arr2[i][arr2index]);
    }
    return arr1;
}

function thickboxLoader(){
    tb_init('a.thickbox, area.thickbox, input.thickbox');//pass where to apply thickbox
	imgLoader = new Image();// preload image
	imgLoader.src = tb_pathToImage;
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
line1.Set('chart.key', ['Kc METRIC','Kc Literatura']);
line1.Set('chart.key.position', 'gutter');
line1.Set('chart.tickmarks', null);
line1.Set('chart.units.post', '');
line1.Set('chart.colors', ['#F27F00', '#CCCCCC']);
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
line1.Set('chart.labels',etiquetas);
line1.Set('chart.text.size',8);
line1.Set('chart.title','Grafico de Kc');
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

function tooltipsFunc(idx){

return 'Mes: '+etiquetasTooltip[idx]+'<br />'+
	   'Valor: '+datosTooltip[idx]+'<br />';
}

function get_month_in_words(mes){
    
    words = '';
    
    switch(mes){
	case 1:
	    words = "ENERO";
	    break;
	case 2:
	    words = "FEBRERO";
	    break;
	case 3:
	    words = "MARZO";
	    break;
	case 4:
	    words = "ABRIL";
	    break;
	case 5:
	    words = "MAYO";
	    break;
	case 6:
	    words = "JUNIO";
	    break;
	case 7:
	    words = "JULIO";
	    break;
	case 8:
	    words = "AGOSTO";
	    break;
	case 9:
	    words = "SEPTIEMBRE";
	    break;
	case 10:
	    words = "OCTUBRE";
	    break;
	case 11:
	    words = "NOVIEMBRE";
	    break;
	case 12:
	    words = "DICIEMBRE";
	    break;
    }
    
    return words;
}

function save_cropsector(){
    var sid = $('#sid').val();
    
    var cuartel_nombre = $('#cuartel_nombre').val();
    var cultivo_nombre = $('#cultivo_nombre').val();
    var variedad_nombre = $('#variedad_nombre').val();
    
    var dist_en_ileras = $('#cuartel_dist_en_ileras').val();
    var dist_so_ileras = $('#cuartel_dist_so_ileras').val();
    var crit_riego = $('#cuartel_crit_riego').val();
    var estr1_textura = $('#cuartel_estr1_textura').val();
    var estr1_grosor = $('#cuartel_estr1_grosor').val();
    var estr1_cc = $('#cuartel_estr1_cc').val();
    var estr1_pmp = $('#cuartel_estr1_pmp').val();	
    var estr2_textura = $('#cuartel_estr2_textura').val();
    var estr2_grosor = $('#cuartel_estr2_grosor').val();
    var estr2_cc = $('#cuartel_estr2_cc').val();
    var estr2_pmp = $('#cuartel_estr2_pmp').val();
    var estr3_textura = $('#cuartel_estr3_textura').val();
    var estr3_grosor = $('#cuartel_estr3_grosor').val();
    var estr3_cc = $('#cuartel_estr3_cc').val();
    var estr3_pmp = $('#cuartel_estr3_pmp').val();
    var ancho_moj = $('#cuartel_ancho_moj').val();
    var caud_emis = $('#cuartel_caud_emis').val();
    var num_emis_planta = $('#cuartel_num_emis_planta').val();
    var efis_riego = $('#cuartel_efis_riego').val();
    var coef_unif = $('#cuartel_coef_unif').val();
    var cropsector_id = $('#cropsector_id').val();

    url = 'mod_remote_sensing_functions.php';
    $.get(url,
          { 
            sid    : sid,
            accion : 'save_cropsector',
            dist_en_ileras : dist_en_ileras,
            dist_so_ileras : dist_so_ileras,
            crit_riego : crit_riego,
            estr1_textura : estr1_textura,
            estr1_grosor : estr1_grosor,
            estr1_cc : estr1_cc,
            estr1_pmp : estr1_pmp,	
            estr2_textura : estr2_textura,
            estr2_grosor : estr2_grosor,
            estr2_cc : estr2_cc,
            estr2_pmp : estr2_pmp,
            estr3_textura : estr3_textura,
            estr3_grosor : estr3_grosor,
            estr3_cc : estr3_cc,
            estr3_pmp : estr3_pmp,
            ancho_moj : ancho_moj,
            caud_emis : caud_emis,
            num_emis_planta : num_emis_planta,
            efis_riego : efis_riego,
            coef_unif : coef_unif,
            cuartel_nombre : cuartel_nombre,
            cultivo_nombre : cultivo_nombre,
            variedad_nombre : variedad_nombre,
            cropsector_id : cropsector_id
        },
        function(data){
            if(data == 1){
                if(cropsector_id == 0){
                    alert('El cuartel a sido ingresado correctamente');                   
                }
                else{
                    alert('El cuartel a sido actualizado correctamente');
                }
                set_fields_to_new_cropsector();
                window.location.href='mod_remote_sensing_cropsector.php?sid='+sid;
            }
            else{
                alert('Ocurrio un error al ingresar o actualizar el cuartel: '+data);
            }
    });
}

function get_cropsector_table(){
      var sid = $('#sid').val();
      var url = 'mod_remote_sensing_functions.php';
      
      $.post(url,
             {
                 accion : 'get_cropsectors_table',
                 sid : sid
             },
             function(data){
                 $('#tabla_cuarteles').html(data);
             });     
}

function make_irrigration_table(){
      var sid = $('#sid').val();
      var eid = jQuery('#select_estacion option:selected').val();
      var cid = jQuery('#cuartel_select option:selected').val();
      var fecha = jQuery('#fecha_imagen').val();
      
      var url = 'mod_remote_sensing_tabla_riego.php';
      
      $.post(url,
             {
                 sid : sid,
                 eid : eid,
                 cid : cid,
                 fecha : fecha,
                 kc : actualKc
             },
             function(data){
                 $('#irrigation_table').html(data);
             });     
}

function set_cropsector_to_edit(cid){
      var sid = $('#sid').val();
      
      var url = 'mod_remote_sensing_functions.php';
      
      $.post(url,
          {
              sid : sid,
              accion : 'set_cropsector_to_edit',
              cid : cid
          },
          function(data){
             
              $CSData = data.split('||');     
                    
              $('#cuartel_nombre').val($CSData[0]);
              $('#cultivo_nombre').val($CSData[1]);
              $('#variedad_nombre').val($CSData[2]);
                    
              $('#cuartel_dist_en_ileras').val($CSData[3]);
              $('#cuartel_dist_so_ileras').val($CSData[4]);
              $('#cuartel_crit_riego').val($CSData[5]);
              $('#cuartel_estr1_textura').val($CSData[6]);
              $('#cuartel_estr1_grosor').val($CSData[7]);
              $('#cuartel_estr1_cc').val($CSData[8]);
              $('#cuartel_estr1_pmp').val($CSData[9]);	
              $('#cuartel_estr2_textura').val($CSData[10]);
              $('#cuartel_estr2_grosor').val($CSData[11]);
              $('#cuartel_estr2_cc').val($CSData[12]);
              $('#cuartel_estr2_pmp').val($CSData[13]);
              $('#cuartel_estr3_textura').val($CSData[14]);
              $('#cuartel_estr3_grosor').val($CSData[15]);
              $('#cuartel_estr3_cc').val($CSData[16]);
              $('#cuartel_estr3_pmp').val($CSData[17]);
              $('#cuartel_ancho_moj').val($CSData[18]);
              $('#cuartel_caud_emis').val($CSData[19]);
              $('#cuartel_num_emis_planta').val($CSData[20]);
              $('#cuartel_efis_riego').val($CSData[21]);
              $('#cuartel_coef_unif').val($CSData[22]);
              
              $('#cropsector_id').val(cid);
          });             
}

function update_cropsector(){
    var sid = $('#sid').val();
    
    var cid = $('#cropsector_id').val();
    var cuartel_nombre = $('#cuartel_nombre').val();
    var cultivo_nombre = $('#cultivo_nombre').val();
    var variedad_nombre = $('#variedad_nombre').val();
    
    var dist_en_ileras = $('#cuartel_dist_en_ileras').val();
    var dist_so_ileras = $('#cuartel_dist_so_ileras').val();
    var crit_riego = $('#cuartel_crit_riego').val();
    var estr1_textura = $('#cuartel_estr1_textura').val();
    var estr1_grosor = $('#cuartel_estr1_grosor').val();
    var estr1_cc = $('#cuartel_estr1_cc').val();
    var estr1_pmp = $('#cuartel_estr1_pmp').val();	
    var estr2_textura = $('#cuartel_estr2_textura').val();
    var estr2_grosor = $('#cuartel_estr2_grosor').val();
    var estr2_cc = $('#cuartel_estr2_cc').val();
    var estr2_pmp = $('#cuartel_estr2_pmp').val();
    var estr3_textura = $('#cuartel_estr3_textura').val();
    var estr3_grosor = $('#cuartel_estr3_grosor').val();
    var estr3_cc = $('#cuartel_estr3_cc').val();
    var estr3_pmp = $('#cuartel_estr3_pmp').val();
    var ancho_moj = $('#cuartel_ancho_moj').val();
    var caud_emis = $('#cuartel_caud_emis').val();
    var num_emis_planta = $('#cuartel_num_emis_planta').val();
    var efis_riego = $('#cuartel_efis_riego').val();
    var coef_unif = $('#cuartel_coef_unif').val();

    url = 'mod_remote_sensing_functions.php';
    $.get(url,
          { 
            sid    : sid,
            accion : 'save_cropsector',
            dist_en_ileras : dist_en_ileras,
            dist_so_ileras : dist_so_ileras,
            crit_riego : crit_riego,
            estr1_textura : estr1_textura,
            estr1_grosor : estr1_grosor,
            estr1_cc : estr1_cc,
            estr1_pmp : estr1_pmp,	
            estr2_textura : estr2_textura,
            estr2_grosor : estr2_grosor,
            estr2_cc : estr2_cc,
            estr2_pmp : estr2_pmp,
            estr3_textura : estr3_textura,
            estr3_grosor : estr3_grosor,
            estr3_cc : estr3_cc,
            estr3_pmp : estr3_pmp,
            ancho_moj : ancho_moj,
            caud_emis : caud_emis,
            num_emis_planta : num_emis_planta,
            efis_riego : efis_riego,
            coef_unif : coef_unif,
            cuartel_nombre : cuartel_nombre,
            cultivo_nombre : cultivo_nombre,
            variedad_nombre : variedad_nombre
        },
        function(data){
            alert(data);
            
    });
}

function set_fields_to_new_cropsector(){
    $('#cuartel_nombre').val('');
    $('#cultivo_nombre').val('');
    $('#variedad_nombre').val('');
                    
    $('#cuartel_dist_en_ileras').val('');
    $('#cuartel_dist_so_ileras').val('');
    $('#cuartel_crit_riego').val('');
    $('#cuartel_estr1_textura').val('');
    $('#cuartel_estr1_grosor').val('');
    $('#cuartel_estr1_cc').val('');
    $('#cuartel_estr1_pmp').val('');	
    $('#cuartel_estr2_textura').val('');
    $('#cuartel_estr2_grosor').val('');
    $('#cuartel_estr2_cc').val('');
    $('#cuartel_estr2_pmp').val('');
    $('#cuartel_estr3_textura').val('');
    $('#cuartel_estr3_grosor').val('');
    $('#cuartel_estr3_cc').val('');
    $('#cuartel_estr3_pmp').val('');
    $('#cuartel_ancho_moj').val('');
    $('#cuartel_caud_emis').val('');
    $('#cuartel_num_emis_planta').val('');
    $('#cuartel_efis_riego').val('');
    $('#cuartel_coef_unif').val('');
              
    $('#cropsector_id').val('0');
}

function delete_cropsector(cid){
    var sid = $('#sid').val();
      
    var url = 'mod_remote_sensing_functions.php';
    
    if(confirm('Esta seguro de querer borrar este cuartel?')){
    
    $.post(url,
        {
            sid : sid,
            accion : 'delete_cropsector',
            cid : cid
         },
         function(data){
             if(data == 1){
                   alert('El cuarte fue borrado correctamente'); 
             }
             else{
                    alert('Ocurrio un error al borrar el cuartel: '+data);
             }
             set_fields_to_new_cropsector();
             window.location.href='mod_remote_sensing_cropsector.php?sid='+sid;
         });
    }
}
