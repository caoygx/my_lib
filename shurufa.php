<?php 
$txt = file_get_contents("./a.txt");
$arr = explode("\r\n",$txt);

$str = '';
foreach($arr as $k => $v){
	$reg = "/(\w+) (.+)/";
	preg_match_all($reg,$v,$o);
	$a = explode(' ',$o[2][0]);
	foreach($a as $k => $v){
		$str .= $v.$o[1][0]."\r\n";
	}
	//var_dump($a);
}
file_put_contents('b.txt',$str);
//echo $str;
 ?>
 
