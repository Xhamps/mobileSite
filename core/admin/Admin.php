<?php


/**
*
*/
class AdminMb
{
  var $pathBase;
  var $mobile_settings;
  function __construct(&$settings)
  {
    $this->pathBase = 'mobileSite/mobileSite.php';
    $this->mobile_settings = $settings;
    $this->add_filters();

  }
  function add_filters(){
    add_action( 'admin_init', array(&$this , 'add_javaScript' ) ) ;
    add_action( 'admin_menu', array(&$this , 'add_options_menu' ) ) ;
    add_action( 'admin_head', array(&$this , 'add_admin_files' ) ) ;
    add_filter( 'plugin_action_links',  array(&$this ,'add_link_settings') , 9, 2 );
  }
  function add_options_menu() {
    add_options_page( __( 'MobileSite Options', 'wpMobileSite' ), 'MobileSite Config', 'manage_options',  $this->pathBase , array(&$this, 'generator_page') );
  }
  function add_link_settings( $links, $file ) {
    if( $file == $this->pathBase && function_exists( "admin_url" ) ) {
      $settings_link = '<a href="' . admin_url( 'options-general.php?page='. $this->pathBase ) . '">' . __('Settings') . '</a>';
      array_unshift( $links, $settings_link ); // after other links
    }
    return $links;
  }
  function generator_page(){
    //Validation to saved;

    if(isset($_POST)){
      $this->mobile_settings->save();
    }

    require_once("template/header.php");
    require_once("template/alert.php");
    echo "<form method=\"post\" action=\"".admin_url( 'options-general.php?page='.$this->pathBase )."\">";
      require_once("template/general-settings.php");
      echo "<input type=\"hidden\" name=\"mobile-nonce\" value=\"".$this->mobile_settings->create_nonce() ."\" />";
      echo "<input type=\"submit\" name=\"submit\" value=\"Save Options\" id=\"mobile-button\" class=\"button-primary\" />";
    echo "</form>";
  }
  function add_admin_files() {
    if ( isset( $_GET['page'] ) && $_GET['page'] == $this->pathBase ) {
      echo "<link rel='stylesheet' type='text/css' href='" . compat_get_plugin_url( 'mobileSite' ) . "/core/admin/template/css/admin.css' />\n";
    }
  }
  function add_javaScript(){
    if ( isset( $_GET['page'] ) && $_GET['page'] == $this->pathBase ) {
      wp_enqueue_script( 'mobileSite-js', compat_get_plugin_url( 'mobileSite' ) . '/core/admin/template/js/admin.js', array( 'jquery' ) );
    }
  }
}

?>