function getScriptList(){
	var sid = $('#sid').val();

	url = 'estaciones.acciones.php';
	$.get(url,{
		sid:  sid,
		accion : 'getlistscript'
	},
	function(data){
		$('#tableofscripts').html(data);
	});
}

function setInstrumentNameAndId(nombre,id){
	$('#nombre_instrumento').val(nombre);
	$('#instrumento_id').val(id);
	setInstrumentoCalibracionData(id);
	self.parent.tb_remove();
}

function setInstrumentoCalibracionData(iid){
	var sid = $('#sid').val();
	var url = 'estaciones.acciones.php';
	
	$.get(url,{
		sid : sid,
		accion: 'getinstrumentocalibraciondata',
		instrumentId: iid
	},function(data){
		var datos = data.split('|');
	
		if(datos[0] != '0'){
			$('#script_id option[value='+datos[0]+']').attr("selected","selected");
			$('#valor_a').val(datos[1]);
			$('#valor_b').val(datos[2]);
			$('#valor_c').val(datos[3]);
			$('#valor_d').val(datos[4]);
			$('#valor_e').val(datos[5]);
			$('#boton_quitar_calibracion').show();
		}
	});
}

function resetScriptFields(){
	$('#nombre').val('');
	$('#descripcion').val('');
	$('#archivo').val('');
}

function newCalibrationScript(){
	var sid = $('#sid').val();
	
	var nombre = $('#nombre').val();
	var descri = $('#descripcion').val();
	var script = $('#archivo').val();
	
	if(nombre == '' || descri == '' || script == ''){
		alert('Debe completar todos los datos!');
		return;
	}
	
	var url = 'estaciones.acciones.php';
	
	$.get(url,{
		sid : sid,
		accion: 'newscript',
		nombre: nombre,
		descripcion: descri,
		script: script
	},function(data){
		if(data == 'true'){
			success('El script fue ingresado correctamente');
			getScriptList();
			resetScriptFields();
		}
		else{
			error('Ocurrio un error en el ingreso. '+data);
		}
	});	
}

function setCalibrationForInstrument(){
	var sid = $('#sid').val();
	
	var instrumentId = $('#instrumento_id').val();
	var scriptId = $('#script_id option:selected').val();
	var aValue = $('#valor_a').val();
	var bValue = $('#valor_b').val();
	var cValue = $('#valor_c').val();
	var dValue = $('#valor_d').val();
	var eValue = $('#valor_e').val();
	
	if(instrumentId == 0){
		alert('Debe elegir un instrumento');
		return;
	}
	
	if(scriptId == 0){
		alert('Debe elegir un script de calibracion');
		return;
	}
	
	if(!validaNumero(aValue)){
		alert('El Valor a debe ser un numero');
		return;
	}
	
	if(!validaNumero(bValue)){
		alert('El Valor b debe ser un numero');
		return;
	}
	
	if(!validaNumero(cValue)){
		alert('El Valor c debe ser un numero');
		return;
	}
	
	if(!validaNumero(dValue)){
		alert('El Valor d debe ser un numero');
		return;
	}
	
	if(!validaNumero(eValue)){
		alert('El Valor e debe ser un numero');
		return;
	}
	
	var url = 'estaciones.acciones.php';
	
	$.get(url,{
		sid : sid,
		accion: 'setcalibrationforinstrument',
		instrumentId: instrumentId,
		scriptId: scriptId,
		aValue: aValue,
		bValue: bValue,
		cValue: cValue,
		dValue: dValue,
		eValue: eValue
	},function(data){
		if(data == 'true'){
			success('Se asigno o actualizo el script de calibracion para el instrumento');
			resetCalibrationForInstrumentFields();
		}
		else{
			error('Ocurrio un error en el ingreso/actualizacion. '+data);
		}
	});
}

function unsetCalibrationForInstrument(){
	var sid = $('#sid').val();
	
	var instrumentId = $('#instrumento_id').val();
	var scriptId = $('#script_id option:selected').val();
	
	var url = 'estaciones.acciones.php';
	
	if(confirm("Seguro que desea quitar esta calibracion?")){
		$.get(url,{
			sid : sid,
			accion: 'unsetinstrumentocalibracion',
			instrumentId: instrumentId,
			scriptId: scriptId
		},function(data){
			if(data == 'true'){
				success('Se elimino de calibracion para el instrumento');
				resetCalibrationForInstrumentFields();
				$('#boton_quitar_calibracion').hide();
			}
			else{
				error('Ocurrio un error en el borrado. '+data);
			}
		});
	}
}

function resetCalibrationForInstrumentFields(){
	$('#instrumento_id').val(0);
	$('#nombre_instrumento').val('');
	$('#script_id option[value=0]').attr("selected","selected");
	$('#valor_a').val(0.0);
	$('#valor_b').val(0.0);
	$('#valor_c').val(0.0);
	$('#valor_d').val(0.0);
	$('#valor_e').val(0.0);
}

function deleteCalibrationScript(csid){
	var sid = $('#sid').val();
	
	var url = 'estaciones.acciones.php';
	
	if(confirm("Seguro que desea quitar este script de calibracion? Esto eliminara las calibraciones relacionadas con este script.")){
		$.get(url,{
			sid : sid,
			accion: 'deletecalibrationscript',
			scriptId: csid
		},function(data){
			if(data == 'true'){
				success('Se elimino el script de calibracion.');
				getScriptList();
			}
			else{
				error('Ocurrio un error en el borrado. '+data);
			}
		});
	}
}

function setCalibrationScriptData(csid){

	var sid = $('#sid').val();
	
	var url = 'estaciones.acciones.php';

	$.get(url,{
		sid : sid,
		accion: 'getcalibrationscriptdata',
		scriptId: csid
	},function(data){
		var datos = data.split('|');
	
		if(datos[0] != '0'){
			$('#nombre').val(datos[0]);
			$('#archivo').val(datos[1]);
			$('#descripcion').val(datos[2]);
			$('#csid').val(csid);
			$('#button_upd_cs').show();
			$('#button_rst_cs').show();
			$('#button_new_cs').hide();
		}
	});
}

function resetFieldOfCalibrationScript(){
	resetScriptFields();
	$('#csid').val(0);
	$('#button_upd_cs').hide();
	$('#button_rst_cs').hide();
	$('#button_new_cs').show();
}

function updateCalibrationScript(){
	var sid = $('#sid').val();
	
	var nombre = $('#nombre').val();
	var descri = $('#descripcion').val();
	var script = $('#archivo').val();
	var csid = $('#csid').val();
	
	if(nombre == '' || descri == '' || script == '' || csid == 0){
		alert('Debe completar todos los datos!');
		return;
	}
	
	var url = 'estaciones.acciones.php';
	
	$.get(url,{
		sid : sid,
		accion: 'updatescript',
		nombre: nombre,
		descripcion: descri,
		script: script,
		csi: csid
	},function(data){
		if(data == 'true'){
			success('El script fue actualizado correctamente');
			getScriptList();
			resetFieldOfCalibrationScript();
		}
		else{
			error('Ocurrio un error al actualizar. '+data);
		}
	});	
}