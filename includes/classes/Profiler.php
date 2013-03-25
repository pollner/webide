<?php 

  class Profiler  
  {
  	
  	var $pathinfo;
  	var $basename;
  	var $dirname;
  	

	function display_filesize($filesize){
	   
	    if(is_numeric($filesize)){
	    $decr = 1024; $step = 0;
	    $prefix = array('Byte','KB','MB','GB','TB','PB');
	       
	    while(($filesize / $decr) > 0.9){
	        $filesize = $filesize / $decr;
	        $step++;
	    }
	    return round($filesize,2).' '.$prefix[$step];
	    } else {
	
	    return 'NaN';
	    }   
	}
	
  	function pp_extension($rp){
  		
		
		$path_info=pathinfo($rp);
		//print_r($path_info);	
		if($path_info==!false){
		//echo $path_info['extension'];
			if(empty($path_info['extension'])) return 'txt';
			else return $path_info['extension'];
		}
		else return 'txt';
	}
	
	 function rrmdir($dir) {
	   if (is_dir($dir)) {
	     $objects = scandir($dir);
	     foreach ($objects as $object) {
	       if ($object != "." && $object != "..") {
	         if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
	       }
	     }
	     reset($objects);
	     rmdir($dir);
	   }
	 }
	
		
	public function path_stat ($file) {
		
		
	 clearstatcache();
	 
	 $ss=stat($file);
	 //if(!$ss) $ss=stat('C:/phplog.txt');//return $file; //Couldnt stat file
	 
	 $ts=array(
	  0140000=>'ssocket',
	  0120000=>'llink',
	  0100000=>'-file',
	  0060000=>'bblock',
	  0040000=>'ddir',
	  0020000=>'cchar',
	  0010000=>'pfifo'
	 );
	 
	 $p=$ss['mode'];
	 $t=decoct($ss['mode'] & 0170000); // File Encoding Bit
	 
	 $str =(array_key_exists(octdec($t),$ts))?$ts[octdec($t)]{0}:'u';
	 $str.=(($p&0x0100)?'r':'-').(($p&0x0080)?'w':'-');
	 $str.=(($p&0x0040)?(($p&0x0800)?'s':'x'):(($p&0x0800)?'S':'-'));
	 $str.=(($p&0x0020)?'r':'-').(($p&0x0010)?'w':'-');
	 $str.=(($p&0x0008)?(($p&0x0400)?'s':'x'):(($p&0x0400)?'S':'-'));
	 $str.=(($p&0x0004)?'r':'-').(($p&0x0002)?'w':'-');
	 $str.=(($p&0x0001)?(($p&0x0200)?'t':'x'):(($p&0x0200)?'T':'-'));
	 
	 $this->pathinfo=pathinfo($file);
	 //print_r($this->pathinfo);
	 
	 $s=array(
	 'perms'=>array(
	  'human'=>$str),

	 'owner'=>array(
	  'fileowner'=>$ss['uid'],
	  'filegroup'=>$ss['gid'],
	  'owner'=>
	  (function_exists('posix_getpwuid'))?
	  @posix_getpwuid($ss['uid']):'',
	  'group'=>
	  (function_exists('posix_getgrgid'))?
	  @posix_getgrgid($ss['gid']):''
	  ),
	 
	 'file'=>array(
	  'filename'=>$file,
	  'realpath'=>(@realpath($file) != $file) ? @realpath($file) : '',
	  'dirname'=>@dirname($file),
	  'extension'=>@$this->pp_extension(realpath($file)),
	  //'extension'=>@pathinfo(3),
	  'basename'=>@basename($file)
	  ),
	
	 'filetype'=>array(
	  'type'=>substr($ts[octdec($t)],1),
	  'type_octal'=>sprintf("%07o", octdec($t)),
	  'is_file'=>@is_file($file),
	  'is_dir'=>@is_dir($file),
	  'is_link'=>@is_link($file),
	  'is_readable'=> @is_readable($file),
	  'is_writable'=> @is_writable($file)
	  ),
	 /*
	 'device'=>array(
	  'device'=>$ss['dev'], //Device
	  'device_number'=>$ss['rdev'], //Device number, if device.
	  'inode'=>$ss['ino'], //File serial number
	  'link_count'=>$ss['nlink'], //link count
	  'link_to'=>($s['type']=='link') ? @readlink($file) : ''
	  ),
	 */
	 'size'=>array(
	  'size'=>$ss['size'], //Size of file, in bytes.
	  'blocks'=>$ss['blocks'], //Number 512-byte blocks allocated
	  'block_size'=> $ss['blksize'] //Optimal block size for I/O.
	  ),
	 
	 'time'=>array(
	  'mtime'=>$ss['mtime'], //Time of last modification
	  'atime'=>$ss['atime'], //Time of last access.
	  'ctime'=>$ss['ctime'], //Time of last status change
	  'accessed'=>@date('d.m. H:i:s',$ss['atime']),
	  'modified'=>@date('d.m. H:i:s',$ss['mtime']),
	  'created'=>@date('d.m. H:i:s',$ss['ctime'])
	  ),
	 );
	 
	 clearstatcache();
	 return $s;
	}	 

	 /*
	 function dirfile_infos($p='.'){
	
	 	$df=$this->path_stat($p);
	 	$dir_file_info_array=array(
	 								
	 							   );
	 	return $dir_file_info_array;
	 }*/
	 
 

  
 }
 
 
 ////////////////////////////////
 //////////////////////////////////

 
 
 
 
 
 //echo "DEBUG";
 /*
 $Profiler=new Profiler();

 
 
 $infos=$Profiler->path_stat('../classes');
 
 
 //print_r($infos);
 */
 //echo "<br />".$Profiler->pathinfo['basename']." ".$infos['perms']['human']." ".$infos['size']['size']." ".$infos['owner']['owner']['name']." ".$infos['owner']['group']['name']." ".$infos['time']['modified']."<br />";;
 
 /*
 foreach ($infos as $key => $value)
 {
 	foreach($value as $k => $v){
 		
 		if (is_array($v)){
 			foreach ($v as $y => $z){
 			echo $key.' : '.$k.' : '.$y.' : '.$z.' <br />';	
 			}
 		}
 		else echo $key.' : '.$k.' : '.$v.'<br />';	
 	}	
 }
 /*
 $params = array(
     'param1' => null,
     'param2' => null,
 );
 
 //echo "DEBUG";
/* 
 
 try{
 $fstat = Profiler::filefactory("profiler.php", $params);	
 }
 
  catch (Exception $e) {
    echo 'Exception abgefangen: ',  $e->getMessage(), "\n";
}
 
print_r($fstat);
//print_r ($object->file_stat("profiler.php"));

// print_r($object);
 
 
 */
 
?>