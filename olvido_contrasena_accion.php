<?php
	session_start();
	require_once('funciones.inc.php');
	require_once('antinyeccion.inc.php');
	
	if(isset($_GET['ac'])){
		if($_GET['ac'] == 'nw'){
			if(	!isset($_SESSION['captchakey']) || 
			!isset($_GET['rut_pass']) || 
			!isset($_GET['captcha'])){
				
				echo "Error General. Codigo: 02";	
				
			}
			else{
				if(MD5($_GET['captcha']) != $_SESSION['captchakey']){
					echo "Error Captcha. Codigo: 01";	
				}
				else{
					$UID = 0;
					$RUT = $_GET['rut_pass'];
					$NOMBRE = '';
					$EMAIL = '';
					
					$SQL = "SELECT id,email,nombre FROM usuario WHERE rut='$RUT'";
					
					$REQ = consulta_sql($SQL);
					
					if($DAT = mysqli_fetch_array($REQ)){
						$UID = $DAT[0];
						$EMAIL = $DAT[1];
						$NOMBRE = $DAT[2];
					}
					else{
						echo "Error Usuario. Codigo: 01";
						exit;	
					}
					
					$HASH = MD5(microtime());
					
					$SQL = "INSERT INTO `eve_renovar_contrasena` (`hash`, `rut`, `nombre`, `email`, `flag`) VALUES ( '$HASH', '$RUT', '$NOMBRE', '$EMAIL', 0)";
					
					if(comando_sql($SQL) > 0){
						$MSG = "Hemos recibido una solicitud de cambio de contrasena por olvido del usuario $NOMBRE con registro a este correo. Si ud no ha solicitado un cambio de contrasena por favor ignore este correo de lo contrario haga click en el siguiente enlace. http://www.citrautalca.cl/eve/olvido_contrasena_accion.php?ac=ol&h=$HASH&r=$RUT&uid=$UID";
						$SBJ = "ADaM - Solicitud de Renovacion de Contrasena";
						
						$ERET = enviar_mail($EMAIL,$NOMBRE,'adam.infosystem@gmail.com','ADaM',$SBJ,$MSG);
						
						if($ERET == 1){
							echo "Se ha enviado un correo electronico a su cuenta con las instrucciones a seguir. Correo: $EMAIL, Nombre: $NOMBRE.";
							exit;
						}
						else{
							echo 'Error Correo. Codigo 01. '.$ERET;
							exit;
						}
					}
					else{
						echo 'Error SQL. Codigo 01';
						exit;
					}
				}
			}
		}
		elseif($_GET['ac'] == 'ol'){
			if(	!isset($_GET['h']) ||
				!isset($_GET['r']) ||
				!isset($_GET['uid'])){
				echo 'Error Hash. Codigo 01';	
			}
			else{
				$HASH = $_GET['h'];
				$RUT = $_GET['r'];
				$NOMBRE = '';
				$EMAIL = '';
				$FLAG = 0;
				$UID = $_GET['uid'];
				
				$SQL = "SELECT nombre, email, flag FROM `eve_renovar_contrasena` WHERE `hash`='$HASH' AND `rut`='$RUT'";
				
				$REQ = consulta_sql($SQL);
					
				if($DAT = mysqli_fetch_array($REQ)){
					$EMAIL = $DAT[1];
					$NOMBRE = $DAT[0];
					$FLAG = $DAT[2];
				}
				else{
					echo "Error Usuario. Codigo: 01";
					exit;	
				}
				
				if($FLAG == 0){
					$SQL = "UPDATE `eve_renovar_contrasena` SET flag=1 WHERE `hash`='$HASH' AND `rut`='$RUT'";
				}
				else{
					echo "Error FLAG. Codigo: 01. La contrasena ya fue cambiada.";
					exit;
				}
				
				if(comando_sql($SQL) > 0){
					$PASS = genpass();
					$MD5PASS = MD5($PASS);
				
					$MSG = "Hemos recibido una solicitud de cambio de contrasena por olvido del usuario $NOMBRE con registro a este correo. Su nueva contrasena es: $PASS, por favor cambiela de inmediato cuando ingrese al sistema.";
					$SBJ = "ADaM - Renovacion de Contrasena";
					
					$SQL = "UPDATE usuario SET clave='$MD5PASS' WHERE `id`=$UID AND `rut`='$RUT'";
					
					if(comando_sql($SQL) > 0){
						$ERET = enviar_mail($EMAIL,$NOMBRE,'adam.infosystem@gmail.com','ADaM',$SBJ,$MSG);
					
						if($ERET == 1){
							echo "Se ha enviado un correo electronico a su cuenta con la nueva contrasena. Correo: $EMAIL, Nombre: $NOMBRE.";
							exit;
						}
						else{
							echo 'Error Correo. Codigo 01. '.$ERET;
							exit;
						}
					}
					else{
						echo 'Error SQL. Codigo 02';
						exit;
					}
				}
				else{
					echo 'Error SQL. Codigo 01';
					exit;
				}
			}
		}
	}
	else{
		echo "Error General. Codigo: 01";
	}
	
	

?>