<?php
ini_set('display_errors', 'on');
error_reporting(E_ALL);

//define('APP_PATH','/usr/local/webserver/application');
//define('KER_PATH','/usr/local/webserver/kernel-1.1.2');
define('APP_PATH','H:/cao/tp/protected/Other/Lib');

include 'debug.php';
//require(APP_PATH.'/core/runtime.php');


$config=array(
    'action'=>array(),
    'model'=>array(),
    'class'=>array(),
    'model'=>'',
    'config'=>''
);

if(!isset($_REQUEST['type'])) $_REQUEST['type']='ctrol';

if(!isset($_REQUEST['type'], $config)){
    $_REQUEST['type']='ctrol';
}



function get_file($dir, $cdir = false,$ext='*') 
{
	$ret = array();
	$arr_ext=is_array($ext)?$ext:explode(',',$ext);
	$dir=realpath($dir);
	if (!is_dir($dir)) return $ret;
	    $dir =str_replace('\\','/',$dir);
	if ($handle = opendir($dir)) {
	    while (false !== ($file = readdir($handle))) {
		if ($file == '.' || $file == '..') continue;
		    $curr_file =$dir.'/'.$file;
		if (is_file($curr_file)) {
			$my_ext=end(explode('.',$curr_file));
			if($ext=='*'||in_array($my_ext, $arr_ext)) $ret[] = $curr_file;
		} 
		elseif (is_dir($curr_file)&&$cdir){
			$ret = array_merge($ret, get_file($curr_file, $cdir,$ext));
		}
	    }
	    closedir($handle);
	}
	return $ret;
}
?>
