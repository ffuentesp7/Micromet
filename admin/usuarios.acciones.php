<?php

	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	check_admin($_SESSION['session_nombre_sesion']);

	$ACCION = $_GET['accion'];
	
	if($ACCION == 'add'){
		$nombre	= $_GET['nombre'];
		$rut	= $_GET['rut'];
		$email	= $_GET['email'];
		$movil	= $_GET['movil'];
		$clave	= md5($_GET['clave']);
		$enviar	= $_GET['enviarporemail'];
		$aviso	= $_GET['avisosensor'];
		$admin	= $_GET['adm'];
		$sys	= $_GET['sys'];
		
		$SQL = "SELECT id FROM usuario WHERE rut='$rut'";
		
		$request_usuario = consulta_sql($SQL);
		
		if(mysqli_num_rows($request_usuario) > 0){
			echo 'El rut ya se encuentra registrado';
			return;
		}
		
		$SQL = "INSERT INTO usuario (email, nombre, administrador, aviso_sensor, telefono_movil, clave, ultimo_ingreso, rut, sistema) VALUES ( '$email', '$nombre', $admin, $aviso, '$movil', '$clave', '0000-00-00 00:00:00', '$rut', $sys)";
		
		if(comando_sql($SQL) > 0){
			if($enviar == 1){
				$BODY = "Se ha creado una nueva cuenta de usuario en EVE System. 
					Los datos de acceso son los siguientes:
					RUT: $rut 
					Clave: ".$_GET['clave']."
					Para entrar al sistema ingrese a www.citrautalca.cl, haga click en la pesta&ntilde;a \"EVE\" 
					de la esquina superior derecha, ingresar su rut y clave y luego hacer click en entrar.
					Para mejorar su experiencia de usuario se recomienda que mantenga su Navegador Web actualizado.";
				if(get_parameter('MAIL_SYSTEM_FUNCTION') == 'ON')
					enviar_mail($email,$nombre,'no-responder@utalca.cl','CITRA - EVE System','Su Cuenta de Usuario en EVE',$BODY,$BODY);
			}
			bitacora("Ingreso de Usuario. Nombre: $nombre");
			echo 1;
			return;
		}
		else{
			echo 'Error SQL';
			return;
		}
		
	}
	else if($ACCION == 'del'){
		$ID = $_GET['id'];
		
		$SQL = "SELECT nombre FROM usuario WHERE id='$ID'";
		
		$request_usuario = consulta_sql($SQL);
		
		$datos_usuario = mysqli_fetch_array($request_usuario);
		
		$SQL = "DELETE FROM usuario WHERE id=$ID";
		
		if(comando_sql($SQL) > 0){
			bitacora("Eliminaci&oacute;n de Usuario: Nombre ".$datos_usuario[0]);
			echo 1;
			return;
		}
		else{
			echo "Error SQL";
			return;
		}
		
		
	}else if($ACCION == 'tabla'){
	
		$QUERY = $_GET['query'];
	
		$SQL = "SELECT usuario.id, usuario.nombre, email, rut, eve_sistema.nombre 
			FROM usuario, eve_sistema 
			WHERE usuario.sistema=eve_sistema.id 
			ORDER BY usuario.nombre LIMIT 50";
		if($QUERY == ''){
			$SQL = "SELECT usuario.id, usuario.nombre, email, rut, eve_sistema.nombre 
				FROM usuario, eve_sistema 
				WHERE usuario.sistema=eve_sistema.id 
				ORDER BY usuario.nombre LIMIT 50";
		}
		else{
			$QUERY2 = explode(" ",$QUERY);
			if(count($QUERY2) == 1){
				$SQL = "SELECT usuario.id, usuario.nombre, email, rut, eve_sistema.nombre 
					FROM usuario, eve_sistema 
					WHERE usuario.sistema=eve_sistema.id 
					AND usuario.nombre LIKE '%$QUERY%' 
					ORDER BY usuario.nombre LIMIT 50";
			}
			else{
				$SQL = "SELECT 	usuario.id, usuario.nombre, email, rut, eve_sistema.nombre 
					FROM 	usuario,eve_sistema 
					WHERE  	usuario.sistema=eve_sistema.id
					AND 	MATCH(usuario.nombre) AGAINST('$QUERY')  
					ORDER BY usuario.nombre LIMIT 50";
			}
		}
		$request_usuario = consulta_sql($SQL);
		//$HTML = $SQL;
		$HTML = "<table id='t1' class='table table-hover dataTable no-footer' role='grid'>";
		$HTML.="<thead>";
		$HTML.="<tr>";
		$HTML.="<th class='top' scope='col'>RUT</td>";
		$HTML.="<th class='top' scope='col'>Nombre</td>";
		$HTML.="<th class='top' scope='col'>Sistema</td>";
		$HTML.="<th class='top' scope='col'>Editar</td>";
		$HTML.="<th class='top' scope='col'>Borrar</td>";
		$HTML.="</tr>";
		$HTML.="<tbody>";
		while($datos_usuario = mysqli_fetch_array($request_usuario)){
			$HTML.="<tr id='userrow_".$datos_usuario[0]."'>";
			$HTML.="<td>".$datos_usuario[3]."</td>";
			$HTML.="<td><a href='mailto:".$datos_usuario[2]."'>".$datos_usuario[1]."</a></td>";
			$HTML.="<td>".$datos_usuario[4]."</td>";
			$HTML.="<td><input type=\"button\" class=\"btn btn-primary\" value='Editar' onclick=\"editUser('".$datos_usuario[0]."')\"/></td>";
			$HTML.="<td><input type=\"button\" class=\"btn btn-danger\" value='Borrar' onclick=\"delUser('".$datos_usuario[0]."')\"/></td>";
			$HTML.="</tr>";
		}
		$HTML.= "</tbody>";
		$HTML.= "</table>";
		echo $HTML;
		return;
	}else if($ACCION == 'tabla_todos'){
	
		$SQL = "SELECT usuario.id, usuario.nombre, email, rut, eve_sistema.nombre, telefono_movil, ultimo_ingreso 
			FROM usuario, eve_sistema 
			WHERE usuario.sistema=eve_sistema.id 
			ORDER BY usuario.nombre";
		
		$request_usuario = consulta_sql($SQL);
		//$HTML = $SQL;
		$HTML .= "<table style='width: 90%; border-collapse: collapse; border: 1px solid #000;'>";
		$HTML.="<tbody>";
		$HTML.="<tr style='border-collapse: collapse; border: 1px solid #000;'>";
		$HTML.="<th style='border-collapse: collapse; border: 1px solid #000;' class='top' scope='col'>RUT</td>";
		$HTML.="<th style='border-collapse: collapse; border: 1px solid #000;' class='top' scope='col'>Nombre</td>";
		$HTML.="<th style='border-collapse: collapse; border: 1px solid #000;' class='top' scope='col'>Correo</td>";
		$HTML.="<th style='border-collapse: collapse; border: 1px solid #000;' class='top' scope='col'>Sistema</td>";
		$HTML.="<th style='border-collapse: collapse; border: 1px solid #000;' class='top' scope='col'>M&oacute;vil</td>";
		$HTML.="<th style='border-collapse: collapse; border: 1px solid #000;' class='top' scope='col'>&Uacute;. Ingreso</td>";
		$HTML.="</tr>";
		while($datos_usuario = mysqli_fetch_array($request_usuario)){
			$HTML.="<tr style='border-collapse: collapse; border: 1px solid #000;' id='userrow_".$datos_usuario[0]."'>";
			$HTML.="<td style='border-collapse: collapse; border: 1px solid #000;'>".$datos_usuario[3]."</td>";
			$HTML.="<td style='border-collapse: collapse; border: 1px solid #000;'>".$datos_usuario[1]."</td>";
			$HTML.="<td style='border-collapse: collapse; border: 1px solid #000;'>".$datos_usuario[2]."</td>";
			$HTML.="<td style='border-collapse: collapse; border: 1px solid #000;'>".$datos_usuario[4]."</td>";
			$HTML.="<td style='border-collapse: collapse; border: 1px solid #000;'>".$datos_usuario[5]."</td>";
			$HTML.="<td style='border-collapse: collapse; border: 1px solid #000;'>".$datos_usuario[6]."</td>";
			$HTML.="</tr>";
		}
		$HTML.= "</tbody>";
		$HTML.= "</table>";
		echo $HTML;
		return;
	}
	elseif($ACCION == 'update'){
		$userid = $_GET['userid'];
		$nombre	= $_GET['nombre'];
		$rut	= $_GET['rut'];
		$email	= $_GET['email'];
		$movil	= $_GET['movil'];
		$enviar	= $_GET['enviarporemail'];
		$aviso	= $_GET['avisosensor'];
		$admin	= $_GET['adm'];
		$sys	= $_GET['sys'];
		
		$SQL = "SELECT rut FROM usuario WHERE id=$userid";
		
		$request_usuario = consulta_sql($SQL);
		
		if(mysqli_num_rows($request_usuario) == 0){
			echo 'El id no se encuentra en la base de datos';
			return;
		}
		
		$datos_usuario = mysqli_fetch_array($request_usuario);
		
		if($rut != $datos_usuario['rut']){
			echo 'El id de usuario no coincide con el rut registrado';
			return;
		}
		
		$SQL = "UPDATE usuario SET email='$email', nombre='$nombre', administrador=$admin, aviso_sensor=$aviso, telefono_movil='$movil', sistema=$sys WHERE id=$userid";
		
		if(comando_sql($SQL) > 0){
			bitacora("Actualizaci&oacute;n de Usuario. Nombre: $nombre");
			echo 1;
			return;
		}
		else{
			echo 'Error SQL';
			return;
		}
	}
	elseif($ACCION == 'updatepass'){
		$userid = $_GET['userid'];
		$clave	= $_GET['clave'];
		
		$SQL = "SELECT rut,nombre FROM usuario WHERE id=$userid";
		
		$request_usuario = consulta_sql($SQL);
		
		if(mysqli_num_rows($request_usuario) == 0){
			echo 'El id no se encuentra en la base de datos';
			return;
		}
		
		$datos_usuario = mysqli_fetch_array($request_usuario);
		$nombre = $datos_usuario[1];
		
		$clavemd5 = md5($clave);
		
		$SQL = "UPDATE `usuario` SET `clave`='$clavemd5' WHERE id=$userid";
		
		if(comando_sql($SQL) > 0){
			bitacora("Actualizaci&oacute;n de Contrase&ntilde;a de Usuario. Nombre: $nombre");
			echo 1;
			return;
		}
		else{
			echo 'Error SQL';
			return;
		}
	}
	else{
		echo 0;
	}
	
?>