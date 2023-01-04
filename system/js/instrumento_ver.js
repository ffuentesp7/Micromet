$(document).ready(function(e){
	get_data(instrumentID);
});

function set_instrument_event(iid){
				
	$(".data_box_"+iid).each(function(e){
		var valor = $(this).attr("valor");
		$(this).mouseover(function(h){
			$.changeInstrumentValue({instrumentValue: valor});
		});
	});
}

function get_data(ins){
	var sid = $('#sid').val();

	var url = 'historico.acciones.php?sid='+sid+'&accion=get_data_instrument&ins='+ins+'&sta='+stationID+'&fd='+fd+'&fh='+fh+'&det=detalle_diario_widget';
	
	$.get(url,'',function(data){
		$('#tabla_datos').html(data);
		
		set_instrument_event(ins);
		//activateInstrument();
	});
}

