var forecast_url = 'http://goo.gl/rUiGM';
var tweet_use = false;

function reloadPage(){
	var sid = $('#sid').val();
	var accion = "window.location.href = 'mod_forecast_index.php?sid="+sid+"';";
	setTimeout(accion,2000);
}

function save_forecast(){
	var sid = $('#sid').val();

	var fecha = $('#fecha').val();
	var fecha_split = fecha.split('-');
	
	var temp_min = $('#temp_min').val();
	var temp_min_hora = $('#temp_min_hora option:selected').val()+':'+$('#temp_min_minuto option:selected').val()+':00';
	var temp_max_ay = $('#temp_max_ay').val();
	var temp_max_ay_hora = $('#temp_max_ay_hora option:selected').val()+':'+$('#temp_max_ay_minuto option:selected').val()+':00';
	var humedad = $('#humedad').val();
	var presion = $('#presion').val();
	var evaporacion = $('#evaporacion').val();
	var pp_ultima = $('#pp_ultima').val();
	var pp_total = $('#pp_total').val();
	var pp_normal = $('#pp_normal').val();
	var pp_superavit = $('#pp_superavit').val();
	var pp_superavit_por = $('#pp_superavit_por').val();
	var pp_deficit = $('#pp_deficit').val();
	var pp_deficit_por = $('#pp_deficit_por').val();
	
	var obser = $('#observaciones').val();
	
	var prono = $('#prono').val();
	var prono_clima = $('#clima option:selected').val();
	
	var prono1 = $('#prono1').val();
	var prono1_clima = $('#clima1 option:selected').val();
	
	var prono2 = $('#prono2').val();
	var prono2_clima = $('#clima2 option:selected').val();
	
	var prono3 = $('#prono3').val();
	var prono3_clima = $('#clima3 option:selected').val();
	
	if(!validaNumero(temp_min)){
		alert('Temperatura Minima debe ser un numero valido');
		return;
	}
	
	if(!validaNumero(temp_max_ay)){
		alert('Temperatura Maxima Ayer debe ser un numero valido');
		return;
	}
	
	if(!validaNumero(humedad)){
		alert('Humedad Relativa del Aire debe ser un numero valido');
		return;
	}
	
	if(!validaNumero(presion)){
		alert('Presion Atmosferica debe ser un numero valido');
		return;
	}
	
	if(!validaNumero(evaporacion)){
		alert('Evaporacion debe ser un numero valido');
		return;
	}
	
	if(!validaNumeroVT(pp_ultima)){
		alert('Ultima LLuvia debe ser un numero valido o debe estar en blanco');
		return;
	}
	
	if(!validaNumeroVT(pp_total)){
		alert('Total a la Fecha debe ser un numero valido o debe estar en blanco');
		return;
	}
	
	if(!validaNumeroVT(pp_normal)){
		alert('Normal a la Fecha debe ser un numero valido o debe estar en blanco');
		return;
	}
	
	if(!validaNumeroVT(pp_superavit)){
		alert('Superavit a la Fecha debe ser un numero valido o debe estar en blanco');
		return;
	}
	
	if(!validaNumeroVT(pp_superavit_por)){
		alert('Superavit a la Fecha (Porcentaje) debe ser un numero valido o debe estar en blanco');
		return;
	}
	
	if(!validaNumeroVT(pp_deficit)){
		alert('Deficit a la Fecha debe ser un numero valido o debe estar en blanco');
		return;
	}
	
	if(!validaNumeroVT(pp_deficit_por)){
		alert('Deficit a la Fecha (Porcentaje) debe ser un numero valido o debe estar en blanco');
		return;
	} 
	var text = 'Pronostico para Talca '+fecha_split[2]+'/'+fecha_split[1]+'/'+fecha_split[0]+': '+prono;
	text = text.substr(0,100)+'... @Utalca '+forecast_url;
	
	var url = 'mod_forecast_functions.php';
	$('#button_cell').html('<img class="centernoborder" src="../img/loaders/loader-04.gif" />');
	$.post(url,{
		sid 		: sid,
		accion		: 'insert_forecast',
		fecha 		: fecha,
		temp_min 	: temp_min,
		temp_min_hora 	: temp_min_hora,
		temp_max_ay 	: temp_max_ay,
		temp_max_ay_hora : temp_max_ay_hora,
		humedad 	: humedad,
		presion 	: presion,
		evaporacion 	: evaporacion,
		pp_ultima 	: pp_ultima,
		pp_total 	: pp_total,
		pp_normal 	: pp_normal,
		pp_superavit 	: pp_superavit,
		pp_superavit_por : pp_superavit_por,
		pp_deficit 	: pp_deficit,
		pp_deficit_por 	: pp_deficit_por,
		prono 		: prono,
		prono_clima 	: prono_clima,
		prono1 		: prono1,
		prono1_clima 	: prono1_clima,
		prono2 		: prono2,
		prono2_clima 	: prono2_clima,
		prono3 		: prono3,
		prono3_clima 	: prono3_clima,
		obser		: obser
	},function(data){
		if(data == 1){
			tweet(text);
		}
		else{
			error("Ocurrio un error al ingresar el pron&oacute;stico. ["+data+"]");
			reloadPage();
		}
	});
}

function save_edited_forecast(){
	var sid = $('#sid').val();
	
	function reloadPage(){
		var accion = "window.location.href = 'mod_forecast_index.php?sid="+sid+"';";
		setTimeout(accion,2000);
	}
	
	var fid = $('#fid').val();
	var fecha = $('#fecha').val();
	
	var temp_min = $('#temp_min').val();
	var temp_min_hora = $('#temp_min_hora option:selected').val()+':'+$('#temp_min_minuto option:selected').val()+':00';
	var temp_max_ay = $('#temp_max_ay').val();
	var temp_max_ay_hora = $('#temp_max_ay_hora option:selected').val()+':'+$('#temp_max_ay_minuto option:selected').val()+':00';
	var humedad = $('#humedad').val();
	var presion = $('#presion').val();
	var evaporacion = $('#evaporacion').val();
	var pp_ultima = $('#pp_ultima').val();
	var pp_total = $('#pp_total').val();
	var pp_normal = $('#pp_normal').val();
	var pp_superavit = $('#pp_superavit').val();
	var pp_superavit_por = $('#pp_superavit_por').val();
	var pp_deficit = $('#pp_deficit').val();
	var pp_deficit_por = $('#pp_deficit_por').val();
	
	var obser = $('#observaciones').val();
	
	var prono = $('#prono').val();
	var prono_clima = $('#clima option:selected').val();
	
	var prono1 = $('#prono1').val();
	var prono1_clima = $('#clima1 option:selected').val();
	
	var prono2 = $('#prono2').val();
	var prono2_clima = $('#clima2 option:selected').val();
	
	var prono3 = $('#prono3').val();
	var prono3_clima = $('#clima3 option:selected').val();
	
	if(!validaNumero(temp_min)){
		alert('Temperatura Minima debe ser un numero valido');
		return;
	}
	
	if(!validaNumero(temp_max_ay)){
		alert('Temperatura Maxima Ayer debe ser un numero valido');
		return;
	}
	
	if(!validaNumero(humedad)){
		alert('Humedad Relativa del Aire debe ser un numero valido');
		return;
	}
	
	if(!validaNumero(presion)){
		alert('Presion Atmosferica debe ser un numero valido');
		return;
	}
	
	if(!validaNumero(evaporacion)){
		alert('Evaporacion debe ser un numero valido');
		return;
	}
	
	if(!validaNumeroVT(pp_ultima)){
		alert('Ultima LLuvia debe ser un numero valido o debe estar en blanco');
		return;
	}
	
	if(!validaNumeroVT(pp_total)){
		alert('Total a la Fecha debe ser un numero valido o debe estar en blanco');
		return;
	}
	
	if(!validaNumeroVT(pp_normal)){
		alert('Normal a la Fecha debe ser un numero valido o debe estar en blanco');
		return;
	}
	
	if(!validaNumeroVT(pp_superavit)){
		alert('Superavit a la Fecha debe ser un numero valido o debe estar en blanco');
		return;
	}
	
	if(!validaNumeroVT(pp_superavit_por)){
		alert('Superavit a la Fecha (Porcentaje) debe ser un numero valido o debe estar en blanco');
		return;
	}
	
	if(!validaNumeroVT(pp_deficit)){
		alert('Deficit a la Fecha debe ser un numero valido o debe estar en blanco');
		return;
	}
	
	if(!validaNumeroVT(pp_deficit_por)){
		alert('Deficit a la Fecha (Porcentaje) debe ser un numero valido o debe estar en blanco');
		return;
	}
	
	var url = 'mod_forecast_functions.php';
	$('#button_cell').html('<img class="centernoborder" src="../img/loaders/loader-04.gif" />');
	$.post(url,{
		sid 		: sid,
		fid		: fid,
		accion		: 'update_forecast',
		fecha 		: fecha,
		temp_min 	: temp_min,
		temp_min_hora 	: temp_min_hora,
		temp_max_ay 	: temp_max_ay,
		temp_max_ay_hora: temp_max_ay_hora,
		humedad 	: humedad,
		presion 	: presion,
		evaporacion 	: evaporacion,
		pp_ultima 	: pp_ultima,
		pp_total 	: pp_total,
		pp_normal 	: pp_normal,
		pp_superavit 	: pp_superavit,
		pp_superavit_por: pp_superavit_por,
		pp_deficit 	: pp_deficit,
		pp_deficit_por 	: pp_deficit_por,
		prono 		: prono,
		prono_clima 	: prono_clima,
		prono1 		: prono1,
		prono1_clima 	: prono1_clima,
		prono2 		: prono2,
		prono2_clima 	: prono2_clima,
		prono3 		: prono3,
		prono3_clima 	: prono3_clima,
		obser		: obser
	},function(data){
		if(data == 1){
			success("El pron&oacute;stico ha sido actualizado correctamente.");
			reloadPage();	
		}
		else{
			error("Ocurrio un error al actualizar el pron&oacute;stico. ["+data+"]");
			reloadPage();
		}
	});
}

function delete_forecast(fid){
	var sid = $('#sid').val();
	function reloadPage(){
		var accion = "window.location.href = 'mod_forecast_index.php?sid="+sid+"';";
		setTimeout(accion,2000);
	}
	if(confirm('Seguro que desea eliminar este pronostico?')){
		var url = 'mod_forecast_functions.php';
		$.post(url,{
			sid 		: sid,
			fid		: fid,
			accion		: 'delete_forecast'
		},function(data){
			if(data == 1){
				success("El pron&oacute;stico ha sido borrado correctamente.");
				reloadPage();	
			}
			else{
				error("Ocurrio un error al borrar el pron&oacute;stico. ["+data+"]");
				reloadPage();
			}
		});
	}
}

function tweet(text){
	if(tweet_use){
		$.ajax({
			url 	: tweet_url,
			h	: tweet_hash,
			t	: text
		},function(data){
			if(data == 1){
				success("El pron&oacute;stico ha sido ingresado correctamente.");
				reloadPage();	
			}
			else{
				error("Ocurrio un error al ingresar el pron&oacute;stico. ["+data+"]");
				reloadPage();
			}
		});
	}else{
		success("El pron&oacute;stico ha sido ingresado correctamente.");
		reloadPage();
	}
	
}