<?php

class PhpinfoCommand extends Command {
  public function doExecute( $request ) {
    /*$name = $request['fc_name'];
    if(!$name) { 
      $name = 'Anonymous';
    }*/
    include_once("includes/templates/PhpinfoTemplate.php");
  }

}