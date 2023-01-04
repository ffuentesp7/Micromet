function delEntry(id){
	var sid = $('#sid').val();
	
	if(confirm('Está seguro de querer eliminar esta entrada?')){
	
		var url = 'blog.acciones.php?sid='+sid+'&accion=del&id='+id;
	
		$.get(url,'',function(data){
			if(data == 1){
				$('#sysrow_'+id+' td').toggleClass('red').fadeTo("slow", 0.001, function(){
					$(this).hide();
				});
				success('La entrada fue borrada con &eacute;xito.');
			}
			else{
				error('Error al borrar la entrada: '+data);
			}
		});
		setTimeout(eraseMensaje,5000);
	}
}

function eraseMensaje(){
	$('#mensaje').empty();
}

function addEntry(){
	var sid = $('#sid').val();
	
	var titulo 	= $('#titulo').val();
	var contenido 	= $('#contenido').val().replace(/\n/g,"<br/>");
	var sistema	= $('#sistema option:selected').val();
	var fecha	= $('#fecha').val();
	var hora	= $('#hora').val();
	
	if(titulo == ''){
		alert("Debe asignar un titulo a la entrada");
		return;
	}
	if(contenido == ''){
		alert("Debe asignar un contenido a la entrada");
		return;
	}
	
	var url = 'blog.acciones.php?sid='+sid+'&accion=add&titulo='+titulo+'&contenido='+contenido+'&sistema='+sistema+'&fecha='+fecha+'&hora='+hora;
	
	$.get(url,'',function(data){
		if(data == 1){
			$('.contactform').fadeOut('fast');
			success('La entrada fue ingresada con &eacute;xito.');
		}
		else{
			error('Error al ingresar la entrada: '+data);
		}
	});
}

function editEntry(id){
	var sid = $('#sid').val();
	
	var url = 'blog.php?sid='+sid+'&page=edit&enid='+id;
	
	window.location.href = url;	
}

function updateEntry(){
	var sid = $('#sid').val();
	
	var titulo 	= $('#titulo').val();
	var contenido 	= $('#contenido').val().replace(/\n/g,"<br/>");
	var sistema	= $('#sistema option:selected').val();
	var fecha	= $('#fecha').val();
	var hora	= $('#hora').val();
	var enid	= $('#enid').val();
	var usid	= $('#usid').val();
	
	if(titulo == ''){
		alert("Debe asignar un titulo a la entrada");
		return;
	}
	if(contenido == ''){
		alert("Debe asignar un contenido a la entrada");
		return;
	}
	
	var url = 'blog.acciones.php?sid='+sid+'&accion=update&titulo='+titulo+'&contenido='+contenido+'&sistema='+sistema+'&fecha='+fecha+'&hora='+hora+'&usid='+usid+'&enid='+enid;
	
	$.get(url,'',function(data){
		if(data == 1){
			$('.contactform').fadeOut('fast');
			success('La entrada fue actualizada con &eacute;xito.');
		}
		else{
			error('Error al actualizar la entrada: '+data);
		}
	});
}