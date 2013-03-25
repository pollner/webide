<?php

$content='<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
   "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<style type=text/css>

* {
	font-family: Verdana, sans-serif,Arial;
	font-size:11px; 	
}

#wrapper {

	vertical-align:top;
	width:300px;
	margin-top: 25px;
	margin-left:25px;
}
</style>
<body>
<div id="wrapper">';

$content.="<div id='content'><p class='about'><b>Serverinformation</b></p>
<div id='server'>";
//foreach ($array as $server){

//	$content.= "<tr><td>".$server."</td><td>".$_SERVER[$server]."</td></tr>";
//}
//$content.="</table>

$content.="<table style='border 1px dotted #eee'>";
$content.="<tr><td><b>SERVER</b></td><td>Variable</td></tr>";
foreach($_SERVER AS $key => $value)
{
$wert=$value;
$content.="<tr><td>".$key."</td><td>".$value."</td></tr>";
}
$content.="<tr><td><b>COOKIE</b></td><td>Variable</td></tr>";
foreach($_COOKIE AS $key => $value)
{
$wert=$value;
$content.="<tr><td>".$key."</td><td>".$value."</td></tr>";
}
$content.="<tr><td><b>ENV</b></td><td>Variable</td></tr>";
foreach($_ENV AS $key => $value)
{
$wert=$value;
$content.="<tr><td>".$key."</td><td>".$value."</td></tr>";
}
$content.="
</table>

</div></div>
</body>
</html>
";
echo $content;
?>