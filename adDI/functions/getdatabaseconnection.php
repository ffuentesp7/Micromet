<?php
	require("functions/login.php");
	require_once("../config.inc.php");
	require("../funciones.inc.php");
	require("functions/crypto.php");
	
	$XML = '';
	
	$result_key = consulta_sql("SELECT llave,fechahora FROM addi WHERE usuario_id=".$USUARIO_ID);
	
	if(mysqli_num_rows($result_key) == 0){
		$XML.= 'There is no key available';
	}
	else{
		if($data_key = mysqli_fetch_array($result_key)){
				
			$key = $data_key[0];
			$fechahora = $data_key[1];
			$fechahoraactual = date('Y-m-d H:i:s');
			
			$unix_fecha_key = strtotime($fechahora);
			$unix_fecha_act = strtotime($fechahoraactual);
			
			if(($unix_fecha_act - $unix_fecha_key) < 604800){
				
				switch($_GET['var']){
					case "HOST":
						$XML.= encode_crypto($key,EVE_SQL_EXTERNAL_HOST_DATABASE);
						break;
					case "USER":
						$XML.= encode_crypto($key,EVE_SQL_HOST_DATABASE_USER_NAME);
						break;
					case "PASS":
						$XML.= encode_crypto($key,EVE_SQL_DATABASE_PASSWORD);
						break;
					case "NAME":
						$XML.= encode_crypto($key,EVE_SQL_DATABASE_NAME);
						break;
					default:
						$XML.= "ERROR VAR";
						break;
				}
			}
			else{
				$XML.= 'The key is not valid. You must obtain a new.';
			}
			
		}
	}

	echo $XML;
?>