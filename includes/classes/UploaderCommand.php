<?php

class UploaderCommand extends Command {
  public function doExecute( $request ) {
    /*$name = $request['fc_name'];
    if(!$name) { 
      $name = 'Anonymous';
    }*/
    
    //$EAPro=Factory::get('includes::classes::Profiler');
    //echo $EAPro->pp_extension($request['dir']);
    //print_r($EAPro->path_stat($request['dir']));
//    include_once($_SERVER['DOCUMENT_ROOT']."/profiler/p/profiler/includes/templates/ExplorerTemplate.php");
    include_once("includes/templates/UploaderTemplate.php");
    if(Registry::get('debug')==strtolower('on')) Factory::get('includes::classes::Debug');
  }

}