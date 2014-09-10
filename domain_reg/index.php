<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

require_once( "config.php" );
require_once( "fns.php" );
$code = $_SERVER['HTTP_HOST'];
$code = str_replace( "www.", "", $code );
$code .= "chenfengye";
$code = md5( $code );
if ( $code != $cfglic && $code != "952768cce9ba1da70e0bb1c4787cbeec" )
{
		//exit( "请安装授权文件！打开config.php将授权序列号填入\$cfglic处,<br>如果您尚未申请授权，请登录www.youdodo.cn/get.php获取授权文件，注意该授权是免费的，只是为方便我们统计！" );
}
if ( $_GET['updata'] == "up" )
{
		$tarr = file( "timetoup.dat" );
		$timeto = $tarr[0];
		$istime = date( "Y-m-d", strtotime( "{$timeto}+{$timetoup} day" ) );
		$now = date( "Y-m-d" );
		if ( $istime < $now )
		{
				define( "UPDATA", "chenfengye" );
				require_once( "autoup.php" );
		}
}
$ch = "";
$do = "";
$kaiwei = "";
$key = "";
$op = "";
$min = 0;
$max = 0;
$sql = "select * from list where id is not null ";
$sq = "";
$re = "";
$totalinfo = 0;
$totalPage = 0;
$currentPage = $_GET['page'] + 0;
$url = "?page";
$halfPer = 6;
$infoperpage = 50;
$ur = $_SERVER['QUERY_STRING'];
$ur = eregi_replace( "&page=[0-9]*", "", $ur );
$ur = eregi_replace( "page=[0-9]*&", "", $ur );
$hef = "?".$ur."&ch";
$url = "?".$ur."&page";
$lim = "<a href=".$hef."=a>A</a><a href={$hef}=b> B</a><a href={$hef}=c> C </a><a href={$hef}=d>D </a><a href={$hef}=e>E</a><a href={$hef}=f> F</a><a href={$hef}=g>G</a><a href={$hef}=h>H </a><a href={$hef}=i>I </a><a href={$hef}=j>J </a><a href={$hef}=k>K</a><a href={$hef}=l> L </a><a href={$hef}=m>M </a><a href={$hef}=n>N</a><a href={$hef}=o>O</a><a href={$hef}=p> P</a><a href={$hef}=q>Q </a><a href={$hef}=r>R </a><a href={$hef}=s>S</a><a href={$hef}=t> T </a><a href={$hef}=u>U </a><a href={$hef}=>V</a><a href={$hef}=w> W </a><a href={$hef}=x>X</a><a href={$hef}=y> Y </a><a href={$hef}=z>Z </a><a href={$hef}=>0 </a><a href={$hef}=1>1</a><a href={$hef}=2> 2 </a><a href={$hef}=3>3 </a><a href={$hef}=4>4</a><a href={$hef}=5> 5</a><a href={$hef}=6> 6</a><a href={$hef}=7> 7</a><a href={$hef}=8> 8 </a><a href={$hef}=9>9 </a>";
if ( !$_GET['action'] )
{
		$action = "all";
}
else
{
		$action = htmlspecialchars( $_GET['action'] );
		if ( $action == "" )
		{
				$action = "all";
		}
		if ( isset( $_GET['page'] ) && $_GET['page'] != "" )
		{
				$currentPage = intval( $_GET['page'] );
		}
}
if ( isset( $_GET['ch'] ) )
{
		$ch = htmlspecialchars( $_GET['ch'] );
}
else if ( isset( $_GET['do'] ) || $_GET['do'] == "do" )
{
		$key = htmlspecialchars( $_GET['key'] );
		$kaiwei = htmlspecialchars( $_GET['kaiwei'] );
		$op = htmlspecialchars( $_GET['op'] );
		$min = intval( $_GET['min'] );
		$max = intval( $_GET['max'] );
		$do = htmlspecialchars( $_GET['do'] );
}
if ( $action != "all" )
{
		$sql .= "and top='".$action."' ";
}
if ( $ch != "" )
{
		if ( !eregi( "^[a-z0-9]+\$", $ch ) )
		{
				exit( "<script>alert(\"你只能根据字符或数字作为分类查询的依据，请不要使用其他字符\");history.go(-1);</script>" );
		}
		$sql .= "and name like '".$ch."%'";
}
if ( $do == "do" && $ch == "" )
{
		if ( $key != "" )
		{
				if ( !eregi( "^[a-z0-9\\-]+\$", $key ) )
				{
						exit( "<script>alert(\"关键字只能使用字母，数字，或者下划线，请返回修改\");history.go(-1);</script>" );
				}
				if ( $kaiwei == "radom" )
				{
						$sql .= " and name like '%".$key."%' ";
				}
				else if ( $kaiwei == "start" )
				{
						$sql .= " and name like '".$key."%' ";
				}
				else if ( $kaiwei == "end" )
				{
						$sql .= " and name like '%".$key."' ";
				}
				else
				{
						exit( "<script>alert(\"您输入了关键词，但你关键字的起始位置没有定义\");history.go(-1);</script>" );
				}
		}
		if ( $op == "num" )
		{
				$sql .= " and name REGEXP '^[0-9]+\$' ";
		}
		else if ( $op == "char" )
		{
				$sql .= " and name REGEXP '^[a-z]+\$' ";
		}
		if ( $min != 0 )
		{
				$sql .= " and length(name)>=".$min;
		}
		if ( $max != 0 )
		{
				$sql .= " and length(name)<=".$max;
		}
}
$nowtime = date( "Y-m-d" );
$sql .= " and dtime >='".$nowtime."' ";
$sq = $sql;
$sq = str_replace( "*", "count(*) as t ", $sq );
$db = new mysqlone( );
$db->connect( $localhost, $dbuser, $dbpass, $dbname );
$query = $db->query( $sq );
$row = $db->fetch_array( $query );
$totalinfo = $row['t'];
if ( $totalinfo <= $infoperpage )
{
		$totalPage = 1;
}
else if ( $infoperpage < $totalinfo )
{
		$totalPage = $totalinfo % $infoperpage == 0 ? $totalinfo / $infoperpage : $totalinfo / $infoperpage;
}
$pageHtml = page( $totalPage, $currentPage, $url, $halfPer );
if ( $currentPage != 0 )
{
		$start = $currentPage * $infoperpage;
}
else
{
		$start = 0;
}
$sql .= " order by dtime asc limit ".$start.",{$infoperpage}";
$result = $db->query( $sql );
while ( $db->num_rows( $result ) && ( $row = $db->fetch_array( $result ) ) )
{
		$name = $row['name'].".".$row['top'];
		$dtime = $row['dtime'];
		$re .= "<LI class=r_left> ".$name." </LI> <LI class=r_leftnone> {$dtime} </LI><br />";
}
$tarr = file( "timetoup.dat" );
$timeto = $tarr[0];
$records = $tarr[1];
$istime = date( "Y-m-d", strtotime( "{$timeto}+{$timetoup} day" ) );
$now = date( "Y-m-d" );
if ( $istime < $now )
{
		//echo "<center><script>alert(\"您好,您是第一个在数据更新日访问本站的朋友,请稍等几分钟更新数据中,并请暂时不要关闭本窗口!\");location.href=\"index.php?updata=up\"</script></center>";
}
else
{
		eval( "print <<< EOF\n".readtf( "tmeplets.htm" )."\nEOF;\n" );
}
?>
