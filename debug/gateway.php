<?php

require('inc.php');
error_reporting(E_ALL);
ob_start();
//require config files
/*require(APP_PATH.'/config/config.php');
require(APP_PATH.'/config/veconn.php');
require(APP_PATH.'/config/dbconn.php');
require(APP_PATH.'/config/ccconn.php');
//require(APP_PATH.'/config/ssconn.php');
require(APP_PATH.'/config/nsconn.php');

//require kernel file
require(KER_PATH.'/ver-1.1.2.php');
$ker=Kernel::instance();
$ker->init();*/

//$ker->run();
ob_end_flush();

$mathod=array('get_method','get_param','get_result');
$c=get_data('c');
if(!in_array($c, $mathod)){
    die('参数错误');
}

$c();

function get_method(){
    $arg=get_data('arg');
    $arg=  explode('/', $arg);
    if($arg[0]=='config'){
	$ret=array();
    }
    else{
	$path=APP_PATH."/{$arg[0]}/{$arg[1]}.class.php";
	$code=  file_get_contents($path);
	if(!$code)	continue;
	$ret=debug::get_method($code);
    }
    if(is_array($ret)) echo json_encode($ret);
    die();
}

function get_param(){
    $arg=get_data('arg');
    $arg=  explode('/', $arg);
    if($arg[0]=='config'){
	$ret=array();
    }
    else{
	$path=APP_PATH."/{$arg[0]}/{$arg[1]}.class.php";
	$code=  file_get_contents($path);
	if(!$code)	continue;
	$ret=debug::get_param($code,$arg[2]);
    }
    if(is_array($ret)) echo json_encode($ret);
    die();
}


function get_result(){
    $arg=get_data('arg');
    $k=get_data('k');
    $v=get_data('v');

    if(empty($v)){
	$v=array();
    }
    if(empty($k)){
	$k=array();
    }
    foreach ($k as $key => $val) {
	if(!isset($v[$key])) $v[$key]='';
	//Kernel::setRequest($val,$v[$key]);   
    }

    if($arg[0]=='config'){
	$ret=config($arg[1]);
    }
    else{
		echo $arg[0];
	//$ret=call($arg[0],"{$arg[1]}/{$arg[2]}",$v);
    }
    if(!is_array($ret)){
	//var_dump($ret);
	if($ret===false){
	    echo "\r\n<br/>=============================<br/>\r\n";
	    print_r(Message::output());
	}
	return true;
    }
    if($arg['3']=='json'){
	echo json_encode($ret);
    }
    else{
	//var_export($ret);
	print_r($ret);
    }
    return true;
    
}

function get_data($var){
	return $_REQUEST[$var];
}
		
?>
