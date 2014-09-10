<?
ini_set('display_errors',false);
//ini_set('error_reporting', E_ALL);
session_start();
if(!isset($_SESSION['temp_filename'])){
$_SESSION['temp_filename'] = "playlist.xml";
}
/*
�{���B�����ҡGIIS5.0+PHP5.0.0�]PHP�C��o�Ӫ����N�L�k�B��^
�{���ɮצW�H�K�R�W�AXML�ɥѵ{���Ĥ@���B��ɦ۰ʥͦ�

�o��{����phpŪ�gxml�O��g�@�ӯd���O��CODE�ӧ������A��@�̪����v�ŧi�p�U
---------------------------------------------------------------------------------------------------------------------------
�{���s�g�G2004�~9��19��18�ɤ_��n��ޤj�ǾǤu�B
�@ �̡G�t�ڵ��N�]���١^
�pôOICQ�G9970143
�ӤH���I�Ghttp://www.21xml.com [�@��XML��]
---------------------------------------------------------------------------------------------------------------------------
�H�U�O�ڪ�²��
---------------------------------------------------------------------------------------------------------------------------
author : hsinchen(���H��)
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
<meta name="author" content="���H��(hsinchen)">
<meta name="keywords" content="playlist creator,hsinchen,���H��,flash_media_player">
<title>flash_media_player playlist creator</title>
<style>td,body{font-size:12px}</style>
</head>
<body>
<table width="100%" border=0 align=center cellpadding=3 cellspacing=1 bgcolor=#e5ecf9>
<tr><td bgcolor=#C3D9FF><div align=center><strong>�إߦۤv��<a href="http://www.jeroenwijering.com/?item=Flash_MP3_Player" target="_blank">Flash_MP3_Player</a>����M��(xml�ɪ��榡���@�ˡA�u�O���񾹤��P)</strong></div></td></tr>
<tr><td bgcolor=#e5ecf9>[<a href=?Action=PostMsg>add(�s�W�v��)</a>][<a href=?Action=ListMsg>list all(��ܲ{���v��)</a>][<a href="<?echo $_SESSION['temp_filename']?>">�b�����k��t�splaylist��</a>][<a href="test.php">���ռ���M��</a>]</td></tr>
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
		echo "<script>alert('�s�W���\');location.href='".$_SERVER['PHP_SELF']."'</script>";
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
			echo "<script>alert('�R�����\');location.href='".$_SERVER['PHP_SELF']."'</script>";
		}else{
			echo "<script>alert('���~�A����^����');location.href='".$_SERVER['PHP_SELF']."'</script>";
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
			print "<b>file(�ɮצ�}):</b>$Field[1]<br><b>title(�ɮצW��):</b>$Field[2]<br>";
			print "<b>author(�ɮק@��):</b>$Field[3]<br><b>link(�s������):</b>$Field[4]<br>";
			print "<b>creator(�����Ϥ�):</b>$Field[5]<br>";
			//$Field[2]=intval(trim(Htmlencode($Field[2])));
			print "<div align=right><a href='?Action=Modify&Identifier=$Field[0]'>edit(�s��)</a>&nbsp;<a href='?Action=Delete&Identifier=$Field[0]'>delete(�R��)</a></div>\n";
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
			print "<tr><td>file(�ɮצ�}):<input type=text name='location' value='$Fields[1]' size=20></td></tr>";
			print "<tr><td>title(�ɮצW��):<input type=text name='title' value='$Fields[2]' size=20></td></tr>";
			print "<tr><td>author(�ɮק@��):<input type=text name='creator' value='$Fields[3]' size=20></td></tr>";
			print "<tr><td>link(�s������):<input type=text name='info' value='$Fields[4]' size=20></td></tr>";
			print "<tr><td>creator(�����Ϥ�):<input type=text name='image' value='$Fields[5]' size=20></td></tr>";
			print "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' value='edit(�ק�)'></td></tr></form>";
		}else{
			echo "<script>alert('���~�A����^����');location.href='".$_SERVER['PHP_SELF']."'</script>";
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
				echo "<script>alert('�ק令�\');location.href='".$_SERVER['PHP_SELF']."'</script>";
			}
		}else{
			echo "<script>alert('���~�A����^����');location.href='".$_SERVER['PHP_SELF']."'</script>";
		}
	}

	public function PostMsg()
	{
		print "<form method='post' action='?Action=Append'>";
		print "<tr><td>file(�ɮצ�}):<input type=text name='location' size=20></td></tr>";
		print "<tr><td>title(�ɮצW��):<input type=text name='title' size=20></td></tr>";
		print "<tr><td>author(�ɮק@��):<input type=text name='creator' size=20></td></tr>";
		print "<tr><td>link(�s������):<input type=text name='info' size=20></td></tr>";
		print "<tr><td>creator(�����Ϥ�):<input type=text name='image' size=20></td></tr>";
		print "<tr><td>&nbsp;&nbsp;&nbsp;&nbsp;<input type='submit' value='add(�s�W)'></td></tr></form>";
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