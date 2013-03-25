<?php

function filewriter($path,$file,$conts) {

	$msg='';
	$path_file='';
	substr($path,-1)=="/" ? $path_file=$path.$file : $path_file=$path.'/'.$file; 	
	
	if (is_writable($path)) {
		 
		 //ööööö
	    if (!$handle = fopen($path_file, "w")) {
	         $msg.= "Could not open ".$path_file.". Permissions?<br />";
	         //exit;
	    }
	    else{
		    // Schreibe $somecontent in die geÃ¶ffnete Datei.
		    if (!fwrite($handle, $conts)) {
		        $msg.= "Could not write ".$path_file.". Permissions?<br />";
		        //exit;
		    }
		    else $msg.= $path_file." saved.<br />";
            }
	
	    fclose($handle);
	
	} else {
	      $msg.= $path." is not writeable. Permissions?<br />";
	}
	return $msg;
}


//$message="<br />";
$html_encoding="";
$notice='';
//var_dump($_POST);
if(isset($_GET['dir']) && $_GET['dir']!='') {
	
	$dir=rawurldecode($_GET['dir']); 
	$notice='Use as encryption "crypt" for Linux and "none" for Windows.<br />
Ubuntu 9.10 with start-up configuration needs encrypted passwords - function crypt() is used here.<br /> 
Apparently there is no way to create an encrypted password with PHP, which validates on Windows Apache,<br />
therefore use htpasswd.exe in Apache\'s /bin.';
}
elseif(isset($_POST['dir']) && $_POST['dir']!='') {
	$dir=rawurldecode($_POST['dir']); 
	 //$dir=utf8_decode($_POST['dir']);
	 $DOCUMENT_ROOT = utf8_decode($_POST['dir']);
}
else
echo die("No directory");


if(isset($_POST['authtype']) && $_POST['authtype']!=''){
	$authtyp=utf8_decode($_POST['authtype']);
} 
else $authtype="Basic";

if(isset($_POST['authname']) && $_POST['authname']!='') {
	$authname=utf8_decode($_POST['authname']);
}
else $authname="admin";


if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $html_encoding="
    	    <option>none</option>
    	    <option>crypt</option";

} else {
    $html_encoding="
    	    <option>crypt</option>
      	    <option>none</option>";
}


if(isset($_POST['user']) && $_POST['user']!='' && isset($_POST['password']) && $_POST['password']!=''){

	$username = utf8_decode($_POST['user']);
	$password = utf8_decode($_POST['password']);
	
	if(isset($_POST['encoding']) && $_POST['encoding']!='') {
		$encoding=$_POST['encoding'];
		switch($encoding) {
		
			case "crypt" : $password=crypt($password); break;
			default : $password=$password;
		}
	}
	

	
	$htaccess_content="AuthType ".$authtype."\n".
             		  "AuthName \"$authname\"\n".
                          "AuthUserFile ".$DOCUMENT_ROOT.".htpasswd\n".
                          "require user ".$username."\n";
	
	$notice.=@filewriter($DOCUMENT_ROOT,'.htaccess',$htaccess_content);
	
	$htpasswd_content="$username:$password\n";
    	
    	$notice.=@filewriter($DOCUMENT_ROOT,'.htpasswd',$htpasswd_content);

}
else {

	if(isset($_POST['user']) && $_POST['user']=='') $notice.='User is needed.<br />';
	if(isset($_POST['password']) && $_POST['password']=='') $notice.='Password is needed.<br />';
}



$html='
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
   "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<style type=text/css>

* {
	font-family: Verdana, sans-serif,Arial;
	font-size:11px; 	
}

.deactivated { color: #888 }

#wrapper {

	/*width:300px;*/
	margin-top: 45px;
	
}
</style>
<script src="js/general.js" type="text/javascript"></script>
<script type="text/javascript">
function explorer() {
	
	explore=urlencode("'.$dir.'");
	
	parent.Daten.location.href="?com=Explorer&set=js&dir="+explore;
}
</script>
<body>
<div style=" position:fixed; background:#fff;top:0px; left:7px; width:250px; height:24px;border:1px solid #fff;z-index:99  " >
<!--<a href="javascript: loading()"><img style="border:0px dotted #fff;margin-top:2px;" src="jqueryFileTree/images/refresh.gif" alt="refresh" /></a>-->
<!--<a href="javascript: updir()"><img style="border:0px dotted #fff;margin-top:2px;" src="jqueryFileTree/images/directory_up.png" alt="up" title="up" /></a>-->
<a href="javascript: explorer()"><img style="border:0px dotted #fff;margin-top:2px;" src="jqueryFileTree/images/explorer.png" alt="Explorer" title="Explorer" /></a>

</div>
<div id="wrapper">
<p><b>Create simple security with .htaccess</b></p>
   <form action='.$_SERVER["SCRIPT_NAME"].' method="post">
	<table>
	   <tr>
	      <td>Path:</td>
	      <td><input class="deactivated" type=text size=100 name="dir" value="'.$dir.'" readonly="readonly" /></td>
	   </tr>
	   <tr>
	      <td>Typ:</td>
	      <td><input class="deactivated" type=text size=25 maxlength=25 name="authtyp" value="'.$authtype.'" readonly="readonly" /></td>
	   </tr>
	      <td>Name:</td>
	      <td><input type=text size=25 maxlength=25 name="authname" value="'.$authname.'" /></td>
	   </tr>	
	   <tr>
	      <td>User:</td>
	      <td><input type=text size=25 maxlength=25 name="user" /></td>
	   </tr>
	   <tr>
	      <td>Password:</td>
	      <td><input type=text size=25 maxlength=25 name="password" /></td>	   
	   </tr>
	   <tr>
	      <td>Encryption:</td>
	      <td><select name="encoding">'.$html_encoding.'
	          </select>
	      </td>	   
	   </tr>	   
	   <tr>
	      <td></td>	
	      <td>
	      <input type=submit name="send" value="send" >
	      <input type=hidden name="com" value="Htaccess" /></td>
	   </tr>   
	</table>
   </form>
<p><b>Notice:</b></p>
<p>'.$notice.'</p>
</div>
</body>
</html>';

echo $html;

?>