<?php
if ( !function_exists( 'mb_generaterLink' ) ) {
  function mb_generaterLink($view , $content){
    global $wpMobileSite;
    if($wpMobileSite){
      return $wpMobileSite->generaterLink($view , $content);
    }
    return '';
  }
}

if ( !function_exists( 'mb_isMobile' ) ) {
  function mb_isMobile(){
    global $wpMobileSite;
    if($wpMobileSite){
      return $wpMobileSite->isMobile();
    }
    return false;
  }
}
?>