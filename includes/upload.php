<?php
//echo "debug";
ini_set("date.timezone", "Europe/Berlin");
error_reporting(E_ALL );


$message='<p>';
$size=' - ';
$temp=' - ';
$file=' - ';
$mission='';

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


function file_upload_error_message($error_code) {
    switch ($error_code) {
    	case 0:
    	    return '#0: Upload to TMP was done successfully.';
        case 1:
            return '#1: The uploaded file exceeds the upload_max_filesize directive in php.ini.';
        case 2:
            return '#2: The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
        case 3:
            return '#3: The uploaded file was only partially uploaded.';
        case 4:
            return '#4: No file was uploaded.';
        case 5:
            return '#5: Missing a temporary folder.';
        case 6:
            return '#6: Failed to write file to disk.';
        case 7:
            return '#7: File upload stopped by extension.';
        default:
            return 'Unknown upload error.';
    }
} 

$ol='';
if (empty($_FILES) && empty($_POST) && isset($_SERVER['REQUEST_METHOD']) && strtolower($_SERVER['REQUEST_METHOD']) == 'post') {   
    $poidsMax = ini_get('post_max_size');
    $ol="<br />Fileoverload: Your feet is too big, maximum allowed size here is ".$poidsMax.".<br />";
} 


$POST_MAX_SIZE = ini_get('post_max_size');
$mul = substr($POST_MAX_SIZE, -1);
$mul = ($mul == 'M' ? 1048576 : ($mul == 'K' ? 1024 : ($mul == 'G' ? 1073741824 : 1)));
if ($_SERVER['CONTENT_LENGTH'] > $mul*(int)$POST_MAX_SIZE && $POST_MAX_SIZE) $ol.="<br />Content-Length: ".display_filesize($_SERVER['CONTENT_LENGTH']);


if(isset($_FILES['uploadfile']['name']) && $_FILES['uploadfile']['name']!=''){
	$mission='Upload aborted.';
	if(isset($_POST['dir']) && $_POST['dir']!='') {
		$dir=utf8_decode($_POST['dir']);
		$en_dir=$_POST['dir'];
		if(substr($dir,-1)!='/') {
			$dir=$dir.'/';
			$message.="\"Directory Separator\" added.<br />";
		}
		
		if(is_dir($dir)) {
			$message.=$en_dir."<br />Directory exists.<br />";
			if(is_writeable($dir)) {
				$message.="Directory is writeable.<br />";
				if(@move_uploaded_file($_FILES['uploadfile']['tmp_name'], $dir.utf8_decode($_FILES['uploadfile']['name']))){
					$message.="Tmp was copied.<br />";
					if(file_exists($dir.utf8_decode($_FILES['uploadfile']['name']))) {
						$message.=$en_dir.$_FILES['uploadfile']['name']."<br />saved.<br />";
						$mission="Upload completed successfully";
					}
					else $message.=$en_dir.$_FILES['uploadfile']['name']." does <b>not</b> exist.<br />";
				}       
				else $message.="Tmp was <b>not</b> copied.<br />";
			}
			else $message.=$en_dir." Directory is <b>not</b> writeable.<br />";
		}
		else $message.=$en_dir." Directory does <b>not</b> exists<br />"; 
		
	}
	else $message.="No directory was found.<br />";
	$message.=
"<p>path: ".$en_dir."<br />name: ".$_FILES['uploadfile']['name']."<br />temp: ".$_FILES['uploadfile']['tmp_name']."<br />size: ".$_FILES['uploadfile']['size']."<br />code: ".$_FILES['uploadfile']['error']."<br />".file_upload_error_message($_FILES['uploadfile']['error'])."</p>";
}
else $message.="No file found.";

$message.="</p>";

echo '<div style="font-size:11px; font-family:Verdana,sans-serif,Arial;" id="result"><p><b>'.$mission.'</b></p>
     <pre>'.$message.' '.$ol.'</pre>
     </div>';
// The form isn't misbehavin then…

?>