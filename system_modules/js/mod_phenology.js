var datos = new Array();
var fechas = new Array();
var fechasAll = new Array();
var horas = new Array();
var testing = new Array();
var unit = '&deg;';
var GDA = 0;
var maxPhenologyIndex = 40;
var minPhenologyindex = 0;
var nombreEstacion = '';


function getStationSelectTypeStation(){
	var sid = $('#sid').val();
	var mid = $('#mid').val();
	var tar = $('#target').val();
	
	var url = '../system/modelo.acciones.php?sid='+sid+'&accion=getstationsselect&target='+tar+'&mid='+mid;
	
	$.get(url,'',function(data){
		if(data != 0){
			swapText('select_estacion_field',data);
			var hours;
			var dates;
			var numbers;
			var sideid = $('#select_estacion option:first').val();
			nombreEstacion = $('#select_estacion option:first').html();
			var startdate = $('#gdd_date').val();
			var url = 'mod_phenology_functions.php?sid='+sid+'&accion=getdata_json&target=SENSOR&mid='+mid+'&eid='+sideid+'&startdate='+startdate;
			
			$.getJSON(url,'',function(data){
				graphData = data;
				copy_array(datos,graphData, 1);
				copy_labels_array2(fechasAll,graphData, 0);
				copy_labels_array3(fechas,graphData, 0);
				get_unit(graphData, 2);
				start_line_graph();
				moveScrollGeneral(getGDA());
				moveScrollCabernetS(getGDA());
				moveScrollMerlot(getGDA());
				moveScrollChardonnay(getGDA());
				moveScrollSauvignonB(getGDA());
				$('#gda_number').html(getGDA());
			});
		}
		else{
			error("Error al cargar las estaciones: "+data );
		}
	});
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

function copy_labels_array2(arr1, arr2, arr2index){
	//var arr1 = new Array();
	for(i = 0; i < arr2.length; i++) {
		arr1.push(arr2[i][arr2index]);
	}
	return arr1;
}

function copy_labels_array3(arr1, arr2, arr2index){
	//var arr1 = new Array();
	for(i = 0; i < arr2.length; i++) {
		if(i % 12 == 0)	
			arr1.push(arr2[i][arr2index]);
		else
			arr1.push('');
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
	return 'Fecha: '+fechasAll[idx]+'<br />'+
	       'Valor: '+datos[idx]+unit+'<br />';
}

function getGDA(){
	return 	datos[datos.length - 1];
}

function start_line_graph(){
	RGraph.Clear(document.getElementById("chartContainer"));
	window.line1 = new RGraph.Line('chartContainer', datos);
	window.line1.Set('chart.background.grid', true);
	window.line1.Set('chart.linewidth', 5);
	window.line1.Set('chart.gutter.left', 65);
	window.line1.Set('chart.gutter.bottom', 85);
	window.line1.Set('chart.hmargin', 5);
	if (!document.all || RGraph.isIE9up()) {
		window.line1.Set('chart.shadow', true);
	}
	window.line1.Set('chart.tickmarks', null);
	window.line1.Set('chart.units.post', unit);
	window.line1.Set('chart.colors', ['#F27F00']);
	window.line1.Set('chart.background.grid.autofit', true);
	window.line1.Set('chart.background.grid.autofit.numhlines', 10);
	window.line1.Set('chart.curvy', false);
	window.line1.Set('chart.text.angle', 45);
	window.line1.Set('chart.curvy.factor', 0.5); // This is the default
	window.line1.Set('chart.animation.unfold.initial',0);
	window.line1.Set('chart.labels',fechas);
	window.line1.Set('chart.text.size',8);
	window.line1.Set('chart.title','GRADOS DIA ACUMULADOS - '+nombreEstacion);
	window.line1.Set('chart.tooltips.effect', 'fade');
	window.line1.Set('chart.tooltips', tooltipsFunc);
	
	if (RGraph.isOld()) {
		window.line1.Draw();
	} else {
		RGraph.Effects.Fade.In(window.line1);
		RGraph.Effects.jQuery.Reveal(window.line1);
		RGraph.Effects.Line.jQuery.Trace(window.line1);
	}
}

function load_data_graph(){
	var sid = $('#sid').val();
	$('#chartContainer').html('Cargando datos...');
	
	var sideid = $('#select_estacion option:selected').val();
	var startdate = $('#gdd_date').val();
	nombreEstacion = $('#select_estacion option:selected').html();
	var url = 'mod_phenology_functions.php?sid='+sid+'&accion=getdata_json&target=SENSOR&mid='+MID+'&eid='+sideid+'&startdate='+startdate;
	var hours;
	var dates;
	var numbers;
	
	$.getJSON(url,'',function(data){
		datos = new Array();
		fechas = new Array();
		fechasAll = new Array();
		horas = new Array();
		testing = new Array();
		graphData = data;
		copy_array(datos,graphData, 1);
		copy_labels_array2(fechasAll,graphData, 0);
		copy_labels_array3(fechas,graphData, 0);
		get_unit(graphData, 2);
		start_line_graph();
		moveScrollGeneral(getGDA());
		moveScrollCabernetS(getGDA());
		moveScrollMerlot(getGDA());
		moveScrollChardonnay(getGDA());
		moveScrollSauvignonB(getGDA());
		$('#gda_number').html(getGDA());
	});
}

//***************************
//SCROLL PANELS
//***************************

var scrollbar, scrollPane, scrollContent;
var scrollbar2, scrollPane2, scrollContent2;
var scrollbar3, scrollPane3, scrollContent3;
var scrollbar4, scrollPane4, scrollContent4;
var scrollbar5, scrollPane5, scrollContent5;

$(function() {
	//scrollpane parts
	scrollPane = $( "#scroll-pane" );
	scrollContent = $( "#scroll-content" );
	
	//build slider
	scrollbar = $( "#scroll-bar" ).slider({
		slide: function( event, ui ) {
			if ( scrollContent.width() > scrollPane.width() ) {
				scrollContent.css( "margin-left", Math.round(
					ui.value / 100 * ( scrollPane.width() - scrollContent.width() )
				) + "px" );
			} else {
				scrollContent.css( "margin-left", 0 );
			}
		}
	});
	
	//append icon to handle
	var handleHelper = scrollbar.find( ".ui-slider-handle" )
	.mousedown(function() {
		scrollbar.width( handleHelper.width() );
	})
	.mouseup(function() {
		scrollbar.width( "100%" );
	})
	.append( "<span class='ui-icon ui-icon-grip-dotted-vertical'></span>" )
	.wrap( "<div class='ui-handle-helper-parent'></div>" ).parent();
	
	//change overflow to hidden now that slider handles the scrolling
	scrollPane.css( "overflow", "hidden" );
	
	//size scrollbar and handle proportionally to scroll distance
	function sizeScrollbar() {
		var remainder = scrollContent.width() - scrollPane.width();
		var proportion = remainder / scrollContent.width();
		var handleSize = scrollPane.width() - ( proportion * scrollPane.width() );
		scrollbar.find( ".ui-slider-handle" ).css({
			width: handleSize,
			"margin-left": -handleSize / 2
		});
		handleHelper.width( "" ).width( scrollbar.width() - handleSize );
	}
	
	//reset slider value based on scroll content position
	function resetValue() {
		var remainder = scrollPane.width() - scrollContent.width();
		var leftVal = scrollContent.css( "margin-left" ) === "auto" ? 0 :
			parseInt( scrollContent.css( "margin-left" ) );
		var percentage = Math.round( leftVal / remainder * 100 );
		scrollbar.slider( "value", percentage );
	}
	
	//if the slider is 100% and window gets larger, reveal content
	function reflowContent() {
			var showing = scrollContent.width() + parseInt( scrollContent.css( "margin-left" ), 10 );
			var gap = scrollPane.width() - showing;
			if ( gap > 0 ) {
				scrollContent.css( "margin-left", parseInt( scrollContent.css( "margin-left" ), 10 ) + gap );
			}
	}
	
	//change handle position on window resize
	$( window ).resize(function() {
		resetValue();
		sizeScrollbar();
		reflowContent();
	});
	//init scrollbar size
	setTimeout( sizeScrollbar, 10 );//safari wants a timeout
});

$(function() {
	//scrollpane parts
	scrollPane2 = $( "#scroll-pane2" );
	scrollContent2 = $( "#scroll-content2" );
	
	//build slider
	scrollbar2 = $( "#scroll-bar2" ).slider({
		slide: function( event, ui ) {
			if ( scrollContent2.width() > scrollPane2.width() ) {
				scrollContent2.css( "margin-left", Math.round(
					ui.value / 100 * ( scrollPane2.width() - scrollContent2.width() )
				) + "px" );
			} else {
				scrollContent2.css( "margin-left", 0 );
			}
		}
	});
	
	//append icon to handle
	var handleHelper2 = scrollbar2.find( ".ui-slider-handle" )
	.mousedown(function() {
		scrollbar2.width( handleHelper2.width() );
	})
	.mouseup(function() {
		scrollbar2.width( "100%" );
	})
	.append( "<span class='ui-icon ui-icon-grip-dotted-vertical'></span>" )
	.wrap( "<div class='ui-handle-helper-parent'></div>" ).parent();
	
	//change overflow to hidden now that slider handles the scrolling
	scrollPane2.css( "overflow", "hidden" );
	
	//size scrollbar and handle proportionally to scroll distance
	function sizeScrollbar2() {
		var remainder = scrollContent2.width() - scrollPane2.width();
		var proportion = remainder / scrollContent2.width();
		var handleSize = scrollPane2.width() - ( proportion * scrollPane2.width() );
		scrollbar2.find( ".ui-slider-handle" ).css({
			width: handleSize,
			"margin-left": -handleSize / 2
		});
		handleHelper2.width( "" ).width( scrollbar2.width() - handleSize );
	}
	
	//reset slider value based on scroll content position
	function resetValue2() {
		var remainder = scrollPane2.width() - scrollContent2.width();
		var leftVal = scrollContent2.css( "margin-left" ) === "auto" ? 0 :
			parseInt( scrollContent2.css( "margin-left" ) );
		var percentage = Math.round( leftVal / remainder * 100 );
		scrollbar2.slider( "value", percentage );
	}
	
	//if the slider is 100% and window gets larger, reveal content
	function reflowContent2() {
			var showing = scrollContent2.width() + parseInt( scrollContent2.css( "margin-left" ), 10 );
			var gap = scrollPane2.width() - showing;
			if ( gap > 0 ) {
				scrollContent2.css( "margin-left", parseInt( scrollContent2.css( "margin-left" ), 10 ) + gap );
			}
	}
	
	//change handle position on window resize
	$( window ).resize(function() {
		resetValue2();
		sizeScrollbar2();
		reflowContent2();
	});
	//init scrollbar size
	setTimeout( sizeScrollbar2, 10 );//safari wants a timeout
});

$(function() {
	//scrollpane parts
	scrollPane3 = $( "#scroll-pane3" );
	scrollContent3 = $( "#scroll-content3" );
	
	//build slider
	scrollbar3 = $( "#scroll-bar3" ).slider({
		slide: function( event, ui ) {
			if ( scrollContent3.width() > scrollPane3.width() ) {
				scrollContent3.css( "margin-left", Math.round(
					ui.value / 100 * ( scrollPane3.width() - scrollContent3.width() )
				) + "px" );
			} else {
				scrollContent3.css( "margin-left", 0 );
			}
		}
	});
	
	//append icon to handle
	var handleHelper3 = scrollbar3.find( ".ui-slider-handle" )
	.mousedown(function() {
		scrollbar3.width( handleHelper3.width() );
	})
	.mouseup(function() {
		scrollbar3.width( "100%" );
	})
	.append( "<span class='ui-icon ui-icon-grip-dotted-vertical'></span>" )
	.wrap( "<div class='ui-handle-helper-parent'></div>" ).parent();
	
	//change overflow to hidden now that slider handles the scrolling
	scrollPane3.css( "overflow", "hidden" );
	
	//size scrollbar and handle proportionally to scroll distance
	function sizeScrollbar3() {
		var remainder = scrollContent3.width() - scrollPane3.width();
		var proportion = remainder / scrollContent3.width();
		var handleSize = scrollPane3.width() - ( proportion * scrollPane3.width() );
		scrollbar3.find( ".ui-slider-handle" ).css({
			width: handleSize,
			"margin-left": -handleSize / 2
		});
		handleHelper3.width( "" ).width( scrollbar3.width() - handleSize );
	}
	
	//reset slider value based on scroll content position
	function resetValue3() {
		var remainder = scrollPane3.width() - scrollContent3.width();
		var leftVal = scrollContent3.css( "margin-left" ) === "auto" ? 0 :
			parseInt( scrollContent3.css( "margin-left" ) );
		var percentage = Math.round( leftVal / remainder * 100 );
		scrollbar3.slider( "value", percentage );
	}
	
	//if the slider is 100% and window gets larger, reveal content
	function reflowContent3() {
			var showing = scrollContent3.width() + parseInt( scrollContent3.css( "margin-left" ), 10 );
			var gap = scrollPane3.width() - showing;
			if ( gap > 0 ) {
				scrollContent3.css( "margin-left", parseInt( scrollContent3.css( "margin-left" ), 10 ) + gap );
			}
	}
	
	//change handle position on window resize
	$( window ).resize(function() {
		resetValue3();
		sizeScrollbar3();
		reflowContent3();
	});
	//init scrollbar size
	setTimeout( sizeScrollbar3, 10 );//safari wants a timeout
});

$(function() {
	//scrollpane parts
	scrollPane4 = $( "#scroll-pane4" );
	scrollContent4 = $( "#scroll-content4" );
	
	//build slider
	scrollbar4 = $( "#scroll-bar4" ).slider({
		slide: function( event, ui ) {
			if ( scrollContent4.width() > scrollPane4.width() ) {
				scrollContent4.css( "margin-left", Math.round(
					ui.value / 100 * ( scrollPane4.width() - scrollContent4.width() )
				) + "px" );
			} else {
				scrollContent4.css( "margin-left", 0 );
			}
		}
	});
	
	//append icon to handle
	var handleHelper4 = scrollbar4.find( ".ui-slider-handle" )
	.mousedown(function() {
		scrollbar4.width( handleHelper4.width() );
	})
	.mouseup(function() {
		scrollbar4.width( "100%" );
	})
	.append( "<span class='ui-icon ui-icon-grip-dotted-vertical'></span>" )
	.wrap( "<div class='ui-handle-helper-parent'></div>" ).parent();
	
	//change overflow to hidden now that slider handles the scrolling
	scrollPane4.css( "overflow", "hidden" );
	
	//size scrollbar and handle proportionally to scroll distance
	function sizeScrollbar4() {
		var remainder = scrollContent4.width() - scrollPane4.width();
		var proportion = remainder / scrollContent4.width();
		var handleSize = scrollPane4.width() - ( proportion * scrollPane4.width() );
		scrollbar4.find( ".ui-slider-handle" ).css({
			width: handleSize,
			"margin-left": -handleSize / 2
		});
		handleHelper4.width( "" ).width( scrollbar4.width() - handleSize );
	}
	
	//reset slider value based on scroll content position
	function resetValue4() {
		var remainder = scrollPane4.width() - scrollContent4.width();
		var leftVal = scrollContent4.css( "margin-left" ) === "auto" ? 0 :
			parseInt( scrollContent4.css( "margin-left" ) );
		var percentage = Math.round( leftVal / remainder * 100 );
		scrollbar4.slider( "value", percentage );
	}
	
	//if the slider is 100% and window gets larger, reveal content
	function reflowContent4() {
			var showing = scrollContent4.width() + parseInt( scrollContent4.css( "margin-left" ), 10 );
			var gap = scrollPane4.width() - showing;
			if ( gap > 0 ) {
				scrollContent4.css( "margin-left", parseInt( scrollContent4.css( "margin-left" ), 10 ) + gap );
			}
	}
	
	//change handle position on window resize
	$( window ).resize(function() {
		resetValue4();
		sizeScrollbar4();
		reflowContent4();
	});
	//init scrollbar size
	setTimeout( sizeScrollbar4, 10 );//safari wants a timeout
});

$(function() {
	//scrollpane parts
	scrollPane5 = $( "#scroll-pane5" );
	scrollContent5 = $( "#scroll-content5" );
	
	//build slider
	scrollbar5 = $( "#scroll-bar5" ).slider({
		slide: function( event, ui ) {
			if ( scrollContent5.width() > scrollPane5.width() ) {
				scrollContent5.css( "margin-left", Math.round(
					ui.value / 100 * ( scrollPane5.width() - scrollContent5.width() )
				) + "px" );
			} else {
				scrollContent5.css( "margin-left", 0 );
			}
		}
	});
	
	//append icon to handle
	var handleHelper5 = scrollbar5.find( ".ui-slider-handle" )
	.mousedown(function() {
		scrollbar5.width( handleHelper5.width() );
	})
	.mouseup(function() {
		scrollbar5.width( "100%" );
	})
	.append( "<span class='ui-icon ui-icon-grip-dotted-vertical'></span>" )
	.wrap( "<div class='ui-handle-helper-parent'></div>" ).parent();
	
	//change overflow to hidden now that slider handles the scrolling
	scrollPane5.css( "overflow", "hidden" );
	
	//size scrollbar and handle proportionally to scroll distance
	function sizeScrollbar5() {
		var remainder = scrollContent5.width() - scrollPane5.width();
		var proportion = remainder / scrollContent5.width();
		var handleSize = scrollPane5.width() - ( proportion * scrollPane5.width() );
		scrollbar5.find( ".ui-slider-handle" ).css({
			width: handleSize,
			"margin-left": -handleSize / 2
		});
		handleHelper5.width( "" ).width( scrollbar5.width() - handleSize );
	}
	
	//reset slider value based on scroll content position
	function resetValue5() {
		var remainder = scrollPane5.width() - scrollContent5.width();
		var leftVal = scrollContent5.css( "margin-left" ) === "auto" ? 0 :
			parseInt( scrollContent5.css( "margin-left" ) );
		var percentage = Math.round( leftVal / remainder * 100 );
		scrollbar5.slider( "value", percentage );
	}
	
	//if the slider is 100% and window gets larger, reveal content
	function reflowContent5() {
			var showing = scrollContent5.width() + parseInt( scrollContent5.css( "margin-left" ), 10 );
			var gap = scrollPane5.width() - showing;
			if ( gap > 0 ) {
				scrollContent5.css( "margin-left", parseInt( scrollContent5.css( "margin-left" ), 10 ) + gap );
			}
	}
	
	//change handle position on window resize
	$( window ).resize(function() {
		resetValue5();
		sizeScrollbar5();
		reflowContent5();
	});
	//init scrollbar size
	setTimeout( sizeScrollbar5, 10 );//safari wants a timeout
});

function modelCabernetS(grados){
	return Math.round(39.0 - 29.81 * Math.exp(-0.002*grados)); 
}

function modelMerlot(grados){
	return Math.round(39.0 - 30.84 * Math.exp(-0.002*grados)); 
}

function modelChardonnay(grados){
	return Math.round(39.0 - 28.22 * Math.exp(-0.002*grados)); 
}

function modelSauvignonB(grados){
	return Math.round(39.0 - 29.98 * Math.exp(-0.002*grados)); 
}

function modelGeneral(grados){
	return Math.round(39.0 - 29.7125 * Math.exp(-0.002*grados)); 
}

function moveScrollGeneral(grados){
	phenology = modelGeneral(grados);
	
	if(phenology > 47 || (ACTUALMONTH > 4 && ACTUALMONTH < 9))
		phenology = 1;

	highlightPhenologyGeneral(phenology);
	scrollPercentPhenology = phenology * 100 / maxPhenologyIndex;
	
	if(scrollPercentPhenology > 100)
		scrollPercentPhenology = 100;
	
	if(scrollPercentPhenology < 0)
		scrollPercentPhenology = 0;
		
	if(phenology <= 5 || phenology > 47)
		scrollPercentPhenology = 0;
	else if(phenology > 35)
		scrollPercentPhenology = 100;
	
	if(phenology > 50)
		phenology = 1;
	
	scrollbar.slider("value",scrollPercentPhenology);
	if ( scrollContent.width() > scrollPane.width() ) {
		scrollContent.css( "margin-left", Math.round(
			scrollbar.slider("value") / 100 * ( scrollPane.width() - scrollContent.width() )
		) + "px" );
	} else {
		scrollContent.css( "margin-left", 0 );
	}
	
}

function highlightPhenologyGeneral(phenologyIndex){
	$('#scroll-content div.scroll-content-item').removeClass('scroll-content-item-current');
	switch(phenologyIndex){
		case 0:
			break;		
		case 1:
		case 3:
		case 5:
		case 7:
		case 9:
		case 12:
		case 15:
		case 17:
		case 19:
		case 23:
		case 25:
		case 27:
		case 29:
		case 31:
		case 33:
		case 34:
		case 35:
		case 36:
		case 38:		
			$('#1phenology-index-'+phenologyIndex).addClass('scroll-content-item-current');
			break;			
		case 2:
			$('#1phenology-index-1').addClass('scroll-content-item-current');
			$('#1phenology-index-3').addClass('scroll-content-item-current');
			break;
		case 4:
			$('#1phenology-index-3').addClass('scroll-content-item-current');
			$('#1phenology-index-5').addClass('scroll-content-item-current');
			break;
		case 6:
			$('#1phenology-index-5').addClass('scroll-content-item-current');
			$('#1phenology-index-7').addClass('scroll-content-item-current');
			break;
		case 8:
			$('#1phenology-index-7').addClass('scroll-content-item-current');
			$('#1phenology-index-9').addClass('scroll-content-item-current');
			break;
		case 10:
		case 11:
			$('#1phenology-index-9').addClass('scroll-content-item-current');
			$('#1phenology-index-12').addClass('scroll-content-item-current');
			break;
		case 13:
		case 14:
			$('#1phenology-index-12').addClass('scroll-content-item-current');
			$('#1phenology-index-15').addClass('scroll-content-item-current');
			break;
		case 16:
			$('#1phenology-index-15').addClass('scroll-content-item-current');
			$('#1phenology-index-17').addClass('scroll-content-item-current');
			break;
		case 18:
			$('#1phenology-index-17').addClass('scroll-content-item-current');
			$('#1phenology-index-19').addClass('scroll-content-item-current');
			break;
		case 20:
		case 21:
		case 22:
			$('#1phenology-index-19').addClass('scroll-content-item-current');
			$('#1phenology-index-23').addClass('scroll-content-item-current');
			break;
		case 24:
			$('#1phenology-index-23').addClass('scroll-content-item-current');
			$('#1phenology-index-25').addClass('scroll-content-item-current');
			break;
		case 26:
			$('#1phenology-index-25').addClass('scroll-content-item-current');
			$('#1phenology-index-27').addClass('scroll-content-item-current');
			break;
		case 28:
			$('#1phenology-index-27').addClass('scroll-content-item-current');
			$('#1phenology-index-29').addClass('scroll-content-item-current');
			break;
		case 30:
			$('#1phenology-index-29').addClass('scroll-content-item-current');
			$('#1phenology-index-31').addClass('scroll-content-item-current');
			break;
		case 32:
			$('#1phenology-index-31').addClass('scroll-content-item-current');
			$('#1phenology-index-33').addClass('scroll-content-item-current');
			break;
		case 37:
			$('#1phenology-index-36').addClass('scroll-content-item-current');
			$('#1phenology-index-38').addClass('scroll-content-item-current');
			break;
		case 39:
		case 40:
		case 41:
		case 42:
		case 43:
		case 44:
		case 45:
		case 46:
		case 47:
			$('#1phenology-index-38').addClass('scroll-content-item-current');
			break;
	}
}

function moveScrollCabernetS(grados){
	phenology = modelCabernetS(grados);
	
	if(phenology > 47 || (ACTUALMONTH > 4 && ACTUALMONTH < 9))
		phenology = 1;
	
	highlightPhenologyCabernetS(phenology);
	scrollPercentPhenology = phenology * 100 / maxPhenologyIndex;
	
	if(scrollPercentPhenology > 100)
		scrollPercentPhenology = 100;
	
	if(scrollPercentPhenology < 0)
		scrollPercentPhenology = 0;
		
	if(phenology <= 5 || phenology > 47)
		scrollPercentPhenology = 0;
	else if(phenology > 35)
		scrollPercentPhenology = 100;
	
	scrollbar2.slider("value",scrollPercentPhenology);
	if ( scrollContent2.width() > scrollPane2.width() ) {
		scrollContent2.css( "margin-left", Math.round(
			scrollbar2.slider("value") / 100 * ( scrollPane2.width() - scrollContent2.width() )
		) + "px" );
	} else {
		scrollContent2.css( "margin-left", 0 );
	}
	
}

function highlightPhenologyCabernetS(phenologyIndex){
	$('#scroll-content2 div.scroll-content-item').removeClass('scroll-content-item-current');
	switch(phenologyIndex){
		case 0:
			break;		
		case 1:
		case 3:
		case 5:
		case 7:
		case 9:
		case 12:
		case 15:
		case 17:
		case 19:
		case 23:
		case 25:
		case 27:
		case 29:
		case 31:
		case 33:
		case 34:
		case 35:
		case 36:
		case 38:		
			$('#2phenology-index-'+phenologyIndex).addClass('scroll-content-item-current');
			break;			
		case 2:
			$('#2phenology-index-1').addClass('scroll-content-item-current');
			$('#2phenology-index-3').addClass('scroll-content-item-current');
			break;
		case 4:
			$('#2phenology-index-3').addClass('scroll-content-item-current');
			$('#2phenology-index-5').addClass('scroll-content-item-current');
			break;
		case 6:
			$('#2phenology-index-5').addClass('scroll-content-item-current');
			$('#2phenology-index-7').addClass('scroll-content-item-current');
			break;
		case 8:
			$('#2phenology-index-7').addClass('scroll-content-item-current');
			$('#2phenology-index-9').addClass('scroll-content-item-current');
			break;
		case 10:
		case 11:
			$('#2phenology-index-9').addClass('scroll-content-item-current');
			$('#2phenology-index-12').addClass('scroll-content-item-current');
			break;
		case 13:
		case 14:
			$('#2phenology-index-12').addClass('scroll-content-item-current');
			$('#2phenology-index-15').addClass('scroll-content-item-current');
			break;
		case 16:
			$('#2phenology-index-15').addClass('scroll-content-item-current');
			$('#2phenology-index-17').addClass('scroll-content-item-current');
			break;
		case 18:
			$('#2phenology-index-17').addClass('scroll-content-item-current');
			$('#2phenology-index-19').addClass('scroll-content-item-current');
			break;
		case 20:
		case 21:
		case 22:
			$('#2phenology-index-19').addClass('scroll-content-item-current');
			$('#2phenology-index-23').addClass('scroll-content-item-current');
			break;
		case 24:
			$('#2phenology-index-23').addClass('scroll-content-item-current');
			$('#2phenology-index-25').addClass('scroll-content-item-current');
			break;
		case 26:
			$('#2phenology-index-25').addClass('scroll-content-item-current');
			$('#2phenology-index-27').addClass('scroll-content-item-current');
			break;
		case 28:
			$('#2phenology-index-27').addClass('scroll-content-item-current');
			$('#2phenology-index-29').addClass('scroll-content-item-current');
			break;
		case 30:
			$('#2phenology-index-29').addClass('scroll-content-item-current');
			$('#2phenology-index-31').addClass('scroll-content-item-current');
			break;
		case 32:
			$('#2phenology-index-31').addClass('scroll-content-item-current');
			$('#2phenology-index-33').addClass('scroll-content-item-current');
			break;
		case 37:
			$('#2phenology-index-36').addClass('scroll-content-item-current');
			$('#2phenology-index-38').addClass('scroll-content-item-current');
			break;
		case 39:
		case 40:
		case 41:
		case 42:
		case 43:
		case 44:
		case 45:
		case 46:
		case 47:
			$('#2phenology-index-38').addClass('scroll-content-item-current');
			break;
	}
}

function moveScrollMerlot(grados){
	phenology = modelMerlot(grados);
	
	if(phenology > 47 || (ACTUALMONTH > 4 && ACTUALMONTH < 9))
		phenology = 1;
	
	highlightPhenologyMerlot(phenology);
	scrollPercentPhenology = phenology * 100 / maxPhenologyIndex;
	
	if(scrollPercentPhenology > 100)
		scrollPercentPhenology = 100;
	
	if(scrollPercentPhenology < 0)
		scrollPercentPhenology = 0;
		
	if(phenology <= 5 || phenology > 47)
		scrollPercentPhenology = 0;
	else if(phenology > 35)
		scrollPercentPhenology = 100;
	
	scrollbar3.slider("value",scrollPercentPhenology);
	if ( scrollContent3.width() > scrollPane3.width() ) {
		scrollContent3.css( "margin-left", Math.round(
			scrollbar3.slider("value") / 100 * ( scrollPane3.width() - scrollContent3.width() )
		) + "px" );
	} else {
		scrollContent3.css( "margin-left", 0 );
	}
	
}

function highlightPhenologyMerlot(phenologyIndex){
	$('#scroll-content3 div.scroll-content-item').removeClass('scroll-content-item-current');
	switch(phenologyIndex){
		case 0:
			break;		
		case 1:
		case 3:
		case 5:
		case 7:
		case 9:
		case 12:
		case 15:
		case 17:
		case 19:
		case 23:
		case 25:
		case 27:
		case 29:
		case 31:
		case 33:
		case 34:
		case 35:
		case 36:
		case 38:		
			$('#3phenology-index-'+phenologyIndex).addClass('scroll-content-item-current');
			break;			
		case 2:
			$('#3phenology-index-1').addClass('scroll-content-item-current');
			$('#3phenology-index-3').addClass('scroll-content-item-current');
			break;
		case 4:
			$('#3phenology-index-3').addClass('scroll-content-item-current');
			$('#3phenology-index-5').addClass('scroll-content-item-current');
			break;
		case 6:
			$('#3phenology-index-5').addClass('scroll-content-item-current');
			$('#3phenology-index-7').addClass('scroll-content-item-current');
			break;
		case 8:
			$('#3phenology-index-7').addClass('scroll-content-item-current');
			$('#3phenology-index-9').addClass('scroll-content-item-current');
			break;
		case 10:
		case 11:
			$('#3phenology-index-9').addClass('scroll-content-item-current');
			$('#3phenology-index-12').addClass('scroll-content-item-current');
			break;
		case 13:
		case 14:
			$('#3phenology-index-12').addClass('scroll-content-item-current');
			$('#3phenology-index-15').addClass('scroll-content-item-current');
			break;
		case 16:
			$('#3phenology-index-15').addClass('scroll-content-item-current');
			$('#3phenology-index-17').addClass('scroll-content-item-current');
			break;
		case 18:
			$('#3phenology-index-17').addClass('scroll-content-item-current');
			$('#3phenology-index-19').addClass('scroll-content-item-current');
			break;
		case 20:
		case 21:
		case 22:
			$('#3phenology-index-19').addClass('scroll-content-item-current');
			$('#3phenology-index-23').addClass('scroll-content-item-current');
			break;
		case 24:
			$('#3phenology-index-23').addClass('scroll-content-item-current');
			$('#3phenology-index-25').addClass('scroll-content-item-current');
			break;
		case 26:
			$('#3phenology-index-25').addClass('scroll-content-item-current');
			$('#3phenology-index-27').addClass('scroll-content-item-current');
			break;
		case 28:
			$('#3phenology-index-27').addClass('scroll-content-item-current');
			$('#3phenology-index-29').addClass('scroll-content-item-current');
			break;
		case 30:
			$('#3phenology-index-29').addClass('scroll-content-item-current');
			$('#3phenology-index-31').addClass('scroll-content-item-current');
			break;
		case 32:
			$('#3phenology-index-31').addClass('scroll-content-item-current');
			$('#3phenology-index-33').addClass('scroll-content-item-current');
			break;
		case 37:
			$('#3phenology-index-36').addClass('scroll-content-item-current');
			$('#3phenology-index-38').addClass('scroll-content-item-current');
			break;
		case 39:
		case 40:
		case 41:
		case 42:
		case 43:
		case 44:
		case 45:
		case 46:
		case 47:
			$('#3phenology-index-38').addClass('scroll-content-item-current');
			break;
	}
}

function moveScrollChardonnay(grados){
	phenology = modelChardonnay(grados);
	
	if(phenology > 47 || (ACTUALMONTH > 4 && ACTUALMONTH < 9))
		phenology = 1;
	
	highlightPhenologyChardonnay(phenology);
	scrollPercentPhenology = phenology * 100 / maxPhenologyIndex;
	
	if(scrollPercentPhenology > 100)
		scrollPercentPhenology = 100;
	
	if(scrollPercentPhenology < 0)
		scrollPercentPhenology = 0;
		
	if(phenology <= 5 || phenology > 47)
		scrollPercentPhenology = 0;
	else if(phenology > 35)
		scrollPercentPhenology = 100;
	
	scrollbar4.slider("value",scrollPercentPhenology);
	if ( scrollContent4.width() > scrollPane4.width() ) {
		scrollContent4.css( "margin-left", Math.round(
			scrollbar4.slider("value") / 100 * ( scrollPane4.width() - scrollContent4.width() )
		) + "px" );
	} else {
		scrollContent4.css( "margin-left", 0 );
	}
	
}

function highlightPhenologyChardonnay(phenologyIndex){
	$('#scroll-content4 div.scroll-content-item').removeClass('scroll-content-item-current');
	switch(phenologyIndex){
		case 0:
			break;		
		case 1:
		case 3:
		case 5:
		case 7:
		case 9:
		case 12:
		case 15:
		case 17:
		case 19:
		case 23:
		case 25:
		case 27:
		case 29:
		case 31:
		case 33:
		case 34:
		case 35:
		case 36:
		case 38:		
			$('#4phenology-index-'+phenologyIndex).addClass('scroll-content-item-current');
			break;			
		case 2:
			$('#4phenology-index-1').addClass('scroll-content-item-current');
			$('#4phenology-index-3').addClass('scroll-content-item-current');
			break;
		case 4:
			$('#4phenology-index-3').addClass('scroll-content-item-current');
			$('#4phenology-index-5').addClass('scroll-content-item-current');
			break;
		case 6:
			$('#4phenology-index-5').addClass('scroll-content-item-current');
			$('#4phenology-index-7').addClass('scroll-content-item-current');
			break;
		case 8:
			$('#4phenology-index-7').addClass('scroll-content-item-current');
			$('#4phenology-index-9').addClass('scroll-content-item-current');
			break;
		case 10:
		case 11:
			$('#4phenology-index-9').addClass('scroll-content-item-current');
			$('#4phenology-index-12').addClass('scroll-content-item-current');
			break;
		case 13:
		case 14:
			$('#4phenology-index-12').addClass('scroll-content-item-current');
			$('#4phenology-index-15').addClass('scroll-content-item-current');
			break;
		case 16:
			$('#4phenology-index-15').addClass('scroll-content-item-current');
			$('#4phenology-index-17').addClass('scroll-content-item-current');
			break;
		case 18:
			$('#4phenology-index-17').addClass('scroll-content-item-current');
			$('#4phenology-index-19').addClass('scroll-content-item-current');
			break;
		case 20:
		case 21:
		case 22:
			$('#4phenology-index-19').addClass('scroll-content-item-current');
			$('#4phenology-index-23').addClass('scroll-content-item-current');
			break;
		case 24:
			$('#4phenology-index-23').addClass('scroll-content-item-current');
			$('#4phenology-index-25').addClass('scroll-content-item-current');
			break;
		case 26:
			$('#4phenology-index-25').addClass('scroll-content-item-current');
			$('#4phenology-index-27').addClass('scroll-content-item-current');
			break;
		case 28:
			$('#4phenology-index-27').addClass('scroll-content-item-current');
			$('#4phenology-index-29').addClass('scroll-content-item-current');
			break;
		case 30:
			$('#4phenology-index-29').addClass('scroll-content-item-current');
			$('#4phenology-index-31').addClass('scroll-content-item-current');
			break;
		case 32:
			$('#4phenology-index-31').addClass('scroll-content-item-current');
			$('#4phenology-index-33').addClass('scroll-content-item-current');
			break;
		case 37:
			$('#4phenology-index-36').addClass('scroll-content-item-current');
			$('#4phenology-index-38').addClass('scroll-content-item-current');
			break;
		case 39:
		case 40:
		case 41:
		case 42:
		case 43:
		case 44:
		case 45:
		case 46:
		case 47:
			$('#4phenology-index-38').addClass('scroll-content-item-current');
			break;
	}
}

function moveScrollSauvignonB(grados){
	phenology = modelSauvignonB(grados);
	
	if(phenology > 47 || (ACTUALMONTH > 4 && ACTUALMONTH < 9))
		phenology = 1;
	
	highlightPhenologySauvignonB(phenology);
	scrollPercentPhenology = phenology * 100 / maxPhenologyIndex;
	
	if(scrollPercentPhenology > 100)
		scrollPercentPhenology = 100;
	
	if(scrollPercentPhenology < 0)
		scrollPercentPhenology = 0;
		
	if(phenology <= 5 || phenology > 47)
		scrollPercentPhenology = 0;
	else if(phenology > 35)
		scrollPercentPhenology = 100;
	
	scrollbar5.slider("value",scrollPercentPhenology);
	if ( scrollContent5.width() > scrollPane5.width() ) {
		scrollContent5.css( "margin-left", Math.round(
			scrollbar5.slider("value") / 100 * ( scrollPane5.width() - scrollContent5.width() )
		) + "px" );
	} else {
		scrollContent5.css( "margin-left", 0 );
	}
	
}

function highlightPhenologySauvignonB(phenologyIndex){
	$('#scroll-content5 div.scroll-content-item').removeClass('scroll-content-item-current');
	switch(phenologyIndex){
		case 0:
			break;		
		case 1:
		case 3:
		case 5:
		case 7:
		case 9:
		case 12:
		case 15:
		case 17:
		case 19:
		case 23:
		case 25:
		case 27:
		case 29:
		case 31:
		case 33:
		case 34:
		case 35:
		case 36:
		case 38:		
			$('#5phenology-index-'+phenologyIndex).addClass('scroll-content-item-current');
			break;			
		case 2:
			$('#5phenology-index-1').addClass('scroll-content-item-current');
			$('#5phenology-index-3').addClass('scroll-content-item-current');
			break;
		case 4:
			$('#5phenology-index-3').addClass('scroll-content-item-current');
			$('#5phenology-index-5').addClass('scroll-content-item-current');
			break;
		case 6:
			$('#5phenology-index-5').addClass('scroll-content-item-current');
			$('#5phenology-index-7').addClass('scroll-content-item-current');
			break;
		case 8:
			$('#5phenology-index-7').addClass('scroll-content-item-current');
			$('#5phenology-index-9').addClass('scroll-content-item-current');
			break;
		case 10:
		case 11:
			$('#5phenology-index-9').addClass('scroll-content-item-current');
			$('#5phenology-index-12').addClass('scroll-content-item-current');
			break;
		case 13:
		case 14:
			$('#5phenology-index-12').addClass('scroll-content-item-current');
			$('#5phenology-index-15').addClass('scroll-content-item-current');
			break;
		case 16:
			$('#5phenology-index-15').addClass('scroll-content-item-current');
			$('#5phenology-index-17').addClass('scroll-content-item-current');
			break;
		case 18:
			$('#5phenology-index-17').addClass('scroll-content-item-current');
			$('#5phenology-index-19').addClass('scroll-content-item-current');
			break;
		case 20:
		case 21:
		case 22:
			$('#5phenology-index-19').addClass('scroll-content-item-current');
			$('#5phenology-index-23').addClass('scroll-content-item-current');
			break;
		case 24:
			$('#5phenology-index-23').addClass('scroll-content-item-current');
			$('#5phenology-index-25').addClass('scroll-content-item-current');
			break;
		case 26:
			$('#5phenology-index-25').addClass('scroll-content-item-current');
			$('#5phenology-index-27').addClass('scroll-content-item-current');
			break;
		case 28:
			$('#5phenology-index-27').addClass('scroll-content-item-current');
			$('#5phenology-index-29').addClass('scroll-content-item-current');
			break;
		case 30:
			$('#5phenology-index-29').addClass('scroll-content-item-current');
			$('#5phenology-index-31').addClass('scroll-content-item-current');
			break;
		case 32:
			$('#5phenology-index-31').addClass('scroll-content-item-current');
			$('#5phenology-index-33').addClass('scroll-content-item-current');
			break;
		case 37:
			$('#5phenology-index-36').addClass('scroll-content-item-current');
			$('#5phenology-index-38').addClass('scroll-content-item-current');
			break;
		case 39:
		case 40:
		case 41:
		case 42:
		case 43:
		case 44:
		case 45:
		case 46:
		case 47:
			$('#5phenology-index-38').addClass('scroll-content-item-current');
			break;
	}
}