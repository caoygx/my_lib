<?php
set_time_limit(0);
$char = array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');//
$len = count($char);
for($i= 0; $i < $len; $i++){
	$a = $char[$i]; //$a$a
	$domains[] = $char[$i].$char[$i+1].$char[$i+2].$char[$i+3];

}
/*var_dump($arr);exit;
$content = var_export($arr,true);
file_put_contents('./arr2.php',$content);
exit;*/
//$domains = include('H:/web/test/domain_reg/arr2.php');
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
		file_put_contents("H:/web/test/domain_reg/domain3.txt", "$v\r\n", FILE_APPEND);
	}
	
	sleep(0.1); 

}

 

?>