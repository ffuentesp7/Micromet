function send_request(){
	var rut = $('#rut_pass').val();
	var cap = $('#codigo_pass').val();
		
	if(rut == ''){
		alert('Debe ingresar el rut.');
		return;
	}	
	if(cap == ''){
		alert('Debe ingresar el codigo captcha de la imagen.');
		return;
	}
	
	var url = 'olvido_contrasena_accion.php?ac=nw&rut_pass='+rut+'&captcha='+cap;
	
	$.get(url,'',function(data){
		$('#loginform').html('<p>'+data+'</p>');
	});
}