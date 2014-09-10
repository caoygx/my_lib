<?php
set_time_limit(0);
/*$char = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');//
$len = count($char);
for($i= 0; $i < $len; $i++){
	$a = $char[$i]; //$a$a
		
	for($j= 0; $j < $len; $j++){
		$b = $char[$j]; //$b$b
		for($k= 0; $k < $len; $k++){
			$c = $char[$k]; //$c
			$arr[] = $a.$a.$b.$c.$c;
		}

	}

}
//var_dump($arr);
$content = var_export($arr,true);
file_put_contents('./arr.php',$content);
exit;*/
$domains = include('H:/web/test/domain_reg/arr.php');
//$domains = array('a','b');
//var_dump($domains);exit;
//ob_implicit_flush(true);  
/*echo str_pad(" ", 256);  

for ($i=10; $i>0; $i--) {  
   echo $i, '<br />';  
   ob_flush(); 
	flush(); 
	sleep(1); 
  
}  

exit;
*/
foreach($domains as $k => $v){
	$url = "http://pandavip.www.net.cn/check/check_ac1.cgi?domain=$v.com";
	
	
	$r = file_get_contents($url);
	$r = str_replace('")','',str_replace('("','',$r));
	$r = explode('|',$r);
	if($r[2] == 210){
		//echo $v,'<br />';
		echo "$v\r\n";
		file_put_contents("H:/web/test/domain_reg/domain.txt", "$v\r\n", FILE_APPEND);
	}
	
	sleep(0.1); 

}

 

?>