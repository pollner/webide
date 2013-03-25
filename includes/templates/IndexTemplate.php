<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN"
   "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<script language="Javascript" type="text/javascript" src="index.js"></script>
<title>codr</title>

<frameset rows="33,*" >

	<frame src="?com=Head" name="Head" scrolling="no" frameborder=0 >
	
	<frameset cols="250,*" >
	  <frame src="?com=JQFT" name="Navigation" scrolling="yes" frameborder=1 >
	  <frame src="?com=Explorer&dir=<?php echo Registry::get('absolut_path');?>" name="Daten" frameborder=0>
	  <noframes>
	    <body>
	      <p><a href="verweise.htm">Navigation</a> <a href="startseite.htm">Daten</a></p>
	    </body>
	  </noframes>
</frameset>


</frameset>
</head>
</html>