function addUser(){
	var sid = $('#sid').val();
	
	var nombre_usuario = $('#nombre_usuario').val();
	var rut_usuario = $('#rut_usuario').val();
	var email_usuario = $('#email_usuario').val();
	var tel_movil_usuario = $('#tel_movil_usuario').val();
	var clave_usuario = $('#clave_usuario').val();
	
	var aviso_sensor_usuario = $('#aviso_sensor_usuario option:selected').val();
	var administrador_usuario = $('#administrador_usuario option:selected').val();
	var sistema_usuario = $('#sistema_usuario option:selected').val();
	
	var enviar_email = $('#enviar_email_usuario:checked').length;
	
	if(nombre_usuario == ''){
		alert('Debe ingresar el nombre');
		$('#nombre_usuario').focus();
		return;
	}
	if(rut_usuario == '' || !validaRut(rut_usuario,'rut_usuario')){
		alert('Debe ingresar el RUT');
		$('#rut_usuario').focus();
		return;
	}
	if(email_usuario == '' || !validaEmail(email_usuario)){
		alert('Debe ingresar un email v�lido');
		$('#email_usuario').focus();
		return;
	}
	// if(tel_movil_usuario.length != 0 && tel_movil_usuario.length != 8){
	// 	alert('Debe ingresar un n�mero de telefono m�vil v�lido (8 d�gitos)');
	// 	$('#tel_movil_usuario').focus();
	// 	return;
	// }
	
	if(clave_usuario == ''){
		alert('Debe ingresar la clave');
		$('#clave_usuario').focus();
		return;
	}
		
	var url = 'usuarios.acciones.php?sid='+sid+'&accion=add&nombre='+nombre_usuario+'&rut='+rut_usuario+'&email='+email_usuario+'&movil='+tel_movil_usuario+'&clave='+clave_usuario+'&enviarporemail='+enviar_email+'&avisosensor='+aviso_sensor_usuario+'&adm='+administrador_usuario+'&sys='+sistema_usuario;
	
	$.get(url,'',function(data){
		if(data == 1){
			$('.contactform').fadeOut('fast');
			success('El usuario fue ingresado con &eacute;xito.');
		}
		else{
			error('Error al ingresar el usuario: '+data);
		}
	});
}

function delUser(id){
	var sid = $('#sid').val();
	
	if(confirm('Est� seguro de querer eliminar el usuario?')){
	
		var url = 'usuarios.acciones.php?sid='+sid+'&accion=del&id='+id;
	
		$.get(url,'',function(data){
			if(data == 1){
				$('#userrow_'+id+' td').toggleClass('red').fadeTo("slow", 0.001, function(){
					$(this).hide();
				});
				success('El usuario fue borrado con &eacute;xito.');
			}
			else{
				error('Error al borrar el usuario: '+data);
			}
		});
		
	}	
}

function editUser(id){
	var sid = $('#sid').val();
	
	var url = 'usuarios.php?sid='+sid+'&page=edit&userid='+id;
	
	window.location.href = url;	
}

function eraseMensaje(){
	$('#mensaje').empty();
}

function updateUser(){
	var sid = $('#sid').val();
	var userid = $('#userid').val();
	
	var nombre_usuario = $('#nombre_usuario').val();
	var rut_usuario = $('#rut_usuario').val();
	var email_usuario = $('#email_usuario').val();
	var tel_movil_usuario = $('#tel_movil_usuario').val();
	
	var aviso_sensor_usuario = $('#aviso_sensor_usuario option:selected').val();
	var administrador_usuario = $('#administrador_usuario option:selected').val();
	var sistema_usuario = $('#sistema_usuario option:selected').val();
	
	var enviar_email = $('#enviar_email_usuario:checked').length;
	
	if(nombre_usuario == ''){
		alert('Debe ingresar el nombre');
		$('#nombre_usuario').focus();
		return;
	}
	if(rut_usuario == '' || !validaRut(rut_usuario,'rut_usuario')){
		alert('Debe ingresar el RUT');
		$('#rut_usuario').focus();
		return;
	}
	if(email_usuario == '' || !validaEmail(email_usuario)){
		alert('Debe ingresar un email v�lido');
		$('#email_usuario').focus();
		return;
	}
	if(tel_movil_usuario.length != 0 && tel_movil_usuario.length != 12){
		alert('Debe ingresar un n�mero de telefono m�vil v�lido (11 d�gitos con signo +) ej. +56976598342');
		$('#tel_movil_usuario').focus();
		return;
	}
		
	var url = 'usuarios.acciones.php?sid='+sid+'&accion=update&userid='+userid+'&nombre='+nombre_usuario+'&rut='+rut_usuario+'&email='+email_usuario+'&movil='+tel_movil_usuario+'&enviarporemail='+enviar_email+'&avisosensor='+aviso_sensor_usuario+'&adm='+administrador_usuario+'&sys='+sistema_usuario;
	
	$.get(url,'',function(data){
		if(data == 1){
			$('.contactform').fadeOut('fast');
			success('El usuario fue actualizado con &eacute;xito.');
		}
		else{
			error('Error al actualizar el usuario: '+data);
		}
	});
}

function updatePassUser(){
	var sid = $('#sid').val();
	var userid = $('#userid').val();

	var clave_usuario = $('#clave_usuario').val();

	if(clave_usuario == ''){
		alert('Debe ingresar la clave');
		$('#clave_usuario').focus();
		return;
	}
		
	var url = 'usuarios.acciones.php?sid='+sid+'&accion=updatepass&userid='+userid+'&clave='+clave_usuario;
	
	$.get(url,'',function(data){
		if(data == 1){
			$('.contactform').fadeOut('fast');
			success('La clave del usuario fue actualizada con &eacute;xito.');
		}
		else{
			error('Error al actualizar la clave del usuario: '+data);
		}
	});
}