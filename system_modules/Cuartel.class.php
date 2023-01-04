<?php


class Cuartel{

	var $cuartel_nombre;
	var $cultivo_nombre;
	var $variedad_nombre;
		
	var $dist_en_ileras;
	var $dist_so_ileras;
	var $crit_riego;
	var $estr1_textura;
	var $estr1_grosor;
	var $estr1_cc;
	var $estr1_pmp;	
	var $estr2_textura;
	var $estr2_grosor;
	var $estr2_cc;
	var $estr2_pmp;
	var $estr3_textura;
	var $estr3_grosor;
	var $estr3_cc;
	var $estr3_pmp;
	var $ancho_moj;
	var $caud_emis;
	var $num_emis_planta;
	var $efis_riego;
	var $coef_unif;
	
	var $id;
	var $usuario_id;

	function __construct($ID){
		$this->id = $ID;
		
		$SQL = "SELECT
					usuario_id,
					cuartel,
					cultivo,
					variedad,
					dist_entre_hileras,
					dist_sobre_hileras,
					criterio_riego,
					estrata_1_grosor,
					estrata_1_textura,
					estrata_1_cc,
					estrata_1_pmp,
					estrata_2_grosor,
					estrata_2_textura,
					estrata_2_cc,
					estrata_2_pmp,
					estrata_3_grosor,
					estrata_3_textura,
					estrata_3_cc,
					estrata_3_pmp,
					ancho_mojado,
					caudal_emisor,
					numero_emisores_por_planta,
					eficiencia_riego,
					coeficiente_uniformidad
				FROM eve_mod_remote_sensing_cropsector
				WHERE id=".$this->id;
				
		$SQLR = consulta_sql($SQL);
		
		if($SQLD = mysql_fetch_assoc($SQLR)){
			$this->usuario_id = $SQLD['usuario_id'];
			$this->cuartel_nombre = $SQLD['cuartel'];
			$this->cultivo_nombre = $SQLD['cultivo'];
			$this->variedad_nombre = $SQLD['variedad'];
			$this->dist_en_ileras = $SQLD['dist_entre_hileras'];
			$this->dist_so_ileras = $SQLD['dist_sobre_hileras'];
			$this->crit_riego = $SQLD['criterio_riego'];
			$this->estr1_grosor = $SQLD['estrata_1_grosor'];
			$this->estr1_textura = $SQLD['estrata_1_textura'];
			$this->estr1_cc = $SQLD['estrata_1_cc'];
			$this->estr1_pmp = $SQLD['estrata_1_pmp'];
			$this->estr2_grosor = $SQLD['estrata_2_grosor'];
			$this->estr2_textura = $SQLD['estrata_2_textura'];
			$this->estr2_cc= $SQLD['estrata_2_cc'];
			$this->estr2_pmp = $SQLD['estrata_2_pmp'];
			$this->estr3_grosor = $SQLD['estrata_3_grosor'];
			$this->estr3_textura = $SQLD['estrata_3_textura'];
			$this->estr3_cc = $SQLD['estrata_3_cc'];
			$this->estr3_pmp = $SQLD['estrata_3_pmp'];
			$this->ancho_moj = $SQLD['ancho_mojado'];
			$this->caud_emis = $SQLD['caudal_emisor'];
			$this->num_emis_planta = $SQLD['numero_emisores_por_planta'];
			$this->efis_riego = $SQLD['eficiencia_riego'];
			$this->coef_unif = $SQLD['coeficiente_uniformidad'];
		}
		else{
			$this->id = 0;
		}

	}
}	
?>