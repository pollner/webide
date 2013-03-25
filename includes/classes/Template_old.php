<?php
/**
 * $Id: template.php,v 1.01 2007/07/15 14:45  $
 * Last Changes:
 * 2007/07/28 10:19 - Pollner, Patrick
 */
class template {
	var $html;
	var $datei;
	var $meldung;
	var $time_start;
	
    
    var $cache_dir = 'cache/';
	

	//Konstruktor, lädt HTML-Code
	function template($datei,$time_start='0') {
		$this->time_start=$time_start;
		$this->datei=$datei;
		$this->meldung=1000;
		$filename=$this->datei;
		if(file_exists($filename)) {
			$handle=fopen("$filename","r");
			$contents = fread($handle, filesize($filename));
			fclose($handle);
			$this->html=$contents;
			//$this->fillin('{PFAD_CSS}','css/');
		} else {
			$this->html=str_replace('%s',$filename,'KEIN TEMPLATE VORHANDEN');
		}
	}

	function fillin ($htmcode,$inhalt) {
		$this->html=eregi_replace("$htmcode",$inhalt,$this->html);
	}

	function showTemplate() {
		$time_end = microtime(true);
		$this->endTime($time_end);
		return $this->html;
	}

	function endTime($time_end) {
		//$time = bcsub($time_end,$this->time_start,2);
		$time = $time_end - $this->time_start;
		$time=0;
		if($time!='0') {
			$this->fillin("{RENDERING}","Rendered in $time sec");
		} else {
			$this->fillin("{RENDERING}","");
		}
	}
	
///     content caching
   
    
    
  function create_cache_file($cachename='0')
   {
    
    $cache_file = $this->cache_dir.$cachename.'.cache';
    $fp = @fopen($cache_file, 'w');
    @flock($fp, 2);
    @fwrite($fp, $this->html);
    @flock($fp, 3);
    @fclose($fp);
   }
   
   function clear_cache($cache_id=false)
   {
    if($cache_id)
     {
      @unlink('../'.$this->cache_dir.$cache_id.'.cache');
     }
    else
     { 
      foreach(glob($this->cache_dir."*.cache") as $cachefile) 
       {
        @unlink($cachefile);
       }
     }  
   }
     
}
?>