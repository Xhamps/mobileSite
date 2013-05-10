<?php
/*
Plugin Name: Mobile Site
Version: 1.0
Description: A plugin uses the 'HTTP_USER_AGENT' to choose the theme for your site.
Author: Xhamps
Author URI: http://www.xhamps.com.br
Text Domain: mobileSite

License: GNU General Public License 2.0 (GPL) http://www.gnu.org/licenses/gpl.html

*/

 require_once("core/helpers.php");
 require_once("core/mobile.php");
 require_once("core/Settings.php");

if(!defined("DOING_AJAX")) define("DOING_AJAX" , false);

 if ( is_admin() ) {
   require_once("core/admin/Admin.php");
 }
class MobileSite
{
  var $mobile;
  var $admin;
  var $mobile_settings;
  function MobileSite()
  {
    $this->mobile_settings = new Settings();

    $this->mobile = new Mobile($this->mobile_settings);

    $this->mobile->detectMobile();

    $this->addFilters();


    if(is_admin()){
      $this->admin = new AdminMb($this->mobile_settings);
    }

  }

  function addFilters(){
    if ( !is_admin()  || DOING_AJAX ) {
      add_filter( 'stylesheet', array(&$this, 'get_stylesheet') );
      add_filter( 'theme_root', array(&$this, 'theme_root') );
      //add_filter( 'theme_root_uri', array(&$this, 'theme_root_uri') );
      add_filter( 'template', array(&$this, 'get_template') );
    }

    add_filter( 'init', array(&$this->mobile, 'wpmobile_check_switch_redirect') );
  }

  function get_stylesheet( $stylesheet ) {
    if (( $this->mobile->changeTheme() && !is_admin() ) || DOING_AJAX ) {
      return 'default';
    } else {
      return $stylesheet;
    }
  }
  function get_template( $template ) {
    if (( $this->mobile->changeTheme() && !is_admin() ) || DOING_AJAX ) {
      return $this->mobile_settings->getValue('mobile-theme');
    } else {
      return $template;
    }
  }
  function theme_root( $path ) {
    $nameTheme = $this->mobile_settings->getValue('mobile-theme');

    if($nameTheme == 'default' && (( $this->mobile->changeTheme() && !is_admin() ) || DOING_AJAX )){
      return plugins_url( 'mobileSite' ) . "/themes";
    } else {
      return $path;
    }
  }

  function theme_root_uri( $url ) {
    if (( $this->mobile->changeTheme() && !is_admin() ) || DOING_AJAX ){
      $nameTheme = $this->mobile_settings->getValue('mobile-theme');
      if($nameTheme != 'default'){
        return theme_url() . $nameTheme ;
      }else{
        return plugins_url('wptouch' ) . "/themes";
      }
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