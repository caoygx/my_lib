<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

set_time_limit( 0 );
require_once( "unzip.lib.php" );
require_once( "fns.php" );
require_once( "config.php" );
$code = $_SERVER['HTTP_HOST'];
$code = str_replace( "www.", "", $code );
$code .= "chenfengye";
$code = md5( $code );
if ( $code != $cfglic && $code != "952768cce9ba1da70e0bb1c4787cbeec" )
{
		///exit( "请安装授权文件！打开config.php将授权序列号填入\$cfglic处,<br>如果您尚未申请授权，请登录www.youdodo.cn/get.php获取授权文件，注意该授权是免费的，只是为方便我们统计！" );
}
if ( UPDATA != "chenfengye" )
{
		echo "请不要非法运行本页面，2秒钟后将自动跳转会首页<meta   http-equiv=\"refresh\"   content=\"2\";url=\"index.php\"";
		exit( );
}
$tarr = file( "timetoup.dat" );
$timeto = $tarr[0];
$records = $tarr[1];
$istime = date( "Y-m-d", strtotime( "{$timeto}+{$timetoup} day" ) );
$now = date( "Y-m-d" );
if ( $now < $istime )
{
		exit( "拒绝更新，请在 ".$istime." 后更新，或者请重新配置您的配置文件" );
}
$fp = fopen( "http://www.pool.com/Downloads/PoolDeletingDomainsList.zip", "r" );
$fo = fopen( "temp.zip", "w" );
if ( !$fp )
{
		exit( "暂时链接远程服务器无法更新,请稍后再行尝试!" );
}
while ( !feof( $fp ) )
{
		fwrite( $fo, fread( $fp, 1024 ) );
}
fclose( $fo );
fclose( $fp );
$zip = new SimpleUnzip( "temp.zip" );
$s =& $zip->Entries[0];
$fp = fopen( "temp.dat", "w" );
if ( $fp )
{
}
else
{
		exit( "创建临时文件失败" );
}
fwrite( $fp, $s );
fclose( $fp );
$db = new mysqlone( );
$db->connect( $localhost, $dbuser, $dbpass, $dbname );
$count = 0;
$rr = 0;
$fp = fopen( "temp.dat", "r" );
if ( $fp )
{
		while ( !feof( $fp ) )
		{
				$tem = fgets( $fp );
				if ( eregi( "\\.(com|net|org),", $tem ) )
				{
						$tem = str_replace( ",AUC", "", $tem );
						$arr = explode( ",", $tem );
						$name = $arr[0];
						$namearr = explode( ".", $name );
						$sub = $namearr[0];
						$top = $namearr[1];
						$dtime = $arr[1];
						$darr = explode( "/", $dtime );
						$mot = $darr[0];
						$day = $darr[1];
						$years = trim( $darr[2] );
						$t = "{$years}-{$mot}-{$day}";
						$y = date( "Y-m-d", strtotime( "{$t}+1 day" ) );
						$sql = "INSERT INTO list VALUES (NULL , '".$sub."','{$top}', '{$y}')";
						$db->query( $sql );
						++$count;
						++$rr;
				}
		}
		fclose( $fp );
		@unlink( "temp.dat" );
		@unlink( "temp.zip" );
		$fp = fopen( "timetoup.dat", "w" );
		if ( $fp )
		{
		}
		else
		{
				exit( "数据录入成功，但无法保存下次更新时间，请检查timetoup.dat文件是否可写，并用记事本打开，写入 ".$timenow."<br>{$rr}" );
		}
		fwrite( $fp, "{$now}\n{$rr}" );
		fclose( $fp );
		echo "数据录入成功！\t共计录入 ".$count." 条，2秒钟后将自动跳转会首页<meta   http-equiv=\"refresh\"   content=\"2\";url=\"index.php\"";
}
exit( "读取临时文件失败！" );
?>
