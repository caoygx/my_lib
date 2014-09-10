<?
session_start();
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=big5">
<meta http-equiv="Content-Language" content="zh-tw">
<meta name="author" content="陳信成(hsinchen)">
<meta name="keywords" content="playlist creator,hsinchen,陳信成,flash_media_player">
<title>flash_media_player</title>
<style>
.dragAble {position:relative;cursor:move;}
</style>

<script type="text/javascript" src="swfobject.js"></script>
</head>
<body>

<INPUT type=button value="回上一頁" name=btnI  onclick="history.go(-1);">
<div id="player2" style="z-index:-1;" />
<a href="http://www.macromedia.com/go/getflashplayer">Get the Flash Player</a> to see this player.
<script type="text/javascript">
	var s2 = new SWFObject("mediaplayer.swf","playlist","100%","100%","7");
	s2.addParam("allowfullscreen","true");
	s2.addVariable("file","<?echo $_SESSION['temp_filename']?>");
	s2.addVariable("displayheight","400");
	s2.addVariable("backcolor","0x000000");
	s2.addVariable("frontcolor","0xCCCCCC");
	s2.addVariable("lightcolor","0x996600");
	s2.write("player2");

</script>

</body>
</html>