<?php

class ZiplistCommand extends Command {
  public function doExecute( $request ) {
  /*  $name = $request['fc_name'];
    if(!$name) { 
      $name = 'Anonymous';
    }*/

$content='';

if(isset($_GET['path']) && $_GET['path']!='')
{
	$zipfile=rawurldecode($_GET['path']);
	$zippatharray=explode('/',$zipfile);
	$zippatharray=array_filter($zippatharray);
	array_pop($zippatharray);
	$zippath='/'.implode('/',$zippatharray).'/';
	$z=Factory::get('includes::classes::Zipper');
	$content.= "<div><img src='jqueryFileTree/images/zip.png' />&nbsp;<b id=\"path\" class=\"pathline\">".utf8_encode($zipfile) ."</b></div>";	
	$content.=utf8_encode($z->ziplist($zipfile));

}
else $content.="Empty";


$msg='';    
    include_once("includes/templates/ZiplistTemplate.php");
    if(Registry::get('debug')==strtolower('on')) Factory::get('includes::classes::Debug');
  }

}