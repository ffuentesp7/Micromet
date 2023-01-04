<?php
	//require('../aut_verifica.inc.php');
	require('funciones.inc.php');
	
	

	$SQL = "SELECT 	estacion.nombre,
			estacion.id, 
			estacion.ultima_fecha, 
			estacion.ultima_hora
		FROM 	eve_usuario_has_tipo_de_permiso_usuario, 
			eve_tipo_de_permiso_usuario, 
			estacion
		WHERE 	usuario_id=".$_SESSION['session_usuario_id']." 
		AND 	eve_tipo_de_permiso_usuario_id=eve_tipo_de_permiso_usuario.id 
		AND 	eve_tipo_de_permiso_usuario.value=estacion.id  
		ORDER BY estacion.nombre";
	
	$result_estaciones = consulta_sql($SQL);
	
	$HTML = '';

// 	<button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
// 	Home
//   </button>
//   <div class="collapse" id="home-collapse" style="">
// 	<ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
// 	  <li><a href="#" class="link-dark rounded">Overview</a></li>
// 	  <li><a href="#" class="link-dark rounded">Updates</a></li>
// 	  <li><a href="#" class="link-dark rounded">Reports</a></li>
// 	</ul>
//   </div>
// </li>
	
	while($datos_estaciones = mysqli_fetch_array($result_estaciones)){
		$HTML.= '<li>';
		$HTML.= '<a class="btn btn-toggle align-items-center rounded collapsed"  aria-expanded="false" href="javascript:toggleMenu(\'sidebar_station_link_'.$datos_estaciones[1].'\');">';
		$HTML.= '<img class="leftnoborder" src="../img/footpanel/one-station.png"/>';
		$HTML.= $datos_estaciones[0];
		$HTML.= '</a>';
		$HTML.= '<ul style="display:none; list-style-type:none;" class="btn-toggle-nav  fw-normal pb-1 small" id="sidebar_station_link_'.$datos_estaciones[1].'">';
		
		$HTML.= '<li><a class="btn btn-sm align-items-center rounded" href="../system/estacion_ver.php?sid='.$_SESSION["session_nombre_sesion"].'&name='.$datos_estaciones[0].'&eid='.$datos_estaciones[1].'">';
		$HTML.= "<img class='leftnoborder' src='../img/footpanel/one-station.png'/>";
		$HTML.= 'Ver Estaci&oacute;n</a></li>';
		
		$HTML.= '<li><a class="btn btn-sm align-items-center rounded" href="javascript:toggleMenuModel(\'sidebar_model_link_'.$datos_estaciones[1].'\');">';
		$HTML.= "<img class='leftnoborder' src='../img/footpanel/function.png'/>";
		$HTML.= 'Modelos Generales</a>';
		
		$HTML.= '<ul style="display:none;" class="sidebar_model_link" id="sidebar_model_link_'.$datos_estaciones[1].'">';
		
		$SQL3 = "SELECT	nombre,
				descripcion,
				id
			FROM 	tipo_modelo,
				estacion_has_modelo 
			WHERE 	id_tipo_modelo = tipo_modelo.id 
			AND 	id_estacion=".$datos_estaciones[1]."
			ORDER BY nombre";
		
		$result_modelos = consulta_sql($SQL3);
		while($datos_modelos = mysqli_fetch_array($result_modelos)){
			
			if("NULL" != get_user_permission($_SESSION['session_usuario_id'],"STATION_MODEL_".strtoupper(str_replace(" ","_",$datos_modelos[0])))){
				$HTML.= '<li><a class="btn btn-sm align-items-center rounded" href="../system/modelo_ver.php?sid='.$_SESSION["session_nombre_sesion"].'&page=tmd&tmd=STATION&mid='.$datos_modelos[2].'&mnm='.$datos_modelos[0].'&eid='.$datos_estaciones[1].'&ids='.$datos_estaciones[1].'" title="'.$datos_modelos[1].'">';
				$HTML.= "<img class='leftnoborder' src='../img/footpanel/function.png'/>";
				$HTML.= $datos_modelos[0].'</a></li>';
			}
		}
		$HTML.= '</ul></li>';
		$SQL2 = "SELECT instrumento.id,tipo_instrumento.nombre,tipo_instrumento.code,modelo,tipo_instrumento.id
			FROM instrumento,tipo_instrumento,estacion
			WHERE instrumento.estacion_id=estacion.id
			AND instrumento.tipo_instrumento_id=tipo_instrumento.id
			AND estacion.id=".$datos_estaciones[1]."
			AND tipo_instrumento.code <> 'SOLARCELL' 
			AND tipo_instrumento.code <> 'BATT' 
			ORDER BY tipo_instrumento.nombre";
		
		$result_instrumentos = consulta_sql($SQL2);
		while($datos_instrumentos = mysqli_fetch_array($result_instrumentos)){
			$HTML.= '<li><a class="btn btn-sm align-items-center rounded" href="../system/instrumento_ver.php?sid='.$_SESSION["session_nombre_sesion"].'&tipo='.$datos_instrumentos[2].'&eid='.$datos_estaciones[1].'&iid='.$datos_instrumentos[0].'&name='.$datos_instrumentos[3].'&tiid='.$datos_instrumentos[4].'">';
			$HTML.= "<img class='leftnoborder' src='../img/sensorsicons/".$datos_instrumentos[2].".png'/>";
			$HTML.= $datos_instrumentos[1].'</a>';
			
			$SQL3 = "SELECT	nombre,
					descripcion,
					tipo_modelo.id,
					estacion_id,
					instrumento.id
				FROM 	tipo_modelo,
					instrumento_has_modelo,
					instrumento 
				WHERE 	tipo_modelo_id = tipo_modelo.id 
				AND 	instrumento_has_modelo.instrumento_id=instrumento.id 
				AND 	instrumento_id=".$datos_instrumentos[0]." 
				ORDER BY nombre";
		
			$result_modelos = consulta_sql($SQL3);
			
			$close_ul = false;
			if(mysqli_num_rows($result_modelos) > 0){
				$HTML.= "<ul>";
				$close_ul = true;
			}
			
			while($datos_modelos = mysqli_fetch_array($result_modelos)){
				$HTML.= '<li><a class="btn btn-sm align-items-center rounded" href="../system/modelo_ver.php?sid='.$_SESSION["session_nombre_sesion"].'&page=tmd&tmd=SENSOR&mid='.$datos_modelos[2].'&mnm='.$datos_modelos[0].'&ids='.$datos_modelos[4].'-'.$datos_modelos[3].'&eid='.$datos_modelos[3].'" title="'.$datos_modelos[1].'">';
				$HTML.= "<img class='leftnoborder' src='../img/footpanel/function.png'/>";
				$HTML.= $datos_modelos[0].'</a></li>';
			}
			
			if($close_ul)
				$HTML.= "</ul>";
			
			$HTML.= "</li>";
		}
		
		$HTML.= '</ul>';
		$HTML.= '</li>';
	}
	
	if($HTML == '')
		$HTML = '<li><a>No Existen Estaciones</a></li>';
	//echo $HTML;

	$_SESSION['estaciones_string'] = $HTML;
	
?>