<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	check_admin($_SESSION['session_nombre_sesion']);

	$ACCION = $_GET['accion'];
	
	if($ACCION == "addusertype"){
		$nombre = $_GET['nombre']; 
		$codigo = $_GET['codigo'];
		$valor  = $_GET['valor'];
		
		$SQL = "SELECT id FROM `eve_tipo_de_permiso_usuario` WHERE nombre='$nombre' OR code='$codigo'";
		$request_tipo_de_permiso_usuario = consulta_sql($SQL);
		
		if(mysqli_num_rows($request_tipo_de_permiso_usuario) > 0){
			echo 'El codigo o el nombre ya se encuentra registrado';
			return;
		}
		
		$SQL = "INSERT INTO `eve_tipo_de_permiso_usuario` (`nombre`, `code`, `value`) VALUES ( '$nombre', '$codigo', '$valor');";
		
		if(comando_sql($SQL) > 0){
			echo 1;
			bitacora("Ingreso de Tipo de Permiso para Usuario. Nombre: $nombre");
			exit;
		}
		else{
			echo 'Error SQL';
			exit;
		}
		
	}
	if($ACCION == "addstationtype"){
		$nombre = $_GET['nombre']; 
		$codigo = $_GET['codigo'];
		$valor  = $_GET['valor'];
		
		$SQL = "SELECT id FROM `eve_tipo_de_permiso_estacion` WHERE nombre='$nombre' OR code='$codigo'";
		$request_tipo_de_permiso_usuario = consulta_sql($SQL);
		
		if(mysqli_num_rows($request_tipo_de_permiso_usuario) > 0){
			echo 'El codigo o el nombre ya se encuentra registrado';
			return;
		}
		
		$SQL = "INSERT INTO `eve_tipo_de_permiso_estacion` (`nombre`, `code`, `value`) VALUES ( '$nombre', '$codigo', '$valor');";
		
		if(comando_sql($SQL) > 0){
			echo 1;
			bitacora("Ingreso de Tipo de Permiso para Estaci&oacute;n. Nombre: $nombre");
			exit;
		}
		else{
			echo 'Error SQL';
			exit;
		}
		
	}
	elseif($ACCION == "updatetype"){
		$nombre = $_GET['nombre']; 
		$codigo = $_GET['codigo'];
		$valor  = $_GET['valor'];
		$tipo	= $_GET['tipo'];
		$id	= $_GET['id'];
		
		$SQL = "SELECT nombre,code FROM `eve_tipo_de_permiso_$tipo` WHERE id=$id";
		$request_tipo_de_permiso = consulta_sql($SQL);
		
		if(mysqli_num_rows($request_tipo_de_permiso) <= 0){
		
			echo 'El id no existe';
			return;
		}
		$SQL = "UPDATE IGNORE `eve_tipo_de_permiso_$tipo` SET `nombre`='$nombre', `value`='$valor' WHERE id=$id";
		
		if(comando_sql($SQL) > 0){
			echo 1;
			bitacora("Actualizacio&oacute;n de Tipo de Permiso. Nombre: $nombre");
			exit;
		}
		else{
			echo 'Error SQL';
			exit;
		}
		
	}
	elseif($ACCION == "deletetype"){
		$tipo	= $_GET['tipo'];
		$id	= $_GET['id'];
		
		$SQL = "SELECT nombre,code FROM `eve_tipo_de_permiso_$tipo` WHERE id=$id";
		$request_tipo_de_permiso = consulta_sql($SQL);
		
		if(mysqli_num_rows($request_tipo_de_permiso) <= 0){
		
			echo 'El id no existe';
			return;
		}
		$datos_tipo_de_permiso = mysqli_fetch_array($request_tipo_de_permiso);
		
		$SQL = "DELETE FROM `eve_tipo_de_permiso_$tipo` WHERE id=$id";
		
		if(comando_sql($SQL) > 0){
			echo 1;
			bitacora("Borrado de Tipo de Permiso. Nombre: ".$datos_tipo_de_permiso[0]);
			exit;
		}
		else{
			echo 'Error SQL';
			exit;
		}
		
	}
	elseif($ACCION == "see"){
		$tabla = $_GET['tipo'];
		
		$SQL = "SELECT id,nombre,code,value FROM eve_tipo_de_permiso_$tabla ORDER BY nombre";
		
		$result_tipo_de_permiso = consulta_sql($SQL);
		
		$HTML = "<table style='width: 100%;' id='tabla_see' class='table table-hover dataTable no-footer'>";
		$HTML.="<thead>";
		$HTML.="<tr>";
		$HTML.="<th class='top' scope='col'>Nombre</td>";
		$HTML.="<th class='top' scope='col'>C&oacute;digo</td>";
		$HTML.="<th class='top' scope='col'>Valor</td>";
		$HTML.="<th class='top' scope='col'>Editar</td>";
		$HTML.="<th class='top' scope='col'>Borrar</td>";
		$HTML.="</tr>";
		$HTML.="</thead>";
		$HTML.="<tbody>";
		while($datos_tipo_de_permiso = mysqli_fetch_array($result_tipo_de_permiso)){
			$HTML.="<tr id='permisionrow_".$datos_tipo_de_permiso['id']."'>";
			$HTML.="<td class='nada'>".$datos_tipo_de_permiso['nombre']."</td>";
			$HTML.="<td class='nada'>".$datos_tipo_de_permiso['code']."</td>";
			$HTML.="<td class='nada'>".$datos_tipo_de_permiso['value']."</td>";
			$HTML.="<td class='nada'><input type=\"button\" class=\"btn btn-primary\" value='Editar' onclick=\"editPermission('".$datos_tipo_de_permiso['id']."','$tabla')\"/></td>";
			$HTML.="<td class='nada'><input type=\"button\" class=\"btn btn-danger\" value='Borrar' onclick=\"deletePermission('".$datos_tipo_de_permiso['id']."','$tabla')\"/></td>";
			$HTML.="</tr>";
		}
		$HTML.= "</tbody>";
		$HTML.= "</table>";
		echo $HTML;
		return;
	}
	elseif($ACCION == "permisosdenieduser"){
		$id = $_GET['id'];
		
		$SQL = "SELECT eve_tipo_de_permiso_usuario.id,eve_tipo_de_permiso_usuario.nombre,eve_tipo_de_permiso_usuario.code,eve_tipo_de_permiso_usuario.value 
			FROM eve_tipo_de_permiso_usuario
			WHERE eve_tipo_de_permiso_usuario.id<>ALL(
				SELECT eve_tipo_de_permiso_usuario_id 
				FROM eve_usuario_has_tipo_de_permiso_usuario,usuario
				WHERE usuario.id=$id
				AND usuario.id=eve_usuario_has_tipo_de_permiso_usuario.usuario_id
			)";
		
		$result_tipo_de_permiso = consulta_sql($SQL);
		
		$HTML = "";
		while($datos_tipo_de_permiso = mysqli_fetch_array($result_tipo_de_permiso)){
			$HTML.="<option value='".$datos_tipo_de_permiso[0]."' id='type_option_".$datos_tipo_de_permiso[0]."'>".$datos_tipo_de_permiso[2]."</option>";
		}
		echo $HTML;
		exit;
	}
	elseif($ACCION == "permitsissued"){
		$id = $_GET['id'];
		
		$SQL = "SELECT eve_tipo_de_permiso_usuario.id,eve_tipo_de_permiso_usuario.nombre,eve_tipo_de_permiso_usuario.code,eve_tipo_de_permiso_usuario.value 
			FROM eve_tipo_de_permiso_usuario,eve_usuario_has_tipo_de_permiso_usuario,usuario
			WHERE eve_tipo_de_permiso_usuario.id=eve_tipo_de_permiso_usuario_id 
			AND usuario.id=$id
			AND usuario.id=eve_usuario_has_tipo_de_permiso_usuario.usuario_id";
		
		$result_tipo_de_permiso = consulta_sql($SQL);
		
		$HTML = "<tbody id='body_tabla_permisos_otorgados'>";
		while($datos_tipo_de_permiso = mysqli_fetch_array($result_tipo_de_permiso)){
			$HTML.="<tr id='permitsissuedrow_".$datos_tipo_de_permiso[0]."' class='permitsissuedrow'>";
			$HTML.="<td class='nada'>".$datos_tipo_de_permiso[1]."</td>";
			$HTML.="<td class='nada' id='permitsissuedrow_code_".$datos_tipo_de_permiso[0]."'>".$datos_tipo_de_permiso[2]."</td>";
			$HTML.="<td class='nada'>".$datos_tipo_de_permiso[3]."</td>";
			$HTML.="<td class='nada'><input type=\"button\" class=\"btn btn-danger\" onclick='removeUserPermission(".$datos_tipo_de_permiso[0].",$id)' value='Quitar'/></td>";
			$HTML.="</tr>";
		}
		$HTML .= "</tbody>";
		echo $HTML;
		exit;
	}
	elseif($ACCION == "giveuserpermission"){
		$pid = $_GET['pid'];
		$uid = $_GET['uid'];
		
		$SQL = "SELECT eve_tipo_de_permiso_usuario.id,eve_tipo_de_permiso_usuario.nombre,eve_tipo_de_permiso_usuario.code,eve_tipo_de_permiso_usuario.value 
			FROM eve_tipo_de_permiso_usuario
			WHERE eve_tipo_de_permiso_usuario.id=$pid";
		
		$result_tipo_de_permiso = consulta_sql($SQL);
		
		$HTML = "<tbody id='body_tabla_permisos_otorgados'>";
		if($datos_tipo_de_permiso = mysqli_fetch_array($result_tipo_de_permiso)){
			$HTML.="<tr id='permitsissuedrow_".$datos_tipo_de_permiso[0]."' class='permitsissuedrow'>";
			$HTML.="<td class='nada'>".$datos_tipo_de_permiso[1]."</td>";
			$HTML.="<td class='nada'>".$datos_tipo_de_permiso[2]."</td>";
			$HTML.="<td class='nada'>".$datos_tipo_de_permiso[3]."</td>";
			$HTML.="<td class='nada'><input type=\"button\" class=\"btn btn-danger\" onclick='removeUserPermission($pid,$uid)' value='Quitar'/></td>";
			$HTML.="</tr>";
			
			$SQL = "INSERT INTO `eve_usuario_has_tipo_de_permiso_usuario` (`usuario_id`, `eve_tipo_de_permiso_usuario_id`) VALUES ($uid,$pid)";
			
			if(comando_sql($SQL) > 0){
				$HTML .= "</tbody>";
				echo $HTML;
				exit;
			}
			else{
				$HTML="<tr class='permitsissuedrow'>";
				$HTML.="<td colspan='4' class='nada'>Error SQL</td>";
				$HTML.="</tr>";
				$HTML .= "</tbody>";
				echo $HTML;
				exit;
			}
			
		}
	}
	elseif($ACCION == "removeuserpermission"){
		$pid	= $_GET['pid'];
		$uid	= $_GET['uid'];
		
		$SQL = "DELETE FROM `eve_usuario_has_tipo_de_permiso_usuario` WHERE usuario_id=$uid AND eve_tipo_de_permiso_usuario_id=$pid";
		
		if(comando_sql($SQL) > 0){
			echo 1;
			exit;
		}
		else{
			echo 'Error SQL';
			exit;
		}
		
	}
	elseif($ACCION == "permisosdeniedstation"){
		$id = $_GET['id'];
		
		$SQL = "SELECT eve_tipo_de_permiso_estacion.id,eve_tipo_de_permiso_estacion.nombre,eve_tipo_de_permiso_estacion.code,eve_tipo_de_permiso_estacion.value 
			FROM eve_tipo_de_permiso_estacion
			WHERE eve_tipo_de_permiso_estacion.id<>ALL(
				SELECT eve_tipo_de_permiso_estacion_id 
				FROM eve_estacion_has_tipo_de_permiso_estacion,estacion
				WHERE estacion.id=$id
				AND estacion.id=eve_estacion_has_tipo_de_permiso_estacion.estacion_id
			)";
		
		$result_tipo_de_permiso = consulta_sql($SQL);
		
		$HTML = "";
		while($datos_tipo_de_permiso = mysqli_fetch_array($result_tipo_de_permiso)){
			$HTML.="<option value='".$datos_tipo_de_permiso[0]."' id='type_option_".$datos_tipo_de_permiso[0]."'>".$datos_tipo_de_permiso[2]."</option>";
		}
		echo $HTML;
		exit;
	}
	elseif($ACCION == "permitsissuedstation"){
		$id = $_GET['id'];
		
		$SQL = "SELECT eve_tipo_de_permiso_estacion.id,eve_tipo_de_permiso_estacion.nombre,eve_tipo_de_permiso_estacion.code,eve_tipo_de_permiso_estacion.value 
			FROM eve_tipo_de_permiso_estacion,eve_estacion_has_tipo_de_permiso_estacion,estacion
			WHERE eve_tipo_de_permiso_estacion.id=eve_tipo_de_permiso_estacion_id 
			AND estacion.id=$id
			AND estacion.id=eve_estacion_has_tipo_de_permiso_estacion.estacion_id";
		
		$result_tipo_de_permiso = consulta_sql($SQL);
		
		$HTML = "";
		while($datos_tipo_de_permiso = mysqli_fetch_array($result_tipo_de_permiso)){
			$HTML.="<tr id='permitsissuedrow_".$datos_tipo_de_permiso[0]."' class='permitsissuedrow'>";
			$HTML.="<td class='nada'>".$datos_tipo_de_permiso[1]."</td>";
			$HTML.="<td class='nada' id='permitsissuedrow_code_".$datos_tipo_de_permiso[0]."'>".$datos_tipo_de_permiso[2]."</td>";
			$HTML.="<td class='nada'>".$datos_tipo_de_permiso[3]."</td>";
			$HTML.="<td class='nada'><input type=\"button\" class=\"btn btn-danger\" onclick='removeStationPermission(".$datos_tipo_de_permiso[0].",$id)' value='Quitar'/></td>";
			$HTML.="</tr>";
		}
		echo $HTML;
		exit;
	}
	elseif($ACCION == "givestationpermission"){
		$pid = $_GET['pid'];
		$uid = $_GET['uid'];
		
		$SQL = "SELECT eve_tipo_de_permiso_estacion.id,eve_tipo_de_permiso_estacion.nombre,eve_tipo_de_permiso_estacion.code,eve_tipo_de_permiso_estacion.value 
			FROM eve_tipo_de_permiso_estacion
			WHERE eve_tipo_de_permiso_estacion.id=$pid";
		
		$result_tipo_de_permiso = consulta_sql($SQL);
		
		$HTML = "";
		if($datos_tipo_de_permiso = mysqli_fetch_array($result_tipo_de_permiso)){
			$HTML.="<tr id='permitsissuedrow_".$datos_tipo_de_permiso[0]."' class='permitsissuedrow'>";
			$HTML.="<td class='nada'>".$datos_tipo_de_permiso[1]."</td>";
			$HTML.="<td class='nada'>".$datos_tipo_de_permiso[2]."</td>";
			$HTML.="<td class='nada'>".$datos_tipo_de_permiso[3]."</td>";
			$HTML.="<td class='nada'><input type=\"button\" class=\"btn btn-danger\" onclick='removeStationPermission($pid,$uid)' value='Quitar'/></td>";
			$HTML.="</tr>";
			
			$SQL = "INSERT INTO `eve_estacion_has_tipo_de_permiso_estacion` (`estacion_id`, `eve_tipo_de_permiso_estacion_id`) VALUES ($uid,$pid)";
			
			if(comando_sql($SQL) > 0){
				echo $HTML;
				exit;
			}
			else{
				$HTML="<tr class='permitsissuedrow'>";
				$HTML.="<td colspan='4' class='nada'>Error SQL</td>";
				$HTML.="</tr>";
				echo $HTML;
				exit;
			}
			
		}
	}
	elseif($ACCION == "removestationpermission"){
		$pid	= $_GET['pid'];
		$uid	= $_GET['uid'];
		
		$SQL = "DELETE FROM `eve_estacion_has_tipo_de_permiso_estacion` WHERE estacion_id=$uid AND eve_tipo_de_permiso_estacion_id=$pid";
		
		if(comando_sql($SQL) > 0){
			echo 1;
			exit;
		}
		else{
			echo 'Error SQL';
			exit;
		}
		
	}
	else{
	
	}
?>