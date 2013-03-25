/**
/* Cookie functions
/*
**/

function setCookie(name,value,expire)
{
 var t = new Date();
 t = new Date(t.getTime() +expire);
 document.cookie = name+'='+value+'; expires='+t.toGMTString()+';';
}

function getCookie(n)
{
 a = document.cookie;
 res = '';
 while(a != '')
 {
  while(a.substr(0,1) == ' '){a = a.substr(1,a.length);}
  cookiename = a.substring(0,a.indexOf('='));
  if(a.indexOf(';') != -1)
  {cookiewert = a.substring(a.indexOf('=')+1,a.indexOf(';'));}
  else{cookiewert = a.substr(a.indexOf('=')+1,a.length);}
  if(n == cookiename){res = cookiewert;}
  i = a.indexOf(';')+1;
  if(i == 0){i = a.length}
  a = a.substring(i,a.length);
 }
return(res);
}



function killCookie(n)
{
 document.cookie = n+'=; expires=Thu, 01-Jan-70 00:00:01 GMT;';
} 

// END Cookie funtions

/**
/* File functions
/*
**/
function urlencode(s) {
	s = encodeURIComponent(s);
  	return s.replace(/~/g,'%7E').replace(/%20/g,'+');
}

function getcurdir(curfile){
	dirarray=curfile.split("/");
	dirarray.pop();
	return dirarray.join("/")+"/";
}

/**
/* Misc.
/**/

//var Jetzt = new Date();

function messenger(msg) {
	var n = new Date();
	//s=n.getSeconds();
	//alert(s.length);
	n.getSeconds()<10 ? seconds='0'+n.getSeconds() : seconds=n.getSeconds();
	n.getHours()<10 ? hours='0'+n.getHours() : hours=n.getHours();
	n.getMinutes()<10 ? minutes='0'+n.getMinutes() : minutes=n.getMinutes();
	//message=n.getDay()+"."+n.getMonth()+". "+n.getHours()+":"+n.getMinutes()+":"+n.getSeconds()+" | "+msg ;
	message=" | "+hours+":"+minutes+":"+seconds+" "+msg ;
	$('#msg').fadeOut('slow', function(){
		document.getElementById('msg').innerHTML=message;
	});
	$('#msg').fadeIn('slow');
	//$('#msg').css('display','hidden');

	
	
	

	

}