function swapText(campo,texto1){
	$('#'+campo).html(texto1);
}

function success(texto){
	$.notifyBar({ cls: "success", html: texto });
}

function error(texto){
	$.notifyBar({ cls: "error", html: texto });
}