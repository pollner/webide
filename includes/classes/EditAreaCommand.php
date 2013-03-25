<?php

class EditAreaCommand extends Command {
  public function doExecute( $request ) {
    /*$name = $request['fc_name'];
    if(!$name) { 
      $name = 'Anonymous';
    }*/
    //print_r($request);
    //$EAPro=Factory::get('includes::classes::Profiler');
    //$EAPro->pp_extension($request['dir']);
    //echo $EAPro->path_stat($request['dir']);
  

    
    ////////////////////////////////////////


	function fileloader($filepath) {
		
		//echo $filename=$filepath;
		//echo utf8_encode($filename);
		if(file_exists($filename)) {
			$handle=fopen("$filename","r");
			if(filesize($filename)>0) {
				$conts = fread($handle, filesize($filename));
			} 
			else $conts='';
			fclose($handle);
			//$this->html=$contents;
			//$this->fillin('{PFAD_CSS}','css/');
		} else {
			$conts='File : '.$filename.' FAILED';
			return $conts;
		}
		return $conts;
	}

	 function findexts ($f_path) 
	 { 
	 $f_path = strtolower($f_path) ; 
	 //$exts = split("[/\\.]", $f_path) ;
         $exts = explode(".", $f_path) ; 
	 $n = count($exts)-1; 
	 $exts = $exts[$n]; 
	 // echo $exts;
	 
	 switch($exts){
	 	case 'c': $ext='C';break;
	 	case 'cpp': $ext='CPP';break;
	 	case 'css': $ext='CSS';break;
	 	case 'html': $ext='HTML';break;
	 	case 'html': $ext='HTML';break;
	 	case 'js': $ext='JS';break;
	 	case 'java': $ext='Java';break;
	 	case 'php': $ext='PHP';break;
	 	case 'txt': $ext='ROBOTSTXT';break;
	 	case 'sql': $ext='SQL';break;
	 	case 'xml': $ext='XML';break;
	 	
	 	default:$ext='ROBOTSTXT';
	 }
	 
	 return $ext; 
	 } 



if(isset($_GET['dir']) && $_GET['dir']!=''){
	$cwd = getcwd();
        $file = $_GET['dir'];
	$fileext=findexts ($file);
	//$contents=fileloader(urldecode($file));
	if(isset($_GET['set']) && $_GET['set']=='js') {
		//$contents=fileloader(rawurldecode($file));
	 	$file=utf8_decode($file);
	}
	else {
		//$contents=fileloader(urldecode($file));
	//$contents=fileloader(utf8_decode($file));
	}
	
}
else  {
	$file='';
	$fileext='';
	$contents='';
}

    include_once("includes/templates/EditAreaTemplate.php");
    
    if(Registry::get('debug')==strtolower('on')) Factory::get('includes::classes::Debug');  
    
    
  }

}