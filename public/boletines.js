function getNewsletterSelect(){
	var sid = $('#sid').val();
	
	var url = 'boletines.acciones.php?sid='+sid+'&accion=getnewsletterselect';
	
	$.get(url,'',function(data){
		if(data != 0){
			swapText('select_boletin_field',data);
		}
		else{
			error("Error al cargar las los boletines: "+data );
		}
	});
}

function getPublicNewsletter(){
	var area = $('#select_area option:selected').val();
	var bid = $('#select_boletin option:selected').val();
	var detalle = $('#select_detalle option:selected').val();
	
	var url = 'boletines.pdf.php?accion=getpublicpdf&area='+area+'&bid='+bid+'&detalle='+detalle;
	
	$('#boton_generar').fadeOut("slow");
	
	window.open(url);
	
	setTimeout(function(e){
		$('#boton_generar').fadeIn("slow");
	},5000);
}