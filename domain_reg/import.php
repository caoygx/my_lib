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
		//exit( "请安装授权文件！打开config.php将授权序列号填入\$cfglic处,<br>如果您尚未申请授权，请登录www.youdodo.cn/get.php获取授权文件，注意该授权是免费的，只是为方便我们统计！" );
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
		echo "\t<form action='' method=get>\r\n\t录入成功<br>\r\n\t请输入sql文本的全名:\r\n\t<input type=text name='q' >\r\n\t<INPUT TYPE=submit>\r\n\t<form>\t";
}
else
{
		echo "\t<form action='' method=get>\r\n\t请输入sql文本的全名:\r\n\t<input type=text name='q' >\r\n\t<INPUT TYPE=submit>\r\n\t<form>\t\r\n\t";
}
?>
