<?php

class ExplorerCommand extends Command {
  public function doExecute( $request ) {
    /*$name = $request['fc_name'];
    if(!$name) { 
      $name = 'Anonymous';
    }*/
    
/*    $EAPro=Factory::get('includes::classes::Profiler');/*
    //echo $EAPro->pp_extension($request['dir']);
    //print_r($EAPro->path_stat($request['dir']));
//    include_once($_SERVER['DOCUMENT_ROOT']."/profiler/p/profiler/includes/templates/ExplorerTemplate.php");*/
    

$msg='';
$cnt=0;
Factory::inc('includes::classes::Profiler');

function updir($statedir,$pointfile){

	if($pointfile=='..') {
	
	$uparray=explode("/",$statedir);
	$popped=array_pop($uparray);
        $popped=array_pop($uparray);
	$upstring=implode('/',$uparray);
	//print_r($uparray);
	return $upstring;
	
	
	}
	else return $statedir.$pointfile;
	
}
//echo $got_dir=$_GET['dir'];
$html_content='';
$html_dirs='';
$html_updir='';
$raw_dir='';
$Profiler = new Profiler();
$root=''; 
//$got_dir = htmlentities(urldecode($_GET['dir']));

//$got_dir = urldecode($_GET['dir']);
if(isset($_GET['set']) && $_GET['set']=='js') {	
	$got_dir = utf8_decode($_GET['dir']);
	//$raw_dir = rawurldecode($_GET['dir']);
}
else {
	$got_dir = rawurldecode($_GET['dir']);
        //$got_dir = utf8_decode($_GET['dir']);
}
//echo utf8_encode($got_dir);
//$got_dir ='';
//print_r($got_dir);
//$xyz='/';//updir($got_dir);
//if($got_dir="") $got_dir="/";
//$got_dir='/';

//$got_dir_array=explode('/', $got_dir, 2);
//$got_dir=$got_dir_array[1];

//echo "DEBUG";
/*
$gcwd=str_replace('\\','/',getcwd());
//echo $_SERVER['DOCUMENT_ROOT'];
$gcwd=str_replace('\\','/',$gcwd);

$pathto=str_replace($_SERVER['DOCUMENT_ROOT'],'',$gcwd);
*/
if( file_exists($got_dir)  ) {
	//$msg="path: ".$got_dir;
}
else {
	$msg=" request not found: ".$got_dir;
	$got_dir=Registry::get('absolut_path');
}


	$html_content.= "<div><img src='jqueryFileTree/images/folder_open.png' />&nbsp;<b id=\"path\" class=\"pathline\">".utf8_encode($got_dir) ."</b></div>";	
	$files = scandir($got_dir);
	//print_r($files);
	

	//print_r($files);
	natcasesort($files);
	//print_r($files);
	if( count($files) > 1 ) { /* The 2 accounts for . and .. */
		
		//$html_content.= "<div><img src='jqueryFileTree/images/folder_open.png' />&nbsp;<b class=\"pathline\">". htmlentities($got_dir)."</b></div>";
		$html_content.= "<table id=\"treeTable\" class=\"jqueryFileTree\" >";
		/*$html_content.="<tr>
                                <td><img src=\"jqueryFileTree/images/directory.png\" /></td>
                                <td><a class=\"dir\" href=\"?com=Explorer&dir=" . htmlentities(  $xyz ) ." \" > ..</a></td></tr>		
				";*/
		// All dirs
		foreach( $files as $file ) {
			//echo "<br />".$file;
			if( file_exists( $got_dir . $file) && $file != '.' /*&& $file != '..'*/ && is_dir($root .   $got_dir . $file ) ) {
			
				$path_stat=$Profiler->path_stat ($root .  $got_dir . $file);
		                isset($path_stat['owner']['owner']['name'])? $owner=$path_stat['owner']['owner']['name'] : $owner='-';
		                isset($path_stat['owner']['group']['name'])? $group=$path_stat['owner']['group']['name'] : $group='-';				
				//$html_content.= "";
				       //$html_content.= "<td><a class=\"dir\" href=\"?com=Explorer&dir=" . htmlentities(  $got_dir.$file ) . "/\" rel=\"" . htmlentities(  $got_dir . $file) . "/\" >" . htmlentities($file) . "</a></td>
					 if($file=="..") {
					 	$html_updir.= "<tr>
							<!--<td><img src=\"jqueryFileTree/images/directory.png\" /></td>-->
							<td class=\"directory\">&nbsp;</td>
					 		<td><a class=\"updir\" href=\"?com=Explorer&dir=" . urlencode(updir($got_dir , $file )) . "/\" rel=\"" .   utf8_encode($got_dir . $file) . "/\" >..</a></td>
					 		<td>".$path_stat['perms']['human']."<td>
						        <td>".$group."<td>        
							<td>".$owner."<td> 
							<td> - <td>
							<td>".$path_stat['time']['created']."<td>
							<td>".$path_stat['time']['modified']."<td>							
							</tr>";}					 	
					 
					 else {
					 	$html_dirs.= "<tr>
							<!--<td><img src=\"jqueryFileTree/images/directory.png\" /></td>-->
							<td class=\"directory\">&nbsp;</td>
					 		<td><a id=\"j".$cnt++."\" class=\"dir\" href=\"?com=Explorer&dir=" . rawurlencode($got_dir . $file ) . "/\" rel=\"" .   utf8_encode($got_dir . $file) . "/\" >" . utf8_encode($file) . "</a></td>
					 		<td>".$path_stat['perms']['human']."<td>
						        <td>".$group."<td>        
							<td>".$owner."<td> 
							<td> - <td>
							<td>".$path_stat['time']['created']."<td>
							<td>".$path_stat['time']['modified']."<td>							
							</tr>";}
					
				
			}
			//else echo $root .   $got_dir . $file;
		}
		$html_content.=$html_updir.$html_dirs;
		// All files
		foreach( $files as $file ) {
			//if( file_exists($root .   $got_dir .'/'. $file) && $file != '.' && $file != '..' && !is_dir($root .   $got_dir .'/'. $file) ) {
			if( file_exists($root .   $got_dir . $file) && $file != '.' && $file != '..' && !is_dir($root .   $got_dir . $file) ) {
				$ext = preg_replace('/^.*\./', '', $file);
				$path_stat=$Profiler->path_stat ($root .  $got_dir . $file);
				isset($path_stat['owner']['owner']['name'])? $owner=$path_stat['owner']['owner']['name'] : $owner='-';
				isset($path_stat['owner']['group']['name'])? $group=$path_stat['owner']['owner']['name'] : $group='-';
				$ext = preg_replace('/^.*\./', '', $file);
				$type=''; $href='';
				switch(strtolower($ext)){
					
					case 'zip': $type='zip'; $href="?com=Ziplist&path=". rawurlencode($got_dir . $file);break;
					default:    $type='file'; $href="?com=EditArea&dir=".rawurlencode(  $got_dir . $file);break;
					
				}
				
				$html_content.= "<tr>
							<!--<td><img src=\"jqueryFileTree/images/file.png\" /></td>-->
							<td class=\"file ext_$ext\">&nbsp;</td>
							<td><a id=\"".$cnt++."\" class=\"$type ext_$ext\" href=\"".$href."\" rel=\"" . utf8_encode( $got_dir . $file) ."\" >" . utf8_encode($file) . "</a></td>
							<td>".$path_stat['perms']['human']."<td>

                                			<td>".$group."<td>                                 	    
                            				<td>".$owner."<td>
							<td>".$path_stat['size']['size']."<td>
							<td>".$path_stat['time']['created']."<td>
							<td>".$path_stat['time']['modified']."<td>
							</tr>";
			}
		}
		$html_content.= "</table>";	
	}


    include_once("includes/templates/ExplorerTemplate.php");
    if(Registry::get('debug')==strtolower('on')) Factory::get('includes::classes::Debug');


  }

}