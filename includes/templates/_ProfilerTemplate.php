<?php
//header('Content-Type: text/plain; charset=utf-8');

    function smartCopy($source, $dest, $options=array('folderPermission'=>0775,'filePermission'=>0775))
    {
        $result=false;
       
        if (is_file($source)) {
            if ($dest[strlen($dest)-1]=='/') {
                if (!file_exists($dest)) {
                    cmfcDirectory::makeAll($dest,$options['folderPermission'],true);
                }
                $__dest=$dest."/".basename($source);
            } else {
                $__dest=$dest;
            }
            $result=@copy($source, $__dest);
            chmod($__dest,$options['filePermission']);
           
        } elseif(is_dir($source)) {
            if ($dest[strlen($dest)-1]=='/') {
                if ($source[strlen($source)-1]=='/') {
                    //Copy only contents
                } else {
                    //Change parent itself and its contents
                    $dest=$dest.basename($source);
                    @mkdir($dest);
                    chmod($dest,$options['filePermission']);
                }
            } else {
                if ($source[strlen($source)-1]=='/') {
                    //Copy parent directory with new name and all its content
                    @mkdir($dest,$options['folderPermission']);
                    chmod($dest,$options['filePermission']);
                } else {
                    //Copy parent directory with new name and all its content
                    @mkdir($dest,$options['folderPermission']);
                    chmod($dest,$options['filePermission']);
                }
            }

            $dirHandle=opendir($source);
            while($file=readdir($dirHandle))
            {
                if($file!="." && $file!=".." && $file!="") {
               
                    if(!is_dir($source."/".$file)) {
                        $__dest=$dest."/".$file;
                    } else {
                        $__dest=$dest."/".$file;
                    }
                    //echo "$source/$file ||| $__dest<br />";
                    $result=@smartCopy($source."/".$file, $__dest, $options);
                }
                else $result=true;
                
            }
            closedir($dirHandle);
           
        } else {
            $result=false;
        }
        return $result;
    }


	function fileloader($filepath) {
		
		$filename=$filepath;
		if(file_exists($filename)) {
			$handle=fopen("$filename","r");
			$conts = fread($handle, filesize($filename));
			 
			fclose($handle);
			//$this->html=$contents;
			//$this->fillin('{PFAD_CSS}','css/');
		} else {
			$conts='File : '.$datei.' FAILED';
		}
		return $conts;
	}
	
	function openFile($file, $mode, $input) {
    	if ($mode == "READ") {
        	if (file_exists($file)) {
                    $size=filesize($file);
        	    if($size>0){		
	            	$handle = fopen($file, "r");
	            	$output = fread($handle, filesize($file));
	            	return $output; // output file text
	            }
	            else return '';
	        } else {
	            return false; // failed.
	        }
	} 
	elseif ($mode == "WRITE") {
	        $handle = fopen($file, "w");
	        if (fwrite($handle, $input)=== FALSE) {
	            return false; // failed.
	        } else {
	            return true; //success.
	        }
	} 
	elseif ($mode == "READ/WRITE") {       
	        if (file_exists($file) && isset($input)) {
	            $handle = fopen($file ,"r+");
	            $read = fread($handle, filesize($file));
	            $data = $read.$input;
	            if (!fwrite($handle, $data)) {
	                return false; // failed.
	            } else {
	                return true; // success.
	            }
	        } else {
	            return false; // failed.
	        }
	    } else {
	        return false; // failed.
	    }
	    fclose($handle);
	}
	
	
	 function rrmdir($dir,$bool=true) {
	 
	   $b=$bool;
	   if (is_dir($dir)) {
	     $objects = scandir($dir);
	     foreach ($objects as $object) {
	       if ($object != "." && $object != "..") {
	         if (filetype($dir."/".$object) == "dir") @rrmdir($dir."/".$object,$b); 
	         else {
	         	if(!@unlink($dir."/".$object)) $b=false;
	         }
	       }
	     }
	     reset($objects);
	     if(!@rmdir($dir)) $b=false;
	   }
	   return $b;
	 }
		

		
/*	
  function create_file($create_name='profiler_empty.txt', $file_content='')
   {
    
    $c_file = $create_name;
    $retmsg.=$c_file;
    $f_content= $file_content;
    $retmsg.=$f_content;
    $fp = fopen($c_file, 'w')    ? $retmsg.="ok " : $retmsg.="failure "; 
    flock($fp, 2)                ? $retmsg.="ok " : $retmsg.="failure "; 
    fwrite($fp, $f_content)      ? $retmsg.="ok " : $retmsg.="failure ";
    flock($fp, 3)                ? $retmsg.="ok " : $retmsg.="failure "; 
    fclose($fp)                  ? $retmsg.="ok " : $retmsg.="failure "; ;
    
    return $retmsg;
   }	
*/

$c='';
$f='';
$m='';

if(isset($_POST['fid']) && $_POST['fid']!=''){
		
		$f=utf8_decode($_POST['fid']);
		
		if(isset($_POST['mode']) && $_POST['mode']!='' && isset($_POST['content']) /*&& $_POST['content']!=''*/){
	
			$m=$_POST['mode']; $c=$_POST['content'];
		}	
		switch ($m) {
	    
			case 'READ'  : 	$m="READ"; 
	        			break;
	        					
	    		case 'WRITE' : 	$m="WRITE";  
	        			break;
	        					
	    		    default  :  $m="READ";
			
		}
		$out=openFile($f,$m,$c);
		if($out===true){
		$out=utf8_encode($f);
		}
		//echo utf8_encode($out);	
		echo $out;		
		/*
		$out=openFile($f,$m,$c);
		if($out===true){
		$out="Did ".strtolower($m)."\n".$f." .";
		}
		else $out="Could not ".strtolower($m)."\n".$f." !\nPermissions?";
		echo utf8_encode($out);	*/
}
elseif(isset($_POST['del']) && $_POST['del']!='' ){

	$del=utf8_decode($_POST['del']);

	if(is_file($del)){
		//try {
			if(!@unlink($del)){
				echo "Could not delete ".utf8_encode($del)." !\nPermissions?";
			}
			else echo utf8_encode($del)."\n deleted!";
		//}
		//catch($e)
	}
	elseif(is_dir($del)){
		if(@rrmdir($del))
			echo utf8_encode($del)."\n deleted!";
		else echo "Could not delete\n".utf8_encode($del)." !\nPermissions?";
		
	}
	else echo utf8_decode($del).' not found';

}
elseif(isset($_POST['mkdir']) && $_POST['mkdir']!='' ){	
	
	$mkdir=utf8_decode($_POST['mkdir']);
	
	
	
	if(!@mkdir($mkdir,0777,true)){
	  echo "Could not create: ".utf8_encode($mkdir)." !\nPermissions?";
	}
	else echo utf8_encode($mkdir)."\n was created";

}

elseif(isset($_POST['mkfile']) && $_POST['mkfile']!='' ){	
	$mkfile=utf8_decode($_POST['mkfile']);
	//$mkfile=utf8_encode(urldecode($_POST['mkfile']));
		$output=@touch($mkfile);
	
		
		//$output=openFile($mkfile,'WRITE','');
		if($output===true){
			chmod($mkfile,0775);
			$output=$mkfile." was created.";
	           	echo utf8_encode($mkfile);
		}
		else {
			echo "Could not create ".utf8_encode($mkfile)." !\nPermissions?";
		}

}

elseif(isset($_POST['cp']) && $_POST['cp']!='' && isset($_POST['cpto']) && $_POST['cpto']!=''){

	$oldfile=utf8_decode($_POST['cp']);
	$newfile=utf8_decode($_POST['cpto']);
	//rename($oldfile,$newfile);
	$checkstring='';
     
     
     	if(@smartCopy($oldfile,$newfile)) echo utf8_encode($oldfile)."\n copied to \n".utf8_encode($newfile);
     	else echo "Copying failed...Permissions?"; 
        	
/*	
	if(file_exists($oldfile)) {
	
		substr($oldfile, -1, 1)=='/' ? $oldfile = substr($oldfile, 0, -1) : '' ;        
	        substr($newfile, -1, 1)=='/' ? $newfile = substr($newfile, 0, -1) : '' ;        
	        $checkarray=explode("/",$newfile);	
	        array_pop($checkarray);
	        $checkstring=implode('/',$checkarray);
	        if(is_dir($checkstring))
	        {
	        	if(copy($oldfile,$newfile)) echo $oldfile."\n copied to \n".$newfile;	         
			else "Copying failed...\n".$newfile."\doesn't exists.";
		}
		else echo "Copying failed... \n ".$checkstring." \nis not a directory"; 
		
		//rename($_POST['ren'],$_POST['rento']);
	}
        else echo "File ".$oldfile." doesn't exists...";
*/
}




elseif(isset($_POST['ren']) && $_POST['ren']!='' && isset($_POST['rento']) && $_POST['rento']!=''){

	$oldfile=utf8_decode($_POST['ren']);
	$newfile=utf8_decode($_POST['rento']);
	//rename($oldfile,$newfile);
	$checkstring='';
	
	
	if(file_exists($oldfile)) {
	
		substr($oldfile, -1, 1)=='/' ? $oldfile = substr($oldfile, 0, -1) : '' ;        
	        substr($newfile, -1, 1)=='/' ? $newfile = substr($newfile, 0, -1) : '' ;        
	        $checkarray=explode("/",$newfile);	
	        array_pop($checkarray);
	        $checkstring=implode('/',$checkarray);
	        if(is_dir($checkstring))
	        {
	        	//if(rename($oldfile,$newfile)) echo utf8_encode($oldfile)."\n renamed to \n".utf8_encode($newfile);	         
	        	if(!@rename($oldfile,$newfile)) echo "Renaming failed...\n".utf8_encode($newfile)."\ndoesn't exists. Permissions?";
			//else "Renaming failed...\n".utf8_encode($newfile)."\doesn't exists.";
			else echo utf8_encode($oldfile)."\n renamed to \n".utf8_encode($newfile);             
		}
		else echo "Renaming failed... \n ".$checkstring." \nis not a directory"; 
		
		//rename($_POST['ren'],$_POST['rento']);
	}
        else echo "File ".utf8_encode($rento)." doesn't exists...";

}

elseif(isset($_POST['show']) && $_POST['show']!='')
{
	$show=utf8_decode($_POST['show']);
	//echo substr(Registry::get('docroot'), 0, strrpos(Registry::get('docroot'), $show)+1);
	//echo substr($show, 0, strrpos( $show, Registry::get('docroot'))+1);
	//echo strstr($show,Registry::get('docroot'));
	//echo strstr($show,Registry::get('docroot'),true);
	//echo strstr($show,'htdocs',true);
	
	//$pos = strpos($show, Registry::get('docroot'));
	//echo '/'.substr($show, $pos + strlen(Registry::get('docroot')));
	

		
		if($arr=explode(Registry::get('docroot'),$show)){
			
			if(isset($arr[1]))
			echo '/'.utf8_encode($arr[1]); 
			else echo "Not Found";  //'/'.$arr[1];
		}

		else echo "Not Found";
}
elseif(isset($_POST['zip']) && $_POST['zip']!='')
{
	$zip=utf8_decode($_POST['zip']);
	$patharray=array_filter(explode('/',$zip));
	$zipfolder=array_pop($patharray);
	$zipfile=$zipfolder.'.zip';
	$zippath='/'.implode('/',$patharray).'/'.$zipfile;
	
	$z=Factory::get('includes::classes::Zipper');
	$zipout=$z->zip($zip,$zippath,$zipfolder);
	echo utf8_encode($zippath);
	//echo "done";

}
elseif(isset($_POST['unzip']) && $_POST['unzip']!='')
{
	$zip=utf8_decode($_POST['unzip']);
	$z=Factory::get('includes::classes::Zipper');
	$patharray=array_filter(explode('/',$zip));
	$zipfile=array_pop($patharray);
	$zippath='/'.implode('/',$patharray).'/';
	$z->unzip($zip,$zippath);
}

elseif(isset($_GET['ziplist']) && $_GET['ziplist']!='')
{
	$zip=utf8_decode($_GET['ziplist']);
	$z=Factory::get('includes::classes::Zipper');
	$z->ziplist($zip);
	/*
	$patharray=array_filter(explode('/',$zip));
	$zipfile=array_pop($patharray);
	$zippath='/'.implode('/',$patharray).'/';
	$z->unzip($zip,$zippath);
	*/
}


else  {
	echo $contents="Choose a file";
}


?>