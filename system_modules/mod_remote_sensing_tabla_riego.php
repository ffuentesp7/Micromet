<?php
	require_once('../aut_verifica.inc.php');
	require_once('../funciones.inc.php');
	require_once('../antinyeccion.inc.php');
	require_once('Cuartel.class.php');
			
		$eid = $_REQUEST['eid'];
		$fecha = $_REQUEST['fecha'];
		$cid = $_REQUEST['cid'];
		$Kc = $_REQUEST['kc'];
		$CUARTEL = new Cuartel($cid);
		
		$dist_en_ileras = $CUARTEL->dist_en_ileras;
		$dist_so_ileras = $CUARTEL->dist_so_ileras;
		$crit_riego = $CUARTEL->crit_riego;
		$estr1_textura = $CUARTEL->estr1_textura;
		$estr1_grosor = $CUARTEL->estr1_grosor;
		$estr1_cc = $CUARTEL->estr1_cc;
		$estr1_pmp = $CUARTEL->estr1_pmp;	
		$estr2_textura = $CUARTEL->estr2_textura;
		$estr2_grosor = $CUARTEL->estr2_grosor;
		$estr2_cc = $CUARTEL->estr2_cc;
		$estr2_pmp = $CUARTEL->estr2_pmp;
		$estr3_textura = $CUARTEL->estr3_textura;
		$estr3_grosor = $CUARTEL->estr3_grosor;
		$estr3_cc = $CUARTEL->estr3_cc;
		$estr3_pmp = $CUARTEL->estr3_pmp;
		$ancho_moj = $CUARTEL->ancho_moj;
		$caud_emis = $CUARTEL->caud_emis;
		$num_emis_planta = $CUARTEL->num_emis_planta;
		$efis_riego = $CUARTEL->efis_riego;
		$coef_unif = $CUARTEL->coef_unif;
		
			
		//VARIABLES CALCULADAS
		//propiedades del sistema de riego
		
		$area_moj = $ancho_moj*$dist_so_ileras/100.0;
		$area_moj_por_emis = $area_moj;
		$pp_sistema_mm_h = ($num_emis_planta*$caud_emis/$area_moj_por_emis)*$efis_riego*$coef_unif;
		$pp_sistema_l_h = $num_emis_planta*$caud_emis*$efis_riego*$coef_unif;
	
		//propiedades del suelo	
		$estr1_HA = $estr1_cc - $estr1_pmp;
		$estr1_lamina_neta = $estr1_HA/100.0*$estr1_grosor*10.0*$crit_riego/100;
		$estr1_vol_de_suelo = $area_moj*$estr1_grosor/100.0*1000.0;
		$estr2_HA = $estr2_cc - $estr2_pmp;
		$estr2_lamina_neta = $estr2_HA/100.0*$estr2_grosor*10.0*$crit_riego/100;
		$estr2_vol_de_suelo = $area_moj*$estr2_grosor/100.0*1000.0;
		$estr3_HA = $estr2_cc - $estr2_pmp;
		$estr3_lamina_neta = $estr3_HA/100.0*$estr3_grosor*10.0*$crit_riego/100;
		$estr3_vol_de_suelo = $area_moj*$estr3_grosor/100.0*1000.0;
		
		$total_lamina_neta = $estr1_lamina_neta + $estr2_lamina_neta + $estr3_lamina_neta;
		$total_vol_de_suelo = $estr1_vol_de_suelo + $estr2_vol_de_suelo + $estr3_vol_de_suelo;
		
		$vol_agua_disp = $total_vol_de_suelo*$crit_riego/100.0*$estr1_HA/100.0;

		?>	
			<div class="column1-unit">
				<h2 class="block">Variables Calculadas</h2>
				<table id="verde" style="width: auto;">
					<thead>
						<tr>
							<th scope="col" colspan="4" style="text-align:center;">Propiedades del Suelo</th>
							<td class="nada" width="50">&nbsp;</td>
							<th scope="col" colspan="2" style="text-align:center;">Propiedades del Sistema de Riego</th>
						</tr>
						<tr>
							<th scope="col" style="text-align:center;">Estrata</th>
							<th scope="col" style="text-align:center;">HA (&#037;&theta;)</th>
							<th scope="col" style="text-align:center;">L&aacute;mina Neta (mm)</th>
							<th scope="col" style="text-align:center;">Volumen de Suelo (L/planta)</th>
							<td class="nada" width="50">&nbsp;</td>
							<th class="destaca" scope="col" style="text-align:center;">&Aacute;rea de Mojado (m<sup>2</sup>)</th>
							<td style="text-align:center;"><?=number_format($area_moj, 2, '.', '')?></td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td style="text-align:center;">I</td>
							<td style="text-align:center;"><?=$estr1_HA?></td>
							<td style="text-align:center;"><?=$estr1_lamina_neta?></td>
							<td style="text-align:center;"><?=$estr1_vol_de_suelo?></td>
							<td class="nada" width="50">&nbsp;</td>	
							<th class="destaca" scope="col" style="text-align:center;">Precipitaci&oacute;n del Sistema (mm h<sup>-1</sup>)</th>
							<td style="text-align:center;"><?=number_format($pp_sistema_mm_h, 2, '.', '')?></td>
						</tr>
						<tr>
							<td style="text-align:center;">II</td>
							<td style="text-align:center;"><?=$estr2_HA?></td>
							<td style="text-align:center;"><?=$estr2_lamina_neta?></td>
							<td style="text-align:center;"><?=$estr2_vol_de_suelo?></td>
							<td class="nada" width="50">&nbsp;</td>
							<th class="destaca" scope="col" style="text-align:center;">Precipitaci&oacute;n del Sistema (l h<sup>-1</sup>)</th>
							<td style="text-align:center;"><?=number_format($pp_sistema_l_h, 2, '.', '')?></td>
						</tr>
						<tr>
							<td style="text-align:center;">III</td>
							<td style="text-align:center;"><?=$estr3_HA?></td>
							<td style="text-align:center;"><?=$estr3_lamina_neta?></td>
							<td style="text-align:center;"><?=$estr3_vol_de_suelo?></td>
							<td class="nada" width="50">&nbsp;</td>
							<th class="destaca" scope="col" style="text-align:center;">Volumen de Agua Disponible (L pl<sup>-1</sup>)</th>
							<td style="text-align:center;"><?=number_format($vol_agua_disp, 2, '.', '')?></td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:center;">TOTAL</td>
							<td style="text-align:center;"><?=$total_lamina_neta?></td>
							<td style="text-align:center;"><?=$total_vol_de_suelo?></td>
							<td class="nada" width="50">&nbsp;</td>
							<th class="destaca" scope="col" style="text-align:center;">&Aacute;rea Mojada por Emisor (m<sup>2</sup> pl<sup>-1</sup>)</th>
							<td style="text-align:center;"><?=number_format($area_moj_por_emis, 2, '.', '')?></td>
						</tr>
					</tbody>
				</table>
			</div>
			<?php
				$fecha_sep_pasado = (date("Y")-3)."-09-01";
				$fecha_sep_actual = (date("Y")-2)."-09-01";
				//$rs = consulta_sql("SELECT fecha,valor FROM modelo_procesado_estacion WHERE estacion_has_modelo_id_estacion=".$eid." AND estacion_has_modelo_id_tipo_modelo=1 AND fecha>='".$fecha_sep_pasado."' AND fecha<'".$fecha_sep_actual."'");
				$rs = consulta_sql("SELECT fecha,valor FROM modelo_procesado_estacion WHERE estacion_has_modelo_id_estacion=".$eid." AND estacion_has_modelo_id_tipo_modelo=1 AND fecha='".$fecha."'");
			?>
			<div class="column1-unit">
				<h2 class="block">Riego para su cuartel</h2>
				<table class="mediagrove" id="azul" style="width: auto;">
					<thead>
						<tr>
							<th scope="col" style="text-align:center;">Fecha</th>
							<th scope="col" style="text-align:center;">Et0 (mm d<sup>-1</sup>)</th>
							<th scope="col" style="text-align:center;">Kc</th>
							<th scope="col" style="text-align:center;">Precipitaci&oacute;n lluvia (mm)</th>
							<th scope="col" style="text-align:center;">Etreal (mm d<sup>-1</sup>)</th>
							<th scope="col" style="text-align:center;">Volumen Consumido (L pl<sup>-1</sup> d<sup>-1</sup>)</th>
							<th scope="col" style="text-align:center;">Precipitaci&oacute;n efectiva Lluvia(L pl<sup>-1</sup> d<sup>-1</sup>)</th>
							<th scope="col" style="text-align:center;">Volumen Acumulado (mm)</th>
							
							<?php
							//<th scope="col" style="text-align:center;">Riego</th>
							//<th scope="col" style="text-align:center;">Tiempo Riego (h:m)</th>
							?>
							<th scope="col" style="text-align:center;">Tiempo Riego Diario (h:m)</th>
						</tr>
					</thead>
					<tbody>
						<?php
							function cerosHora($numero){
								if($numero >=0 && $numero <=9)
									return "0".$numero;
								else
									return $numero;
							}
							
							$ultima_fecha = "";
							$RIEGO = "";
							$Tiempo_de_riego = 0.0;
							$Tiempo_de_riego_diario = 0.0;
							$Tiempo_de_riego_h_min = "";
							$Tiempo_de_riego_diario_h_min = "";
							$ultima_fecha = $fecha_sep_pasado;
							$ETr = 0.0;
							$ETreal = 0.0;
							$PP_lluvia = 0.0;	
							$Vol_acum = 0.0;
							$Vol_consumido = 0.0;
							$PP_lluvia_efectiva = 0.0;
							$flag = 0;
							while($datos = mysqli_fetch_array($rs)){
								$ultima_fecha = $datos[0];
								if($flag == 0){
									$ETr = $datos[1];
									$ETreal = $Kc*$ETr*1.0;
									$PP_lluvia = 0*1.0;   //PONER AQUI LAS LLUVIAS
									$Vol_consumido = $ETreal*$area_moj_por_emis*1.0;

									$PP_lluvia_efectiva = $PP_lluvia * 0.85*1.0 ;
									
									$Vol_acum = $ETreal;
									$flag = 1;
									$RIEGO = "";
									$Tiempo_de_riego = 0.0;
									$Tiempo_de_riego_diario = $Vol_consumido/$pp_sistema_l_h*1.0;
								}
								else{
									$ETr = $datos[1];
									$ETreal = $Kc*$ETr*1.0;
									
									$PP_lluvia = 0*1.0;   //PONER AQUI LAS LLUVIAS
									$Vol_consumido = $ETreal*$area_moj_por_emis*1.0;
	
									if(($PP_lluvia*0.85*$area_moj_por_emis)>($Vol_acum+$Vol_consumido))
										$PP_lluvia_efectiva = $Vol_consumido + $Vol_acum*1.0;
									else
										$PP_lluvia_efectiva = $PP_lluvia * 0.85 * $area_moj_por_emis*1.0;
									
									$Vol_acum_anterior = $Vol_acum;
									if(($Vol_acum_anterior+$Vol_consumido-$PP_lluvia_efectiva)>=($vol_agua_disp))
										$Vol_acum = $Vol_consumido*1.0;
									else
										$Vol_acum = $Vol_acum+$Vol_consumido-$PP_lluvia_efectiva;
									
									if(($PP_lluvia != 0.0 || $Vol_acum < $Vol_acum_anterior) && $PP_lluvia == 0.0)
										$RIEGO = "Riego";
									else
										$RIEGO = "";

									if($RIEGO == "Riego")
										$Tiempo_de_riego = $Vol_acum_anterior/$pp_sistema_l_h*1.0;
									else
										$Tiempo_de_riego = 0.0;

									$Tiempo_de_riego_diario = $Vol_consumido/$pp_sistema_l_h*1.0;
								}
								if($Tiempo_de_riego != 0.0){
									$Tiempo_de_riego_h_min = cerosHora(((int)$Tiempo_de_riego)).":";
									$Tiempo_de_riego_h_min = $Tiempo_de_riego_h_min.cerosHora(((int)(($Tiempo_de_riego-((int)$Tiempo_de_riego))*60)));
								}
								else
									$Tiempo_de_riego_h_min = "00:00";

								if($Tiempo_de_riego_diario != 0.0){
									$Tiempo_de_riego_diario_h_min = cerosHora(((int)$Tiempo_de_riego_diario)).":";
									$Tiempo_de_riego_diario_h_min = $Tiempo_de_riego_diario_h_min.cerosHora(((int)(($Tiempo_de_riego_diario-((int)$Tiempo_de_riego_diario))*60)));
								}
								else
									$Tiempo_de_riego_diario_h_min = "00:00";
								
								echo '<tr>';
								echo '<td style="text-align:center;">'.cambia_fecha_a_normal($ultima_fecha).'</td>';
								echo '<td style="text-align:center;">'.number_format($ETr, 1, ".", "").'</td>';
								echo '<td style="text-align:center;">'.number_format($Kc, 2, ".", "").'</td>';
								echo '<td style="text-align:center;">'.number_format($PP_lluvia, 2, ".", "").'</td>';
								
								echo '<td style="text-align:center;">'.number_format($ETreal, 2, ".", "").'</td>';
								echo '<td style="text-align:center;">'.number_format($Vol_consumido, 1, ".", "").'</td>';
								echo '<td style="text-align:center;">'.number_format($PP_lluvia_efectiva, 1, ".", "").'</td>';
								echo '<td style="text-align:center;">'.number_format($Vol_acum, 1, ".", "").'</td>';
								/*if($RIEGO == "Riego"){
									echo '<td style="text-align:center; background: #197808;"><span style="color:#ffffff"><b>'.$RIEGO.'</b></span></td>';
									echo '<td style="text-align:center; background: #197808;"><span style="color:#ffffff"><b>'.$Tiempo_de_riego_h_min.'</b></span></td>';
									echo '<td style="text-align:center; background: #197808;"><span style="color:#ffffff"><b>'.$Tiempo_de_riego_diario_h_min.'</b></span></td>';
								}
								else{
									echo '<td style="text-align:center;"><span style="color:#ffffff"><b>'.$RIEGO.'</b></span></td>';
									echo '<td style="text-align:center;">'.$Tiempo_de_riego_h_min.'</td>';
									echo '<td style="text-align:center;">'.$Tiempo_de_riego_diario_h_min.'</td>';
								}*/
								echo '<td style="text-align:center;">'.$Tiempo_de_riego_diario_h_min.'</td>';
								echo '</tr>';
							} 
						?>
					</tbody>
				</table>
			</div>

		<?php
	
?>