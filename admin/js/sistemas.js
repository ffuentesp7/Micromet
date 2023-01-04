function delSys(id){
	var sid = $('#sid').val();
	
	if(confirm('Est� seguro de querer eliminar el sistema?')){
	
		var url = 'sistemas.acciones.php?sid='+sid+'&accion=del&id='+id;
	
		$.get(url,'',function(data){
			if(data == 1){
				$('#sysrow_'+id+' td').toggleClass('red').fadeTo("slow", 0.001, function(){
					$(this).hide();
				});
				success('El sistema fue borrado con &eacute;xito.');
			}
			else{
				error('Error al borrar el sistema: '+data);
			}
		});
		setTimeout(eraseMensaje,5000);
	}
}

function eraseMensaje(){
	$('#mensaje').empty();
}

function addSys(){
	var sid = $('#sid').val();
	
	var nombre_sistema = $('#nombre_sistema').val();
	var pag_sistema = $('#pagina_sistema').val();
	
	if(nombre_sistema == ''){
		alert('Debe ingresar un nombre de sistema');
		$('#nombre_sistema').focus();
		return;
	}
	if(pag_sistema == ''){
		alert('Debe ingresar una pagina de sistema');
		$('#pagina_sistema').focus();
		return;
	}
	
	var url = 'sistemas.acciones.php?sid='+sid+'&accion=add&nombre='+nombre_sistema+'&pag_sys='+pag_sistema;
	
	$.get(url,'',function(data){
		if(data == 1){
			$('.contactform').fadeOut('fast');
			success('El sistema fue ingresado con &eacute;xito.');
		}
		else{
			error('Error al ingresar el sistema: '+data);
		}
	});
}

function editSys(id){
	var sid = $('#sid').val();
	
	var url = 'sistemas.php?sid='+sid+'&page=edit&sysid='+id;
	
	window.location.href = url;	
}

function updateSys(){
	var sid = $('#sid').val();
	
	var sysid = $('#sysid').val();
	var nombre_sistema = $('#nombre_sistema').val();
	var pag_sistema = $('#pagina_sistema').val();
	
	if(nombre_sistema == ''){
		alert('Debe ingresar un nombre de sistema');
		$('#nombre_sistema').focus();
		return;
	}
	if(pag_sistema == ''){
		alert('Debe ingresar una pagina de sistema');
		$('#pagina_sistema').focus();
		return;
	}
	
	var url = 'sistemas.acciones.php?sid='+sid+'&accion=update&sysid='+sysid+'&nombre='+nombre_sistema+'&pag_sys='+pag_sistema;
	
	$.get(url,'',function(data){
		if(data == 1){
			$('.contactform').fadeOut('fast');
			success('El sistema fue actualizado con &eacute;xito.');
		}
		else{
			error('Error al actualizar el sistema: '+data);
		}
	});
}