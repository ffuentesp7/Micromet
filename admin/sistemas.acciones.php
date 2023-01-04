<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	check_admin($_SESSION['session_nombre_sesion']);

	$ACCION = $_GET['accion'];
	
	if($ACCION == "add"){
		$nombre		= $_GET['nombre'];
		$pag_pri	= $_GET['pag_sys'];
		
		$SQL = "INSERT INTO eve_sistema(nombre, pag_principal) 
			VALUES ( '$nombre', '$pag_pri');";
		
		if(comando_sql($SQL) > 0){
			bitacora("Ingreso de Sistema. Nombre: $nombre");
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
	
		$SQL = "SELECT id, nombre FROM eve_sistema ORDER BY id LIMIT 10";
		if($QUERY == ''){
			$SQL = "SELECT id, nombre FROM eve_sistema ORDER BY id LIMIT 10";
		}
		else{
			$QUERY2 = explode(" ",$QUERY);
			if(count($QUERY2) == 1){
				$SQL = "SELECT id, nombre FROM eve_sistema WHERE nombre LIKE '%$QUERY%' LIMIT 10";
			}
			else{
				$SQL = "SELECT id, nombre FROM eve_sistema WHERE MATCH(nombre) AGAINST('$QUERY') LIMIT 10";
			}
		}
		$request_sistema = consulta_sql($SQL);
		//$HTML = $SQL;
		$HTML = "<table style='width: 90%;'>";
		$HTML.="<tbody>";
		$HTML.="<tr>";
		$HTML.="<th class='top' scope='col'>ID</th>";
		$HTML.="<th class='top' scope='col'>Nombre</th>";
		$HTML.="<th class='top' scope='col'>Editar</th>";
		$HTML.="<th class='top' scope='col'>Borrar</th>";
		$HTML.="</tr>";
		while($datos_sistema = mysqli_fetch_array($request_sistema)){
			$HTML.="<tr id='sysrow_".$datos_sistema['id']."'>";
			$HTML.="<td><p>".$datos_sistema['id']."</p></td>";
			$HTML.="<td><p>".$datos_sistema['nombre']."</p></td>";
			$HTML.="<td><input type=\"button\" class=\"button\" value='Editar' onclick=\"editSys('".$datos_sistema['id']."')\"/></td>";
			$HTML.="<td><input type=\"button\" class=\"button\" value='Borrar' onclick=\"delSys('".$datos_sistema['id']."')\"/></td>";
			$HTML.="</tr>";
		}
		$HTML.= "</tbody>";
		$HTML.= "</table>";
		echo $HTML;
		return;
	}
	elseif($ACCION == "del"){
		$ID = $_GET['id'];
		
		$SQL = "SELECT nombre FROM eve_sistema WHERE id=$ID";
		
		$request_sistema = consulta_sql($SQL);
		
		$datos_sistema = mysqli_fetch_array($request_sistema);
		
		$nombre = $datos_sistema[0];
		
		
		$SQL = "DELETE FROM eve_sistema WHERE id=$ID";
		
		if(comando_sql($SQL) > 0){
			bitacora("Eliminaci&oacute;n de Sistema. Nombre: $nombre");
			echo 1;
			return;
		}
		else{
			echo "Error SQL";
			return;
		}
	}
	elseif($ACCION == "update"){
		$sysid 		= $_GET['sysid'];
		$nombre		= $_GET['nombre'];
		$pag_pri	= $_GET['pag_sys'];
		
		$SQL = "SELECT * FROM eve_sistema WHERE id=$sysid";
		
		$request_sistema = consulta_sql($SQL);
		
		if(mysqli_num_rows($request_sistema) == 0){
			echo 'El id no se encuentra registrado';
			return;
		}		
		
		$SQL = "UPDATE `eve_sistema` SET `nombre`='$nombre', `pag_principal`= '$pag_pri' WHERE id=$sysid";
		
		if(comando_sql($SQL) > 0){
			bitacora("Actualizacion de Sistema. Nombre: $nombre");
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