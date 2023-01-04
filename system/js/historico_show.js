offset = 1;
loadingData = false;

function load_data(){
	loadingData = true;
	loading('Cargando Datos');
	$.get(url2+'&offset='+offset,'',function(data){
		$('#load_buttom_row').remove();
		$('#body_table').append(data);
		offset=offset+1;
		stopLoading();
		loadingData = false;
	});
}