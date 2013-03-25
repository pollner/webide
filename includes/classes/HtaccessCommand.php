<?php

class HtaccessCommand extends Command {
  public function doExecute( $request ) {
    /*$name = $request['fc_name'];
    if(!$name) { 
      $name = 'Anonymous';
    }*/
  
    include_once("includes/templates/HtaccessTemplate.php");
    if(Registry::get('debug')==strtolower('on')) Factory::get('includes::classes::Debug');
  }

}