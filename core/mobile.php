<?php


/**
*
*/
class Mobile
{
  var $isMobile;
  var $desired_view;
  var $useragents;
  var $mobile_settings;
  function __construct(&$settings)
  {
    # code...
    $this->mobile_settings = $settings;

    $this->isMobile = false;
    $this->registerDevice();
  }
  function registerDevice(){

    $this->useragents = array(
                          'iPhone',           // iPhone
                          'iPod',             // iPod touch
                          'incognito',        // iPhone alt browser
                          'webmate',        // iPhone alt browser
                          'Android',          // Android
                          'dream',          // Android
                          'CUPCAKE',        // Android
                          'froyo',            // Android
                          'BlackBerry9500',     // Storm 1
                          'BlackBerry9520',     // Storm 1
                          'BlackBerry9530',     // Storm 2
                          'BlackBerry9550',     // Storm 2
                          'BlackBerry 9800',  // Torch
                          'BlackBerry 9850',  // Torch 2
                          'BlackBerry 9860',  // Torch 2
                          'BlackBerry 9780',  // Bold 3
                          'BlackBerry 9790',  // Bold Touch
                          'BlackBerry 9900',  // Bold
                          'BlackBerry 9930',  // Bold
                          'BlackBerry 9350',  // Curve
                          'BlackBerry 9360',  // Curve
                          'BlackBerry 9370',  // Curve
                          'BlackBerry 9380',  // Curve
                          'BlackBerry 9810',  // Torch
                          'BB10',           // BlackBerry 10 devices
                          'webOS',          // Palm Pre/Pixi
                          's8000',          // Samsung s8000
                          'bada',           // Samsung Bada Phone
                          'Googlebot-Mobile', // Google's mobile Crawler
                          'AdsBot-Google'   // Google's Ad Bot Crawler
                          );


  }
  function detectMobile() {

    $container = $_SERVER['HTTP_USER_AGENT'];

    foreach ( $this->useragents as $useragent ) {
      if ( preg_match( "#$useragent#i", $container ) ) {
        $this->isMobile = true;
        break;
      }
    }

    $this->checkCookie();
  }
  function wpmobile_check_switch_redirect() {
    if ( isset( $_GET['wpmobile_redirect'] ) ) {
      if ( isset( $_GET['wpmobile_nonce'] ) ) {
        $nonce = $_GET['wpmobile_nonce'];
        if ( !wp_verify_nonce( $nonce, 'wpmobile_redirect' ) ) {
          _e( 'Nonce failure');
          die;
        }

        $protocol = ( !empty($_SERVER['HTTPS']) ) ? 'https://' : 'http://';
        $redirect_location = $protocol . $_SERVER['SERVER_NAME'] . $_GET['wpmobile_redirect'];

        header( 'Location: ' . $redirect_location );
        die;
      }
    }
  }
  function checkCookie() {
    $key = 'wpmobile_view';
    $time = time()+60*60*24*365; // one year
    $url_path = '/';

    if ( isset( $_GET[ 'wpmobile_view'] ) ) {
      if ( $_GET[ 'wpmobile_view' ] == 'mobile' ) {
        setcookie( $key, 'mobile', $time, $url_path );
      } elseif ( $_GET[ 'wpmobile_view' ] == 'full') {
        setcookie( $key, 'normal', $time, $url_path );
      }
    }

    if (isset($_COOKIE[$key])) {
      $this->desired_view = $_COOKIE[$key];
    } else {
     if ($this->isMobile) {
        $this->desired_view = 'mobile';
      } else {
          $this->desired_view = 'full';
      }
    }

  }
  function changeTheme(){
    return ($this->isMobile && $this->desired_view === 'mobile');
  }

  function generatorLink($view = 'mobile' , $content = ''){
    return "<a id='switch-link' href=\"" . home_url() . "/?wpmobile_view=".$view."&wpmobile_nonce=" . wp_create_nonce( 'wpmobile_redirect' ) . "&wpmobile_redirect=" . urlencode( $_SERVER['REQUEST_URI'] ) . "\">" . $content . "</a>";
  }
}
?>