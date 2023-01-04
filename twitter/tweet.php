<?php

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

require 'tmhOAuth.php';
require 'tmhUtilities.php';
require '../funciones.inc.php';


if(isset($_REQUEST['h']) && isset($_REQUEST['t'])){
  
  $HASH = $_REQUEST['h'];
  $TWIT = $_REQUEST['t'];
  
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
      echo '1';
    } else {
      tmhUtilities::pr($tmhOAuth->response['response']);
    }
    
  }
  else{
    echo "Your hash code is invalid!";
    
  }
}
else{
   echo "You cannot use this service";
  
}


?>