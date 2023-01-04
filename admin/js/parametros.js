function delParam(id){
	var sid = $('#sid').val();
	
	if(confirm('Está seguro de querer eliminar el parametro?')){
	
		var url = 'parametros.acciones.php?sid='+sid+'&accion=del&id='+id;
	
		$.get(url,'',function(data){
			if(data == 1){
				$('#paramrow_'+id+' td').toggleClass('red').fadeTo("slow", 0.001, function(){
					$(this).hide();
				});
				success('El par&aacute;metro fue borrado con &eacute;xito.');
			}
			else{
				error('Error al borrar el par&aacute;metro: '+data);
			}
		});
		setTimeout(eraseMensaje,5000);
	}
}

function eraseMensaje(){
	$('#mensaje').empty();
}

function addParam(){
	var sid = $('#sid').val();
	
	var nombre_parametro = $('#nombre_parametro').val();
	var codigo_parametro = $('#codigo_parametro').val();
	var descripcion_parametro = $('#descripcion_parametro').val();
	var valor_parametro = $('#valor_parametro').val();
	
	if(nombre_parametro == ''){
		alert('Debe ingresar un nombre de parámetro');
		$('#nombre_parametro').focus();
		return;
	}
	if(codigo_parametro == ''){
		alert('Debe ingresar un código de parámetro');
		$('#codigo_parametro').focus();
		return;
	}
	if(descripcion_parametro == ''){
		alert('Debe ingresar una descripcion del parámetro');
		$('#descripcion_parametro').focus();
		return;
	}
	if(valor_parametro == ''){
		alert('Debe ingresar un valor para el parámetro');
		$('#valor_parametro').focus();
		return;
	}
	
	var url = 'parametros.acciones.php?sid='+sid+'&accion=add&nombre='+nombre_parametro+'&codigo='+codigo_parametro+'&descripcion='+descripcion_parametro+'&valor='+valor_parametro;
	
	$.get(url,'',function(data){
		if(data == 1){
			$('.contactform').fadeOut('fast');
			success('El par&aacute;metro fue ingresado con &eacute;xito.');
		}
		else{
			error('Error al ingresar el par&aacute;metro: '+data);
		}
	});
}

function editParam(id){
	var sid = $('#sid').val();
	
	var url = 'parametros.php?sid='+sid+'&page=edit&paramid='+id;
	
	window.location.href = url;	
}

function updateParam(){
	var sid = $('#sid').val();
	
	var pid = $('#pid').val();
	var nombre_parametro = $('#nombre_parametro').val();
	var codigo_parametro = $('#codigo_parametro').val();
	var descripcion_parametro = $('#descripcion_parametro').val();
	var valor_parametro = $('#valor_parametro').val();
	
	if(nombre_parametro == ''){
		alert('Debe ingresar un nombre de parámetro');
		$('#nombre_parametro').focus();
	}
	if(codigo_parametro == ''){
		alert('Debe ingresar un código de parámetro');
		$('#codigo_parametro').focus();
	}
	if(descripcion_parametro == ''){
		alert('Debe ingresar una descripcion del parámetro');
		$('#descripcion_parametro').focus();
	}
	if(valor_parametro == ''){
		alert('Debe ingresar un valor para el parámetro');
		$('#valor_parametro').focus();
	}
	
	var url = 'parametros.acciones.php?sid='+sid+'&accion=update&pid='+pid+'&nombre='+nombre_parametro+'&codigo='+codigo_parametro+'&descripcion='+descripcion_parametro+'&valor='+valor_parametro;
	
	$.get(url,'',function(data){
		if(data == 1){
			$('.contactform').fadeOut('fast');
			success('El par&aacute;metro fue actualizado con &eacute;xito.');
		}
		else{
			error('Error al actualizar el par&aacute;metro: '+data);
		}
	});
}