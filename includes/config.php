<?php
/**
/* Set an absolut path 
/* you want to specify like 
/* /var/www or C:\\Apache2\\htdocs or C:/Apache2/htdocs or /Apache2
/* if empty or false getcwd() will set.
**/
 $root='/Apache2/htdocs/codr';
 
/**
/* deBug is a simple helper.
/* Start Registry::set('deBug','on');
*/
 Registry::set('query_string',$_SERVER["QUERY_STRING"]);
 Registry::set('debug','off');
 Registry::set('error_log','on');
/**
/* Choose an error_reporting like 
/* error_reporting(0);
/* for development best choice: 
/* error_reporting(E_ALL|E_STRICT);
*/ 
 error_reporting(E_ALL | E_STRICT);
 //error_reporting(0);

 ini_set("display_errors", 1);
 //ini_set("display_errors", 1);
 //ini_set('safe_mode', '1'); 
 ini_set('register_globals', 'off');
 ini_set('magic_quotes_gpc', 'off');
 ini_set('magic_quotes_runtime', 'off');
 //ini_set("error_log","C:\phplog.txt");
 ini_set("date.timezone", "Europe/Berlin");

  
if(Registry::get('error_log')==strtolower('on')){
	Registry::set('error_log_file','logs/php_error_log.txt');
	ini_set ('track_errors', 1);
	ini_set ('log_errors', 1);
	ini_set("error_log",Registry::get('error_log_file'));
} 


 //var $localpath='';
 
 $getcwd=str_replace('\\','/',getcwd());
 $docroot=$_SERVER['DOCUMENT_ROOT'];
 $webroot=str_replace($_SERVER['DOCUMENT_ROOT'],'',$getcwd);
 
 if($root=='' || $root==null) {
 	//$root=$getcwd;
 	$root=$docroot;
 }

 $root=str_replace('\\','/',$root);

if(file_exists($root)) $root = $root;
else $root = $docroot; 

// if(file_exists($root)) {strpos($root,'/')===0 ? $absolut_path=$root : $absolut_path=substr($root, strpos($root,'/'));}
// else { strpos($getcwd,'/')===0 ? $absolut_path=$getcwd; : $absolut_path=substr($getcwd, strpos($getcwd,'/'));}

 strpos($root,'/')===0 ? $absolut_path=$root : $absolut_path=substr($root, strpos($root,'/'));
 substr($absolut_path, -1, 1)=='/' ? $absolut_path=trim($absolut_path) : $absolut_path=trim($absolut_path).'/';


function strip_reg_path($p){
	$p=str_replace('\\','/',$p);
	strpos($p,'/')===0 ? $p=$p : $p=substr($p, strpos($p,'/'));
	substr($p, -1, 1)=='/' ? $p=trim($p) : $p=trim($p).'/';
	return $p;
}

$docroot=strip_reg_path($docroot);
$webroot=strip_reg_path($webroot);
$getcwd=strip_reg_path($getcwd);
/* 
 echo '<br />'.$absolut_path;
 echo '<br />'.$docroot;
 echo '<br />'.$webroot;
 echo '<br />'.$getcwd;
*/
 Registry::set('getcwd',$getcwd);
 Registry::set('docroot',$docroot);
 Registry::set('webroot',$webroot);
 Registry::set('root',$root);
 Registry::set('absolut_path',$absolut_path);
 Registry::set('includes_path',Registry::get('getcwd').'includes/');
 


    
    $uparray=explode("/",$absolut_path);
    $popped=array_pop($uparray);
    $popped=array_pop($uparray);
    $up_path=implode('/',$uparray);

Registry::set('up_path',$up_path);    

/*
 $localpath=$_SERVER["SCRIPT_FILENAME"];
 $absolutepath= realpath($localpath);
 // a fix for Windows slashes
 $absolutepath=str_replace("\\","/",$absolutepath);
 $docroot=substr($absolutepath,0,strpos($absolutepath,$localpath));
 // as an example of use
 //include($docroot."/includes/config.php");*/