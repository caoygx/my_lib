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
require_once( "config.php" );
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
$list = "list.sql";
$count = 0;
$rr = 0;
$lc = 1;
$cont = "";
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
						$cont .= "INSERT INTO list VALUES (NULL,'".$sub."','{$top}','{$y}');\n";
						if ( 15000 < $count )
						{
								$count = 0;
								++$lc;
								$list = "list_".$lc.".sql";
								$ff = fopen( $list, w );
								if ( $ff )
								{
								}
								else
								{
										exit( "无法生成文件" );
								}
								fwrite( $ff, $cont );
								fclose( $ff );
								$cont = "";
						}
						++$rr;
						++$count;
				}
		}
		fclose( $fp );
		@unlink( "temp.zip" );
		@unlink( "temp.dat" );
		echo "生成数据成功！请把list前缀的sql文件传到网站根目录下，运行import.php文件导入数据！";
		$now = date( "Y-m-d" );
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
		echo "<br>请连同根目录下的timetoup.dat也一起上传覆盖。<br>当您完成了这些之后，请您一定要删除掉.sql文件！";
}
exit( "读取临时文件失败！" );
?>
