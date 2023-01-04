<?php
	
	if(isset($_GET['function'])){
		
		switch($_GET['function']){
			case "login":
				header('Content-Type: text/xml');
				require('functions/login.php');
				break;
			case "getdatabaseconnection":
				require('functions/getdatabaseconnection.php');
				break;
			case "error":
				header('Content-Type: text/xml');
				require('functions/error.php');
				break;
			default:
				header('Content-Type: text/xml');
				$HTML = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>';
				$HTML.= '<response>';
				$HTML.= '<error code="02">Unknown function</error>';
				$HTML.= '</response>';
				
				echo $HTML;
				break;
		}
	}
	else{
		header('Content-Type: text/xml');
		$HTML = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>';
		$HTML.= '<response>';
		$HTML.= '<error code="00">Bad URL</error>';
		$HTML.= '</response>';
		
		echo $HTML;
	}
?>