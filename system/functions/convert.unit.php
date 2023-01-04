<?php


//km/h a m/s
function kmh2ms($value){
	return $value / 3.6;
}

// m/s a km/h
function ms2kmh($value){
	return $value * 3.6;
}

/*/ w/m2 a MJ/m2
function wm22MJm2($value){
	return $value*60.0*15.0/1000000.0;
}*/

// w/m2 a MJ/m2
function Wm22MJm2($value,$interval){
	return $value*60.0*$interval/1000000.0;
}

// w/m2 a MJ/m2/day
function Wm22MJm2day($value){
	return $value*0.0864;
}

// w/m2 a MJ/m2/week
function Wm22MJm2week($value){
	return $value*0.6048;
}

?>