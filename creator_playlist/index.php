<?
ini_set('display_errors',false);
//ini_set('error_reporting', E_ALL);
session_start();
if(!isset($_SESSION['temp_filename'])){
$_SESSION['temp_filename'] = "playlist.xml";
}
/*
程式運行環境：IIS5.0+PHP5.0.0（PHP低於這個版本將無法運行）
程式檔案名隨便命名，XML檔由程式第一次運行時自動生成

這支程式的php讀寫xml是改寫一個留言板的CODE而完成的，原作者的版權宣告如下
---------------------------------------------------------------------------------------------------------------------------
程式編寫：2004年9月19日18時于湖南科技大學學工處
作 者：孤芳翔鷹（蔣贊）
聯繫OICQ：9970143
個人站點：http://www.21xml.com [世紀XML網]
---------------------------------------------------------------------------------------------------------------------------
以下是我的簡介
---------------------------------------------------------------------------------------------------------------------------
author : hsinchen(陳信成)
mail : hsinchen7@gmail.com
msn : hsinchen7@hotmail.com
website : http://hsin.ohya.to
---------------------------------------------------------------------------------------------------------------------------
*/
?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=big5">
<meta http-equiv="Content-Language" content="zh-tw">
<meta name="author" content="陳信成(hsinchen)">
<meta name="keywords" content="playlist creator,hsinchen,陳信成,flash_media_player">
<title>flash_media_player playlist creator</title>
<style>td,body{font-size:12px}</style>
</head>
<body>
<table width="100%" border=0 align=center cellpadding=3 cellspacing=1 bgcolor=#e5ecf9>
<tr><td bgcolor=#C3D9FF><div align=center><strong>建立自己的<a href="http://www.jeroenwijering.com/?item=Flash_MP3_Player" target="_blank">Flash_MP3_Player</a>播放清單(xml檔的格式都一樣，只是播放器不同)</strong></div></td></tr>
<tr><td bgcolor=#e5ecf9>[<a href=?Action=PostMsg>add(新增影音)</a>][<a href=?Action=ListMsg>list all(顯示現有影音)</a>][<a href="<?echo $_SESSION['temp_filename']?>">在此按右鍵另存playlist檔</a>][<a href="test.php">測試播放清單</a>]</td></tr>
<?php
class StudyXML extends DOMDocument
{
private $Root;
	public function __construct()
	{
		parent:: __construct();
		if (!file_exists($_SESSION['temp_filename']))
		{
			$xmlstr = "<?xml version='1.0'?><playlist version='1' xmlns='http://xspf.org/ns/0/'><trackList></trackList></playlist>";
			$this->loadXML($xmlstr);
			$this->save($_SESSION['temp_filename']);
		}
		else{
		$this->load($_SESSION['temp_filename']);
		}
    }

	public function Append($location,$title,$creator,$info,$image)
	{
	  $location = ($location != "") ? $location : " ";
	  $title = ($title != "") ? $title : " ";
	  $creator = ($creator != "") ? $creator : " ";
	  $info = ($info != "") ? $info : " ";
	  $image = ($image != "") ? $image : " ";

		$Root = $this->documentElement;

		$Identifier =date("Ynjhis");
		$NIdentifier = $this->createElement("identifier");
		$text = $this->createTextNode(iconv("big5","UTF-8",$Identifier));
		$NIdentifier->appendChild($text);

		$Nlocation = $this->createElement("location");
		$text = $this->createTextNode(iconv("big5","UTF-8",$location));
		$Nlocation->appendChild($text);

		$Ntitle = $this->createElement("title");
		$text = $this->createTextNode(iconv("big5","UTF-8",$title));
		$Ntitle->appendChild($text);

		$Ncreator = $this->createElement("creator");
		$text = $this->createTextNode(iconv("big5","UTF-8",$creator));
		$Ncreator->appendChild($text);

		$Ninfo = $this->createElement("info");
		$text = $this->createTextNode(iconv("big5","UTF-8",$info));
		$Ninfo->appendChild($text);

		$Nimage = $this->createElement("image");
		$text = $this->createTextNode(iconv("big5","UTF-8",$image));
		$Nimage->appendChild($text);

		$trackList = $this->getElementsByTagName("trackList")->item(0);
		$track = $this->createElement("track");
		$track->appendChild($NIdentifier);
		$track->appendChild($Nlocation);
		$track->appendChild($Ntitle);
		$track->appendChild($Ncreator);
		$track->appendChild($Ninfo);
		$track->appendChild($Nimage);
		$trackList->appendChild($track);
		$Root->appendChild($trackList);
		$this->save($_SESSION['temp_filename']);
		echo "<script>alert('新增成功');location.href='".$_SERVER['PHP_SELF']."'</script>";
	}

	public function Delete($Identifier)
	{
		//$Root = $this->documentElement;
		$trackList = $this->getElementsByTagName("trackList")->item(0);
		$track = $this->getElementsByTagName("track");
		$track_Length =$track->length;
		for($i=0;$i<$track->length;$i++)
		{

			foreach ($track->item($i)->childNodes as $articles)
			{
				$Field[0]=iconv("UTF-8","big5",$articles->textContent);
				if($Field[0] == $Identifier){$j=$i;break;}
			}
		}
		if(isset($j)){
			$K=0;
			foreach ($track->item($j)->childNodes as $articles)
			{
				$Fields[$K]=iconv("UTF-8","big5",$articles->textContent);
				$K++;
			}
			$trackList->removeChild($track->item($j));
			$this->save($_SESSION['temp_filename']);
			echo "<script>alert('刪除成功');location.href='".$_SERVER['PHP_SELF']."'</script>";
		}else{
			echo "<script>alert('錯誤，跳轉回首頁');location.href='".$_SERVER['PHP_SELF']."'</script>";
		}
	}

	function Htmlencode($Text)
	{
		$Text=StripSlashes($Text);
		$Text=ereg_replace("\|","&#124;",$Text);
		//$Text=ereg_replace("<","&lt;",$Text);
		//$Text=ereg_replace(">","&gt;",$Text);
		$Text=ereg_replace("\r\n","<br>",$Text);
		$Text=ereg_replace("\r","<br>",$Text);
		$Text=ereg_replace(" ","&nbsp;",$Text);
		$Text=nl2br($Text);
		return $Text;
	}

	public function ListMsg()
	{
		//$Root = $this->documentElement;
		//$xpath = new DOMXPath($this);
		$track = $this->getElementsByTagName("track");
		$track_Length =$track->length;
		for($i=0;$i<$track->length;$i++)
		{

			$K=0;
			foreach ($track->item($i)->childNodes as $articles)
			{
				$Field[$K]=iconv("UTF-8","big5",$articles->textContent);
				$K++;
			}
			print "<tr><td bgcolor=#FFFFFF>";
			print "<b>file(檔案位址):</b>$Field[1]<br><b>title(檔案名稱):</b>$Field[2]<br>";
			print "<b>author(檔案作者):</b>$Field[3]<br><b>link(連結網站):</b>$Field[4]<br>";
			print "<b>creator(相關圖片):</b>$Field[5]<br>";
			//$Field[2]=intval(trim(Htmlencode($Field[2])));
			print "<div align=right><a href='?Action=Modify&Identifier=$Field[0]'>edit(編輯)</a>&nbsp;<a href='?Action=Delete&Identifier=$Field[0]'>delete(刪除)</a></div>\n";
			print "</td></tr>";
		}
	}

	public function Modify($Identifier)
	{
		//$Root = $this->documentElement;
		//$xpath = new DOMXPath($this);
		$track = $this->getElementsByTagName("track");
		$track_Length =$track->length;
		for($i=0;$i<$track->length;$i++)
		{

			foreach ($track->item($i)->childNodes as $articles)
			{
				$Field[0]=iconv("UTF-8","big5",$articles->textContent);
				if($Field[0] == $Identifier){$j=$i;break;}
			}
		}
		if(isset($j)){
			$K=0;
			foreach ($track->item($j)->childNodes as $articles)
			{
			$Fields[$K]=iconv("UTF-8","big5",$articles->textContent);
			$K++;
			}

			print "<form method='post' action='?Action=SaveEdit&Identifier=$Identifier'>";
			print "<tr><td>file(檔案位址):<input type=text name='location' value='$Fields[1]' size=20></td></tr>";
			print "<tr><td>title(檔案名稱):<input type=text name='title' value='$Fields[2]' size=20></td></tr>";
			print "<tr><td>author(檔案作者):<input type=text name='creator' value='$Fields[3]' size=20></td></tr>";
			print "<tr><td>link(連結網站):<input type=text name='info' value='$Fields[4]' size=20></td></tr>";
			print "<tr><td>creator(相關圖片):<input type=text name='image' value='$Fields[5]' size=20></td></tr>";
			print "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' value='edit(修改)'></td></tr></form>";
		}else{
			echo "<script>alert('錯誤，跳轉回首頁');location.href='".$_SERVER['PHP_SELF']."'</script>";
		}
	}

	public function SaveEdit($Identifier,$location,$title,$creator,$info,$image)
	{
	  $location = ($location != "") ? $location : " ";
	  $title = ($title != "") ? $title : " ";
	  $creator = ($creator != "") ? $creator : " ";
	  $info = ($info != "") ? $info : " ";
	  $image = ($image != "") ? $image : " ";

		//$Root = $this->documentElement;
		//$xpath = new DOMXPath($this);
		$track = $this->getElementsByTagName("track");
		$track_Length =$track->length;
		for($i=0;$i<$track->length;$i++)
		{
			foreach ($track->item($i)->childNodes as $articles)
			{
				$Field[0]=iconv("UTF-8","big5",$articles->textContent);
				if($Field[0] == $Identifier){$j=$i;break;}
			}
		}

		$Replace[0]=$Identifier;
		$Replace[1]=$location;
		$Replace[2]=$title;
		$Replace[3]=$creator;
		$Replace[4]=$info;
		$Replace[5]=$image;
		if(isset($j)){
			$K=0;
			foreach ($track->item($j)->childNodes as $articles)
			{
				//$Field[$K]=iconv("UTF-8","big5",$articles->textContent);
				$newText = $this->createTextNode(iconv("big5","UTF-8",$Replace[$K]));
				$articles->replaceChild($newText,$articles->lastChild);
				$K++;
				$this->save($_SESSION['temp_filename']);
				echo "<script>alert('修改成功');location.href='".$_SERVER['PHP_SELF']."'</script>";
			}
		}else{
			echo "<script>alert('錯誤，跳轉回首頁');location.href='".$_SERVER['PHP_SELF']."'</script>";
		}
	}

	public function PostMsg()
	{
		print "<form method='post' action='?Action=Append'>";
		print "<tr><td>file(檔案位址):<input type=text name='location' size=20></td></tr>";
		print "<tr><td>title(檔案名稱):<input type=text name='title' size=20></td></tr>";
		print "<tr><td>author(檔案作者):<input type=text name='creator' size=20></td></tr>";
		print "<tr><td>link(連結網站):<input type=text name='info' size=20></td></tr>";
		print "<tr><td>creator(相關圖片):<input type=text name='image' size=20></td></tr>";
		print "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' value='add(新增)'></td></tr></form>";
	}
}

$HawkXML = new StudyXML;

if(isset($_GET['Action'])){
	switch($_GET['Action'])
	{
		case "":
		case "ListMsg":
		$HawkXML->ListMsg();
		break;
		case "PostMsg":
		$HawkXML->PostMsg();
		break;
		case "Append":
		$HawkXML->Append($_POST['location'],$_POST['title'],$_POST['creator'],$_POST['info'],$_POST['image']);
		break;
		case "Delete":
		$HawkXML->Delete($_GET['Identifier']);
		break;
		case "Modify":
		$HawkXML->Modify($_GET['Identifier']);
		break;
		case "SaveEdit":
		$HawkXML->SaveEdit($_GET['Identifier'],$_POST['location'],$_POST['title'],$_POST['creator'],$_POST['info'],$_POST['image']);
		break;
	}
}else{
		$HawkXML->ListMsg();
}
?>
</table>
</body>
</html>