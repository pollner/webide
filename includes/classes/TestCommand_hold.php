<?php

class TestCommand extends Command {
  public function doExecute( $request ) {
  
    
   // $html_content.='<br/><br/>';
     
     	 
    $Model=Factory::get('includes::classes::Build');
    $Model->attach(Factory::get('includes::classes::ServerObserver'));
    $Model->attach(Factory::get('includes::classes::NavigationObserver'));   
    //$Model->add(Factory::get('includes::classes::TestTemplateCmd'));
    $Model->make();         	                      
       
    $html_iconset='<a href="javascript: explorer()">
         	     <img title="Explorer" alt="Explorer" src="jqueryFileTree/images/explorer.png" style="">
         	   </a>
         	   <a href="javascript: parent.Daten.location.reload(false)">
         	     <img title="Reload" alt="Explorer" src="jqueryFileTree/images/refresh.gif" style="">
         	   </a>';  
    $html_content='';       


if(isset($_POST['path']) && $_POST['path']!='') {

	if(isset($request['mode']) && $request['mode']=='system') {
	
		$stdout='';
		$testfile=$request['path'];
		
			
		if(is_dir($testfile)) {	
		     echo 'alert("scandir");';
	
		}
		else {
			//echo "<b>";
			systemtest($testfile);
			//echo "</b>";
		}
	}	
	

       
      else {
    	$Template=Factory::get("includes::classes::TemplateFluid");
    	$Template->load("includes/templates/TestTemplate.html")
    			->replace('{TESTOBJECT}',utf8_encode($request['path']))
    			->replace('{ICONSET}',$html_iconset)
    	     		->replace('{CONTENT}',$html_content.utf8_encode($request['path']))     	              
    		        ->render();
    
    //include_once("includes/templates/StandardTemplate.html");
    	Registry::set('Model',$Model);
    	Registry::set('Req',$request);
    //$m=Registry::get('model');
    //if(Registry::get('debug')=='on') Factory::get('includes::classes::Debug','Model');
    //if(Registry::get('debug')==strtolower('on')) Factory::get('includes::classes::Debug');
    }
    
  
  }else echo "Error....no file to test";
}

 function systemtest ($tfile) {
	
	$cmd = 'php -l "'.$tfile.'"';
        echo $last_line=system($cmd);        
        
}
?>