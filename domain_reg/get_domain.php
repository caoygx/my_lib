<?php
$chr = array('a','b','c','d','e','g','i','j','k','o','p','q','r','t','u','v','y','z');
$str = file_get_contents('domain.txt');
//PHP_EOL
$arr = explode(PHP_EOL,$str);
foreach($arr as $k => $v){
	if(in_array($v[0],$chr) && in_array($v[2],$chr) && in_array($v[3],$chr)){
		echo $k,'---',$v,'<br />';
	}
}
/*
$str = "abc";
echo $str[0];*/
?>