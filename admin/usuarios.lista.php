<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	check_admin($_SESSION['session_nombre_sesion']);
?>
<html>
	<head>
		<TITLE>Seleccione un Usuario</TITLE>
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
				width: 480px;
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
				<form method="GET" action="usuarios.lista.php">
				<input type="hidden" name="sid" value="<?=$_SESSION['session_nombre_sesion']?>"/>
				<td style="border-bottom: 2px #7AB63A solid;"><input class="search" type="text" name="buscar"/></td>
				<td style="border-bottom: 2px #7AB63A solid;"><input type="submit" value="Buscar"/></td>
				</form>
			</tr>
			<?php
			$qry = "SELECT id,nombre FROM usuario ORDER BY nombre";
			if(isset($_GET['buscar'])){
				//$_GET['buscar'] .= ' ';
				$busqueda = explode(" ",$_GET['buscar']);
							
				if(count($busqueda) == 1)
					$qry = "SELECT id,nombre FROM usuario WHERE nombre LIKE '%".$_GET['buscar']."%' ORDER BY nombre";
				else
					$qry = "SELECT id,nombre FROM usuario WHERE AND MATCH(usuarios.nombre) AGAINST('".$_GET['buscar']."') ORDER BY nombre";
				
			}
			$resultado = consulta_sql($qry);
				while($datos = mysqli_fetch_array($resultado)){
					echo '<tr>';
					echo '<td colspan="3">';
					echo '<a title="Seleccionar este usuario" href="#" onclick="javascript:self.parent.setDataUserForAddPermission(\''.$datos["nombre"].'\',\''.$datos["id"].'\');">'.$datos["nombre"].'</a></td>';
					echo '</tr>';
				}
			?>
		</table>
	</body>

</html>