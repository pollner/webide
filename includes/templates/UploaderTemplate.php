<?php

function return_bytes($val) {
    $val = trim($val);
    $last = strtolower($val[strlen($val)-1]);
    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}

function return_filesize($filesize){
   
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

$postmaxsize=return_bytes(ini_get('post_max_size'));
$uploadmaxfilesize=return_bytes(ini_get('upload_max_filesize'));


$dir='';

if(isset($_GET['dir'])&& $_GET['dir']!=''){
	$dir=rawurldecode($_GET['dir']);
	//$dir=utf8_decode($_GET['dir']);
}
else $dir=Registry::get('absolut_path');


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
   "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<title>Ajax Uploader</title>
<script src="js/general.js" type="text/javascript"></script>
<script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>
<script type="text/javascript">
$(function() {
	// Formular abschicken
	$('#uploadForm').submit(function(data) {
		// Ajax Loader anzeigen
		$('#loader').html(' Sending data...');
		$('#loader').show();

		var submittingForm = $('#uploadForm');

		var uploadFrame = $('#uframe');
		//uploadFrame.empty();		
		uploadFrame.load( function(data) {
			
			setTimeout(function() {
				$('#loader').hide();
			}, 1000);
		}); 

		submittingForm.attr('target', 'uframe');
	});
	
	$('#uploadbutton').click(function() {
	        //$('uframe').contents().empty();
		// Formular abschicken
		$('#uploadForm').submit();
	});
});

function explorer() {
	
	explore="<?php echo $dir ?>";
	parent.Daten.location.href="?com=Explorer&set=js&dir="+urlencode(explore);
}

function loading() {
	load="<?php echo $dir ?>";
	parent.Daten.location.href="?com=Uploader&dir="+load;
}


</script>
<style type="text/css">
	*,html,body {margin:0px ;padding:0px; font-size:11px; font-family:Verdana,sans-serif,Arial }
	body {padding: 0px 7px;}
	td {border: 3px solid #fff}
	
	#uframe {width:100%; height:400px; color: #000; background:#fff ;border: none}
	#wrapper { margin-top: 45px;  }
	



	
</style>
</head>
<body style="border:none">
<div style=" position:fixed; background:#fff;top:0px; left:7px; width:250px; height:24px;border:1px solid #fff;z-index:99  " >
<!--<a href="javascript: loading()"><img style="border:0px dotted #fff;margin-top:2px;" src="jqueryFileTree/images/refresh.gif" alt="refresh" /></a>-->
<!--<a href="javascript: updir()"><img style="border:0px dotted #fff;margin-top:2px;" src="jqueryFileTree/images/directory_up.png" alt="up" title="up" /></a>-->
<a href="javascript: explorer()"><img style="border:0px dotted #fff;margin-top:2px;" src="jqueryFileTree/images/explorer.png" alt="Explorer" title="Explorer" /></a>

</div>

<div id="wrapper">



<p><b>Simple Uploader</b></p>
<br />

<p><?php echo ' file_uploads (boolean) = ' . ini_get('file_uploads'); ?></p>
<p><?php echo ' post_max_size = ' . return_bytes(ini_get('post_max_size')).' bytes ('.return_filesize($postmaxsize).')'; ?></p>
<p><?php echo ' upload_max_filesize = ' . return_bytes(ini_get('upload_max_filesize')).'  bytes ('.return_filesize($uploadmaxfilesize).')'; ?></p>
<br />
<form action="includes/upload.php" method="post" enctype="multipart/form-data" id="uploadForm">
<table>
<tr>
	<td valign="top">Path:</td>
	<td><input type="text" name="dir" value="<?php echo $dir ?>" id="path" style="width: 400px;color:#888" readonly="readonly" /></td>
</tr>		
<tr>
	<td style="vertical-align:top">File:</td>
	<td>
		<div id="hide">
			<input type="file" name="uploadfile" id="uploadfile" size="47" />
			<br /><br />
			<input type="button" name="uploadbutton" value="Send" id="uploadbutton"/>&nbsp;&nbsp;
			<span id="loader"></span>
		</div>	
	
	</td>
</tr>
</table>
</form>

<iframe id="uframe" name="uframe" frameborder="0" ></iframe>
</div>
</body>
</html>