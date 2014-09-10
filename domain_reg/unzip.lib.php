<?php
/*********************/
/*                   */
/*  Version : 5.1.0  */
/*  Author  : RM     */
/*  Comment : 071223 */
/*                   */
/*********************/

class SimpleUnzip
{

		public $Comment = "";
		public $Entries = array( );
		public $Name = "";
		public $Size = 0;
		public $Time = 0;
		public $iFileName = NULL;

		public function SimpleUnzip( $in_FileName = "" )
		{
				if ( $in_FileName !== "" )
				{
						SimpleUnzip::readfile( $in_FileName );
				}
		}

		public function delzip( )
		{
				@unlink( $iFileName );
		}

		public function Count( )
		{
				return count( $this->Entries );
		}

		public function GetData( $in_Index )
		{
				return $this->Entries[$in_Index]->Data;
		}

		public function GetEntry( $in_Index )
		{
				return $this->Entries[$in_Index];
		}

		public function GetError( $in_Index )
		{
				return $this->Entries[$in_Index]->Error;
		}

		public function GetErrorMsg( $in_Index )
		{
				return $this->Entries[$in_Index]->ErrorMsg;
		}

		public function GetName( $in_Index )
		{
				return $this->Entries[$in_Index]->Name;
		}

		public function GetPath( $in_Index )
		{
				return $this->Entries[$in_Index]->Path;
		}

		public function GetTime( $in_Index )
		{
				return $this->Entries[$in_Index]->Time;
		}

		public function ReadFile( $in_FileName )
		{
				$this->Entries = array( );
				$this->Name = $in_FileName;
				$this->Time = filemtime( $in_FileName );
				$this->Size = filesize( $in_FileName );
				$oF = fopen( $in_FileName, "rb" );
				$vZ = fread( $oF, $this->Size );
				fclose( $oF );
				$aE = explode( "PK\x05\x06", $vZ );
				$aP = unpack( "x16/v1CL", $aE[1] );
				$this->Comment = substr( $aE[1], 18, $aP['CL'] );
				$this->Comment = strtr( $this->Comment, array( "\r\n" => "\n", "\r" => "\n" ) );
				$aE = explode( "PK\x01\x02", $vZ );
				$aE = explode( "PK\x03\x04", $aE[0] );
				array_shift( $aE );
				foreach ( $aE as $vZ )
				{
						$aI = array( );
						$aI['E'] = 0;
						$aI['EM'] = "";
						$aP = unpack( "v1VN/v1GPF/v1CM/v1FT/v1FD/V1CRC/V1CS/V1UCS/v1FNL", $vZ );
						$bE = $aP['GPF'] & 1 ? TRUE : FALSE;
						$nF = $aP['FNL'];
						if ( $aP['GPF'] & 8 )
						{
								$aP1 = unpack( "V1CRC/V1CS/V1UCS", substr( $vZ, -12 ) );
								$aP['CRC'] = $aP1['CRC'];
								$aP['CS'] = $aP1['CS'];
								$aP['UCS'] = $aP1['UCS'];
								$vZ = substr( $vZ, 0, -12 );
						}
						$aI['N'] = substr( $vZ, 26, $nF );
						if ( substr( $aI['N'], -1 ) == "/" )
						{
								continue;
						}
						$aI['P'] = dirname( $aI['N'] );
						$aI['P'] = $aI['P'] == "." ? "" : $aI['P'];
						$aI['N'] = basename( $aI['N'] );
						$vZ = substr( $vZ, 26 + $nF );
						if ( strlen( $vZ ) != $aP['CS'] )
						{
								$aI['E'] = 1;
								$aI['EM'] = "Compressed size is not equal with the value in header information.";
						}
						else if ( $bE )
						{
								$aI['E'] = 5;
								$aI['EM'] = "File is encrypted, which is not supported from this class.";
						}
						else
						{
								switch ( $aP['CM'] )
								{
								case 0 :
										break;
								case 8 :
										$vZ = gzinflate( $vZ );
										break;
								case 12 :
										if ( !extension_loaded( "bz2" ) )
										{
												if ( strtoupper( substr( PHP_OS, 0, 3 ) ) == "WIN" )
												{
														@dl( "php_bz2.dll" );
												}
												else
												{
														@dl( "bz2.so" );
												}
										}
										if ( extension_loaded( "bz2" ) )
										{
												$vZ = bzdecompress( $vZ );
										}
										else
										{
												$aI['E'] = 7;
												$aI['EM'] = "PHP BZIP2 extension not available.";
										}
										break;
								default :
										$aI['E'] = 6;
										$aI['EM'] = "De-/Compression method {$aP['CM']} is not supported.";
										break;
								}
								if ( !$aI['E'] )
								{
										if ( $vZ === FALSE )
										{
												$aI['E'] = 2;
												$aI['EM'] = "Decompression of data failed.";
										}
										else if ( strlen( $vZ ) != $aP['UCS'] )
										{
												$aI['E'] = 3;
												$aI['EM'] = "Uncompressed size is not equal with the value in header information.";
										}
										else if ( crc32( $vZ ) != $aP['CRC'] )
										{
												$aI['E'] = 4;
												$aI['EM'] = "CRC32 checksum is not equal with the value in header information.";
										}
								}
						}
						$aI['D'] = $vZ;
						$aI['T'] = mktime( ( $aP['FT'] & 63488 ) >> 11, ( $aP['FT'] & 2016 ) >> 5, ( $aP['FT'] & 31 ) << 1, ( $aP['FD'] & 480 ) >> 5, $aP['FD'] & 31, ( ( $aP['FD'] & 65024 ) >> 9 ) + 1980 );
						$this->Entries[] =new SimpleUnzipEntry( $aI );
				}
				return $this->Entries;
		}

}

class SimpleUnzipEntry
{

		public $Data = "";
		public $Error = 0;
		public $ErrorMsg = "";
		public $Name = "";
		public $Path = "";
		public $Time = 0;

		public function SimpleUnzipEntry( $in_Entry )
		{
				$this->Data = $in_Entry['D'];
				$this->Error = $in_Entry['E'];
				$this->ErrorMsg = $in_Entry['EM'];
				$this->Name = $in_Entry['N'];
				$this->Path = $in_Entry['P'];
				$this->Time = $in_Entry['T'];
		}

		public function __toString( )
		{
				return $this->Data;
		}

}

?>
