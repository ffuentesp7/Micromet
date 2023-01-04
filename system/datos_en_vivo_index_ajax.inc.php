<?php
	require_once('../aut_verifica.inc.php');
	require_once('../funciones.inc.php');
        require_once('functions/statistic.functions.php');
	estadisticas('WEB','PAGE_VIEW');
	estadisticas('USER_USE','DATOS EN VIVO');


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
        ORDER BY rand(" . time() . " * " . time() . ") LIMIT 2";
	
	$result_estaciones = consulta_sql($SQL);
	
	$HTML = '';
	
	while($datos_estaciones = mysqli_fetch_array($result_estaciones)){
            
            $HTML .= '<div class="each">
                            <div class="content_slider">
                                <p><strong>'.$datos_estaciones[0].'</strong></p>';
            
            $EID = $datos_estaciones[1];
            
	    $INSTRUMENTS = getInstrumentsOfStation($EID);
            $LASTM = getLastMeasurementStation($EID);
		
            if(empty($INSTRUMENTS) || empty($LASTM) || $LASTM[0] == 'NaN'){
                    $HTML .= "<p>Lamentablemente no existen datos para mostrar</p>";			
            }
            else{
                /*$HOURDATE = add_seconds($LASTM[2],$LASTM[1],-900);
                $DATE_FROM = $HOURDATE[1];
                $DATE_TO = $LASTM[1];
                $HOUR_FROM = $HOURDATE[0];
                $HOUR_TO = $LASTM[2];
		
		$L = count($INSTRUMENTS);
                
                $SQL = "SELECT ins0.fecha, ins0.hora";
                
                for($i = 0; $i < $L; $i++){
                        $SQL.=", ins$i.medicion";
                }
                $SQL.=" FROM medicion AS ins0";
                for($i = 1; $i < $L; $i++){
                        $SQL.=" LEFT OUTER JOIN medicion AS ins$i ON ins".($i-1).".fecha=ins$i.fecha AND ins".($i-1).".hora=ins$i.hora";
                }
                $SQL.=" WHERE";
                for($i = 0; $i < $L; $i++){
                        if($i == 0)
                                $SQL.=" ins$i.instrumento_id = ".$INSTRUMENTS[$i][0];
                        else
                                $SQL.=" AND ins$i.instrumento_id = ".$INSTRUMENTS[$i][0];
                }
                $SQL.=" AND ins0.fecha >= '$DATE_FROM' AND ins0.fecha <= '$DATE_TO' AND ins0.hora >= '$HOUR_FROM' AND ins0.hora <= '$HOUR_TO'";
                $SQL.=" ORDER BY ins0.fecha, ins0.hora DESC";
                
                $RES_DATA = consulta_sql($SQL);
                $HTML.="<ul>";
                for($j = 0; $DATA = mysqli_fetch_array($RES_DATA); $j++){
                    
                        $HTML.="<li>";
                    
                        if($j == 0){
                           $HTML.="Fecha: ".cambia_fecha_a_normal($DATA[0]); 
                        }
                        elseif($j == 1){
                            $HTML.="Hora: ".$DATA[1];
                        }
                        else{
                            $HTML.=$INSTRUMENTS[$j - 2][1].' : ';
                            $HTML.=number_format($DATA[$j], 1, '.', '').' '.$INSTRUMENTS[$j - 2][3];
                        }
                               
                        
                        $HTML.="</li>";
                }
                */
                $HTML.="<ul>";
                for($i = 0; $i < count($INSTRUMENTS); $i++){
                    
                    $INSDATA = getLastMeasurement($INSTRUMENTS[$i][0]);
                    
                    if($i == 0){
                        $HTML.="<li>";
                        $HTML.="Fecha: ".cambia_fecha_a_normal($INSDATA[1]);
                        $HTML.="</li>";
                        $HTML.="<li>";
                        $HTML.="Hora: ".$INSDATA[2];
                        $HTML.="</li>";
                    }
                    else{
                        $HTML.="<li>";
                        $HTML.=$INSTRUMENTS[$i][1].' : ';
                        $HTML.=number_format($INSDATA[0], 1, '.', '').' '.$INSTRUMENTS[$i][3];
                        $HTML.="</li>";
                    }
                }
                
                $HTML.="</ul>";
            
            }
            $HTML .= '</div>
                    </div>';
	}
	
	if($HTML == '')
		$HTML = '<div class="each">
                            <div class="content_slider">
                                <p><strong>No existen estaciones</strong></p>
                                <p>Lamentablemente no hay estaciones para entregar datos.</p>
                            </div>
                        </div>';
	echo $HTML;
?>