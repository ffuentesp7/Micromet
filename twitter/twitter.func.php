<?php
require_once '../funciones.inc.php';
/**
 * Tweets a message from the user whose user token and secret you use.
 *
 * Although this example uses your user token/secret, you can use
 * the user token/secret of any user who has authorised your application.
 *
 * Instructions:
 * 1) If you don't have one already, create a Twitter application on
 *      https://dev.twitter.com/apps
 * 2) From the application details page copy the consumer key and consumer
 *      secret into the place in this code marked with (YOUR_CONSUMER_KEY
 *      and YOUR_CONSUMER_SECRET)
 * 3) From the application details page copy the access token and access token
 *      secret into the place in this code marked with (A_USER_TOKEN
 *      and A_USER_SECRET)
 * 4) Visit this page using your web browser.
 *
 * @author themattharris
 */
function twitter_send($H,$T){
    require_once 'tmhOAuth.php';
    require_once 'tmhUtilities.php';

    $HASH = $H;
    $TWIT = $T;
    
    if($HASH == get_parameter('TWITTER_HASH')){
      
      $NEWHASH = md5(genpass());
      set_parameter('TWITTER_HASH',$NEWHASH);
      
      $tmhOAuth = new tmhOAuth(array(
        'consumer_key'    => get_parameter('TWITTER_CONSUMER_KEY'),
        'consumer_secret' => get_parameter('TWITTER_CONSUMER_SECRET'),
        'user_token'      => get_parameter('TWITTER_USER_TOKEN'),
        'user_secret'     => get_parameter('TWITTER_USER_SECRET'),
      ));
      
      
      $code = $tmhOAuth->request('POST', $tmhOAuth->url('1/statuses/update'), array(
        'status' => $TWIT
      ));
      
      if ($code == 200) {
        return '1';
      } else {
        return $tmhOAuth->response['response'];
      }
      
    }
    else{
      return "Your hash code is invalid!";
    }
}

function twitter_save($tweet,$date){
    $fecha = date('Y-m-d');
    $tweet = $tweet;
    $SQL = "SELECT forecast_date FROM eve_twitter ORDER BY forecast_date DESC LIMIT 1";
    
    $SQLR = consulta_sqlUTF8($SQL);
    $fecha_anterior = '1979-01-01';
    
    if($SQLD = mysqli_fetch_array($SQLR)){
        $fecha_anterior = $SQLD[0];
    }
    
    if(retorna_unix($fecha_anterior,'00:00:00') < retorna_unix($date,'00:00:00')){
        $SQL = "INSERT INTO eve_twitter (tweet, tweeted, date, forecast_date) VALUES ('$tweet', 0, '$fecha','$date')";
        
        if(comando_sqlUTF8($SQL)){
            return 1;
        }
        else{
            return 0;
        }
    }
}

?>