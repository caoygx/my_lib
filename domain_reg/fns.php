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

		public function connect( $_obfuscate_4iCTDqGr, $_obfuscate_, $_obfuscate_O7X9lwÿÿ, $_obfuscate_KLbKkj9 = "", $_obfuscate_b9RtudWbBleW = "gbk" )
		{
				if ( !@mysql_connect( $_obfuscate_4iCTDqGr, $_obfuscate_, $_obfuscate_O7X9lwÿÿ ) )
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

		public function fetch_array( $_obfuscate_ammigv8ÿ, $_obfuscate_6o8QMSJ_aw0OGxEÿ = MYSQL_ASSOC )
		{
				return mysql_fetch_array( $_obfuscate_ammigv8ÿ, $_obfuscate_6o8QMSJ_aw0OGxEÿ );
		}

		public function query( $_obfuscate_3y0Y, $_obfuscate_LeS8hwÿÿ = "" )
		{
				if ( !( $_obfuscate_ammigv8ÿ = mysql_query( $_obfuscate_3y0Y ) ) )
				{
						$this->show( "MySQL Query Error", $_obfuscate_3y0Y );
				}
				return $_obfuscate_ammigv8ÿ;
		}

		public function affected_rows( )
		{
				return mysql_affected_rows( );
		}

		public function result( $_obfuscate_ammigv8ÿ, $_obfuscate_gkt )
		{
				return mysql_result( $_obfuscate_ammigv8ÿ, $_obfuscate_gkt );
		}

		public function num_rows( $_obfuscate_ammigv8ÿ )
		{
				return mysql_num_rows( $_obfuscate_ammigv8ÿ );
		}

		public function num_fields( $_obfuscate_ammigv8ÿ )
		{
				return mysql_num_fields( $_obfuscate_ammigv8ÿ );
		}

		public function free_result( $_obfuscate_ammigv8ÿ )
		{
				return mysql_free_result( $_obfuscate_ammigv8ÿ );
		}

		public function insert_id( )
		{
				return mysql_insert_id( );
		}

		public function fetch_row( $_obfuscate_ammigv8ÿ )
		{
				return mysql_fetch_row( $_obfuscate_ammigv8ÿ );
		}

		public function version( )
		{
				return mysql_get_server_info( );
		}

		public function close( )
		{
				return mysql_close( );
		}

		public function show( $_obfuscate_FYJCcRzosAÿÿ = "", $_obfuscate_3y0Y = "" )
		{
				if ( !$_obfuscate_3y0Y )
				{
						echo $_obfuscate_FYJCcRzosAÿÿ;
				}
				else
				{
						echo $_obfuscate_FYJCcRzosAÿÿ."<br>".$_obfuscate_3y0Y;
				}
		}

}

function PutCookie( $_obfuscate_Vwty, $_obfuscate_VgKtFegÿ )
{
		$_obfuscate_FEqIk_y = 360000;
		$_obfuscate_lUgÿ = "/";
		setcookie( $_obfuscate_Vwty, $_obfuscate_VgKtFegÿ, time( ) + $_obfuscate_FEqIk_y, $_obfuscate_lUgÿ );
}

function DropCookie( $_obfuscate_Vwty )
{
		setcookie( $_obfuscate_Vwty, "", time( ) - 360000, "/" );
}

function GetCookie( $_obfuscate_Vwty )
{
		return $_COOKIE[$_obfuscate_Vwty];
}

function readtf( $_obfuscate_6Qÿÿ )
{
		$_obfuscate_YBYÿ = fopen( $_obfuscate_6Qÿÿ, "rb" );
		if ( $_obfuscate_YBYÿ )
		{
				$_obfuscate_SeV31Qÿÿ = fread( $_obfuscate_YBYÿ, filesize( $_obfuscate_6Qÿÿ ) );
				fclose( $_obfuscate_YBYÿ );
				return $_obfuscate_SeV31Qÿÿ;
		}
		$_obfuscate_SeV31Qÿÿ = "¶ÁÈ¡ÎÄ¼þ²»³É¹¦£¡";
		return $_obfuscate_SeV31Qÿÿ;
}

function page( $_obfuscate_iXkXVbqqrFHM, $_obfuscate_tvkTpt_cd5NGizQÿ, $_obfuscate_Il8i, $_obfuscate_fhnN5p9Qÿÿ = 5 )
{
		$_obfuscate_j9sJesÿ = $_obfuscate_iXkXVbqqrFHM - 1;
		$_obfuscate_iXkXVbqqrFHM = intval( $_obfuscate_iXkXVbqqrFHM );
		$_obfuscate_YIkÿ = "<td><font color=#85AC1E size=1>¹²".$_obfuscate_iXkXVbqqrFHM."Ò³:</font></td>\n";
		$_obfuscate_YIkÿ .= 0 < $_obfuscate_tvkTpt_cd5NGizQÿ ? "<td><a href=\"".$_obfuscate_Il8i."=0\">Ê×Ò³</a></td>\n<td><a href=\"{$_obfuscate_Il8i}=".( $_obfuscate_tvkTpt_cd5NGizQÿ - 1 )."\">ÉÏÒ»Ò³</a></td>\n" : "<td>Ê×Ò³</td>\n<td>ÉÏÒ»Ò³</td>\n";
		$_obfuscate_7wÿÿ = $_obfuscate_tvkTpt_cd5NGizQÿ - $_obfuscate_fhnN5p9Qÿÿ;
		if ( !( 0 < $_obfuscate_7wÿÿ ) )
		{
				$_obfuscate_7wÿÿ = 0;
		}
		$_obfuscate_XAÿÿ = $_obfuscate_tvkTpt_cd5NGizQÿ + $_obfuscate_fhnN5p9Qÿÿ;
		if ( !( $_obfuscate_XAÿÿ < $_obfuscate_iXkXVbqqrFHM ) )
		{
				$_obfuscate_XAÿÿ = $_obfuscate_iXkXVbqqrFHM;
		}
		for ( ;	$_obfuscate_7wÿÿ < $_obfuscate_XAÿÿ;	++$_obfuscate_7wÿÿ	)
		{
				$_obfuscate_YIkÿ .= $_obfuscate_7wÿÿ == $_obfuscate_tvkTpt_cd5NGizQÿ ? "<td><b class=currentPage>[".( $_obfuscate_7wÿÿ + 1 )."]</b></td>\n" : "<td><a href=\"".$_obfuscate_Il8i."={$_obfuscate_7wÿÿ}\">".( $_obfuscate_7wÿÿ + 1 )."</a></td>\n";
		}
		$_obfuscate_YIkÿ .= $_obfuscate_tvkTpt_cd5NGizQÿ < $_obfuscate_j9sJesÿ ? "<td><a href=\"".$_obfuscate_Il8i."=".( $_obfuscate_tvkTpt_cd5NGizQÿ + 1 ).( "\">ÏÂÒ»Ò³</a></td>\n<td><a href=\"".$_obfuscate_Il8i."=" ).$_obfuscate_j9sJesÿ."\">Î²Ò³</a>\n</td>" : "<td>ÏÂÒ»Ò³</td>\n<td>Î²Ò³</td>\n";
		$_obfuscate_YIkÿ = "<table style=text-align:center><tr>".$_obfuscate_YIkÿ."</tr></table>";
		return $_obfuscate_YIkÿ;
}

?>
