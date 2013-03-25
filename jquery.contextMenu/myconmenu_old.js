//<script type="text/javascript">

	function deletion(p){
	
		con=confirm("Delete "+p+", really ?");
		
		if(con){
			$.ajax({
				type: "POST",
		   		url: "index.php",
		   		data: "com=Profiler&del="+encodeURIComponent(p),
		   		success: function(msg){		       		
					alert(msg);
		       			parent.Daten.location.reload(false);
		       			parent.Navigation.load();
		   		}
			});
		}
	}
	
	function renaming(i,q){

                id=$('#'+i);         
                t=id.text();

                options = $.extend({
	                requestUrl  : "index.php",
	                minWidth    : '150px',
	                borderStyle : '0px dotted #dedede'                                 
        	});
                old_content = t;
                width  = (id.width() < options.minWidth)?options.minWidth:id.width()+50;
                ref=id.attr('href');
                id.removeAttr("href");

                var input = document.createElement('input');
                $(input).attr({ name  : 'input', value : t});
                $(input).css({
                        'width'  : width+'px', 
                        'height' : '13px',
                        'font-family':'Verdana,Arial,sans-serif',
                        'font-size':'11px'
                                
                });
                $(input).focus(function(){id.css({'border':options.borderStyle});});
                $(input).focusout(function(){
	                        
	                if($(input).val() == '' || $(input).val() == old_content) {
	         		
				$(input).remove();
				id.text(old_content);
				id.attr('href',ref);
	             	}
             	});
                $(input).change(function(){
                        $(input).css({'border':'0px dotted #fff'});                                  
                 	pth=$('#path').text();
                 
                 	old_path = urlencode(pth+old_content);
                 	new_path = urlencode(pth+$(input).val());
                         	//alert($(input).val());
                        if($(input).val() == '' || $(input).val() ==old_content) { 	
     				$(input).remove();
     				id.text(old_content);
     				id.attr('href',ref);
             		}
			else {
		 		datas="com=Profiler&ren="+old_path+"&rento="+new_path; 
                       
                		$.ajax({
                		type:"POST",
                		url:"index.php",
                		data:datas,
                		success: function(msg) {		        		
		        		messenger(msg);
		        		p=($(input).val());
		     			$(input).empty().remove();
		     			id.text(p);
		       			parent.Navigation.load();
		       			parent.Daten.location.reload(false);	
                        	}
                        	});
                        
                        }                 
                });

		   
		$(input).keydown(function(e) {
		      	//alert(e.keyCode);
		      	if(e.keyCode == 13) {
		      		//p=$(input).val();
		      		//alert("VAL="+p);
		      		if($(input).val()=='' || $(input).val() == old_content) {
                         		
                         		//p=($(input).val());
             				$(input).remove();
             				id.text(old_content);
             				id.attr('href',ref);
	 			} 
		      	}
		});
		
                        
                        
                $(input).html(id.text().replace(/<br\s*\/?>/img,""));
                id.html(input);
                $(input).focus();      
                                               
	}

	function ishowing(s) {
		
           	$.ajax({
                    type: "POST",
                    url: "index.php",
                       //data: "fid=&mode=WRITE&content="+encodeURIComponent(content),
                    //data: "fid="+encodeURIComponent(s)+"&mode=READ",
                    data: "com=Profiler&show="+urlencode(s),
                    success: function(answer){                   
                           if(answer=="Not Found") messenger("Unreachable");
                           //else alert(answer);
                           else parent.Daten.location.href="?com=IFrame&path="+answer;
                    }
            });	
	}
	
	function showing(s) {
		
           	$.ajax({
                    type: "POST",
                    url: "index.php",
                       //data: "fid=&mode=WRITE&content="+encodeURIComponent(content),
                    //data: "fid="+encodeURIComponent(s)+"&mode=READ",
                    data: "com=Profiler&show="+encodeURIComponent(s),
                    success: function(answer){                   
                           if(answer=="Not Found") messenger("Unreachable");
                           else parent.Daten.location.href=answer;
                    }
            });	
	}
	
	function zipping(s) {
		//alert(s);
	
		//parent.Daten.location.href=s;
           	$.ajax({
                    type: "POST",
                    url: "index.php",
                       //data: "fid=&mode=WRITE&content="+encodeURIComponent(content),
                    //data: "fid="+encodeURIComponent(s)+"&mode=READ",
                    data: "com=Profiler&zip="+encodeURIComponent(s),
                    success: function(zipmessage){                   
                           //if(answer=="Not Found") alert("Unreachable");
                           //else parent.Daten.location.href=answer;
	                       messenger(zipmessage);
	               
	                       parent.Daten.location.reload(false);
	                       parent.Navigation.load();                           
                    }
            });	
	}	

	function unzipping(s) {
		//alert(s);
	
		//parent.Daten.location.href=s;
           	$.ajax({
                    type: "POST",
                    url: "index.php",
                       //data: "fid=&mode=WRITE&content="+encodeURIComponent(content),
                    //data: "fid="+encodeURIComponent(s)+"&mode=READ",
                    data: "com=Profiler&unzip="+encodeURIComponent(s),
                    success: function(zipmessage){                   
                           //if(answer=="Not Found") alert("Unreachable");
                           //else parent.Daten.location.href=answer;
	                       messenger(zipmessage);
	               
	                       parent.Daten.location.reload(false);
	                       parent.Navigation.load();                           
                    }
            });	
	}
	
	function ziplist(s) {
		//alert(s);
		s=encodeURIComponent(s);
  		parent.Daten.location.href="?com=Ziplist&path="+s;
		
	
	}
	
	function copying(s) {
		setCookie('com','Profiler');
		setCookie('op','copy');
		setCookie('ren',s);
		
		$('#dirMenu').enableContextMenuItems('#paste');
		$(this).attr('disabled', true);
	
	}
	
	function cutting(s) {
		//alert(s);
		setCookie('com','Profiler');
		setCookie('op','cut');
		setCookie('ren',s);

		$('#dirMenu').enableContextMenuItems('#paste');
		$(this).attr('disabled', true);
		
	}
	
	function pasting(p) {
		
		ren=getCookie('ren');
		if( ren.substr(-1, 1) == "/") {
			ren=ren.substr(0, ren.length-1);
		} 
		ren_array=ren.split('/');
		dir_file=ren_array[ren_array.length-1];
		rento=p+dir_file;

		switch(getCookie('op')){
		
			case 'cut' : datas='com='+getCookie('com')+'&ren='+urlencode(ren)+'&rento='+urlencode(rento);
				     break;	
			case 'copy' : datas='com='+getCookie('com')+'&cp='+urlencode(ren)+'&cpto='+urlencode(rento);
				     break;	
		}
		
           	$.ajax({
                    type: "POST",
                    url: "index.php",

                    data: datas,
                    success: function(answer){                   
                           if(answer=='') messenger("Unreachable");
                           else {
                           	messenger(answer);
                           	killCookie('op');
				killCookie('com');
				killCookie('ren');
		                $('#dirMenu').disableContextMenuItems('#paste');
				$(this).attr('disabled', true);				
                            	parent.Daten.location.reload();
                           }

                           
                            
                                              }
                });
                
                $('#dirMenu').disableContextMenuItems('#paste');
		$(this).attr('disabled', true);
		
		//document.cookie=";expires=Thu, 01-Jan-70 00:00:01 GMT";
		//document.cookie=cpath+";expires=Thu, 01-Jan-70 00:00:01 GMT";
		//document.cookie='';
		killCookie('op');
		killCookie('com');
		killCookie('ren');
		//x=document.cookie;
		//alert("Cookie: "+x);

		
         	
	}	
		
		$(document).ready( function() {
	                    		
				//c=document.cookie;
				//alert(c);
				//c=getCookie('ren');
				//if(document.cookie.length > 0){
				if(getCookie("op")=="copy" || getCookie("op")=="cut"){
					
					$('#dirMenu').enableContextMenuItems('#paste');
					$(this).attr('disabled', true);
				}
				else {
					
					$('#dirMenu').disableContextMenuItems('#paste');
					$(this).attr('disabled', true);
				} 
				
				
				// Show menu when #myDiv is clicked
				$(".dir").contextMenu({
					menu: 'dirMenu'
				},
				function(action, el, pos) {
					/*alert(
						'Action: ' + action + '\n\n' +
						'Element text: ' + $(el).text() + '\n\n' + 
						'X: ' + pos.x + '  Y: ' + pos.y + ' (relative to element)\n\n' + 
						'X: ' + pos.docX + '  Y: ' + pos.docY+ ' (relative to document)'
				  	     );*/
								
					switch(action){
					
						case 'Explorer': 
						//alert($(el).attr('rel'));
						parent.Daten.location.href='?com=Explorer&dir='+$(el).attr('rel');break;
						//case 'Explorer': parent.Daten.location.href='?com=Explorer&dir='+$(el);break;
						//case 'show': parent.Daten.location.href=$(el).attr('rel'); break;
						case 'paste': pasting(href=$(el).attr('rel')); break;
						case 'cut'  : cutting(href=$(el).attr('rel')); break;
						case 'copy': copying(href=$(el).attr('rel'));break;
						case 'Test': parent.Daten.location.href='?com=Test&path='+urlencode($(el).attr('rel'));break;	
						case 'rename': renaming(id=$(el).attr('id'),href=$(el).attr('rel'));break;	
						case 'zip': zipping(href=$(el).attr('rel'));break;
						case 'delete': deletion(href=$(el).attr('rel'));break;
				        }
				  	    
				});

 //ZIP				
				// Show menu when a list item is clicked
				$(".zip").contextMenu({
					menu: 'zipMenu'
				}, function(action, el, pos) {
					
					switch(action){
					
						case 'edit': parent.Daten.location.href='?com=EditArea&dir='+$(el).attr('rel');break;
						//case 'edit': parent.Daten.location.href='?com=EditArea&dir='+$(el).attr('rel');break;
						//case 'show': parent.Daten.location.href=$(el).attr('rel'); break;
						case 'show'  : showing(href=$(el).attr('rel')); break;
						case 'ziplist'  : ziplist(href=$(el).attr('rel')); break;
						case 'rename': renaming(id=$(el).attr('id'),href=$(el).attr('rel'));break;
						case 'unzip': unzipping(href=$(el).attr('rel'));break;
						case 'copy'  : copying(href=$(el).attr('rel'));break;
						case 'cut'  : cutting(href=$(el).attr('rel')); break;						
						//case 'rename': renaming(href=$(el).attr('rel'));break;	
						case 'delete': deletion(href=$(el).attr('rel'));break;    						      
					}
					//alert(action+'?fid='+$(el).attr('rel'));
					
				});	
//END ZIP 	

				
				// Show menu when a list item is clicked
				$(".file").contextMenu({
					menu: 'fileMenu'
				}, function(action, el, pos) {
					
					switch(action){
					
						case 'edit': parent.Daten.location.href='?com=EditArea&dir='+$(el).attr('rel');break;
						//case 'edit': parent.Daten.location.href='?com=EditArea&dir='+$(el).attr('rel');break;
						//case 'show': parent.Daten.location.href=$(el).attr('rel'); break;
						case 'show'  : showing(href=$(el).attr('rel')); break;
						case 'copy'  : copying(href=$(el).attr('rel'));break;
						case 'cut'  : cutting(href=$(el).attr('rel')); break;
						case 'rename': renaming(id=$(el).attr('id'),href=$(el).attr('rel'));break;						
						case 'Test': parent.Daten.location.href='?com=Test&path='+urlencode($(el).attr('rel'));break;
						//case 'Test': alert("DDD");break;
						case 'delete': deletion(href=$(el).attr('rel'));break;    						      
					}
					//alert(action+'?fid='+$(el).attr('rel'));
					
				});
		
				
				// Disable menus
				$("#disableMenus").click( function() {
					$('#myDiv, #myList UL LI').disableContextMenu();
					$(this).attr('disabled', true);
					$("#enableMenus").attr('disabled', false);
				});
				
				// Enable menus
				$("#enableMenus").click( function() {
					$('#myDiv, #myList UL LI').enableContextMenu();
					$(this).attr('disabled', true);
					$("#disableMenus").attr('disabled', false);
				});
				
				// Disable cut/copy
				$("#disableItems").click( function() {
					$('#myMenu').disableContextMenuItems('#cut,#copy');
					$(this).attr('disabled', true);
					$("#enableItems").attr('disabled', false);
				});
				
				// Enable cut/copy
				$("#enableItems").click( function() {
					$('#myMenu').enableContextMenuItems('#cut,#copy');
					$(this).attr('disabled', true);
					$("#disableItems").attr('disabled', false);
				});				
				
			});
			
		//</script>