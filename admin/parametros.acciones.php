<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	check_admin($_SESSION['session_nombre_sesion']);

	$ACCION = $_GET['accion'];
	
	if($ACCION == "add"){
		$nombre		= $_GET['nombre'];
		$codigo		= $_GET['codigo'];
		$descripcion	= $_GET['descripcion'];
		$valor		= $_GET['valor'];
		
		$SQL = "SELECT id FROM eve_parametro WHERE code='$codigo'";
		
		$request_parametro = consulta_sql($SQL);
		
		if(mysqli_num_rows($request_parametro) > 0){
			echo 'El codigo ya se encuentra registrado';
			return;
		}
		
		$SQL = "INSERT INTO `eve_parametro` (`nombre`, `descripcion`, `code`, `valor`) VALUES ( '$nombre', '$descripcion', '$codigo', '$valor' );";
		
		if(comando_sql($SQL) > 0){
			bitacora("Ingreso de Parametro. C&oacute;digo: $codigo");
			echo 1;
			return;
		}
		else{
			echo 'Error SQL';
			return;
		}
	}
	elseif($ACCION == "tabla"){
		$QUERY = $_GET['query'];
	
		$SQL = "SELECT id, nombre, descripcion, code, valor FROM eve_parametro ORDER BY id DESC";
		if($QUERY == ''){
			$SQL = "SELECT id, nombre, descripcion, code, valor FROM eve_parametro ORDER BY id DESC";
		}
		else{
			$QUERY2 = explode(" ",$QUERY);
			if(count($QUERY2) == 1){
				$SQL = "SELECT id, nombre, descripcion, code, valor FROM eve_parametro WHERE nombre LIKE '%$QUERY%' LIMIT 10";
			}
			else{
				$SQL = "SELECT id, nombre, descripcion, code, valor FROM eve_parametro WHERE MATCH(nombre) AGAINST('$QUERY') LIMIT 10";
			}
		}
		$request_parametro = consulta_sql($SQL);
		//$HTML = $SQL;
		$HTML = "<table style='width: 90%;'>";
		$HTML.="<tbody>";
		$HTML.="<tr>";
		$HTML.="<th class='top' scope='col'>Nombre</th>";
		$HTML.="<th class='top' scope='col'>C&oacute;digo</th>";
		$HTML.="<th class='top' scope='col'>Valor</th>";
		$HTML.="<th class='top' scope='col'>Editar</th>";
		$HTML.="<th class='top' scope='col'>Borrar</th>";
		$HTML.="</tr>";
		while($datos_parametro = mysqli_fetch_array($request_parametro)){
			$HTML.="<tr id='paramrow_".$datos_parametro['id']."'>";
			$HTML.="<td><a title=\"".$datos_parametro['descripcion']."\">".$datos_parametro['nombre']."</a></td>";
			$HTML.="<td>".wordwrap($datos_parametro['code'], 20, "<br />\n",true)."</td>";
			$HTML.="<td>".wordwrap($datos_parametro['valor'], 18, "<br />\n",true)."</td>";
			$HTML.="<td><input type=\"button\" class=\"button\" value='Editar' onclick=\"editParam('".$datos_parametro['id']."')\"/></td>";
			$HTML.="<td><input type=\"button\" class=\"button\" value='Borrar' onclick=\"delParam('".$datos_parametro['id']."')\"/></td>";
			$HTML.="</tr>";
		}
		$HTML.= "</tbody>";
		$HTML.= "</table>";
		echo $HTML;
		return;
	}
	elseif($ACCION == "del"){
		$ID = $_GET['id'];
		
		$SQL = "SELECT code FROM eve_parametro WHERE code='$codigo'";
		
		$request_parametro = consulta_sql($SQL);
		
		$datos_parametro = mysqli_fetch_array($request_parametro);
		
		$nombre = $datos_parametro[0];
		
		
		$SQL = "DELETE FROM eve_parametro WHERE id=$ID";
		
		if(comando_sql($SQL) > 0){
			bitacora("Eliminaci&oacute;n de Par&aacute;metro. C&oacute;digo: $nombre");
			echo 1;
			return;
		}
		else{
			echo "Error SQL";
			return;
		}
	}
	elseif($ACCION == "update"){
		$paramid 	= $_GET['pid'];
		$nombre		= $_GET['nombre'];
		$codigo		= $_GET['codigo'];
		$descripcion	= $_GET['descripcion'];
		$valor		= $_GET['valor'];
		
		$SQL = "SELECT code FROM eve_parametro WHERE id=$paramid";
		
		$request_parametro = consulta_sql($SQL);
		
		if(mysqli_num_rows($request_parametro) == 0){
			echo 'El id no se encuentra registrado';
			return;
		}		
		
		$SQL = "UPDATE `eve_parametro` SET `nombre`='$nombre', `descripcion`= '$descripcion', `valor`='$valor' WHERE id=$paramid";
		
		if(comando_sql($SQL) > 0){
			bitacora("Actualizacion de Parametro. C&oacute;digo: $codigo");
			echo 1;
			return;
		}
		else{
			echo 'Error SQL';
			return;
		}
	}
	else{
		echo 1;
	}
	
?>