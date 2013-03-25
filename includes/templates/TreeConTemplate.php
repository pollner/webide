<?php
//
// jQuery File Tree PHP Connector
//
// Version 1.01
//
// Cory S.N. LaViska
// A Beautiful Site (http://abeautifulsite.net/)
// 24 March 2008
//
// History:
//
// 1.01 - updated to work with foreign characters in directory/file names (12 April 2008)
// 1.00 - released (24 March 2008)
//
// Output a list of files for jQuery File Tree
//
//$root="/Apache2/htdocs/profiler/p";
//echo urldecode($_POST['dir'])." | ";
//echo $_POST['dir']=utf8_decode($_POST['dir']);
//$_POST['dir']=utf8_decode($_POST['dir']);
$_POST['dir']=rawurldecode($_POST['dir']);
//echo utf8_encode($_POST['dir']);
if( file_exists($_POST['dir']) ) {
	$files = scandir($_POST['dir']);
	//print_r($files);
	natcasesort($files);
	//print_r($files);
	if( count($files) > 2 ) { /* The 2 accounts for . and .. */
		
		echo "<ul class=\"jqueryFileTree\" style=\"display: none;\">";
		// All dirs
		foreach( $files as $file ) {
			if( file_exists($_POST['dir'] . $file) && $file != '.' && $file != '..' && is_dir($_POST['dir'] . $file) ) {
				//echo "<li class=\"directory collapsed\"><a href=\"?com=Explorer&dir=". htmlentities($_POST['dir'] . $file) ."\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
				//echo "<li class=\"directory collapsed\"><a onclick=\"openexplorer('?com=Explorer&dir=". htmlentities($_POST['dir'] . $file)."')\" href=\"?com=Explorer&dir=". htmlentities($_POST['dir'] . $file) ."\" rel=\"" . htmlentities($_POST['dir'] . $file) . "/\">" . htmlentities($file) . "</a></li>";
				echo "<li class=\"directory collapsed\"><a onclick=\"openexplorer('". utf8_encode($_POST['dir'] . $file)."/')\" rel=\"" . utf8_encode($_POST['dir'] . $file) . "/\">" . utf8_encode($file) . "</a></li>";
			}
		}
		// All files
		foreach( $files as $file ) {
			if( file_exists($_POST['dir'] . $file) && $file != '.' && $file != '..' && !is_dir($_POST['dir'] . $file) ) {
				$ext = preg_replace('/^.*\./', '', $file);
				//echo "<li class=\"file ext_$ext\"><a href=\"?com=EditArea&dir=" . htmlentities($_POST['dir'] . $file) . "\" rel=\"" . htmlentities($_POST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
				echo "<li class=\"file ext_$ext\"><a onclick=\"openeditor('" . utf8_encode($_POST['dir'] . $file) . "');\" rel=\"" . utf8_encode($_POST['dir'] . $file) . "\">" . utf8_encode($file) . "</a></li>";
                                //echo "<li class=\"file ext_$ext\"><a href=\"#\" onclick=\"openeditor('" . htmlentities($_POST['dir'] . $file)\" rel=\"" . htmlentities($_POST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";				
				//echo "<li class=\"file ext_$ext\"><a href=\"javascript:alert('" . htmlentities($_POST['dir'] . $file) . "');\" rel=\"" . htmlentities($_POST['dir'] . $file) . "\">" . htmlentities($file) . "</a></li>";
				
			}
		}
		echo "</ul>";	
	}
}

?>