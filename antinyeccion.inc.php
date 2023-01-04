<?php
function mysql_quote($value){
	$value = addslashes( $value );
	$value = str_replace("\r","\\r'",$value);
	$value = str_replace("\n","\\n'",$value);
	$value = str_replace("'","",$value);
	return $value;
}
foreach($_GET as $variable=>$valor){
   $_GET[$variable] = mysql_quote($_GET[$variable]);
}
// Modificamos las variables de formularios
foreach($_POST as $variable=>$valor){
   $_POST[$variable] = mysql_quote($_POST[$variable]);
}
?>