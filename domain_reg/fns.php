<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class mysqlone
{

		public function connect( $_obfuscate_4iCTDqGr, $_obfuscate_, $_obfuscate_O7X9lw��, $_obfuscate_KLbKkj9 = "", $_obfuscate_b9RtudWbBleW = "gbk" )
		{
				if ( !@mysql_connect( $_obfuscate_4iCTDqGr, $_obfuscate_, $_obfuscate_O7X9lw�� ) )
				{
						$this->show( "Can not connect to MySQL server" );
				}
				if ( $_obfuscate_KLbKkj9 )
				{
						$this->select_db( $_obfuscate_KLbKkj9 );
				}
				if ( "4.1" < $this->version( ) && $_obfuscate_b9RtudWbBleW )
				{
						$this->query( "SET NAMES '".$_obfuscate_b9RtudWbBleW."'" );
				}
		}

		public function select_db( $_obfuscate_KLbKkj9 )
		{
				return mysql_select_db( $_obfuscate_KLbKkj9 );
		}

		public function fetch_array( $_obfuscate_ammigv8�, $_obfuscate_6o8QMSJ_aw0OGxE� = MYSQL_ASSOC )
		{
				return mysql_fetch_array( $_obfuscate_ammigv8�, $_obfuscate_6o8QMSJ_aw0OGxE� );
		}

		public function query( $_obfuscate_3y0Y, $_obfuscate_LeS8hw�� = "" )
		{
				if ( !( $_obfuscate_ammigv8� = mysql_query( $_obfuscate_3y0Y ) ) )
				{
						$this->show( "MySQL Query Error", $_obfuscate_3y0Y );
				}
				return $_obfuscate_ammigv8�;
		}

		public function affected_rows( )
		{
				return mysql_affected_rows( );
		}

		public function result( $_obfuscate_ammigv8�, $_obfuscate_gkt )
		{
				return mysql_result( $_obfuscate_ammigv8�, $_obfuscate_gkt );
		}

		public function num_rows( $_obfuscate_ammigv8� )
		{
				return mysql_num_rows( $_obfuscate_ammigv8� );
		}

		public function num_fields( $_obfuscate_ammigv8� )
		{
				return mysql_num_fields( $_obfuscate_ammigv8� );
		}

		public function free_result( $_obfuscate_ammigv8� )
		{
				return mysql_free_result( $_obfuscate_ammigv8� );
		}

		public function insert_id( )
		{
				return mysql_insert_id( );
		}

		public function fetch_row( $_obfuscate_ammigv8� )
		{
				return mysql_fetch_row( $_obfuscate_ammigv8� );
		}

		public function version( )
		{
				return mysql_get_server_info( );
		}

		public function close( )
		{
				return mysql_close( );
		}

		public function show( $_obfuscate_FYJCcRzosA�� = "", $_obfuscate_3y0Y = "" )
		{
				if ( !$_obfuscate_3y0Y )
				{
						echo $_obfuscate_FYJCcRzosA��;
				}
				else
				{
						echo $_obfuscate_FYJCcRzosA��."<br>".$_obfuscate_3y0Y;
				}
		}

}

function PutCookie( $_obfuscate_Vwty, $_obfuscate_VgKtFeg� )
{
		$_obfuscate_FEqIk_y = 360000;
		$_obfuscate_lUg� = "/";
		setcookie( $_obfuscate_Vwty, $_obfuscate_VgKtFeg�, time( ) + $_obfuscate_FEqIk_y, $_obfuscate_lUg� );
}

function DropCookie( $_obfuscate_Vwty )
{
		setcookie( $_obfuscate_Vwty, "", time( ) - 360000, "/" );
}

function GetCookie( $_obfuscate_Vwty )
{
		return $_COOKIE[$_obfuscate_Vwty];
}

function readtf( $_obfuscate_6Q�� )
{
		$_obfuscate_YBY� = fopen( $_obfuscate_6Q��, "rb" );
		if ( $_obfuscate_YBY� )
		{
				$_obfuscate_SeV31Q�� = fread( $_obfuscate_YBY�, filesize( $_obfuscate_6Q�� ) );
				fclose( $_obfuscate_YBY� );
				return $_obfuscate_SeV31Q��;
		}
		$_obfuscate_SeV31Q�� = "��ȡ�ļ����ɹ���";
		return $_obfuscate_SeV31Q��;
}

function page( $_obfuscate_iXkXVbqqrFHM, $_obfuscate_tvkTpt_cd5NGizQ�, $_obfuscate_Il8i, $_obfuscate_fhnN5p9Q�� = 5 )
{
		$_obfuscate_j9sJes� = $_obfuscate_iXkXVbqqrFHM - 1;
		$_obfuscate_iXkXVbqqrFHM = intval( $_obfuscate_iXkXVbqqrFHM );
		$_obfuscate_YIk� = "<td><font color=#85AC1E size=1>��".$_obfuscate_iXkXVbqqrFHM."ҳ:</font></td>\n";
		$_obfuscate_YIk� .= 0 < $_obfuscate_tvkTpt_cd5NGizQ� ? "<td><a href=\"".$_obfuscate_Il8i."=0\">��ҳ</a></td>\n<td><a href=\"{$_obfuscate_Il8i}=".( $_obfuscate_tvkTpt_cd5NGizQ� - 1 )."\">��һҳ</a></td>\n" : "<td>��ҳ</td>\n<td>��һҳ</td>\n";
		$_obfuscate_7w�� = $_obfuscate_tvkTpt_cd5NGizQ� - $_obfuscate_fhnN5p9Q��;
		if ( !( 0 < $_obfuscate_7w�� ) )
		{
				$_obfuscate_7w�� = 0;
		}
		$_obfuscate_XA�� = $_obfuscate_tvkTpt_cd5NGizQ� + $_obfuscate_fhnN5p9Q��;
		if ( !( $_obfuscate_XA�� < $_obfuscate_iXkXVbqqrFHM ) )
		{
				$_obfuscate_XA�� = $_obfuscate_iXkXVbqqrFHM;
		}
		for ( ;	$_obfuscate_7w�� < $_obfuscate_XA��;	++$_obfuscate_7w��	)
		{
				$_obfuscate_YIk� .= $_obfuscate_7w�� == $_obfuscate_tvkTpt_cd5NGizQ� ? "<td><b class=currentPage>[".( $_obfuscate_7w�� + 1 )."]</b></td>\n" : "<td><a href=\"".$_obfuscate_Il8i."={$_obfuscate_7w��}\">".( $_obfuscate_7w�� + 1 )."</a></td>\n";
		}
		$_obfuscate_YIk� .= $_obfuscate_tvkTpt_cd5NGizQ� < $_obfuscate_j9sJes� ? "<td><a href=\"".$_obfuscate_Il8i."=".( $_obfuscate_tvkTpt_cd5NGizQ� + 1 ).( "\">��һҳ</a></td>\n<td><a href=\"".$_obfuscate_Il8i."=" ).$_obfuscate_j9sJes�."\">βҳ</a>\n</td>" : "<td>��һҳ</td>\n<td>βҳ</td>\n";
		$_obfuscate_YIk� = "<table style=text-align:center><tr>".$_obfuscate_YIk�."</tr></table>";
		return $_obfuscate_YIk�;
}

?>
