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
		///exit( "�밲װ��Ȩ�ļ�����config.php����Ȩ���к�����\$cfglic��,<br>�������δ������Ȩ�����¼www.youdodo.cn/get.php��ȡ��Ȩ�ļ���ע�����Ȩ����ѵģ�ֻ��Ϊ��������ͳ�ƣ�" );
}
if ( UPDATA != "chenfengye" )
{
		echo "�벻Ҫ�Ƿ����б�ҳ�棬2���Ӻ��Զ���ת����ҳ<meta   http-equiv=\"refresh\"   content=\"2\";url=\"index.php\"";
		exit( );
}
$tarr = file( "timetoup.dat" );
$timeto = $tarr[0];
$records = $tarr[1];
$istime = date( "Y-m-d", strtotime( "{$timeto}+{$timetoup} day" ) );
$now = date( "Y-m-d" );
if ( $now < $istime )
{
		exit( "�ܾ����£����� ".$istime." ����£������������������������ļ�" );
}
$fp = fopen( "http://www.pool.com/Downloads/PoolDeletingDomainsList.zip", "r" );
$fo = fopen( "temp.zip", "w" );
if ( !$fp )
{
		exit( "��ʱ����Զ�̷������޷�����,���Ժ����г���!" );
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
		exit( "������ʱ�ļ�ʧ��" );
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
				exit( "����¼��ɹ������޷������´θ���ʱ�䣬����timetoup.dat�ļ��Ƿ��д�����ü��±��򿪣�д�� ".$timenow."<br>{$rr}" );
		}
		fwrite( $fp, "{$now}\n{$rr}" );
		fclose( $fp );
		echo "����¼��ɹ���\t����¼�� ".$count." ����2���Ӻ��Զ���ת����ҳ<meta   http-equiv=\"refresh\"   content=\"2\";url=\"index.php\"";
}
exit( "��ȡ��ʱ�ļ�ʧ�ܣ�" );
?>
