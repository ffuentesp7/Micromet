<?php
	if (!function_exists('str_split')){
		function str_split($string, $split_length=1){
		
			if ($split_length < 1){
				return false;
			}
		
			for ($pos=0, $chunks = array(); $pos < strlen($string); $pos+=$split_length){
				$chunks[] = substr($string, $pos, $split_length);
			}
			return $chunks;
		}
	}
	
	function encode_crypto($key,$text){
		
		$enc = '';
		
		$key2 = $key;
		$key = str_split($key);
		$text = str_split($text);

		for($i = 0, $j = 0; $i < count($text) && $j < count($key); $i++, $j++){
			$enc.=chr(ord($text[$i])+((int)$key[$j]));
			
			if($j == (count($key)-1))
				$j = -1;
		}
		
		return $enc;
	}
	
	function decode_crypto($key,$text){
		
		$enc = '';
		
		$key2 = $key;
		$key = str_split($key);
		$text = str_split($text);
	
		for($i = 0, $j = 0; $i < count($text) && $j < count($key); $i++, $j++){
			$enc.=chr(ord($text[$i])-((int)$key[$j]));
			
			if($j == (count($key)-1))
				$j = -1;
		}
		
		return $enc;
	}
?>