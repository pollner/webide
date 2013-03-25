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


if(isset($request['path']) && $request['path']!='') {


        //$request['path']=rawurlencode($request['path']);

	if(isset($request['mode']) && $request['mode']=='system') {
	
		$stdout='';
		$testfile=$request['path'];
		
			
		if(is_dir($testfile)) {	
		     systemtest($testfile);
	
		}
		else {
			//echo "<b>";
			//getJSON($testfile);
			systemtest($testfile);
			//echo "</b>";
		}
	}
	elseif(isset($request['mode']) && $request['mode']=='getJSON') {
	
		$stdout='';
		$testfile=$request['path'];
		
			
		if(is_dir($testfile)) {	
		     getJSON($testfile);
	
		}
		else {
			//echo "<b>";
			getJSON($testfile);
			//systemtest($testfile);
			//echo "</b>";
		}
	}	
	

       
       else {
    	$Template=Factory::get("includes::classes::TemplateFluid");
    	$Template->load("includes/templates/TestTemplate.html")
    			->replace('{TESTOBJECT}',utf8_encode($_GET['path']))
    			->replace('{ICONSET}',$html_iconset)
    	     		->replace('{CONTENT}',$html_content.utf8_encode($request['path']))     	              
    		        ->render();
    
    //include_once("includes/templates/StandardTemplate.html");
    	//Registry::set('Model',$Model);
    	//Registry::set('Req',$request);
    //$m=Registry::get('model');
    //if(Registry::get('debug')=='on') Factory::get('includes::classes::Debug','Model');
    if(Registry::get('debug')==strtolower('on')) Factory::get('includes::classes::Debug');
       }
       
    
  
  }else echo "Error....no file to test";
}
}

 function getJSON($tpath) {
 
 	//var $json_array=new Array();
 
 	if(file_exists($tpath)){
 	
 		
 		if (is_dir($tpath)) {
 			//$tpath=rawurlencode($tpath);
 			//$dirlist = getDirectoryTree($tpath,'php');
 			
 			$json_Array['type']="dir";
 			$json_Array['filelist']=rscandir($tpath);
 		        //$json_Array['filelist']=$dirlist;
 		        /*
 		        foreach($dirlist as $key => $value)
 		        {
 		        	//$json_Array['filelist']=rawurlencode($tpath.$value);
 		        	$json_Array['filelist']=$tpath.$value;
 		        }
 		        */
 			echo json_encode($json_Array);
 			//echo "<pre>".print_r($json_Array,true)."</pre>";
 		}
 		else {
 			$tpath=rawurlencode($tpath);
 			$json_Array['type']="file";
 		        $json_Array['filelist'][]=$tpath;
 			echo json_encode($json_Array);
 			
 		}
 	}
 	else echo "Error: file doesn't exist";
 }

 function systemtest ($tfile) {
	
	$cmd = 'php -l "'.$tfile.'"';
        $last_line=system($cmd);        
        
}

function getDirectoryTree( $outerDir , $x){
    $dirs = array_diff( scandir( $outerDir ), Array( ".", "..","" ) );
    $dir_array = Array();
    static $file_array;
    foreach( $dirs as $d ){
        if( is_dir($outerDir."/".$d)  ){
            $dir_array[ $d ] = getDirectoryTree( $outerDir."/".$d , $x);
        }else{
         if (($x)?ereg($x.'$',$d):1)
            $dir_array[ $d ] = $d;
            }
    }
    return $dir_array;
}

//$dirlist = getDirectoryTree('/Apache2/htdocs/jscodr/jscodr/test/','php');
//print_r($dirlist);

 
 function rscandir($base='', &$data=array()) {
 
  $array = array_diff(scandir($base), array('.', '..','')); # remove ' and .. from the array */
  
  foreach($array as $value) : /* loop through the array at the level of the supplied $base */
 
    if (is_dir($base.$value)) : /* if this is a directory */
      $data[] = rawurlencode($base.$value.'/'); /* add it to the $data array */
      $data = rscandir($base.$value.'/', $data); /* then make a recursive call with the
      current $value as the $base supplying the $data array to carry into the recursion */
     
    elseif (is_file($base.$value)) : /* else if the current $value is a file */
      $data[] = rawurlencode($base.$value); /* just add the current $value to the $data array */
     
    endif;
   
  endforeach;
 
  return $data; // return the $data array
 
}

//echo '<pre>'; var_export(rscandir('/Apache2/htdocs/jscodr/jscodr/')); echo '</pre>';
 
 


?>