<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" >
<head>
	<meta name="robots" content="all">
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>EditArea - the code editor in a textarea</title>
	<script language="javascript" type="text/javascript" src="js/general.js"></script>
	<script language="javascript" type="text/javascript" src="jquery/jquery-1.4.2.min.js"></script>
	<!--<script language="Javascript" type="text/javascript" src="editarea/edit_area/edit_area_full.js"></script>-->
	<script language="javascript" type="text/javascript" src="editarea/edit_area/edit_area_compressor.php?plugins"></script>
	<!--<script language="javascript" type="text/javascript" src="editarea/edit_area/edit_area_full.gz"></script>-->
	<style type="text/css">
         *, body, html {margin:0px;padding:0px;}
         body{padding:0px 3px;} 
         img {position:relative;}
         
         
         </style>
	<script language="Javascript" type="text/javascript">
		// initialisation
	
		
		filename="<?php echo utf8_encode($file) ?>";   

           function init(){
           	d=filename;
           	messenger("Loaded from: "+d);
           }
           
           window.onload = init;

		
		editAreaLoader.init({
			id: "code"	// id of the textarea to transform		
			,start_highlight: true
			,allow_resize: "both"
			,allow_toggle: false
			//,font-family: "monospace"
			,language: "en"
			,syntax: "<?php echo $fileext; ?>"	
			//,toolbar: "search, go_to_line, |, undo, redo, |, select_font, |, syntax_selection, |, change_smooth_selection, highlight, reset_highlight, |, help"
			//,toolbar:"load, new_document, | , select_font, | , syntax_selection, | , charmap, fullscreen, search, go_to_line, undo, redo, change_smooth_selection, reset_highlight, highlight, word_wrap, | , help" 
                        ,toolbar:"| , select_font, | , syntax_selection, | , charmap, fullscreen, search, go_to_line, undo, redo, change_smooth_selection, reset_highlight, highlight, word_wrap, | , help" 
			,syntax_selection_allow: "css,html,js,java,perl,php,python,vb,xml,c,cpp,robotstxt,sql,basic,pas"
			,is_multi_files: true
			,EA_load_callback: "editAreaLoaded"
			,show_line_colors: true
			//,load_callback: "my_load"
			//,save_callback: "my_save"
			//,end_toolbar: "*,test_but, |,test_select",
			,plugins: "charmap"
			//,end_toolbar: "*,test_but, |,test_select",
			//,plugins: "test"
			//,word_wrap: true
			//,gecko_spellcheck:true
			//,allow_toggle: true
			//,debug:true
		});
		
		function safe(){
					
			File=editAreaLoader.getCurrentFile("code");
			/*for (props in File){
				ps=ps +" | "+ props + " : "+File[props];
			}*/
			//alert(ps);
			pname=File['title'];
			//alert(pname);
			ftext=File['text'];
			//alert('filetitle  : ' + File['title']);
			//alert('filetext  : ' + File['text']);
			$.ajax({
   					type: "POST",
			   		url: "index.php",
			   		//data: "fid=&mode=WRITE&content="+encodeURIComponent(content),
			   		data: "com=Profiler&fid="+encodeURIComponent(pname)+"&mode=WRITE&content="+encodeURIComponent(ftext),
			   		success: function(msg){
			       		//alert( "Data saved:\n" + msg );
			       		//$('#msg').text('Data saved: '+msg);
			       		parent.Navigation.load();
			       		messenger("Data saved: "+msg);
			       		editAreaLoader.setFileEditedMode("code",pname, false)
			       		
			       		//open_file(codestring);
			       		//var new_file= {id: "code", text:codestring , syntax: "PHP", title: ''+file_name};
						//editAreaLoader.openFile('code', new_file);
						//editAreaLoader.setValue("code", codestring);
			   		
			   		}
			   		//editAreaLoader.setFileEditedMode("code", file_id, edited_mode)
 			});
			//my_save(id,content);
			
		}
		// callback functions
		
		/*
		function my_save(id,content){
		
		gcf=editAreaLoader.getCurrentFile("code");	
		
		pname=gcf['title'];	
			msg="FAILED";
			//alert(nd);
			//alert("Here is the content of the EditArea '"+ id +"' as received by the save callback function:\n"+content);
			$.ajax({
   					type: "POST",
			   		url: "profiler.php",
			   		//data: "fid=&mode=WRITE&content="+encodeURIComponent(content),
			   		data: "fid="+pname+"&mode=WRITE&content="+encodeURIComponent(content),
			   		success: function(msg){
			       		alert( "Data saved: " + msg );
			       		//open_file(codestring);
			       		//var new_file= {id: "code", text:codestring , syntax: "PHP", title: ''+file_name};
						//editAreaLoader.openFile('code', new_file);
						//editAreaLoader.setValue("code", codestring);
			   		}
 				});		
		}*/

		function my_load(){
			//open_file("<?php echo $file; ?>");
			open_file("./includes/profiler.php");
			//editAreaLoader.setValue(id, "The content is loaded from the load_callback function into EditArea");
		}
		//Starting Loader
		function editAreaLoaded(id){
			if(id=="code")
			{
				open_file3();
				//open_file(filename);
				/*$.ajax({
   					type: "POST",
			   		url: "profiler.php",
			   		data: "fid=<?php echo $file; ?>",
			   		success: function(codestring){
			       		//alert( "Data Saved: " + msg );
			       		open_file(codestring);
   					}
 				});*/
			}
		}
		

		function new_document () 
		{
		        var newfilename="";
			newfilename=prompt("New document: ",getcurdir(filename)+"new_file");
			if(newfilename){
				syn=getextension(newfilename);
				
				var new_file= {id: newfilename, text: "", title: newfilename, syntax:syn};
				editAreaLoader.openFile('code' ,new_file );			
			}
		}

		function open_file3()
		{
			$.ajax({
   					type: "POST",
			   		url: "index.php",
			   		data: "com=Profiler&fid="+urlencode(filename),
			   		success: function(codestring){
			       		//alert( "Data loaded: " + codestring );
			       		//open_file(codestring);
			       		//var new_file= {id: "code", text:codestring , syntax: "PHP", title: ''+file_name};
					con_text=codestring;	
			       		//editAreaLoader.openFile('code', new_file);
						//editAreaLoader.setValue("code", codestring);
			var new_file= {id: filename, text: con_text, title: filename};
			editAreaLoader.openFile('code', new_file);
			   		}
 			});		
 			//alert("DEBUG");
			//var new_file= {id: filename, text: con_text, syntax: 'php', title: filename};
			//editAreaLoader.openFile('code', new_file);
		}

		function getextension(pathtofile) {
	            splitfile=pathtofile.split("/");
	            //alert(splitfile);
	            
	            gext=splitfile[splitfile.length - 1];
	            hext=gext.split(".");
	            ext=hext[hext.length-1];
	            //alert(ext);
	            if ( ext in { c:1, cpp:1, css:1, html:1, js:1, java:1, php:1, sql:1, xml:1 } )
	            {
	                 return ext;
	            }
	            else {
	            
	                ext='robotstxt';
	                return ext;
	                
	            }
			
		}
		function open_file4(f)
		{
			
			extens=getextension(f);
			
			$.ajax({
   					type: "POST",
			   		url: "index.php",
			   		data: "com=Profiler&fid="+urlencode(f),
			   		success: function(c){
			       		//alert( "Data loaded: " + codestring );
			       		//open_file(codestring);
			       		//var new_file= {id: "code", text:codestring , title: ''+file_name};
					con_text=c;	
			       		//editAreaLoader.openFile('code', new_file);
						//editAreaLoader.setValue("code", codestring);
			var new_file= {id: f, text: con_text, syntax: extens , title: f};
			editAreaLoader.openFile('code', new_file);
			   		}
 			});		
 			//alert("DEBUG");
			//var new_file= {id: filename, text: con_text, syntax: 'php', title: filename};
			//editAreaLoader.openFile('code', new_file);
		}
				
		function shell(){
		
			//alert("SHELL!");
			parent.Daten.location.href="phpshell-2.1/phpshell.php";
		}
		
		function getcurdir(curfile){
		
			dirarray=curfile.split("/");
			dirarray.pop();
			//dirarray.pop();
			//alert(dirarray.join("/")+"/");
			return dirarray.join("/")+"/";
		}

		function urlencode(s) {
			s = encodeURIComponent(s);
		  	return s.replace(/~/g,'%7E').replace(/%20/g,'+');
		}
		
		function closeEA(){
		
			explorerpath=getcurdir(filename);

			parent.Daten.location.href="?com=Explorer&dir="+urlencode(explorerpath)+"&set=js";
		}
		
		function uploader() {
			uploaderpath=getcurdir(filename);
			parent.Daten.location.href="?com=Uploader&dir="+urlencode(uploaderpath);

		}

	</script>
</head>
<body>
<div style="height: 25px;margin-bottom:0px;padding-bottom:0px;">
<input type="image" src="editarea/edit_area/images/save.gif" onclick='safe();' title="Save" />
<input type="image" src="editarea/edit_area/images/newdocument.gif" onclick='new_document()' title="New file" value='New file' />
<input type="image" src="editarea/edit_area/images/shell.gif" onclick='parent.Daten.location.href="phpshell-2.4/phpshell.php"' title="Shell" />
<input type="image" src="editarea/edit_area/images/nfoscript.gif" onclick='parent.Daten.location.href="?com=Server"' title="Server" />
<input type="image" src="jqueryFileTree/images/php.png" onclick='parent.Daten.location.href="?com=Phpinfo"' title="Phpinfo" />
<input type="image" src="editarea/edit_area/images/screw1.png" onclick='open_file4("<?php echo Registry::get('getcwd'); ?>includes/config.php")' title="Config" />
<img title="Explorer" alt="Explorer" src="jqueryFileTree/images/explorer.png" onclick='closeEA()' style="border: 0px dotted rgb(255, 255, 255); margin-top: 2px;">
<img title="Upload" alt="Upload" src="icons/upload.png" onclick='uploader()' style="border: 0px dotted rgb(255, 255, 255); margin-top: 2px;">
<!--<input type="image" src="editarea/edit_area/images/close.gif" onclick='closeEA();' title="Close" align="right" />-->
<span id="msg" class="pathline" style="font-family:Verdana, Arial, sans-serif; font-size:11px;"></span>
</div>
<form action="" method="post">
	
		<textarea id="code" style="height: 530px ;width: 100%;" name="test_1">
		</textarea>
		<br />
<!--
	<fieldset>
		<textarea id="example_2" style="height: 280px; width: 100%;" name="test_2">
		</textarea>
		<p>Custom controls:<br />
			<input type='button' onclick='open_file1()' value='open file 1' />
			<input type='button' onclick='open_file2()' value='open file 2' />
			<input type='button' onclick='close_file1()' value='close file 1' />
		</p>
	</fieldset>	
-->
</form>
	<script language="Javascript" type="text/javascript">
           
           
	   	
	   if (navigator.appName.indexOf("Explorer") != -1){
           	 var h=document.documentElement.clientHeight-50;	
           }
           else {
           	 var h=window.innerHeight-50+"px";			
           }     
   
	   document.getElementById("code").style.height=h;
	   	
	</script>
</body>
</html>