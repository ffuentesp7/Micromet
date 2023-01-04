function swapText(campo,texto1){
	$('#'+campo).html(texto1);
}

function success(texto){
	$.notifyBar({ cls: "success", html: texto });
}

function error(texto){
	$.notifyBar({ cls: "error", html: texto });
}

function loading(texto){
	$.notifyBar({ cls: "loading", html: texto, delay: 3000, animationSpeed: 50, close: true });
}

function stopLoading(){
	$('#__notifyBar').slideUp(50, function() { $('#__notifyBar').remove() });
}

function putZero(num){
	if(num < 10 && num >= 0){
		return '0'+num;
	}
	else{
		return num;
	}
}