<?php

require_once('../funciones.inc.php');

class eveSystem{

	var $id;
	var $nombre;
	var $pagPrincipal;
	
	function __construct($id){
		$this->id = $id;
			
		$SQL = 'SELECT nombre,pag_principal FROM eve_sistema WHERE id='$id;
		
		$SQLR = consulta_sql($SQL);
		
		if($SQLD = mysqli_fetch_array($SQLR)){
			$this->nombre = $SQLD['nombre'];
			$this->pagPrincipal = $SQLD['pag_principal'];
		}
	
	}



}

?>