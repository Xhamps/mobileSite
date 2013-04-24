<?php
/**
*
*/
class Settings
{
  var $mobile_settings;
  function __construct()
  {
    # code...
    $this->mobile_settings = array(
      'mobile-theme' =>  ''
      );
    $this->_get_values();
  }

  function create_nonce(){
    return wp_create_nonce( 'mobileSite-nonce' );
  }
  function check_nonce($nonce){
    return wp_verify_nonce($nonce, 'mobileSite-nonce' );
  }

  function getValue($label){
    return (isset($this->mobile_settings[$label])) ? $this->mobile_settings[$label] :  '';
  }

  function save(){
    if ( isset( $_POST['submit'] ) ) {

      $nonce = $_POST['mobile-nonce'];

      // Security
      if ( !$this->check_nonce( $nonce) ) {
        _e( "Nonce Failure");
        die;
      }
      if ( !current_user_can( 'manage_options' ) ) {
        _e( "Security failure.  Please log in again.");
        die;
      }


      foreach ($this->mobile_settings as $label => $value ) {
        if( isset( $_POST[$label] ) ){
          $this->mobile_settings[$label] = $_POST[$label];
        }
      }

      $values = serialize($this->mobile_settings);

      update_option("mobile_settings" , $values);
    }
  }
  function _get_values(){
    $v = get_option("mobile_settings");

    if (!$v) {
      $v = array();
    }

    if (!is_array($v)) {
      $v = unserialize($v);
    }

    foreach ($this->mobile_settings as $label => $value) {
        if( isset( $v[$label] ) ){
          $this->mobile_settings[$label] = $v[$label];
        }
    }

  }
}
?>