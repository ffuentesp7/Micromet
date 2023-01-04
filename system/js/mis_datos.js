function updatePersonalData(){
	var sid = $('#sid').val();
	
	var nombre = $('#nombre_usuario').val();
	var telefono = $('#tel_movil_usuario').val();
	var email = $('#email_usuario').val();
	
	var url = 'mis_datos.acciones.php?sid='+sid+'&accion=data&nombre='+nombre+'&telefono='+telefono+'&email='+email;
	
	$.get(url,'',function(data){
		if(data == 1){
			success("Los datos fueron actualizados correctamente.");
		}
		else{
			error("Error al actualizar los datos: "+data );
		}
	});
}

function updatePersonalPass(){
	var sid = $('#sid').val();
	
	var pass1 = $('#clave_usuario_antigua').val();
	var pass2 = $('#clave_usuario_nueva').val();

	
	var url = 'mis_datos.acciones.php?sid='+sid+'&accion=checkpass&oldpass='+pass1;
	
	if(pass1 == ''){
		error('Debe escribir su clave actual');
		return;
	}
	
	if(pass2 == ''){
		error('Debe escribir una nueva clave');
		return;
	}
	
	$.get(url,'',function(data){
		if(data == 1){
			var url2 = 'mis_datos.acciones.php?sid='+sid+'&accion=pass&newpass='+pass2;
			$.get(url2,'',function(data){
				if(data == 1){
					success("La clave fue actualizada correctamente.");
				}
				else{
					error("Error al actualizar la clave: "+data );
				}
			});
		}
		else{
			error("Error al actualizar la clave: "+data );
		}
	});

}