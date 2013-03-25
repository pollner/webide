<?php

class PhpshellCommand extends Command {
  public function doExecute( $request ) {
    /*$name = $request['fc_name'];
    if(!$name) { 
      $name = 'Anonymous';
    }*/
    
    include_once("includes/templates/PhpshellTemplate.php");
    if(Registry::get('deBug')==strtolower('on')) include_once("includes/deBug.php");
  }

}