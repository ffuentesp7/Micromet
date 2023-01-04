<?php
include_once('twitter.func.php');
require_once('../funciones.inc.php');

$CURRENT_DATE = date('Y-m-d');

$SQL = "SELECT id,tweet FROM eve_twitter WHERE tweeted=0 ORDER BY date LIMIT 1";

$SQLR = consulta_sqlUTF8($SQL);

if($SQLD = mysqli_fetch_array($SQLR)){
    if(twitter_send(get_parameter('TWITTER_HASH'),$SQLD[1]) == 1){
        $SQL = "UPDATE eve_twitter SET tweeted=1 WHERE id=".$SQLD[0];
        comando_sql($SQL);
    }
}

$LASTHOUR = get_parameter('TWITTER_LAST_HOUR');
$LASTDATE = get_parameter('TWITTER_LAST_DATE');

$TEMPID = get_parameter('TWITTER_TEMP_ID');
$RHID = get_parameter('TWITTER_RH_ID');
$STAID = get_parameter('TWITTER_STATION_ID');

$STANAME  = get_parameter('TWITTER_STATION_NAME');


$HORA = '';
$FECHA = '';
$TEMP = 0.0;
$RH = 0.0;

$STATE1 = 1;
$STATE2 = 1;

$SQL = "SELECT fecha,hora,medicion,estado FROM medicion WHERE instrumento_id=$TEMPID ORDER BY fecha DESC, hora DESC LIMIT 1";

$SQLR = consulta_sql($SQL);

if($SQLD = mysqli_fetch_array($SQLR)){
    $STATE1 = $SQLD[3];
    if($SQLD[3] == 0){
        $HORA = $SQLD[1]; 
        $FECHA = $SQLD[0];
        $TEMP = $SQLD[2]; 
    }   
}


$CURRENT_HOUR = date('H:i:s');

$CURRENT_HOUR_NUMBER = split(':',$HORA);

$CURRENT_UNIX_TIMESTAMP = retorna_unix($CURRENT_DATE,$CURRENT_HOUR) - (60 * 60 * 2);

if(($CURRENT_HOUR_NUMBER[0] == 8 || $CURRENT_HOUR_NUMBER[0] == 12 || $CURRENT_HOUR_NUMBER[0] == 16 || $CURRENT_HOUR_NUMBER[0] == 20 || $CURRENT_HOUR_NUMBER[0] == 0) && retorna_unix($LASTDATE,$LASTHOUR) < retorna_unix($FECHA,$HORA) && retorna_unix($FECHA,$HORA) > $CURRENT_UNIX_TIMESTAMP){
    $SQL = "SELECT medicion,estado FROM medicion WHERE instrumento_id=$RHID AND fecha='$FECHA' AND hora='$HORA'";

    $SQLR = consulta_sql($SQL);
    
    if($SQLD = mysqli_fetch_array($SQLR)){
        $STATE2 = $SQLD[1];
        if($SQLD[1] == 0){
            $RH = $SQLD[0];
        }   
    }
    
    $TWEET = "Temperatura y Humedad en Talca, ".cambia_fecha_a_normal($FECHA)." a las $HORA hrs. Temp: ".number_format($TEMP, 0, '.', '')."°C, Hum: ".number_format($RH, 0, '.', '')."% en $STANAME @UTalca http://goo.gl/5cxpa";
    
    if($STATE1 == 0 && $STATE2 == 0 && twitter_send(get_parameter('TWITTER_HASH'),$TWEET) == 1){
        set_parameter('TWITTER_LAST_HOUR',$HORA);
        set_parameter('TWITTER_LAST_DATE',$FECHA);
        echo "Tweet OK";
    }
}
else{
    echo "No Tweet found";
}


?>