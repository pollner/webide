<?php

class IFrameCommand extends Command {
  public function doExecute( $request ) {
  
  	$content='';
  	
  	$path = $request['path'];
    	if(!$path) { $path = ''; }
    	$html_iconset='NAvI';
    	$content.='<iframe src='.$path.' width="100%" height="800" name="IFrame" ></iframe><br />
    	           <p>&nbsp;</p>';
    	
	$template=Factory::get("includes::classes::TemplateFluid");
	$template->load("includes/templates/IframeTemplate.html")
	
		->replace('{ICONSET}',$html_iconset)
		->replace('{CONTENT}',$content)            
	        ->render();	
	/*
    include_once("includes/templates/ServerTemplate.php");
    $microtime_end = microtime(true);
    echo $time = $microtime_end - Registry::get('microtime_start'). " seconds.";
    */
    if(Registry::get('deBug')==strtolower('on')) include_once("includes/deBug.php");
    
  }

}