<?php
  echo '<h1>Create a new template</h1>';
  echo '<br/>';
  if ( function_exists( 'mb_generaterLink' ) ){
     echo mb_generaterLink('full' , "Full Site");
  }
?>