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
		exit( "������ʱ�ļ�ʧ��" );
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
										exit( "�޷������ļ�" );
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
		echo "�������ݳɹ������listǰ׺��sql�ļ�������վ��Ŀ¼�£�����import.php�ļ��������ݣ�";
		$now = date( "Y-m-d" );
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
		echo "<br>����ͬ��Ŀ¼�µ�timetoup.datҲһ���ϴ����ǡ�<br>�����������Щ֮������һ��Ҫɾ����.sql�ļ���";
}
exit( "��ȡ��ʱ�ļ�ʧ�ܣ�" );
?>
