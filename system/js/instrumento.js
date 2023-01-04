function getStationSelect(){
	var sid = $('#sid').val();
	var tiid = $('#tiid').val();
	
	var url = 'instrumento.acciones.php?sid='+sid+'&accion=getstationsselect&tiid='+tiid;
	
	$.get(url,'',function(data){
		if(data != 0){
			swapText('select_estacion_field',data);
		}
		else{
			error("Error al cargar las estaciones: "+data );
		}
	});
}

function getData(){
	$('#graph_loading').show();
	horas = [];
		
	swapText('cuerpo_datos','<img class="centernoborder" src="../img/loaders/loader-01.gif" />');

	var sid 	= $('#sid').val();
	var eid 	= $('#select_estacion option:selected').val();
	stationID       = eid;
	stationName 	= $('#select_estacion option:selected').html();
	var tiid 	= $('#tiid').val();
	
	var url = 'instrumento.acciones.php?sid='+sid+'&accion=getdata&tiid='+tiid+'&eid='+eid;
	
	$.get(url,'',function(data){
		if(data != 0){
			swapText('cuerpo_datos',data);
		}
		else{
			error("Error al cargar los datos: "+data );
		}
	});
	
	var url = 'instrumento.acciones.php?sid='+sid+'&accion=getdata_graph&tiid='+tiid+'&eid='+eid;
	var hours;
	var dates;
	var numbers;
	$.getJSON(url,'',function(data){
		graphData = data;
		
		if(CDA == 1){
			copy_array(datos,graphData, 2);
			copy_unit(graphData,3);
			copy_labels_array(horas,graphData, 1, graphData, 0);
			copy_labels_array2(horasTodas,graphData, 1, graphData, 0);
			
			if(code == 'RAIN'){
				start_bar_graph();
			}
			else if(code == 'WINDDIR'){
				start_rose_graph();
			}else{
				start_line_graph();
			}
		}
		else{
			if(code == 'RAIN'){
				copy_array_day(datos,graphData);
				datos = [];
				copy_array(datos,graphData, 1);
				copy_unit_day(graphData);
				copy_labels_array3(horas,graphData, 0);
				copy_labels_array4(horasTodas,graphData, 0);
				start_bar_graph();
			}
			else if(code == 'WINDDIR'){
				copy_array(datos,graphData, 1);
				copy_unit(graphData,2);
				copy_labels_array(horas,graphData, 1, graphData, 0);
				copy_labels_array2(horasTodas,graphData, 1, graphData, 0);
				start_rose_graph();
			}else{
				copy_array_day(datos,graphData);
				copy_unit_day(graphData);
				copy_labels_array3(horas,graphData, 0);
				copy_labels_array4(horasTodas,graphData, 0);
				start_poliline_graph();
			}
			
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

function copy_array_day(arr1, arr2){
	
	var line = [];
	
	b = (arr2[0].length - 1 ) / 2;
	howmany = b;
		
	for(var i = 1 ; i < (b + 1); i++){
		for(j = 0; j < arr2.length; j++){
			line.push(arr2[j][i]);
			datosLabel.push(arr2[j][i]);
			if(arr2[j][i] < 0)
				negative = true;
		}
			
		arr1[i - 1] = RGraph.array_clone(line);
		line = [];
	}
	return arr1;
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
	line1.Set('chart.units.post', insUnit);
	line1.Set('chart.colors', ['#F27F00']);
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
	line1.Set('chart.labels',horas);
	line1.Set('chart.text.size',8);
	line1.Set('chart.title',stationName+' - '+insName);
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

function start_poliline_graph(){
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
	line1.Set('chart.units.post', insUnit);
	
	if(howmany == 2)
		line1.Set('chart.colors', ['#F27F00', '#B3CAEF']);
	if(howmany == 3)
		line1.Set('chart.colors', ['#F27F00', '#B3CAEF','#C8C8C8']);
	if(howmany == 4)
		line1.Set('chart.colors', ['#F27F00', '#B3CAEF','#C8C8C8','#68C623']);

	line1.Set('chart.background.grid.autofit', true);
	line1.Set('chart.background.grid.autofit.numhlines', 10);
	line1.Set('chart.curvy', false);

	if(negative) line1.Set('chart.xaxispos', 'center');

	line1.Set('chart.text.angle', 45);
	line1.Set('chart.curvy.factor', 0.5); // This is the default
	line1.Set('chart.animation.unfold.initial',0);
	line1.Set('chart.labels',horas);
	line1.Set('chart.tickmarks', 'circle');
	line1.Set('chart.text.size',8);
	line1.Set('chart.title',stationName+' - '+insName);
	line1.Set('chart.tooltips.effect', 'fade');
	line1.Set('chart.tooltips', tooltipsFuncWithoutHours);

	

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
	bar.Set('chart.units.post', insUnit);
	bar.Set('chart.colors', ['blue']);
	bar.Set('chart.background.grid.autofit', true);
	bar.Set('chart.background.grid.autofit.numhlines', 10);
	bar.Set('chart.curvy', false);
	bar.Set('chart.text.angle', 45);
	bar.Set('chart.curvy.factor', 0.5); // This is the default
	bar.Set('chart.animation.unfold.initial',0);
	bar.Set('chart.labels',horas);
	bar.Set('chart.text.size',8);
	bar.Set('chart.title',stationName+' - '+insName);
	bar.Set('chart.tooltips', tooltipsFuncWithoutHours);
	
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
	rose.Set('chart.title',stationName+' - '+insName);
	
	if (RGraph.isOld()) {
		rose.Draw();
	} else {
		RGraph.Effects.Fade.In(rose);
		RGraph.Effects.jQuery.Reveal(rose);
	}
}