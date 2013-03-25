<?php

//session_start();

class ServerCommand extends Command {
  public function doExecute( $request ) {
  /*  $name = $request['fc_name'];
    if(!$name) { 
      $name = 'Anonymous';
    }*/
    	
        $iconset='<a href="javascript: explorer()">
         	    <img title="Explorer" alt="Explorer" src="jqueryFileTree/images/explorer.png" style="">
         	   </a>'; 

        $content='<div id="sub"><b>Superglobals</b></div>';
	$content.="<table style='border: 1px dotted #eee'>";
		
	//$super=array($_COOKIE,$_SERVER,$_ENV);
	$super=array('_COOKIE','_SESSION','_SERVER','_ENV','_GLOBALS');
	
	foreach($super AS $k => $v){
		global $$v;
		if(is_array(${$v})){
			$content.="<tr><td><b>".$v."</b></td><td><b>".${$v}."</b></td></tr>";
		
			foreach(${$v} AS $key => $value) 
			{
				$content.="<tr><td>".$key."</td><td>".$value."</td></tr>";
			}
		}
	}	
	$content.="</table>";
	


    
    $template=Factory::get("includes::classes::TemplateFluid");
    $template->load("includes/templates/StandardTemplate.html")
    		->replace('{ICONSET}',$iconset)
    	        ->replace('{CONTENT}',$content);  
    	             
    $template->render();	
    /*
    include_once("includes/templates/ServerTemplate.php");
    $microtime_end = microtime(true);
    echo $time = $microtime_end - Registry::get('microtime_start'). " seconds.";
    */
   if(Registry::get('deBug')==strtolower('on')) include_once("includes/deBug.php");
    
  }

}