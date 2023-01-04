<?php
	require('../aut_verifica.inc.php');
	require('../funciones.inc.php');
	require('../system/functions/statistic.functions.php');
	require('../system/functions/instrument.type.php');
	require('../system/functions/convert.unit.php');

	define('FPDF_FONTPATH','../system/fpdf/font/');
	require('../system/fpdf/fpdf.php');

	$ACCION = $_GET['accion'];
	
	if($ACCION == "getmeteovidpdf"){
		$AREA 	= $_GET['area'];
		$BID	= $_GET['bid'];
		$DET	= $_GET['detalle'];
		
		$SQL = "SELECT 	estacion.id,estacion.nombre,eve_area.nombre 
			FROM	eve_area, 
				eve_area_has_estacion, 
				estacion 
			WHERE	eve_area.id=$AREA 
			AND 	eve_area_has_estacion.area_id=eve_area.id 
			AND	eve_area_has_estacion.estacion_id=estacion.id";
		
		$ESTACION = array(); //ID,ESTACION.NOMBRE,AREA.NOMBRE
		
		$RES = consulta_sql($SQL);
		
		while($DAT = mysqli_fetch_array($RES)){
			$ESTACION[] = $DAT;
		}
		
		$INSTRUMENTO = array( 	'GR' => 1, //GR
					'WINDSPEED' => 2, //WINDSPEED
					'RH' => 4, //RH
					'TEMP' => 5, //TEMP aire
					'RAIN' => 6  //RAIN
					);
		
		$SQL = "SELECT 	semana, 
				anio, 
				fecha_inicio, 
				fecha_termino 
			FROM	eve_semana_boletin 
			WHERE 	id=$BID";
		
		$RES = consulta_sql($SQL);
		
		$BOLETIN = array();//SEMANA, ANIO, FECHA INICIO, FECHA TERMINO
		
		if($DAT = mysqli_fetch_array($RES)){
			$BOLETIN = $DAT;
		}
		
		$DAYSWITHDEFICIENTDATA = intval(get_parameter('MAX_DAYS_WITH_DEFICIENT_DATA'));
		
		class PDF extends FPDF{
			function Footer(){
				//Go to 1.5 cm from bottom
				$this->SetY(-15);
				//Select Arial italic 8
				$this->SetFont('Arial','B',8);
				$this->SetTextColor(0,20,0);
				//Print current and total page numbers
				$this->Cell(5,10,utf8_decode(''),0,0,'L');
				$this->Cell(0,10,utf8_decode('NeR: Estación que no está en condiciones de referencia, no se puede calcular ET0.'),0,0,'L');
				$this->SetFont('Arial','I',8);
				$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'R');
				$this->Image('../system/img/banner3b.jpg',235,190,40);
			}
		}
		
		if($DET == "semanal"){
			$pdf=new PDF('L','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetMargins(0.5,0.5);
			$pdf->SetAutoPageBreak(true,20);
			$pdf->Image('../system/img/banner3a.jpg',94,2,110);
			$pdf->SetFont('Arial','BU',16);
			$pdf->Ln(20);
			$pdf->MultiCell(0,8,utf8_decode('Resumen Agroclimático Semanal - Meteovid'),0,'C');
			$pdf->SetFont('Arial','B',14);
			$pdf->MultiCell(0,8,utf8_decode("Semana ".$BOLETIN[0]." del ".cambia_fecha_a_normal($BOLETIN[2])." al ".cambia_fecha_a_normal($BOLETIN[3])),0,'C');
			$pdf->MultiCell(0,8,utf8_decode($ESTACION[0][2]),0,'C');
			$pdf->Cell(5,7,'',0,0,'C');
			$pdf->SetFont('Arial','B',11);
			$pdf->SetFillColor(0,97,0);
			$pdf->SetTextColor(255);
			$pdf->SetDrawColor(255);
			$pdf->SetLineWidth(.4);
			
			$pdf->Cell(70,7,utf8_decode('Estación'),1,0,'C',true);
			$pdf->Cell(45,7,utf8_decode('Temperatura ºC'),1,0,'C',true);
			$pdf->Cell(45,7,utf8_decode('Humedad Relativa (%)'),1,0,'C',true);
			$pdf->Cell(25,7,utf8_decode('Pps. (mm)'),1,0,'C',true);
			$pdf->Cell(25,7,utf8_decode('Rad. (MJ/m2)'),1,0,'C',true);
			$pdf->Cell(45,7,utf8_decode('Vel. Viento (km/h)'),1,0,'C',true);
			$pdf->Cell(25,7,utf8_decode('ET0 (mm)'),1,0,'C',true);
			
			$pdf->Ln(7);
			$pdf->Cell(5,7,'',0,0,'C');
			$pdf->SetFillColor(120,120,0);
			
			$pdf->Cell(70,7,'',1,0,'C',true);
			$pdf->Cell(15,7,utf8_decode('Media'),1,0,'C',true);
			$pdf->Cell(15,7,utf8_decode('Mín.'),1,0,'C',true);
			$pdf->Cell(15,7,utf8_decode('Máx.'),1,0,'C',true);
			$pdf->Cell(15,7,utf8_decode('Media'),1,0,'C',true);
			$pdf->Cell(15,7,utf8_decode('Min.'),1,0,'C',true);
			$pdf->Cell(15,7,utf8_decode('Máx.'),1,0,'C',true);
			$pdf->Cell(25,7,utf8_decode('Acumulado'),1,0,'C',true);
			$pdf->Cell(25,7,utf8_decode('Acumulado'),1,0,'C',true);
			$pdf->Cell(23,7,utf8_decode('Media'),1,0,'C',true);
			$pdf->Cell(22,7,utf8_decode('Máx.'),1,0,'C',true);
			$pdf->Cell(25,7,utf8_decode('Acumulado'),1,0,'C',true);
			
			$pdf->SetTextColor(0,20,0);
			for($i = 0; $i < count($ESTACION); $i++){
				$pdf->Ln(7);
			
				if($i%2 == 0)
					$pdf->SetFillColor(218,218,218);
				else
					$pdf->SetFillColor(230,239,229);
				
				$pdf->Cell(5,7,'',0,0,'C');
				$pdf->Cell(70,7,utf8_decode($ESTACION[$i][1]),1,0,'C',true);
				
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['TEMP']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'AVGDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
					
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['TEMP']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'MINDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['TEMP']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'MAXDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['RH']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'AVGDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
					
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['RH']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'MINDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['RH']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'MAXDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['RAIN']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'SUMDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(25,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(25,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(25,7,utf8_decode('-----'),1,0,'C',true);
				}
				
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['GR']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'SUMDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(25,7,utf8_decode(number_format(Wm22MJm2($VALUE[0],getMeasuringInterval(getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['GR']))), 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(25,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(25,7,utf8_decode('-----'),1,0,'C',true);
				}
				
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['WINDSPEED']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'AVGDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(23,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(23,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(23,7,utf8_decode('-----'),1,0,'C',true);
				}
				
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['WINDSPEED']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'MAXDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(22,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(22,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(22,7,utf8_decode('-----'),1,0,'C',true);
				}
				
				$VALUE2 = getTypeOfProcessedModel($ESTACION[$i][0],'ETo');
				$VALUE = getProcessedModelRange($ESTACION[$i][0],'ETo','SUM',$BOLETIN[2],$BOLETIN[3]);
				
				if($VALUE2 == 'FALSE')
					$pdf->Cell(25,7,utf8_decode('NeR'),1,0,'C',true);
				elseif($VALUE == "NaN")
					$pdf->Cell(25,7,utf8_decode('0.0'),1,0,'C',true);
				else
					$pdf->Cell(25,7,utf8_decode(number_format($VALUE*1, 1, '.', '')),1,0,'C',true);
			}
			
			$pdf->Output("resumen-agroclimatico-semanal-".$BOLETIN[0]."-".utf8_decode($ESTACION[0][2])."-".date('YmdHis')."-.pdf","D");
			exit;
		}
		elseif($DET == "diario"){
			$pdf=new PDF('L','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetMargins(0.5,0.5);
			$pdf->SetAutoPageBreak(true,20);
			$pdf->Image('../system/img/banner3a.jpg',94,2,110);
			$pdf->SetFont('Arial','BU',16);
			$pdf->Ln(20);
			$pdf->MultiCell(0,8,utf8_decode('Resumen Agroclimático Diario - Meteovid'),0,'C');
			$pdf->SetFont('Arial','B',14);
			$pdf->MultiCell(0,8,utf8_decode("Semana ".$BOLETIN[0]." del ".cambia_fecha_a_normal($BOLETIN[2])." al ".cambia_fecha_a_normal($BOLETIN[3])),0,'C');
			$pdf->MultiCell(0,8,utf8_decode($ESTACION[0][2]),0,'C');
			
			$DEFICIENTDATAPERDAY = intval(get_parameter('MAX_DEFICIENT_DATA_PER_DAY'));
			
			for($i = 0; $i < count($ESTACION); $i++){
				
				$FECHAACTUAL = $BOLETIN[2];

				$pdf->Cell(5,7,'',0,0,'C');
				$pdf->SetFont('Arial','B',11);
				$pdf->SetFillColor(0,97,0);
				$pdf->SetTextColor(255);
				$pdf->SetDrawColor(255);
				$pdf->SetLineWidth(.4);
				$pdf->Cell(70,7,utf8_decode('Estación/Fecha'),1,0,'C',true);
				$pdf->Cell(45,7,utf8_decode('Temperatura ºC'),1,0,'C',true);
				$pdf->Cell(45,7,utf8_decode('Humedad Relativa (%)'),1,0,'C',true);
				$pdf->Cell(25,7,utf8_decode('Pps. (mm)'),1,0,'C',true);
				$pdf->Cell(25,7,utf8_decode('Rad. (MJ/m2)'),1,0,'C',true);
				$pdf->Cell(45,7,utf8_decode('Vel. Viento (km/h)'),1,0,'C',true);
				$pdf->Cell(25,7,utf8_decode('ET0 (mm)'),1,0,'C',true);
				
				$pdf->Ln(7);
				$pdf->Cell(5,7,'',0,0,'C');
				$pdf->SetFillColor(120,120,0);
				
				$pdf->Cell(70,7,utf8_decode($ESTACION[$i][1]),1,0,'C',true);
				$pdf->Cell(15,7,utf8_decode('Media'),1,0,'C',true);
				$pdf->Cell(15,7,utf8_decode('Mín.'),1,0,'C',true);
				$pdf->Cell(15,7,utf8_decode('Máx.'),1,0,'C',true);
				$pdf->Cell(15,7,utf8_decode('Media'),1,0,'C',true);
				$pdf->Cell(15,7,utf8_decode('Min.'),1,0,'C',true);
				$pdf->Cell(15,7,utf8_decode('Máx.'),1,0,'C',true);
				$pdf->Cell(25,7,utf8_decode('Acumulado'),1,0,'C',true);
				$pdf->Cell(25,7,utf8_decode('Acumulado'),1,0,'C',true);
				$pdf->Cell(23,7,utf8_decode('Media'),1,0,'C',true);
				$pdf->Cell(22,7,utf8_decode('Máx.'),1,0,'C',true);
				$pdf->Cell(25,7,utf8_decode('Acumulado'),1,0,'C',true);
				
				$pdf->SetTextColor(0,20,0);
			
				$pdf->Ln(7);
				
				for($j = 0; retorna_unix($FECHAACTUAL,'00:00:00') <= retorna_unix($BOLETIN[3],'00:00:00'); $j++){
					if($j%2 == 0)
						$pdf->SetFillColor(218,218,218);
					else
						$pdf->SetFillColor(230,239,229);
					
					$pdf->Cell(5,7,'',0,0,'C');
					$pdf->Cell(70,7,utf8_decode(cambia_fecha_a_normal($FECHAACTUAL)),1,0,'C',true);
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['TEMP']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'AVGDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['TEMP']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'MINDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['TEMP']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'MAXDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['RH']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'AVGDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['RH']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'MINDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['RH']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'MAXDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['RAIN']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'SUMDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(25,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(25,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(25,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['GR']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'SUMDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(25,7,utf8_decode(number_format(Wm22MJm2($VALUE[0],getMeasuringInterval(getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['GR']))), 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(25,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(25,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['WINDSPEED']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'AVGDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(23,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(23,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(23,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['WINDSPEED']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'MAXDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(22,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(22,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(22,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$VALUE = getProcessedModel($ESTACION[$i][0],'ETo',$FECHAACTUAL);
					
					if($VALUE == 'NaN')
						$pdf->Cell(25,7,utf8_decode('NeR'),1,0,'C',true);
					else
						$pdf->Cell(25,7,utf8_decode(number_format($VALUE*1, 1, '.', '')),1,0,'C',true);
				
					$FECHAACTUAL = cambia_fecha_a_mysql(add_days(cambia_fecha_a_normal($FECHAACTUAL), 1));
					$pdf->Ln(7);
				}
				$pdf->Ln(7);
			}
			
			$pdf->Output("resumen-agroclimatico-diario-".$BOLETIN[0]."-".utf8_decode($ESTACION[0][2])."-".date('YmdHis')."-.pdf","D");
			exit;
			
			
		}
	}
	elseif($ACCION == "getgeneralpdf"){
		$AREA 	= $_GET['area'];
		$BID	= $_GET['bid'];
		$DET	= $_GET['detalle'];
		
		$SQL = "SELECT 	estacion.id,estacion.nombre,eve_area.nombre 
			FROM	eve_area, 
				eve_area_has_estacion, 
				estacion 
			WHERE	eve_area.id=$AREA 
			AND 	eve_area_has_estacion.area_id=eve_area.id 
			AND	eve_area_has_estacion.estacion_id=estacion.id";
		
		$ESTACION = array(); //ID,ESTACION.NOMBRE,AREA.NOMBRE
		
		$RES = consulta_sql($SQL);
		
		while($DAT = mysqli_fetch_array($RES)){
			$ESTACION[] = $DAT;
		}
		
		$INSTRUMENTO = array( 	'GR' => 1, //GR
					'WINDSPEED' => 2, //WINDSPEED
					'RH' => 4, //RH
					'TEMP' => 5, //TEMP aire
					'RAIN' => 6  //RAIN
					);
		
		$SQL = "SELECT 	semana, 
				anio, 
				fecha_inicio, 
				fecha_termino 
			FROM	eve_semana_boletin 
			WHERE 	id=$BID";
		
		$RES = consulta_sql($SQL);
		
		$BOLETIN = array();//SEMANA, ANIO, FECHA INICIO, FECHA TERMINO
		
		if($DAT = mysqli_fetch_array($RES)){
			$BOLETIN = $DAT;
		}
		
		$DAYSWITHDEFICIENTDATA = intval(get_parameter('MAX_DAYS_WITH_DEFICIENT_DATA'));
		
		class PDF extends FPDF{
			function Footer(){
				//Go to 1.5 cm from bottom
				$this->SetY(-15);
				//Select Arial italic 8
				$this->SetFont('Arial','B',8);
				$this->SetTextColor(0,20,0);
				//Print current and total page numbers
				$this->Cell(5,10,utf8_decode(''),0,0,'L');
				$this->Cell(0,10,utf8_decode('NeR: Estación que no está en condiciones de referencia, no se puede calcular ET0.'),0,0,'L');
				$this->SetFont('Arial','I',8);
				$this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'R');
				$this->Image('../system/img/banner_general_inf_01.jpg',235,190,40);
			}
		}
		
		if($DET == "semanal"){
			$pdf=new PDF('L','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetMargins(0.5,0.5);
			$pdf->SetAutoPageBreak(true,20);
			$pdf->Image('../system/img/banner_general_sup_01.jpg',94,2,110);
			$pdf->SetFont('Arial','BU',16);
			$pdf->Ln(20);
			$pdf->MultiCell(0,8,utf8_decode('Resumen Agroclimático Semanal - CITRA'),0,'C');
			$pdf->SetFont('Arial','B',14);
			$pdf->MultiCell(0,8,utf8_decode("Semana ".$BOLETIN[0]." del ".cambia_fecha_a_normal($BOLETIN[2])." al ".cambia_fecha_a_normal($BOLETIN[3])),0,'C');
			$pdf->MultiCell(0,8,utf8_decode($ESTACION[0][2]),0,'C');
			$pdf->Cell(5,7,'',0,0,'C');
			$pdf->SetFont('Arial','B',11);
			$pdf->SetFillColor(0,97,0);
			$pdf->SetTextColor(255);
			$pdf->SetDrawColor(255);
			$pdf->SetLineWidth(.4);
			
			$pdf->Cell(70,7,utf8_decode('Estación'),1,0,'C',true);
			$pdf->Cell(45,7,utf8_decode('Temperatura ºC'),1,0,'C',true);
			$pdf->Cell(45,7,utf8_decode('Humedad Relativa (%)'),1,0,'C',true);
			$pdf->Cell(25,7,utf8_decode('Pps. (mm)'),1,0,'C',true);
			$pdf->Cell(25,7,utf8_decode('Rad. (MJ/m2)'),1,0,'C',true);
			$pdf->Cell(45,7,utf8_decode('Vel. Viento (km/h)'),1,0,'C',true);
			$pdf->Cell(25,7,utf8_decode('ET0 (mm)'),1,0,'C',true);
			
			$pdf->Ln(7);
			$pdf->Cell(5,7,'',0,0,'C');
			$pdf->SetFillColor(120,120,0);
			
			$pdf->Cell(70,7,'',1,0,'C',true);
			$pdf->Cell(15,7,utf8_decode('Media'),1,0,'C',true);
			$pdf->Cell(15,7,utf8_decode('Mín.'),1,0,'C',true);
			$pdf->Cell(15,7,utf8_decode('Máx.'),1,0,'C',true);
			$pdf->Cell(15,7,utf8_decode('Media'),1,0,'C',true);
			$pdf->Cell(15,7,utf8_decode('Min.'),1,0,'C',true);
			$pdf->Cell(15,7,utf8_decode('Máx.'),1,0,'C',true);
			$pdf->Cell(25,7,utf8_decode('Acumulado'),1,0,'C',true);
			$pdf->Cell(25,7,utf8_decode('Acumulado'),1,0,'C',true);
			$pdf->Cell(23,7,utf8_decode('Media'),1,0,'C',true);
			$pdf->Cell(22,7,utf8_decode('Máx.'),1,0,'C',true);
			$pdf->Cell(25,7,utf8_decode('Acumulado'),1,0,'C',true);
			
			$pdf->SetTextColor(0,20,0);
			for($i = 0; $i < count($ESTACION); $i++){
				$pdf->Ln(7);
			
				if($i%2 == 0)
					$pdf->SetFillColor(218,218,218);
				else
					$pdf->SetFillColor(230,239,229);
				
				$pdf->Cell(5,7,'',0,0,'C');
				$pdf->Cell(70,7,utf8_decode(tilde_to_utf8($ESTACION[$i][1])),1,0,'C',true);
				
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['TEMP']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'AVGDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
					
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['TEMP']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'MINDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['TEMP']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'MAXDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['RH']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'AVGDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
					
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['RH']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'MINDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['RH']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'MAXDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
				}
				
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['RAIN']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'SUMDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(25,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(25,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(25,7,utf8_decode('-----'),1,0,'C',true);
				}
				
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['GR']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'SUMDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(25,7,utf8_decode(number_format(Wm22MJm2($VALUE[0],getMeasuringInterval(getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['GR']))), 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(25,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(25,7,utf8_decode('-----'),1,0,'C',true);
				}
				
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['WINDSPEED']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'AVGDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(23,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(23,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(23,7,utf8_decode('-----'),1,0,'C',true);
				}
				
				$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['WINDSPEED']);
				if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
					$VALUE = getProcessedMeasurementRange($GHOSTID,'MAXDAY',$BOLETIN[2],$BOLETIN[3]);
					if($VALUE[2] < $DAYSWITHDEFICIENTDATA && $VALUE[1] > (7 - $DAYSWITHDEFICIENTDATA))
						$pdf->Cell(22,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
					else
						$pdf->Cell(22,7,utf8_decode('-----'),1,0,'C',true);
				}
				else{
					$pdf->Cell(22,7,utf8_decode('-----'),1,0,'C',true);
				}
				
				$VALUE2 = getTypeOfProcessedModel($ESTACION[$i][0],'ETo');
				$VALUE = getProcessedModelRange($ESTACION[$i][0],'ETo','SUM',$BOLETIN[2],$BOLETIN[3]);
				
				if($VALUE2 == 'FALSE')
					$pdf->Cell(25,7,utf8_decode('NeR'),1,0,'C',true);
				elseif($VALUE == "NaN")
					$pdf->Cell(25,7,utf8_decode('0.0'),1,0,'C',true);
				else
					$pdf->Cell(25,7,utf8_decode(number_format($VALUE*1, 1, '.', '')),1,0,'C',true);
			}
			
			$pdf->Output("resumen-agroclimatico-semanal-general".$BOLETIN[0]."-".utf8_decode($ESTACION[0][2])."-".date('YmdHis')."-.pdf","D");
			exit;
		}
		elseif($DET == "diario"){
			$pdf=new PDF('L','mm','A4');
			$pdf->AliasNbPages();
			$pdf->AddPage();
			$pdf->SetMargins(0.5,0.5);
			$pdf->SetAutoPageBreak(true,20);
			$pdf->Image('../system/img/banner_general_sup_01.jpg',94,2,110);
			$pdf->SetFont('Arial','BU',16);
			$pdf->Ln(20);
			$pdf->MultiCell(0,8,utf8_decode('Resumen Agroclimático Diario - CITRA'),0,'C');
			$pdf->SetFont('Arial','B',14);
			$pdf->MultiCell(0,8,utf8_decode("Semana ".$BOLETIN[0]." del ".cambia_fecha_a_normal($BOLETIN[2])." al ".cambia_fecha_a_normal($BOLETIN[3])),0,'C');
			$pdf->MultiCell(0,8,utf8_decode($ESTACION[0][2]),0,'C');
			
			$DEFICIENTDATAPERDAY = intval(get_parameter('MAX_DEFICIENT_DATA_PER_DAY'));
			
			for($i = 0; $i < count($ESTACION); $i++){
				
				$FECHAACTUAL = $BOLETIN[2];

				$pdf->Cell(5,7,'',0,0,'C');
				$pdf->SetFont('Arial','B',11);
				$pdf->SetFillColor(0,97,0);
				$pdf->SetTextColor(255);
				$pdf->SetDrawColor(255);
				$pdf->SetLineWidth(.4);
				$pdf->Cell(70,7,utf8_decode('Estación/Fecha'),1,0,'C',true);
				$pdf->Cell(45,7,utf8_decode('Temperatura ºC'),1,0,'C',true);
				$pdf->Cell(45,7,utf8_decode('Humedad Relativa (%)'),1,0,'C',true);
				$pdf->Cell(25,7,utf8_decode('Pps. (mm)'),1,0,'C',true);
				$pdf->Cell(25,7,utf8_decode('Rad. (MJ/m2)'),1,0,'C',true);
				$pdf->Cell(45,7,utf8_decode('Vel. Viento (km/h)'),1,0,'C',true);
				$pdf->Cell(25,7,utf8_decode('ET0 (mm)'),1,0,'C',true);
				
				$pdf->Ln(7);
				$pdf->Cell(5,7,'',0,0,'C');
				$pdf->SetFillColor(120,120,0);
				
				$pdf->Cell(70,7,utf8_decode(tilde_to_utf8($ESTACION[$i][1])),1,0,'C',true);
				$pdf->Cell(15,7,utf8_decode('Media'),1,0,'C',true);
				$pdf->Cell(15,7,utf8_decode('Mín.'),1,0,'C',true);
				$pdf->Cell(15,7,utf8_decode('Máx.'),1,0,'C',true);
				$pdf->Cell(15,7,utf8_decode('Media'),1,0,'C',true);
				$pdf->Cell(15,7,utf8_decode('Min.'),1,0,'C',true);
				$pdf->Cell(15,7,utf8_decode('Máx.'),1,0,'C',true);
				$pdf->Cell(25,7,utf8_decode('Acumulado'),1,0,'C',true);
				$pdf->Cell(25,7,utf8_decode('Acumulado'),1,0,'C',true);
				$pdf->Cell(23,7,utf8_decode('Media'),1,0,'C',true);
				$pdf->Cell(22,7,utf8_decode('Máx.'),1,0,'C',true);
				$pdf->Cell(25,7,utf8_decode('Acumulado'),1,0,'C',true);
				
				$pdf->SetTextColor(0,20,0);
			
				$pdf->Ln(7);
				
				for($j = 0; retorna_unix($FECHAACTUAL,'00:00:00') <= retorna_unix($BOLETIN[3],'00:00:00'); $j++){
					if($j%2 == 0)
						$pdf->SetFillColor(218,218,218);
					else
						$pdf->SetFillColor(230,239,229);
					
					$pdf->Cell(5,7,'',0,0,'C');
					$pdf->Cell(70,7,utf8_decode(cambia_fecha_a_normal($FECHAACTUAL)),1,0,'C',true);
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['TEMP']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'AVGDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['TEMP']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'MINDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['TEMP']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'MAXDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['RH']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'AVGDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['RH']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'MINDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['RH']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'MAXDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(15,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(15,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['RAIN']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'SUMDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(25,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(25,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(25,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['GR']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'SUMDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(25,7,utf8_decode(number_format(Wm22MJm2($VALUE[0],getMeasuringInterval(getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['GR']))), 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(25,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(25,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['WINDSPEED']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'AVGDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(23,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(23,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(23,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$GHOSTID = getInstrumetId($ESTACION[$i][0],$INSTRUMENTO['WINDSPEED']);
					if($GHOSTID != 'NaN' && $GHOSTID != 'FALSE' && $GHOSTID != 'false'){
						$VALUE = getProcessedMeasurement($GHOSTID,'MAXDAY',$FECHAACTUAL);
						if($VALUE[2] > $DEFICIENTDATAPERDAY)
							$pdf->Cell(22,7,utf8_decode(number_format($VALUE[0]*1, 1, '.', '')),1,0,'C',true);
						else
							$pdf->Cell(22,7,utf8_decode('-----'),1,0,'C',true);
					}
					else{
						$pdf->Cell(22,7,utf8_decode('-----'),1,0,'C',true);
					}
					
					$VALUE = getProcessedModel($ESTACION[$i][0],'ETo',$FECHAACTUAL);
					
					if($VALUE == 'NaN')
						$pdf->Cell(25,7,utf8_decode('NeR'),1,0,'C',true);
					else
						$pdf->Cell(25,7,utf8_decode(number_format($VALUE*1, 1, '.', '')),1,0,'C',true);
				
					$FECHAACTUAL = cambia_fecha_a_mysql(add_days(cambia_fecha_a_normal($FECHAACTUAL), 1));
					$pdf->Ln(7);
				}
				$pdf->Ln(7);
			}
			
			$pdf->Output("resumen-agroclimatico-diario-general-".$BOLETIN[0]."-".utf8_decode($ESTACION[0][2])."-".date('YmdHis')."-.pdf","D");
			exit;
			
			
		}
	}

?>