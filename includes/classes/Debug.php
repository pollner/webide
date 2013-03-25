<?php 

class Debug {

public function __construct($element='') {    

if($element=='') $elementName="Registry";
else $elementName=$element;
$debug= '<div id="debugger" 
		style="
		width:100%;
		border-top:1px solid #eee;border-right: 1px solid #aaa;
		border-left:1px solid #ccc;
		border-bottom: 1px solid #888;
		font-family: arial; 
		font-size:11px;
		font-weight:100;
		background-color:#dadada">
                <div style="background-color: rgb(4, 99, 128);color:#fff;padding:2px;		
                border-top:1px solid #eee;border-right: 1px solid #aaa;
		border-left:1px solid #ccc;
		border-bottom: 1px solid #888;">
                <input type="image" style="float:left" title="Close" onclick="javascript:document.getElementById(\'debugger\').style.display=\'none\';" src="editarea/edit_area/images/close.gif">
                 &nbsp;<b>Debug :: '.$elementName.'<b></div>
                 <div id="innerDebugger" style="margin:3px;">
                 <pre>';
    
//$debug.='request: '. print_r( $request,true );
$rendering_time=microtime(true) - $_SERVER['REQUEST_TIME'];
Registry::set('rendering_time',$rendering_time.' seconds');

if($element=='') $debug.=print_r(Registry::getAll(),true);
else $debug.=print_r(Registry::get($element),true);
//else $debug.= print ReflectionClass::export('Model');

$debug.= 	'</pre>
	</div></div>';
echo $debug;
}
}
?>