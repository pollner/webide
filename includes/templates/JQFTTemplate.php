<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<title>jQuery File Tree</title>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		
		<style type="text/css">
			*,
			BODY,
			HTML {
				padding: 0px;
				margin: 0px;
			}
			img {position:relative;}
			BODY {
				font-family: Verdana, Arial, Helvetica, sans-serif;
				font-size: 11px;
				background: #FFF;
				padding-left: 10px;
			}
			
			H1 {
				font-family: Georgia, serif;
				font-size: 20px;
				font-weight: normal;
			}
			
			H2 {
				font-family: Georgia, serif;
				font-size: 16px;
				font-weight: normal;
				margin: 0px 0px 10px 0px;
			}
			
			.example {
				border-top:7px solid #fff;
			/*
				float: left;
				margin: 0px;
			*/	
			}
			#root  
			     {/*
			     	border-top: 5px dotted #fff;
				border-bottom: 5px dotted #fff;
			     */}
			
			.demo {
				width: 200px;
				height: 400px;
				border-top: solid 1px #BBB;
				border-left: solid 1px #BBB;
				border-bottom: solid 1px #FFF;
				border-right: solid 1px #FFF;
				background: #FFF;
				overflow: scroll;
				padding: 0px;
			}
			
			.demos {
				width: 400px;
				/*height: 400px;
				border-top: solid 1px #BBB;
				border-left: solid 1px #BBB;
				border-bottom: solid 1px #FFF;
				border-right: solid 1px #FFF;*/
				background: #FFF;
				/*overflow: scroll;*/
				padding: 0px;
			}			
			
			P.note {
				color: #999;
				clear: both;
			}
		</style>
		
		<script src="jquery/jquery-1.4.2.min.js" type="text/javascript"></script>
		<script src="jquery.easing/jquery.easing.1.3.js" type="text/javascript"></script>
		<script src="jqueryFileTree/jqueryFileTree.js" type="text/javascript"></script>
		<!--<script src="jqueryFileTree/FileTreeCommand.js" type="text/javascript"></script>-->
		<link href="jqueryFileTree/jqueryFileTree.css" rel="stylesheet" type="text/css" media="screen" />
		
		<script type="text/javascript">
		

function updir(){

	updir.path=document.getElementById("root").innerHTML;
	//if(!updir.path  ) updir.path=absolutpath;
 	if(updir.path=="/") updir.path=absolutpath;
	else {
	patharray=updir.path.split("/");
	patharray.pop();
	patharray.pop();
	updir.path=patharray.join("/")+"/";
	}
	document.getElementById("root").innerHTML=updir.path;
	treeloader(updir.path);
	
}



function openexplorer(ex) {
	
	//explore=document.getElementById("root").innerHTML;
	//parent.Daten.location.href="?com=Explorer&dir="+explore;
	//document.getElementById("root").innerHTML=ex;
	//parent.Head.setURL("?com=Explorer&dir="+ex);
}

function explorer() {
	
	explore=document.getElementById("root").innerHTML;
	parent.Daten.location.href="?com=Explorer&dir="+explore;
}
		
function system(){
	treeloader("<?php echo Registry::get('getcwd'); ?>");
}

function openeditor(f) {
	p=f;
	//alert(encodeURIComponent(p));
	q=parent.Daten.location.search;
	qsub=q.substring(0,13);
	if(qsub=="?com=EditArea") {
	//alert("Editor erkannt");
	parent.Daten.open_file4(p);	
	}
	else if(qsub="?com=Explorer"){
	//alert("Explorer erkannt");
	parent.Daten.location.href="?com=EditArea&dir="+urlencode(p)+"&set=js";
	//parent.Daten.location.href="?com=EditArea&dir="+encodeURI(p);
	//parent.Daten.open_file4(p);
	}
	else {
	//alert(qsub);
	//alert(parent.Daten.location.search);
    	parent.Daten.location.href=parent.Daten.location.search;
        } 
}

var absolutpath="<?php echo Registry::get('absolut_path'); ?>";

window.onload=function(){
	treeloader(absolutpath);
}

function load(){
	f=document.getElementById("root").innerHTML;
	//alert(f);
	treeloader(f);
	//parent.Navigation.location.reload(false);
}

function treeloader(treepath){
			//xx="<?php echo Registry::get('absolut_path'); ?>";
			
			//var xxx=encodeURI(treepath);
			var xxx=treepath;
			//alert(xxx);
			document.getElementById("root").innerHTML=treepath;
			$(document).ready( function() {
				
				$('#fileTree').fileTree(
				{ 
				
				root:xxx,

				script:'index.php'}
				, function(file) { 
				});				
			});
}

function home() {
	parent.Navigation.location.href="?com=JQFT";
}
		</script>

	</head>
	
	<body>

		
		
		
<div style=" position:fixed; background:#fff;top:0px; left:7px; width:250px; height:24px;border:1px solid #fff;z-index:99  " >
<!--<a href="javascript: treeloader(absolutpath)" target="Navigation"><img style="border:0px dotted #fff;margin-top:2px;" src="icons/home.png" alt="Home" /></a>-->
<a href="javascript: home();" ><img style="border:0px dotted #fff;margin-top:2px;" src="icons/home.png" alt="Home" /></a>
<a href="javascript: parent.Navigation.load()" target="Navigation"><img style="border:0px dotted #fff;margin-top:2px;" src="jqueryFileTree/images/refresh.gif" alt="refresh" /></a>
<a href="javascript: updir()"><img style="border:0px dotted #fff;margin-top:2px;" src="jqueryFileTree/images/directory_up.png" alt="up" title="up" /></a>
<a href="javascript: explorer()"><img style="border:0px dotted #fff;margin-top:2px;" src="jqueryFileTree/images/explorer.png" alt="Explorer" title="Explorer" /></a>
<a href="javascript: system()"><img style="border:0px dotted #fff;margin-top:2px;" src="jqueryFileTree/images/spanner_blue.png" alt="System" title="System" /></a>
</div>
<p style="position:relative;z-index:3;top:0px;height:28px;border:1px solid #fff">&nbsp;</p>
<div id="root"><?php echo Registry::get('absolut_path'); ?></div>
<div class="example">
			<div id="fileTree" class="demos"></div>
		</div>
		
	</body>
	
</html>