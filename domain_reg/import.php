<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

set_time_limit( 0 );
require_once( "fns.php" );
require_once( "config.php" );
$code = $_SERVER['HTTP_HOST'];
$code = str_replace( "www.", "", $code );
$code .= "chenfengye";
$code = md5( $code );
if ( $code != $cfglic && $code != "952768cce9ba1da70e0bb1c4787cbeec" )
{
		//exit( "�밲װ��Ȩ�ļ�����config.php����Ȩ���к�����\$cfglic��,<br>�������δ������Ȩ�����¼www.youdodo.cn/get.php��ȡ��Ȩ�ļ���ע�����Ȩ����ѵģ�ֻ��Ϊ��������ͳ�ƣ�" );
}
if ( $_GET['q'] != "" )
{
		$st = $_GET['q'];
		$sq = file( $st );
		$db = new mysqlone( );
		$db->connect( $localhost, $dbuser, $dbpass, $dbname );
		foreach ( $sq as $i )
		{
				$query = $db->query( $i );
		}
		@unlink( $st );
		echo "\t<form action='' method=get>\r\n\t¼��ɹ�<br>\r\n\t������sql�ı���ȫ��:\r\n\t<input type=text name='q' >\r\n\t<INPUT TYPE=submit>\r\n\t<form>\t";
}
else
{
		echo "\t<form action='' method=get>\r\n\t������sql�ı���ȫ��:\r\n\t<input type=text name='q' >\r\n\t<INPUT TYPE=submit>\r\n\t<form>\t\r\n\t";
}
?>
