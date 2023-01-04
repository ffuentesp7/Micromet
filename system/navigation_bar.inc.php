<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css">

<nav class="navbar navbar-expand-sm navbar-dark bg-success">
	<div class="container-fluid">
		<div class="collapse navbar-collapse" id="navbarScroll">
			<button class="btn btn-secondary btn-back" id="menu-toggle"><i class="fa fa-chevron-left"></i></button>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
				<li class="nav-item dropdown">

					<!-- Navigation item -->
					<a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">Datos Sensores últimos 30 días
						<!--[if IE 7]><!-->
					</a>
					<!--<![endif]-->
					<!--[if lte IE 6]><table><tr><td><![endif]-->
					<ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
						<?php
						$SQL = "SELECT DISTINCT tipo_instrumento.nombre,tipo_instrumento.code,tipo_instrumento.id
						FROM instrumento,tipo_instrumento
						WHERE tipo_instrumento_id=tipo_instrumento.id
						AND tipo_instrumento.code <> 'SOLARCELL'
						AND tipo_instrumento.code <> 'BATT'";

						$result_tipo_instrumento = consulta_sql($SQL);
						$HTML = "";


						while ($datos_tipo_instrumento = mysqli_fetch_array($result_tipo_instrumento)) {
							$HTML .= "<li><a class='dropdown-item' href='../system/instrumento.php?sid=" . $_SESSION['session_nombre_sesion'] . "&tipo=" . $datos_tipo_instrumento[1] . "&tiid=" . $datos_tipo_instrumento[2] . "&page=ti'>";
							$HTML .= "<img class='leftnoborder' src='../img/sensorsicons/" . $datos_tipo_instrumento[1] . ".png'/> ";
							$HTML .= $datos_tipo_instrumento[0] . "</a></li>";
						}
						if ($HTML == '')
							$HTML = "<li><a class='dropdown-item'>No Existen Sensores</a></li>";

						echo $HTML;
						?>
					</ul>
					<!--[if lte IE 6]></td></tr></table></a><![endif]-->
				</li>

				<!-- Navigation item -->
				<?php
				if (get_user_permission($_SESSION['session_usuario_id'], 'LOADING_DATA_ACCESS') == '1') {
				?>
					<ul>
						<li><a href="#">Sensores (Otros)
								<!--[if IE 7]><!-->
							</a>
							<!--<![endif]-->
							<!--[if lte IE 6]><table><tr><td><![endif]-->
							<ul>

								<li><a href="#"><img class="leftnoborder" src="../img/footpanel/plugin.png" />Cargar Datos</a></li>

							</ul>
							<!--[if lte IE 6]></td></tr></table></a><![endif]-->
						</li>
					</ul>
				<?php
				}
				?>
				<!-- Navigation item -->

				<li class="nav-item dropdown"><a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown2" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">Datos Modelos últimos 30 días
						<!--[if IE 7]><!-->
					</a>
					<!--<![endif]-->
					<!--[if lte IE 6]><table><tr><td><![endif]-->
					<ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown2">
						<?php
						include_once('functions/models.classification.php');
						include_once('functions/statistic.functions.php');

						$MODELOS_AUTORIZADOS = getActiveStationModels();

						$SQL = "SELECT DISTINCT tipo_modelo.nombre,tipo_modelo.id,tipo_modelo.descripcion
					FROM tipo_modelo,estacion,estacion_has_modelo
					WHERE estacion.id=estacion_has_modelo.id_estacion
					AND estacion_has_modelo.id_tipo_modelo=tipo_modelo.id";

						$result_modelos = consulta_sql($SQL);

						$HTML = '';

						while ($datos_modelos = mysqli_fetch_array($result_modelos)) {
							for ($i = 0; $i < count($MODELOS_AUTORIZADOS); $i++) {

								if ($MODELOS_AUTORIZADOS[$i][0] == $datos_modelos[1] && "NULL" != get_user_permission($_SESSION['session_usuario_id'], "STATION_MODEL_" . strtoupper(str_replace(" ", "_", $MODELOS_AUTORIZADOS[$i][1])))) {
									$HTML .= '<li>';
									$HTML .= '<a class="dropdown-item" href="../system/modelo.php?sid=' . $_SESSION['session_nombre_sesion'] . '&page=tmd&tmd=STATION&mid=' . $datos_modelos[1] . '&mnm=' . $datos_modelos[0] . '" title="' . $datos_modelos[0] . '">';
									$HTML .= '<img class="leftnoborder" src="../img/footpanel/function.png"/> ';
									$HTML .= $datos_modelos[2];
									$HTML .= '</a>';
									$HTML .= '</li>';
									break;
								}
							}
						}

						$SQL = "SELECT DISTINCT tipo_modelo.nombre,tipo_modelo.id,tipo_modelo.descripcion
					FROM tipo_modelo,instrumento,instrumento_has_modelo
					WHERE instrumento.id=instrumento_has_modelo.instrumento_id
					AND instrumento_has_modelo.tipo_modelo_id=tipo_modelo.id";

						$result_modelos = consulta_sql($SQL);

						while ($datos_modelos = mysqli_fetch_array($result_modelos)) {
							$HTML .= '<li>';
							$HTML .= '<a class="dropdown-item" href="../system/modelo.php?sid=' . $_SESSION['session_nombre_sesion'] . '&page=tmd&tmd=SENSOR&mid=' . $datos_modelos[1] . '&mnm=' . $datos_modelos[0] . '" title="' . $datos_modelos[0] . '">';
							$HTML .= '<img class="leftnoborder" src="../img/footpanel/function.png"/> ';
							$HTML .= $datos_modelos[2];
							$HTML .= '</a>';
							$HTML .= '</li>';
						}

						if ($HTML == '')
							$HTML = '<li><a class="dropdown-item">No Existen Modelos</a></li>';
						echo $HTML;

						/*
				$HTML = '';
				foreach($MODELCLASSIFICATION as $CLASSIFICATIONITEM => $MODELS){
					$HTML.= '<li>';
					$HTML.= '<a href="#">';
					$HTML.= '<img class="leftnoborder" src="../img/footpanel/function.png"/>';
					$HTML.= $CLASSIFICATIONITEM;
					$HTML.= '</a>';
					$HTML.= '</li>';					
				}
				echo $HTML;
				*/
						?>
					</ul>
					<!--[if lte IE 6]></td></tr></table></a><![endif]-->
				</li>

				<!-- Navigation item -->
				<?php
				if (get_user_permission($_SESSION['session_usuario_id'], 'HISTORICAL_DATA_ACCESS') == '1') {
				?>

					<li class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown3" role="button" data-bs-toggle="dropdown" aria-expanded="false" href="#">Datos Hist&oacute;ricos
							<!--[if IE 7]><!-->
						</a>
						<!--<![endif]-->
						<!--[if lte IE 6]><table><tr><td><![endif]-->
						<ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown3">
							<li><a class="dropdown-item" href="../system/historico_estacion.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>"><img class="leftnoborder" src="../img/footpanel/one-station.png" /> Estaci&oacute;n</a></li>
							<li><a class="dropdown-item" href="../system/historico_instrumento.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>"><img class="leftnoborder" src="../img/footpanel/port.png" /> Sensor&#047;Instrumento</a></li>
							<li><a class="dropdown-item" href="../system/historico_modelo.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>"><img class="leftnoborder" src="../img/footpanel/function.png" /> Modelo</a></li>
							<li><a class="dropdown-item" href="#"><img class="leftnoborder" src="../img/footpanel/chart-pie.png" /> Comparativos</a></li>
							<li><a class="dropdown-item" href="../system/descarga.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>"><img class="leftnoborder" src="../img/footpanel/page-excel.png" /> Descarga</a></li>
						</ul>
						<!--[if lte IE 6]></td></tr></table></a><![endif]-->
					</li>

				<?php
				}
				?>
				<!-- Navigation item -->
				<?php
				if (get_user_permission($_SESSION['session_usuario_id'], 'NEWSLETTERS_ACCESS') == '1') {
				?>
					<ul>
						<li><a href="#">Boletines
								<!--[if IE 7]><!-->
							</a>
							<!--<![endif]-->
							<!--[if lte IE 6]><table><tr><td><![endif]-->
							<ul>
								<li><a href="../system/boletines_area_general.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>"><img class="leftnoborder" src="../img/footpanel/page-white-pdf.png" /> General (por &aacute;rea)</a></li>
								<?php
								if (get_user_permission($_SESSION['session_usuario_id'], 'NEWSLETTERS_ACCESS_METEOVID') == '1') {
								?>
									<li><a href="../system/boletines_area_meteovid.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>"><img class="leftnoborder" src="../img/footpanel/page-white-pdf.png" /> Meteovid (por &aacute;rea)</a></li>
								<?php
								}
								?>
							</ul>
							<!--[if lte IE 6]></td></tr></table></a><![endif]-->
						</li>
					</ul>
				<?php
				}
				?>
				<!-- Navigation item -->

				<!-- Navigation item -->
				<?php
				if (get_user_permission($_SESSION['session_usuario_id'], 'TOOLS_ACCESS') == '1') {
				?>
					<ul>
						<li><a href="#">Herramientas
								<!--[if IE 7]><!-->
							</a>
							<!--<![endif]-->
							<!--[if lte IE 6]><table><tr><td><![endif]-->
							<ul>
								<li><a href="../system/llave_adDI.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>"><img class="leftnoborder" src="../img/footpanel/plugin.png" />adDI Key</a></li>
							</ul>
							<!--[if lte IE 6]></td></tr></table></a><![endif]-->
						</li>
					</ul>
				<?php
				}
				?>
				<!-- Navigation item -->
				<li class="nav-item"><a class="nav-link active" href="../index.php?sid=<?= $_SESSION['session_nombre_sesion'] ?>">&#091;Desconectar&#093;
						<!--[if IE 7]><!-->
					</a>
					<!--<![endif]-->
					<!--[if lte IE 6]></a><![endif]-->
				</li>
</nav>

<script>
	$(function() {
		$('[data-toggle="tooltip"]').tooltip();

		$("#menu-toggle").click(function(e) {
			if ($(this).html() === '<i class="fa fa-chevron-right" aria-hidden="true"></i>') {
				e.preventDefault();
				$("#wrapper").toggleClass("toggled");

				$(this).html('<i class="fa fa-chevron-left" aria-hidden="true"></i>');
			} else {
				e.preventDefault();
				$("#wrapper").toggleClass("toggled");

				$(this).html('<i class="fa fa-chevron-right" aria-hidden="true"></i>');
			}
		});

	});
</script>