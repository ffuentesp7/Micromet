<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	check_admin($_SESSION['session_nombre_sesion']);

	$ACCION = $_GET['accion'];
	
	if($ACCION == "add"){
		$titulo 	= $_REQUEST['titulo'];
		$contenido 	= $_REQUEST['contenido'];
		$sistema	= $_REQUEST['sistema'];
		$fecha		= $_REQUEST['fecha'];
		$hora		= $_REQUEST['hora'];
		
		$SQL = "INSERT INTO `eve_blog` (`usuario_id`, `fecha`, `hora`, `titulo`, `contenido`, `sistema`) 
			VALUES (".get_user_id().", '$fecha', '$hora', '$titulo', '$contenido', $sistema)";
		
		if(comando_sql($SQL) > 0){
			bitacora("Ingreso de Entrada al Blog. Titulo: $titulo");
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
	
		$SQL = "SELECT 	eve_blog.id, 
				usuario_id, 
				fecha, 
				hora, 
				titulo, 
				contenido, 
				eve_sistema.nombre, 
				usuario.nombre
			FROM 	eve_blog, 
				eve_sistema, 
				usuario 
			WHERE 	eve_blog.sistema = eve_sistema.id 
			AND 	eve_blog.usuario_id = usuario.id 
			ORDER BY fecha DESC 
			LIMIT 30";
		if($QUERY != ''){
			$SQL = "SELECT 	eve_blog.id, 
					usuario_id, 
					fecha, 
					hora, 
					titulo, 
					contenido,
					eve_sistema.nombre, 
					usuario.nombre 
				FROM 	eve_blog, 
					eve_sistema, 
					usuario 
				WHERE 	eve_blog.sistema = eve_sistema.id 
				AND 	fecha <= '$QUERY' 
				AND 	eve_blog.usuario_id = usuario.id 
				ORDER BY fecha DESC 
				LIMIT 30";
		}
		$request_blog = consulta_sql($SQL);
		//$HTML = $SQL;
		$HTML = "<table style='width: 90%;'>";
		$HTML.="<tbody>";
		$HTML.="<tr>";
		$HTML.="<th class='top' scope='col'>T&iacute;tulo</th>";
		$HTML.="<th class='top' scope='col'>Autor</th>";
		$HTML.="<th class='top' scope='col'>Sistema</th>";
		$HTML.="<th class='top' scope='col'>Fecha</th>";
		$HTML.="<th class='top' scope='col'>Borrar</th>";
		$HTML.="</tr>";
		while($datos_blog = mysqli_fetch_array($request_blog)){
			$HTML.="<tr id='sysrow_".$datos_blog[0]."'>";
			$HTML.="<td><a onclick=\"editEntry('".$datos_blog[0]."')\" href='#'>".$datos_blog[4]."</a></td>";
			$HTML.="<td><p>".$datos_blog[7]."</p></td>";
			$HTML.="<td><p>".$datos_blog[6]."</p></td>";
			$HTML.="<td><p>".cambia_fecha_a_normal($datos_blog[2])."</p></td>";
			$HTML.="<td><input type=\"button\" class=\"button\" value='Borrar' onclick=\"delEntry('".$datos_blog[0]."')\"/></td>";
			$HTML.="</tr>";
		}
		$HTML.= "</tbody>";
		$HTML.= "</table>";
		echo $HTML;
		return;
	}
	elseif($ACCION == "del"){
		$ID = $_GET['id'];
		
		$SQL = "SELECT titulo FROM eve_blog WHERE id=$ID";
		
		$request_blog = consulta_sql($SQL);
		
		$datos_blog = mysqli_fetch_array($request_blog);
		
		$titulo = $datos_blog[0];
		
		$SQL = "DELETE FROM eve_blog WHERE id=$ID";
		
		if(comando_sql($SQL) > 0){
			bitacora("Eliminaci&oacute;n de Entrada de Blog. Nombre: $titulo");
			echo 1;
			return;
		}
		else{
			echo "Error SQL";
			return;
		}
	}
	elseif($ACCION == "update"){
		$titulo 	= $_REQUEST['titulo'];
		$contenido 	= $_REQUEST['contenido'];
		$sistema	= $_REQUEST['sistema'];
		$fecha		= $_REQUEST['fecha'];
		$hora		= $_REQUEST['hora'];
		$enid		= $_REQUEST['enid'];
		$usid		= $_REQUEST['usid'];
		
		$SQL = "SELECT * FROM eve_blog WHERE id=$enid";
		
		$request_blog = consulta_sql($SQL);
		
		if(mysqli_num_rows($request_blog) == 0){
			echo 'El id no se encuentra registrado';
			return;
		}		
		
		$SQL = "UPDATE 	`eve_blog` 
			SET 	`usuario_id` = $usid, 
				`fecha` = '$fecha', 
				`hora` = '$hora', 
				`titulo` = '$titulo', 
				`contenido` = '$contenido', 
				`sistema` = $sistema 
			WHERE 	id = $enid";
		
		if(comando_sql($SQL) > 0){
			bitacora("Actualizacion de Entrada de Blog. ID: $enid");
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