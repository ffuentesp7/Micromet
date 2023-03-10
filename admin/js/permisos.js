function setPermissionLabelsFromStation(stationName,stationId){
	var upperStationName = stationName.toUpperCase();
	finalStationName = upperStationName.replace("(","").replace(")","");
	finalStationName = realReplace(finalStationName,' ','_');
	var finalPermissionCode = "STATION_ACCESS_"+finalStationName;
	$('#codigo_tipo_permiso').val(finalPermissionCode);
	var finalPermissionName = "Acceso a Estacion "+stationName;
	$('#nombre_tipo_permiso').val(finalPermissionName);
	$('#valor_tipo_permiso').val(stationId);
	tb_remove();
}

function realReplace(string,searchString,replaceString){
	do {
		string = string.replace(searchString,replaceString);
	} while(string.indexOf(searchString) >= 0);
	return string;
}

function addUserTypePermission(){
	var sid = $('#sid').val();
	
	var nombre = $('#nombre_tipo_permiso').val();
	var codigo = $('#codigo_tipo_permiso').val();
	var valor  = $('#valor_tipo_permiso').val();
	
	if(nombre == ''){
		alert('Debe ingresar un nombre');
		$('#nombre_tipo_permiso').focus();	
		return;
	}
	if(codigo == ''){
		alert('Debe ingresar un codigo');
		$('#codigo_tipo_permiso').focus();	
		return;
	}
	if(valor == ''){
		alert('Debe ingresar un valor');
		$('#valor_tipo_permiso').focus();	
		return;
	}
	
	var url = 'permisos.acciones.php?sid='+sid+'&accion=addusertype&nombre='+nombre+'&codigo='+codigo+'&valor='+valor+'';
	
	$.get(url,'',function(data){
		if(data == 1){
			$('.contactform').fadeOut('fast');
			success('El permiso fue ingresado con &eacute;xito.');
		}
		else{
			error('Error al ingresar el permiso: '+data);
		}
	
	});
}

function addStationTypePermission(){
	var sid = $('#sid').val();
	
	var nombre = $('#nombre_tipo_permiso').val();
	var codigo = $('#codigo_tipo_permiso').val();
	var valor  = $('#valor_tipo_permiso').val();
	
	if(nombre == ''){
		alert('Debe ingresar un nombre');
		$('#nombre_tipo_permiso').focus();	
		return;
	}
	if(codigo == ''){
		alert('Debe ingresar un codigo');
		$('#codigo_tipo_permiso').focus();	
		return;
	}
	if(valor == ''){
		alert('Debe ingresar un valor');
		$('#valor_tipo_permiso').focus();	
		return;
	}
	
	var url = 'permisos.acciones.php?sid='+sid+'&accion=addstationtype&nombre='+nombre+'&codigo='+codigo+'&valor='+valor+'';
	
	$.get(url,'',function(data){
		if(data == 1){
			$('.contactform').fadeOut('fast');
			success('El permiso fue ingresado con &eacute;xito.');
		}
		else{
			error('Error al ingresar el permiso: '+data);
		}
	
	});
}

function seePermissions(){
	var sid = $('#sid').val();
	
	var tipo = $('#tipo_de_permiso option:selected').val();
	
	var url = 'permisos.acciones.php?sid='+sid+'&accion=see&tipo='+tipo;
	
	$.get(url,'',function(data){
		$('#contenido').html('<img class="centernoborder" src="../img/loaders/loader-01.gif" />');
		if(data != 0){
			$('#contenido').html(data);
			$('#tabla_see').DataTable();
		}
		else{
			$('#contenido').html('<blockquote class="warning"><p>Error al cargar los permisos</p></blockquote>');
		}
	});	
}

function editPermission(id,tipo){
	var sid = $('#sid').val();
	var url = 'permisos.php?sid='+sid+'&page=edit&tipo='+tipo+'&id='+id;
	
	window.location.href = url;
}

function updateTypePermission(id,tipo){
	var sid = $('#sid').val();
	
	var nombre = $('#nombre_tipo_permiso').val();
	var codigo = $('#codigo_tipo_permiso').val();
	var valor  = $('#valor_tipo_permiso').val();
	
	if(nombre == ''){
		alert('Debe ingresar un nombre');
		$('#nombre_tipo_permiso').focus();	
		return;
	}
	if(codigo == ''){
		alert('Debe ingresar un codigo');
		$('#codigo_tipo_permiso').focus();	
		return;
	}
	if(valor == ''){
		alert('Debe ingresar un valor');
		$('#valor_tipo_permiso').focus();	
		return;
	}
	
	var url = 'permisos.acciones.php?sid='+sid+'&accion=updatetype&tipo='+tipo+'&id='+id+'&nombre='+nombre+'&codigo='+codigo+'&valor='+valor+'';
	
	$.get(url,'',function(data){
		if(data == 1){
			$('.contactform').fadeOut('fast');
			success('El permiso fue actualizado con &eacute;xito.');
		}
		else{
			error('Error al actualizar el permiso: '+data);
		}
	});
}

function deletePermission(id,tipo){
	var sid = $('#sid').val();
	var url = 'permisos.acciones.php?sid='+sid+'&accion=deletetype&tipo='+tipo+'&id='+id;
	
	if(confirm('Seguro que quiere eliminar el permiso?')){
	
		$.get(url,'',function(data){
			if(data == 1){
				$('#permisionrow_'+id+' td').toggleClass('red').fadeTo("slow", 0.001, function(){
					$(this).hide();
				});
				success('El permiso fue borrado con &eacute;xito.');
			}
			else{
				error('Error al borrar el permiso: '+data);
			}
		});
	}
}

function eraseMensaje(){
	$('#mensaje').empty();
}

function setDataUserForAddPermission(nombre,id){
	var sid = $('#sid').val();
	$('#nombre_usuario').val(nombre);
	$('#usuario_id').val(id);
	
	$('#contenido').html('<img class="centernoborder" src="../img/loaders/loader-01.gif" />');
	url = 'permisos.acciones.php?sid='+sid+'&accion=permisosdenieduser&id='+id;
	
	$.get(url,'',function(data){
		$('#permisos').html(data);
		
		url = 'permisos.acciones.php?sid='+sid+'&accion=permitsissued&id='+id;
		
		$.get(url,'',function(data){
			$('#tabla_permisos_otorgados .permitsissuedrow').remove();
			$('#body_tabla_permisos_otorgados').remove();
			$('#tabla_permisos_otorgados').DataTable().destroy();

			$('#tabla_permisos_otorgados').append(data);
			$('#tabla_permisos_otorgados').DataTable();

			$('#contenido').html('');
			tb_remove();
		});
	});
}

function giveUserPermission(){
	var sid = $('#sid').val();
	var userid = $('#usuario_id').val();
	var permissionid = $('#permisos option:selected').val();
	
	url = 'permisos.acciones.php?sid='+sid+'&accion=giveuserpermission&pid='+permissionid+'&uid='+userid;
	$('#contenido').html('<img class="centernoborder" src="../img/loaders/loader-01.gif" />');
	$.get(url,'',function(data){
		$('#tabla_permisos_otorgados').append(data);

		url = 'permisos.acciones.php?sid='+sid+'&accion=permisosdenieduser&id='+userid;
		
		$.get(url,'',function(data){
			$('#permisos').html(data);
			$('#contenido').html('');
			tb_remove();
		});
	});
}

function removeUserPermission(pid,uid){
	var sid = $('#sid').val();
	
	url = 'permisos.acciones.php?sid='+sid+'&accion=removeuserpermission&pid='+pid+'&uid='+uid;
	$('#contenido').html('<img class="centernoborder" src="../img/loaders/loader-01.gif" />');
	$.get(url,'',function(data){
		if(data == 1){
			var pcode = $('#permitsissuedrow_code_'+pid).text();
		
			$('#permitsissuedrow_'+pid+' td').toggleClass('red').fadeTo("slow", 0.001, function(){
				$(this).hide();
			});
	
			$('#permisos').append("<option value='"+pid+"' id='type_option_"+pid+"'>"+pcode+"</option>");
			$('#contenido').html('');
			success('El permiso fue quitado con ???xito.');
		}
		else{
			error('Error al quitar el permiso: '+data);
			setTimeout(eraseMensaje,5000);
		}
	});
}

function setDataStationForAddPermission(nombre,id){
	var sid = $('#sid').val();
	$('#nombre_estacion').val(nombre);
	$('#estacion_id').val(id);
	
	$('#contenido').html('<img class="centernoborder" src="../img/loaders/loader-01.gif" />');
	url = 'permisos.acciones.php?sid='+sid+'&accion=permisosdeniedstation&id='+id;
	
	$.get(url,'',function(data){
		$('#permisos').html(data);
		
		url = 'permisos.acciones.php?sid='+sid+'&accion=permitsissuedstation&id='+id;
		
		$.get(url,'',function(data){
			$('#tabla_permisos_otorgados .permitsissuedrow').remove();
			$('#tabla_permisos_otorgados').append(data);
			$('#contenido').html('');
			tb_remove();
		});
	});
}

function giveStationPermission(){
	var sid = $('#sid').val();
	var userid = $('#estacion_id').val();
	var permissionid = $('#permisos option:selected').val();
	
	url = 'permisos.acciones.php?sid='+sid+'&accion=givestationpermission&pid='+permissionid+'&uid='+userid;
	$('#contenido').html('<img class="centernoborder" src="../img/loaders/loader-01.gif" />');
	$.get(url,'',function(data){
		$('#tabla_permisos_otorgados').append(data);

		url = 'permisos.acciones.php?sid='+sid+'&accion=permisosdeniedstation&id='+userid;
		
		$.get(url,'',function(data){
			$('#permisos').html(data);
			$('#contenido').html('');
			tb_remove();
		});
	});
}

function removeStationPermission(pid,uid){
	var sid = $('#sid').val();
	
	url = 'permisos.acciones.php?sid='+sid+'&accion=removestationpermission&pid='+pid+'&uid='+uid;
	$('#contenido').html('<img class="centernoborder" src="../img/loaders/loader-01.gif" />');
	$.get(url,'',function(data){
		if(data == 1){
			var pcode = $('#permitsissuedrow_code_'+pid).text();
		
			$('#permitsissuedrow_'+pid+' td').toggleClass('red').fadeTo("slow", 0.001, function(){
				$(this).hide();
			});
	
			$('#permisos').append("<option value='"+pid+"' id='type_option_"+pid+"'>"+pcode+"</option>");
			$('#contenido').html('');
			success('El permiso fue quitado con ???xito.');
		}
		else{
			error('Error al quitar el permiso: '+data);
		}
	});
}