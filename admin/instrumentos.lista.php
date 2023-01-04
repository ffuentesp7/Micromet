<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	check_admin($_SESSION['session_nombre_sesion']);
?>
<html>
	<head>
		<TITLE>Seleccione un Instrumento</TITLE>
		<style>
			body {
				font: 70%/1.5em Verdana, Tahoma, arial, sans-serif;
				background:#DDDDDD;
				color: #7AB63A;
			}
			a {
				color: #17690C;
				text-decoration: none;
			}
			a:hover{
				color: #98E149;
				text-decoration: none;
			}
			table.content{
				width: 680px;
				height: auto;
				margin: 0px auto 0px auto;
				background: #FAFAFA;
			}
			input.search {
				width: 300px;
			}
			
		</style>
	</head>
	<body>
		<table class="content">
			<tr>	
				<td style="border-bottom: 2px #7AB63A solid;"><p><b>Nombre: </b></p></td>
				<form method="GET" action="instrumentos.lista.php">
				<input type="hidden" name="sid" value="<?=$_SESSION['session_nombre_sesion']?>"/>
				<td style="border-bottom: 2px #7AB63A solid;"><input class="search" type="text" name="buscar"/></td>
				<td style="border-bottom: 2px #7AB63A solid;"><input type="submit" value="Buscar"/></td>
				</form>
			</tr>
			<?php
			$qry = "SELECT instrumento.id,instrumento.modelo,estacion.nombre FROM instrumento,estacion WHERE instrumento.estacion_id=estacion.id ORDER BY nombre";
			if(isset($_GET['buscar'])){
				//$_GET['buscar'] .= ' ';
				$busqueda = explode(" ",$_GET['buscar']);
							
				if(count($busqueda) == 1)
					$qry = "SELECT instrumento.id,instrumento.modelo,estacion.nombre FROM instrumento,estacion WHERE estacion.nombre LIKE '%".$_GET['buscar']."%' AND instrumento.estacion_id=estacion.id ORDER BY estacion.nombre, instrumento.modelo";
				else
					$qry = "SELECT instrumento.id,instrumento.modelo,estacion.nombre FROM instrumento,estacion WHERE AND MATCH(estacion.nombre) AGAINST('".$_GET['buscar']."') AND instrumento.estacion_id=estacion.id ORDER BY estacion.nombre, instrumento.modelo";
				
			}
			$resultado = consulta_sql($qry);
			
			$HTML="";
			while($datos = mysqli_fetch_array($resultado)){
				$HTML.= '<tr>';
				$HTML.= '<td colspan="3">';
				if(isset($_GET['class']) && $_GET['class']=='ownpermission'){
					$HTML.= '<a title="Seleccionar este instrumento" href="#" onclick="javascript:self.parent.setDataStationForAddPermission(\''.$datos["nombre"].'\',\''.$datos["id"].'\');">'.$datos["nombre"].'</a></td>';
				}
				elseif(isset($_GET['class']) && $_GET['class']=='stationsetdata'){
					$HTML.= '<a title="Seleccionar este instrumento" href="#" onclick="javascript:self.parent.setLabelsFromStationForGetStatus(\''.$datos["nombre"].'\',\''.$datos["id"].'\');">'.$datos["nombre"].'</a></td>';
				}
				else{
					$HTML.= '<a title="Seleccionar este instrumento" href="#" onclick="javascript:self.parent.setInstrumentNameAndId(\''.$datos[2].' - '.$datos[1].'\',\''.$datos[0].'\');">'.$datos[2].' - '.$datos[1].'</a></td>';
				}
				$HTML.= '</tr>';
			}
			echo $HTML;
			?>
		</table>
	</body>

</html>