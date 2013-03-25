<?php
   
class Zipper extends ZipArchive {

public function ziplist($l) {
	
	$zip = zip_open($l);	
	$htm='';
	$val='';
	$dirs=array();
	$files=array();
	
	if ($zip) {
	while ($zip_entry = zip_read($zip)) {
	 $h=zip_entry_name($zip_entry);
	 if(preg_match('#\/#',$h)){
	 	
	 	$val=substr($h, 0, strpos($h, '/'));
	 	 //$val=array_shift(explode('/',$h,2));
	 	 $dirs[]='<tr><td class="directory">&nbsp;</td><td>'.$val.'</td></tr>';
	 }
	 else $files[]='<tr><td class="file">&nbsp;</td><td>'.$h.'</td></tr>';
	 //$arr=array_unique(array_unique($arr));
	 
	//echo zip_entry_name($zip_entry) . "<br />";
	//echo "Dateigroesse: " . zip_entry_filesize($zip_entry) . "\n";
	//echo "Komprimierte groesse: " . zip_entry_compressedsize($zip_entry) . "\n";
	//echo "Kompressions Methode: " . zip_entry_compressionmethod($zip_entry) . "\n";
	}
	zip_close($zip);
	}
	
	$dirs=array_values(array_unique($dirs));
	//print_r($arr);
	$htm.='<table class="jqueryFileTree">';
	//$htm.='<caption class="directory">' . $l . '</caption>';
	foreach($dirs as $key) $htm.=$key;
	foreach($files as $key) $htm.=$key;
	$htm.='</table>';
	
	return $htm;
	

}
   
public function addDir($path) {
    print 'adding ' . $path . '<br>';
    $this->addEmptyDir($path);
    $nodes = glob($path . '/*');
    foreach ($nodes as $node) {
        print $node . '<br>';
        if (is_dir($node)) {
            $this->addDir($node);
        } else if (is_file($node))  {
            $this->addFile($node);
        }
    }
}

public function addFolderToZip($dir, $zipArchive, $zipdir = ''){
    if (is_dir($dir)) {
        if ($dh = opendir($dir)) {

            //Add the directory
            if(!empty($zipdir)) $this->addEmptyDir($zipdir);
          
            // Loop through all the files
            while (($file = readdir($dh)) !== false) {
          
                //If it's a folder, run the function again!
                if(!is_file($dir . $file)){
                    // Skip parent and root directories
                    if( ($file !== ".") && ($file !== "..")){
                        $this->addFolderToZip($dir . $file . "/", $zipArchive, $zipdir . $file . "/");
                    }
                  
                }else{
                    // Add the files
                    $this->addFile($dir . $file, $zipdir . $file);
                  
                }
            }
        }
    }
} 

public function unzip($source,$target='./')
{
    //$zip = new ZipArchive;
    $this->open($source);
    $this->extractTo($target);
    $this->close();
    echo "Ok!";
}

   


//$z=new Zipper();
//$z->unzip('xxx.zip');
//$z->addDir('./yyy');

public function zip($source,$target='./testzippo.zip',$folder)
{
	if ($this->open($target,ZIPARCHIVE::CREATE) === TRUE) {
	    //$zip->addFile('/pfad/zur/datei.txt', 'neuername.txt');
	    $this->addFolderToZip($source,$target,$folder.'/');
	    $this->close();
	    return 'zipped';
	} else {
	    return 'error';
	}
}
} // class Zipper
/*
    $zip = new ZipArchive;
    $zip->open('xxx.zip');
    $zip->extractTo('./');
    $zip->close();
    echo "Ok!";
*/
    
?>