<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8">
	<title>Explorer</title>

	

	<link href="jqueryFileTree/mainFileTree.css" rel="stylesheet" type="text/css" media="screen" />
	<script type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>
    	<script type="text/javascript" src="js/general.js"></script>
<!--	<script src="jquery.inlineEdit.js"  type="text/javascript"></script>-->
	<script type="text/javascript" src="jquery.contextMenu/jquery.contextMenu.js"></script>
	<script type="text/javascript" src="jquery.contextMenu/myconmenu.js"></script>
	<link rel="StyleSheet" href="jquery.contextMenu/jquery.contextMenu.css" type="text/css" />

	<script language="Javascript" type="text/javascript">
		// initialisation
		
	      path="<?php echo utf8_encode($got_dir) ?>";
		
	    function init(){
           	//d=path;
           	//messenger("Loaded from: "+d);
           }
           
           window.onload = init;
		
		/*
            $(document).ready(function() { 
                    $('.dir').each(function() {
                            $(this).inlineEdit({
                                    requestUrl : 'index.php'
                            });
                    });
            });		*/
		
		
		function new_folder(){
			foldername=prompt("New directory :",path+"new_directory");
			if(foldername){
				//alert("mkdir="+path+foldername);
				$.ajax({
   					type: "POST",
			   		url: "index.php",
			   		//data: "fid=&mode=WRITE&content="+encodeURIComponent(content),
			   		data: "com=Profiler&mkdir="+encodeURIComponent(foldername),
			   		success: function(msg){
			       			alert( "Data saved: " + msg );
			       			parent.Daten.location.reload(false);
			       			parent.Navigation.load();
			       		
			   		}
			   		
 					});

				
				//alert("Neues Verzeichnis "+foldername+" in "+path);
			}
			
		}
		
		function new_file(){
		
			//$("table").append('<tr style="border:1px dotted red"><td class="file">&nbsp;</td><td><input id="input" type="text" value="newfile.txt" /></td><td></td><td></td></tr>');
			//$("#input").focus();
			filename=prompt("New file :",path+"new_file");
			
			if(filename){
				//alert("mkdir="+path+foldername);
				$.ajax({
   					type: "POST",
			   		url: "index.php",
			   		//data: "fid=&mode=WRITE&content="+encodeURIComponent(content),
			   		data: "com=Profiler&mkfile="+encodeURIComponent(filename),
			   		success: function(msg){
			       			alert( "Data saved: " + msg );
			       			parent.Daten.location.reload(false);
			       			parent.Navigation.load();
			       		
			   		}
			   		
 					});

				
				//alert("Neues Verzeichnis "+foldername+" in "+path);
			}
			
			
			
			
		}


		
		function shell(){
		    parent.Daten.location.href="phpshell-2.4/phpshell.php";
		    //parent.Daten.location.href="?com=Phpshell";
		}
		
		
	        function phpinfo(){
	            parent.Daten.location.href="?com=Phpinfo";
	        }
		
		function server(){
		    parent.Daten.location.href="?com=Server";
		}

		function make_ht(){
		    //r=document.getElementById('path').innerHTML;
		    r=path;
		    r=urlencode(r);
		    
		    parent.Daten.location.href="?com=Htaccess&dir="+r;
		}

		function uploader() {
			//alert("DEBUG");
			//uploaderpath=document.getElementById('').innerHTML;
			parent.Daten.location.href="?com=Uploader&dir="+urlencode(path);

		}
		 function urlencode(s) {
		  	s = encodeURIComponent(s);
		  	return s.replace(/~/g,'%7E').replace(/%20/g,'+');
		 }

	</script>



</head>
<body>


<input type="image" src="jqueryFileTree/images/directory.png" onclick="new_folder()" title="Directory" value="new_folder" />
<input type="image" src="jqueryFileTree/images/file.png" onclick="new_file()" title="File" value="new_folder" />
<input type="image" src="editarea/edit_area/images/shell.gif" onclick="shell()" title="Shell" />
<input type="image" src="editarea/edit_area/images/nfoscript.gif" onclick="server()" title="Server" />
<input type="image" src="jqueryFileTree/images/php.png" onclick="phpinfo()" title="Phpinfo" />
<input type="image" src="editarea/edit_area/images/screw1.png" onclick='parent.Daten.location.href="?com=EditArea&dir=<?php echo Registry::get('getcwd'); ?>includes/config.php"' title="Config" />
<input type="image" src="icons/folder_lock.png" onclick="make_ht()" title="Htaccess" />
<input type="image" src="icons/upload.png" onclick="uploader()" title="Uploader" />
<span id="msg" class="pathline"><?php echo $msg ?></span>
<dir id="content" style="margin:0px;padding:0px;"><?php echo $html_content ?></dir>
		<ul id="dirMenu" class="contextMenu">
			<li class="Explorer"><a href="#Explorer">Open</a></li>
		        <li class="copy separator"><a href="#copy">Copy</a></li>
		    	<li class="cut" style="color:grey"><a href="#cut">Cut</a></li>
		        <li class="paste"><a href="#paste" disabled="disabled" >Paste</a></li>
			<li class="rename" style="color:grey"><a href="#rename">Rename</a></li>
			<li class="zip" style="color:grey"><a href="#zip">Zip</a></li>
			<li class="test"><a href="#Test">Test</a></li>
			<li class="delete"><a href="#delete">Delete</a></li>
		    <!--<li class="quit separator"><a href="#quit">Quit</a></li>-->
		</ul>
		

		<ul id="fileMenu" class="contextMenu">
			<li class="edit"><a href="#edit">Edit</a></li>
		        <li class="show separator" style="color:grey"><a href="#show">Show</a></li>
		        <li class="copy"><a href="#copy">Copy</a></li>
		        <li class="cut" style="color:grey"><a href="#cut">Cut</a></li>
		        <!--<li class="paste"><a href="#paste">Paste</a></li>-->
			<li class="rename"><a href="#rename">Rename</a></li>
			<li class="test"><a href="#Test">Test</a></li>
			<li class="delete"><a href="#delete">Delete</a></li>
		    <!--<li class="quit separator"><a href="#quit">Quit</a></li>-->
		</ul>
		
		<ul id="zipMenu" class="contextMenu">
		        <li class="Explorer" style="color:grey"><a href="#ziplist">Open</a></li>
		        <li class="dload separator"><a href="#show" >Download</a></li>
		        <li class="zip"><a href="#unzip">Extract</a></li>		       
		        <li class="copy"><a href="#copy">Copy</a></li>
		        <li class="cut" style="color:grey"><a href="#cut">Cut</a></li>
		        <!--<li class="paste"><a href="#paste">Paste</a></li>-->
			<li class="rename"><a href="#rename">Rename</a></li>
			<li class="delete"><a href="#delete">Delete</a></li>
		    <!--<li class="quit separator"><a href="#quit">Quit</a></li>-->
		</ul>				

</body>
</html>