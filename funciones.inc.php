<?php
/*##########################################################
* Autor: Rodrigo Aguilar Saavedra
* Ing. en Bioinformatica
* Universidad de Talca
* 2010
*/
$RUTASERVER = "/e-VE/";
//set_time_limit(60);

//==== Redirect... Try PHP header redirect, then Java redirect, then try http redirect.:
function redirect($url){
    if (!headers_sent()){    //If headers not sent yet... then do php redirect
        header('Location: '.$url); exit;
    }else{                    //If headers are sent... do java redirect... if java disabled, do html redirect.
        echo '<script type="text/javascript">';
        echo 'window.location.href="'.$url.'";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url='.$url.'" />';
        echo '</noscript>'; exit;
    }
}



function check_admin($sid){
	if($_SESSION['session_usuario_administrador'] != 1)
		redirect("../index.php?sid=$sid");
}

/*##########################################################
**# Funciones para el manejo de fechas
*/

/*
* Convierte fecha de mysql a normal
* @param fecha Fecha de entrada en formato  aaaa-mm-dd (tipo MySQL)
* @return la fecha en formato dd/mm/aaaa
*/
function cambia_fecha_a_normal($fecha){
    preg_match( "/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/", $fecha, $mifecha);
    $lafecha=$mifecha[3]."/".$mifecha[2]."/".$mifecha[1];
    return $lafecha;
}

/*
* Convierte fecha de normal a mysql
* @param fecha Fecha de entrada en formato  dd/mm/aaaa (tipo normal)
* @return la fecha en formato aaaa-mm-dd
*/
function cambia_fecha_a_mysql($fecha){
    preg_match( "/([0-9]{1,2})\/([0-9]{1,2})\/([0-9]{2,4})/", $fecha, $mifecha);
    $lafecha=$mifecha[3]."-".$mifecha[2]."-".$mifecha[1];
    return $lafecha;
} 

function add_days($fecha, $ndiasasumar)
{
	list($dia, $mes, $ano) = explode("/", $fecha);
	$nueva = mktime(0, 0, 0, $mes, $dia, $ano) + $ndiasasumar * 24 * 60 * 60;
	$nuevafecha = date("d/m/Y", $nueva);
	return($nuevafecha);
}

function add_days_mysql($fecha, $ndiasasumar)
{
	list($ano, $mes, $dia) = explode("-", $fecha);
	$nueva = mktime(0, 0, 0, $mes, $dia, $ano) + $ndiasasumar * 24 * 60 * 60;
	$nuevafecha = date("Y-m-d", $nueva);
	return($nuevafecha);
}

function add_seconds($hour,$date,$seconds){
	list($hr, $min, $seg) = explode(":", $hour);
	list($ano, $mes, $dia) = explode("-", $date);
	$nueva = mktime($hr, $min, $seg, $mes, $dia, $ano) + $seconds;
	$nuevaHoraFecha = array(date("H:i:s", $nueva),date("Y-m-d", $nueva));
	return($nuevaHoraFecha);
}


function add_work_days($fecha, $ndiashabilesasumar)
{
	$i = 0;
	while ($i < $ndiashabilesasumar) {
		$fecha = add_days($fecha, 1);
		list($dia, $mes, $ano) = explode("/", $fecha);
		if (date("N", mktime(0, 0, 0, $mes, $dia, $ano)) != 6 && date("N", mktime(0, 0, 0, $mes, $dia, $ano)) != 7)
			$i += 1;
	}
	return $fecha;
}

function suma_dias_a_fecha_2($dias,$fecha){
	$array_date = explode("-", $fecha);
    $fecha = date("Y-m-d", mktime(0, 0, 0, $array_date[1], $array_date[2] + $dias, $array_date[0]));
	return $fecha;
}

function retorna_semana($fecha){
	$array_date = explode("-", $fecha);
    	$semana = date("W", mktime(0, 0, 0, $array_date[1], $array_date[2], $array_date[0]));
	return $semana;
}

function retorna_unix($fecha,$hora){
	$array_date = explode("-", $fecha);
	$array_hour = explode(":",$hora);
    	$unix = mktime($array_hour[0], $array_hour[1], $array_hour[2], $array_date[1], $array_date[2], $array_date[0]);
	return $unix;
}

function retorna_anho($fecha){
	preg_match( "/([0-9]{2,4})-([0-9]{1,2})-([0-9]{1,2})/", $fecha, $mifecha);
    return $mifecha[1];
}

/*###################################################
** Funciones para el manejo de la base de datos
*/

function check_mysql(){
	require_once('config.inc.php');
	// Conectando y seleccionando la base de datos
	$link = mysqli_connect(EVE_SQL_HOST_DATABASE, EVE_SQL_HOST_DATABASE_USER_NAME, EVE_SQL_DATABASE_PASSWORD);
	
	if(!$link){
		return false;
	}
	else{
		$valor = mysqli_select_db($link, EVE_SQL_DATABASE_NAME);
		if($valor){
			mysqli_close($link);
			return true;
		}
		else{
			return false;
		}
	}
}


/*
* Realiza una consulta SQL una base de datos MySQL definida en config.inc.php
* @param consulta La consulta SQL
* @return Una matriz tipo MySQL con el resultado de la consulta
*/
function consulta_sql($consulta){
	require_once('config.inc.php');
	// Conectando y seleccionando la base de datos
	$link = mysqli_connect(EVE_SQL_HOST_DATABASE, EVE_SQL_HOST_DATABASE_USER_NAME, EVE_SQL_DATABASE_PASSWORD)
		or die('No se pudo conectar al servidor MySQL: ' . mysqli_error($link));
	mysqli_select_db($link,EVE_SQL_DATABASE_NAME) or die('No se pudo seleccionar la base de datos: '.mysqli_error($link) );
	
	// Realizando la consulta
	$result = mysqli_query($link,$consulta) or die('Consulta fallida: ' . mysqli_error($link));
	
	// cerrando la conexion
	mysqli_close($link);
	return $result;
}

function consulta_sqlUTF8($consulta){
	require_once('config.inc.php');
	// Conectando y seleccionando la base de datos
	$link = mysqli_connect(EVE_SQL_HOST_DATABASE, EVE_SQL_HOST_DATABASE_USER_NAME, EVE_SQL_DATABASE_PASSWORD)
		or die('No se pudo conectar al servidor MySQL: ' . mysqli_error($link));
	mysqli_select_db($link, EVE_SQL_DATABASE_NAME) or die('No se pudo seleccionar la base de datos: '.mysqli_error($link) );
	mysqli_query($link, "SET NAMES 'utf8'");
	// Realizando la consulta
	$result = mysqli_query($link, $consulta) or die('Consulta fallida: ' . mysqli_error($link));
	
	// cerrando la conexion
	mysqli_close($link);
	return $result;
}


function comando_sql($consulta){
	require_once('config.inc.php');
	// Conectando y seleccionando la base de datos
	$link = mysqli_connect(EVE_SQL_HOST_DATABASE, EVE_SQL_HOST_DATABASE_USER_NAME, EVE_SQL_DATABASE_PASSWORD)
		or die('No se pudo conectar al servidor MySQL: ' . mysqli_error($link));
	mysqli_select_db($link, EVE_SQL_DATABASE_NAME) or die('No se pudo seleccionar la base de datos: '.mysqli_error($link) );
	
	// Realizando la consulta
	mysqli_query($link,$consulta) or die('Comando fallido: ' . mysqli_error($link));
	$affected = mysqli_affected_rows($link);
	// cerrando la conexion
	mysqli_close($link);
	return $affected; //si es > 0 comando se ejecuto correctamente
}

function comando_sqlUTF8($consulta){
	require_once('config.inc.php');
	// Conectando y seleccionando la base de datos
	$link = mysqli_connect(EVE_SQL_HOST_DATABASE, EVE_SQL_HOST_DATABASE_USER_NAME, EVE_SQL_DATABASE_PASSWORD)
		or die('No se pudo conectar al servidor MySQL: ' . mysqli_error($link));
	mysqli_select_db($link, EVE_SQL_DATABASE_NAME) or die('No se pudo seleccionar la base de datos: '.mysqli_error($link) );
	mysqli_query($link, "SET NAMES 'utf8'");
	// Realizando la consulta
	mysqli_query($link, $consulta) or die('Comando fallido: ' . mysqli_error($link));
	$affected = mysqli_affected_rows($link);
	// cerrando la conexion
	mysqli_close($link);
	return $affected; //si es > 0 comando se ejecuto correctamente
}

function consulta_sql_jsat($consulta){
	require_once('config.inc.php');
	// Conectando y seleccionando la base de datos
	$link = mysqli_connect(JSAT_SQL_HOST_DATABASE, JSAT_SQL_HOST_DATABASE_USER_NAME, JSAT_SQL_DATABASE_PASSWORD)
		or die('No se pudo conectar al servidor MySQL: ' . mysqli_error($link));
	mysqli_select_db($link, JSAT_SQL_DATABASE_NAME) or die('No se pudo seleccionar la base de datos: '.mysqli_error($link) );
	
	// Realizando la consulta
	$result = mysqli_query($link, $consulta) or die('Consulta fallida: ' . mysqli_error($link));
	
	// cerrando la conexion
	mysqli_close($link);
	return $result;
}

function bitacora($nota){
	$fecha = date('Y-m-d');
	$hora = date('H:i:s');
	comando_sql("INSERT INTO eve_bitacora(usuario_id,fecha,hora,observacion) VALUES(".$_SESSION['session_usuario_id'].",'$fecha','$hora','$nota')");
}

function ultima_visita($ID){
	require('config.inc.php');
	$fechahora = date('Y-m-d H:i:s');
	consulta_sql("UPDATE usuario SET ultimo_ingreso='".$fechahora."' WHERE id=".$ID);
}

function estadisticas($tipo,$nombre){
	$resultado = consulta_sql("SELECT valor,id FROM eve_estadistica WHERE tipo='$tipo' AND nombre='$nombre'");
	if(mysqli_num_rows($resultado) == 0){
		comando_sql("INSERT INTO eve_estadistica(nombre,tipo,valor) VALUES('$nombre','$tipo',1)");
	}
	else{
		$datos_estadisticos = mysqli_fetch_array($resultado);
		$conteo = $datos_estadisticos[0];
		$conteo++;
		consulta_sql("UPDATE eve_estadistica SET valor=".$conteo." WHERE id=".$datos_estadisticos[1]);
	}
}

function enviar_mail($to,$toname,$from,$fromname,$subject,$body,$altbody='',$cc1='',$cc1name='',$cc2='',$cc2name=''){
	require('config.inc.php');
	include_once('PHPMailer/class.phpmailer.php');
	
	if(get_parameter('MAIL_METHOD') == 'MAIL'){
		$message = $body;
		
		$headers = "From: \"".$fromname."\" <".$from.">\r\n";
		
		$headers .= "To: \"".$toname."\" <".$to.">\r\n";
		$headers .= "Subject: \"".$subject."\"\r\n";
		
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
		
		$ok = 0;
		
		if($cc1 != '' && $cc1name != ''){
			//$headers .= "Cc: \"".$cc1name."\" <".$cc1.">\n";
			if(!mail ($cc1, $subject, $message, $headers)) {
				$ok = 0;
			} else {
				$ok = 1;
			}
		}
		if($cc2 != '' && $cc2name != ''){
			//$headers .= "Bcc: \"".$cc2name."\" <".$cc2.">\n";
			if(!mail ($cc2, $subject, $message, $headers)) {
				$ok = 0;
			} else {
				$ok = 1;
			}
		}
		if(!mail ($to, $subject, $message, $headers)) {
			$ok = 0;
		} else {
			$ok = 1;
		}
			
		if($ok == 1){
			return 1;
		}
		else{
			return "Error al enviar el correo";
		}
		
	}
	elseif(get_parameter('MAIL_METHOD') == 'SMTP'){
		$mail             = new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = get_parameter('MAIL_SMTP_HOST'); // SMTP server
		$mail->From       = $from;
		$mail->FromName   = $fromname;
		
		$mail->Subject    = $subject;
		
		$mail->AltBody    = $altbody;
		
		$mail->MsgHTML($body);
		
		$mail->AddAddress($to, $toname);           // attachment
		
		if($cc1 != '' && $cc1name != '')
			$mail->AddAddress($cc1, $cc1name);
		if($cc2 != '' && $cc2name != '')	
			$mail->AddAddress($cc2, $cc2name);
		
		if(!$mail->Send()) {
			return $mail->ErrorInfo;
		} else {
			return 1;
		}
	}
	elseif(get_parameter('MAIL_METHOD') == 'SMTP_AUTH'){
		include_once("PHPMailer/class.smtp.php");
		
		$mail             = new PHPMailer();
		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->SMTPAuth   = true;
		$mail->SMTPSecure = "tls";
		$mail->Port       = get_parameter('MAIL_SMTP_HOST_AUTH_PORT');
		$mail->Username   = get_parameter('MAIL_SMTP_HOST_AUTH_USER');
		$mail->Password   = get_parameter('MAIL_SMTP_HOST_AUTH_PASS');
		$mail->Host       = get_parameter('MAIL_SMTP_HOST_AUTH');
		$mail->From       = $from;
		$mail->FromName   = $fromname;
		$mail->SMTPDebug  = false;
		
		$mail->Subject    = $subject;
		
		//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		
		$mail->MsgHTML($body);
		
		$mail->AddAddress($to, $toname);           // attachment
		
		if($cc1 != '' && $cc1name != '')
			$mail->AddAddress($cc1, $cc1name);
		if($cc2 != '' && $cc2name != '')	
			$mail->AddAddress($cc2, $cc2name);
		
		if(!$mail->Send()) {
			return $mail->ErrorInfo;
		} else {
			return 1;
		}
	}
	elseif(get_parameter('MAIL_METHOD') == 'SENDMAIL'){
		$mail             = new PHPMailer();
		$mail->IsSendmail();
		$mail->From       = $from;
		$mail->FromName   = $fromname;
		
		$mail->Subject    = $subject;
		
		//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
		
		$mail->MsgHTML($body);
		
		$mail->AddAddress($to, $toname);           // attachment
		
		if($cc1 != '' && $cc1name != '')
			$mail->AddAddress($cc1, $cc1name);
		if($cc2 != '' && $cc2name != '')	
			$mail->AddAddress($cc2, $cc2name);
		
		if(!$mail->Send()) {
			return $mail->ErrorInfo;
		} else {
			return 1;
		}
	}
	else{
		
	}
}

function get_parameter($param){
	$res = consulta_sql("SELECT valor FROM eve_parametro WHERE code='$param'");
	$data = mysqli_fetch_array($res);
	return $data[0];
}

function set_parameter($param,$value){
	$res = comando_sql("UPDATE eve_parametro SET valor='$value' WHERE code='$param'");
	return $res;
}


function get_user_option($user,$opt){
	$res = consulta_sql("SELECT valor FROM eve_opciones_de_usuario WHERE code='$opt' AND usuario_id=$user");
	if(mysqli_num_rows($res) == 0){
		return 'NULL';
	}
	else{
		$data = mysqli_fetch_array($res);
		return $data[0];
	}
}

function get_user_permission($user,$opt){

	$SQL = "SELECT eve_tipo_de_permiso_usuario.value 
		FROM eve_tipo_de_permiso_usuario,eve_usuario_has_tipo_de_permiso_usuario
		WHERE code='$opt' 
		AND usuario_id=$user
		AND eve_usuario_has_tipo_de_permiso_usuario.eve_tipo_de_permiso_usuario_id=eve_tipo_de_permiso_usuario.id";
		
	$res = consulta_sql($SQL);
	if(mysqli_num_rows($res) == 0){
		return 'NULL';
	}
	else{
		$data = mysqli_fetch_array($res);
		return $data[0];
	}
}

function genpass(){
	return substr(MD5(microtime(true) * mktime(1)),0,6);
}

function genpassnumber(){
	return substr(microtime(true) * mktime(1),0,6);
}

function get_last_sensor_value($sensor,$station){
	$SQL = "SELECT medicion.fecha,medicion.hora,medicion.medicion
		FROM medicion,instrumento,tipo_instrumento,estacion
		WHERE medicion.instrumento_id=instrumento.id
		AND instrumento.tipo_instrumento_id=tipo_instrumento.id
		AND instrumento.estacion_id=$station
		AND tipo_instrumento.code='$sensor'
		ORDER BY medicion.fecha DESC, medicion.hora DESC, tipo_instrumento.id
		LIMIT 1";
		
	$result_medicion = consulta_sql($SQL);
	
	if(mysqli_num_rows($result_medicion) == 0){
		return "NULL";
	}
	else{
		$datos_medicion = mysqli_fetch_array($result_medicion);
		return $datos_medicion[0]."|".$datos_medicion[1]."|".$datos_medicion[2];
	}
}

function getStationState($state){
        if($state == ("O")){
            return "Offline";
        }
        else if($state == ("D")){
            return "Descargando";
        }
        else if($state == ("S")){
            return "Detenida";
        }
        else if($state == ("C")){
            return "En Modo De Cese de Descarga";
        }
        else if($state == ("E")){
            return "Error Desconocido";
        }
        else{
            return "Error";
        }
}

function array_insert($array,$offset,$insert){

	$parcial = array_slice($array,0,$offset+1);
	$parcial[] = $insert;
	$tail = array_slice($array,$offset+1);
	$result = array_merge($parcial,$tail);
	
	return $result;
}

function check_mobile_browser(){
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	
	$browsers = '/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|symb(ian|os|ianOS)|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i';
	
	if(preg_match($browsers,$useragent)){
		return true;
	}
	return false;
}

function get_user_id(){
	return $_SESSION['session_usuario_id'];
}

function tilde_to_utf8($text){
	
	$text = str_replace('&aacute;','á',$text);
	$text = str_replace('&Aacute;','Á',$text);
	$text = str_replace('&eacute;','é',$text);
	$text = str_replace('&Eacute;','É',$text);
	$text = str_replace('&iacute;','í',$text);
	$text = str_replace('&Iacute;','Í',$text);
	$text = str_replace('&oacute;','ó',$text);
	$text = str_replace('&Oacute;','Ó',$text);
	$text = str_replace('&uacute;','ú',$text);
	$text = str_replace('&Uacute;','Ú',$text);
	$text = str_replace('&ntilde;','ñ',$text);
	$text = str_replace('&Ntilde;','Ñ',$text);
	$text = str_replace('&deg;','º',$text);
	$text = str_replace("&#037;",'%',$text);
	$text = str_replace("&#37;",'%',$text);

	return $text;
}

function utf8_to_tilde($text){
	
	$text = str_replace('á','&aacute;',$text);
	$text = str_replace('Á','&Aacute;',$text);
	$text = str_replace('é','&eacute;',$text);
	$text = str_replace('É','&Eacute;',$text);
	$text = str_replace('í','&iacute;',$text);
	$text = str_replace('Í','&Iacute;',$text);
	$text = str_replace('ó','&oacute;',$text);
	$text = str_replace('Ó','&Oacute;',$text);
	$text = str_replace('ú','&uacute;',$text);
	$text = str_replace('Ú','&Uacute;',$text);
	$text = str_replace('ñ','&ntilde;',$text);
	$text = str_replace('Ñ','&Ntilde;',$text);
	$text = str_replace('º','&deg;',$text);
	$text = str_replace('%',"&#037;",$text);
	$text = str_replace('%',"&#37;",$text);

	return $text;
}

function get_month_in_words($mes){
    
    $words = '';
    
    switch($mes){
	case "01":
	case "1":
	case 1:
	    $words = "ENERO";
	    break;
	case "02":
	case "2":
	case 2:
	    $words = "FEBRERO";
	    break;
	case "03":
	case "3":
	case 3:
	    $words = "MARZO";
	    break;
	case "04":
	case "4":
	case 4:
	    $words = "ABRIL";
	    break;
	case "05":
	case "5":
	case 5:
	    $words = "MAYO";
	    break;
	case "06":
	case "6":
	case 6:
	    $words = "JUNIO";
	    break;
	case "07":
	case "7":
	case 7:
	    $words = "JULIO";
	    break;
	case "08":
	case "8":
	case 8:
	    $words = "AGOSTO";
	    break;
	case "09":
	case "9":
	case 9:
	    $words = "SEPTIEMBRE";
	    break;
	case "10":
	case 10:
	    $words = "OCTUBRE";
	    break;
	case "11":
	case 11:
	    $words = "NOVIEMBRE";
	    break;
	case "12":
	case 12:
	    $words = "DICIEMBRE";
	    break;
    }
    
    return $words;
}

?>