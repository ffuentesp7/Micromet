function addArea(){
	var sid = $('#sid').val();
	
	var nombre_area = $('#nombre_area').val();
	var descripcion_area = $('#descripcion_area').val();
	
	if(nombre_area == ''){
		alert('Debe ingresar un nombre de �rea');
		$('#nombre_area').focus();
		return;
	}
	if(descripcion_area == ''){
		alert('Debe ingresar una descripcion del �rea');
		$('#descripcion_area').focus();
		return;
	}
	
	var url = 'areas.acciones.php?sid='+sid+'&accion=add&nombre='+nombre_area+'&descripcion='+descripcion_area;
	
	$.get(url,'',function(data){
		if(data == 1){
			$('.contactform').fadeOut('fast');
			success('El &aacute;rea fue ingresada con &eacute;xito.');
		}
		else{
			error('Error al ingresar el &aacute;rea: '+data);
		}
	});
}

function updateArea(){
	var sid = $('#sid').val();
	var aid = $('#aid').val();
	
	var nombre_area = $('#nombre_area').val();
	var descripcion_area = $('#descripcion_area').val();
	
	if(nombre_area == ''){
		alert('Debe ingresar un nombre de �rea');
		$('#nombre_area').focus();
		return;
	}
	if(descripcion_area == ''){
		alert('Debe ingresar una descripcion del �rea');
		$('#descripcion_area').focus();
		return;
	}
	
	var url = 'areas.acciones.php?sid='+sid+'&accion=update&nombre='+nombre_area+'&descripcion='+descripcion_area+'&aid='+aid;
	
	$.get(url,'',function(data){
		if(data == 1){
			success('El &aacute;rea fue actualizada con &eacute;xito.');
		}
		else{
			error('Error al actualizar el &aacute;rea: '+data);
		}
	});
}

function openAllAreas(){
	var sid = $('#sid').val();
	
	var url = 'areas.acciones.php?sid='+sid+'&accion=openall';
	
	$.get(url,'',function(data){
		if(data != 0){
			swapText('contenido',data);
		}
		else{
			error('Error al seleccionar las &aacute;reas: '+data);
		}
	});
}

function editArea(aid){
	var sid = $('#sid').val();
	
	var url = 'areas.php?sid='+sid+'&page=openone&aid='+aid;
	
	window.location.href = url;
}

function getSelectStation(){
	var sid = $('#sid').val();
	var aid = $('#aid').val();
	
	var url = 'areas.acciones.php?sid='+sid+'&accion=stationselect&aid='+aid;
	
	$.get(url,'',function(data){
		if(data != 0){
			swapText('span_estacion',data);
		}
		else{
			error('Error al cargar las estaciones: '+data);
		}
	});
}

function getAssociatedStation(){
	var sid = $('#sid').val();
	var aid = $('#aid').val();
	
	var url = 'areas.acciones.php?sid='+sid+'&accion=associatedstations&aid='+aid;
	
	$.get(url,'',function(data){
		if(data != 0){
			swapText('contenido',data);
		}
		else{
			error('Error al cargar las estaciones asociadas: '+data);
		}
	});
}

function linkStation(){
	var sid = $('#sid').val();
	var aid = $('#aid').val();
	var eid = $('#select_estaciones option:selected').val();
	
	var url = 'areas.acciones.php?sid='+sid+'&accion=linkstation&aid='+aid+'&eid='+eid;
	
	$.get(url,'',function(data){
		swapText('contenido','<img src="../img/loaders/loader-01.gif" class="centernoborder" />');
		swapText('span_estacion','<img src="../img/loaders/loader-01.gif" class="centernoborder" />');
		if(data == 1){
			success('La estaci&oacute;n fue asociada correctamente');
			getAssociatedStation();
			getSelectStation();
		}
		else{
			error('Error asociar la estacion: '+data);
		}
	});
}

function deleteAssociatedStation(eid){
	var sid = $('#sid').val();
	var aid = $('#aid').val();
	
	var url = 'areas.acciones.php?sid='+sid+'&accion=dellinkstation&aid='+aid+'&eid='+eid;
	
	$.get(url,'',function(data){
		swapText('contenido','<img src="../img/loaders/loader-01.gif" class="centernoborder" />');
		swapText('span_estacion','<img src="../img/loaders/loader-01.gif" class="centernoborder" />');
		if(data == 1){
			success('La estaci&oacute;n fue desasociada correctamente');
			getAssociatedStation();
			getSelectStation();
		}
		else{
			error('Error desasociar la estacion: '+data);
		}
	});
}

function deleteArea(aid){
	var sid = $('#sid').val();
	
	var url = 'areas.acciones.php?sid='+sid+'&accion=deletearea&aid='+aid;
	
	if(confirm('Seguro que quiere eliminar el �rea')){
	
		$.get(url,'',function(data){
			swapText('contenido','<img src="../img/loaders/loader-01.gif" class="centernoborder" />');
			if(data == 1){
				success('El &aacute;rea fue eliminada correctamente');
				openAllAreas();
			}
			else{
				error('Error al eliminar el area: '+data);
			}
		});
	}
}