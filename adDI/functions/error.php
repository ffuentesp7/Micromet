<?php

	$MSG = '';
	switch($_GET['e']){
		case '00': 
			$MSG = 'Bad URL';
			break;
		case '01': 
			$MSG = 'Session Close';
			break;
		case '02':
			$MSG = 'Unknown function';
			break;
		case '03':
			$MSG = 'There is no key available';
			break;
		case '04':
			$MSG = 'The key is not valid. You must obtain a new.';
			break;
		case '05':
			$MSG = 'User does not exists';
			break;
		case '06':
			$MSG = 'Password is incorrect';
			break;
		case '07':
			$MSG = 'MySQL Error: connection';
			break;
		case '08':
			$MSG = 'MySQL Error: query';
			break;
		default:
			$MSG = 'Unknown error';
			break;
	}

	$HTML = '<?xml version="1.0" encoding="UTF-8" standalone="no"?>';
	$HTML.= '<response>';
	$HTML.= '<error code="'.$_GET['e'].'">'.$MSG.'</error>';
	$HTML.= '</response>';

	echo $HTML;
	exit;

?>