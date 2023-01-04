<?php
include_once('funciones.inc.php');

$debug = '';

if(isset($_GET['email'])){
	$email = $_GET['email'];
	$mensaje = '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es" lang="es">
			<head></head>
			<body>
				<p><b>Prueba</b></p>
				<p>este es un correo de prueba para verificar el comportamiento del sistema de envio de correo</p>
			</body>
		</html>';
	$salida = enviar_mail($email,'Usted','adam.infosystem@gmail.com','ADaM System','Probando envio de correo',$mensaje);
	$debug = "El correo fue enviado correctamente <br/> El mensaje contenido en el correo es el siguiente: <br/> $mensaje <br/>
			El estado del envio de correo es el siguiente: $salida <br/><br/>";
}
?>

<html>
	<head><TITLE>Prueba del sistema de correo</TITLE></head>
	<body>
		<span><?=$debug?></span>
		
		<form action="prueba.email.php" method="GET">
			<label>EMail: <input type="text" name="email" value=""/></label>
			<input type="submit" value="Enviar"/>
		</form>
	</body>
</html>
