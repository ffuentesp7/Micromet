<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	check_admin($_SESSION['session_nombre_sesion']);

	$ACCION = $_GET['accion'];
	
	if($ACCION == "add"){
	
		$NOMBRE		= $_GET['nombre'];
		$DESCRIPCION	= $_GET['descripcion'];
		
		$SQL = "INSERT INTO `eve_area` (`nombre`, `descripcion`) VALUES ('$NOMBRE' ,'$DESCRIPCION');";
		
		if(comando_sql($SQL) > 0){
			echo 1;
			exit;
		}
		else{
			echo 'Error SQL';
			exit;
		}
	}
	elseif($ACCION == "update"){
	
		$NOMBRE		= $_GET['nombre'];
		$DESCRIPCION	= $_GET['descripcion'];
		$AID		= $_GET['aid'];
		
		$SQL = "UPDATE `eve_area` SET `nombre`='$NOMBRE', `descripcion`='$DESCRIPCION' WHERE id=$AID";
		
		if(comando_sql($SQL) > 0){
			echo 1;
			exit;
		}
		else{
			echo 'Error SQL';
			exit;
		}
	}
	elseif($ACCION == "openall"){
		$SQL = "SELECT id,nombre,descripcion FROM eve_area ORDER BY nombre";
		
		$result_area = consulta_sql($SQL);
		
		$HTML = "<table style='width: 90%;'>";
		$HTML.="<tbody>";
		$HTML.="<tr>";
		$HTML.="<th class='top' scope='col'>ID</td>";
		$HTML.="<th class='top' scope='col'>Nombre</td>";
		$HTML.="<th class='top' scope='col'>Descripcion</td>";
		$HTML.="<th class='top' scope='col'>Ver &bull; Editar</td>";
		$HTML.="<th class='top' scope='col'>Borrar</td>";
		$HTML.="</tr>";
		
		while($datos_area = mysqli_fetch_array($result_area)){
			$HTML.="<tr id='userrow_".$datos_area['id']."'>";
			$HTML.="<td>".$datos_area['id']."</td>";
			$HTML.="<td>".$datos_area['nombre']."</td>";
			$HTML.="<td>".$datos_area['descripcion']."</td>";
			$HTML.="<td><input type=\"button\" class=\"button\" style='width: auto;' value='Ver &bull; Editar' onclick=\"editArea('".$datos_area['id']."')\"/></td>";
			$HTML.="<td><input type=\"button\" class=\"button\" style='width: auto;' value='Borrar' onclick=\"deleteArea('".$datos_area['id']."')\"/></td>";
			$HTML.="</tr>";
		}
		$HTML.= "</tbody>";
		$HTML.= "</table>";
		echo $HTML;
		exit;
	}
	elseif($ACCION == "stationselect"){
	
		$AID = $_GET['aid'];
	
		$SQL = "SELECT 	estacion.id, 
				estacion.nombre 
			FROM 	estacion 
			WHERE 	estacion.id<>ALL(
					SELECT 	estacion_id 
					FROM 	eve_area_has_estacion 
					WHERE 	area_id=$AID) 
			ORDER BY nombre";
		
		$result_area = consulta_sql($SQL);
		
		$HTML = "<select id='select_estaciones' name='select_estaciones' class='combo' style='width: 300px;'>";
		
		while($datos_area = mysqli_fetch_array($result_area)){
			$HTML.="<option id='stationoption_".$datos_area['id']."' value='".$datos_area['id']."'>";
			$HTML.=$datos_area['nombre'];
			$HTML.="</option>";
		}
		$HTML.= "</select>";
		echo $HTML;
		exit;
	}
	elseif($ACCION == "associatedstations"){
	
		$AID = $_GET['aid'];
	
		$SQL = "SELECT	id,
				nombre 
			FROM 	estacion, 
				eve_area_has_estacion 
			WHERE	eve_area_has_estacion.estacion_id=estacion.id
			AND	eve_area_has_estacion.area_id=$AID 
			ORDER BY nombre";
		
		$result_estacion = consulta_sql($SQL);
		
		$HTML = "<table style='width: 90%;'>";
		$HTML.="<tbody>";
		$HTML.="<tr>";
		$HTML.="<th class='top' scope='col'>ID</td>";
		$HTML.="<th class='top' scope='col'>Estacion</td>";
		$HTML.="<th class='top' scope='col'>Quitar</td>";
		$HTML.="</tr>";
		
		while($datos_estacion = mysqli_fetch_array($result_estacion)){
			$HTML.="<tr id='stationrow_".$datos_estacion['id']."'>";
			$HTML.="<td>".$datos_estacion['id']."</td>";
			$HTML.="<td>".$datos_estacion['nombre']."</td>";
			$HTML.="<td><input type=\"button\" class=\"button\" style='width: auto;' value='Quitar' onclick=\"deleteAssociatedStation('".$datos_estacion['id']."')\"/></td>";
			$HTML.="</tr>";
		}
		$HTML.= "</tbody>";
		$HTML.= "</table>";
		echo $HTML;
		exit;
	}
	elseif($ACCION == "linkstation"){
	
		$AID	= $_GET['aid'];
		$EID	= $_GET['eid'];
		
		$SQL = "INSERT INTO `eve_area_has_estacion` (`area_id`, `estacion_id`) VALUES ($AID ,$EID)";
		
		if(comando_sql($SQL) > 0){
			echo 1;
			exit;
		}
		else{
			echo 'Error SQL';
			exit;
		}
	}
	elseif($ACCION == "dellinkstation"){
	
		$AID	= $_GET['aid'];
		$EID	= $_GET['eid'];
		
		$SQL = "DELETE FROM `eve_area_has_estacion` WHERE area_id=$AID AND estacion_id=$EID";
		
		if(comando_sql($SQL) > 0){
			echo 1;
			exit;
		}
		else{
			echo 'Error SQL';
			exit;
		}
	}
	elseif($ACCION == "deletearea"){
	
		$AID	= $_GET['aid'];
		
		$SQL = "DELETE FROM eve_area_has_estacion WHERE area_id=$AID";
		
		comando_sql($SQL);
		
		$SQL = "DELETE FROM eve_area WHERE id=$AID";
		if(comando_sql($SQL) > 0){
			echo 1;
			exit;
		}
		else{
			echo 'Error SQL1';
			exit;
		}
	
	}
?>