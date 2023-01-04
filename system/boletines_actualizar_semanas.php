<?php
	$rst = consulta_sql("SELECT * FROM eve_semana_boletin ORDER BY fecha_termino DESC LIMIT 1");
	
	if(mysqli_num_rows($rst) == 0){
		$fecha1 = "2007-01-01";
		$hoy = date("Y-m-d");
		$fecha2 = suma_dias_a_fecha_2(6,$fecha1);

		while($fecha2 < $hoy){
			consulta_sql("INSERT INTO eve_semana_boletin(semana,anio,fecha_inicio,fecha_termino) VALUES(".retorna_semana($fecha2).",".retorna_anho($fecha2).",'".$fecha1."','".$fecha2."')");
			$fecha1 = suma_dias_a_fecha_2(7,$fecha1);
			$fecha2 = suma_dias_a_fecha_2(6,$fecha1);
		}	
	}
	else{
		if($dato = mysqli_fetch_array($rst)){
			$fecha1 = $dato["fecha_inicio"];
	
			$fecha1 = suma_dias_a_fecha_2(7,$fecha1);
			$hoy = date("Y-m-d");
			$fecha2 = suma_dias_a_fecha_2(6,$fecha1);
	
			while($fecha2 < $hoy){
				consulta_sql("INSERT INTO eve_semana_boletin(semana,anio,fecha_inicio,fecha_termino) VALUES(".retorna_semana($fecha2).",".retorna_anho($fecha2).",'".$fecha1."','".$fecha2."')");
				$fecha1 = suma_dias_a_fecha_2(7,$fecha1);
				$fecha2 = suma_dias_a_fecha_2(6,$fecha1);
			}
			if($fecha2 == $hoy && date("H") > 7){
				consulta_sql("INSERT INTO eve_semana_boletin(semana,anio,fecha_inicio,fecha_termino) VALUES(".retorna_semana($fecha2).",".retorna_anho($fecha2).",'".$fecha1."','".$fecha2."')");
			}
		}
	}

?>