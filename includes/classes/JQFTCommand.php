<?php

class JQFTCommand extends Command {
  public function doExecute( $request ) {
    /*$name = $request['fc_name'];
    if(!$name) { 
      $name = 'Anonymous';
    }*/
  
    include_once("includes/templates/JQFTTemplate.php");
    if(Registry::get('debug')=='on') Factory::get('includes::classes::Debug');
  }

}