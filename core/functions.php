<?php
if ( !function_exists( 'compat_get_wp_content_dir' ) ) {
  function compat_get_wp_content_dir() {
    if ( defined( 'WP_CONTENT_DIR' ) ) {
      return WP_CONTENT_DIR;
    } else {
      return site_url() . '/wp-content';
    }
  }
}
if ( !function_exists( 'compat_get_base_plugin_dir' ) ) {
  function compat_get_base_plugin_dir() {
    return compat_get_wp_content_dir() . '/plugins';
  }
}
if ( !function_exists( 'compat_get_plugin_dir') ) {
  function compat_get_plugin_dir( $plugin_name ) {
    return compat_get_base_plugin_dir() . '/' . $plugin_name;
  }
}

?>