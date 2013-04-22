<?php
/*
Plugin Name: Mobile Site
Version: 1.0
Description: A plugin which formats your site with a mobile theme for visitors on Apple <a href="http://www.apple.com/iphone/">iPhone</a> / <a href="http://www.apple.com/ipodtouch/">iPod touch</a>, <a href="http://www.android.com/">Google Android</a>, <a href="http://www.blackberry.com/">Blackberry Storm and Torch</a>, <a href="http://www.palm.com/us/products/phones/pre/">Palm Pre</a> and other touch-based smartphones.
Author: Xhamps
Author URI: http://www.xhamps.com.br
Text Domain: mobileSite

License: GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html


*/

 require_once("core/functions.php");
 require_once("core/helpers.php");
 require_once("core/mobile.php");

class MobileSite
{
  var $mobile;
  function MobileSite()
  {
    # code...
    $this->mobile = new Mobile();

    $this->mobile->detectMobile();

    $this->addFilters();


  }

  function addFilters(){

    if ( !is_admin() ) {
      add_filter( 'stylesheet', array(&$this, 'get_stylesheet') );
      add_filter( 'theme_root', array(&$this, 'theme_root') );
      add_filter( 'theme_root_uri', array(&$this, 'theme_root_uri') );
      add_filter( 'template', array(&$this, 'get_template') );
    }
    add_filter( 'init', array(&$this->mobile, 'wpmobile_check_switch_redirect') );
  }

  function get_stylesheet( $stylesheet ) {
    if ($this->mobile->changeTheme()) {
      return 'default';
    } else {
      return $stylesheet;
    }
  }
  function get_template( $template ) {
    if ($this->mobile->changeTheme()) {
      return 'default';
    } else {
      return $template;
    }
  }
  function theme_root( $path ) {
    $theme_root = compat_get_plugin_dir( 'mobileSite' );
    if ($this->mobile->changeTheme()) {
      return $theme_root . '/themes';
    } else {
      return $path;
    }
  }

  function theme_root_uri( $url ) {
    if ($this->mobile->changeTheme()) {
      return compat_get_plugin_url( 'mobileSite' ) . "/themes";
    } else {
      return $url;
    }
  }
  function generaterLink($view , $content){
    return $this->mobile->generatorLink($view , $content);
  }
  function isMobile(){
    return $this->mobile->isMobile;
  }
}
global $wpMobileSite;
$wpMobileSite = new MobileSite();
?>