<?php
function get_client_ip() {
	if (getenv ( "HTTP_CLIENT_IP" ) && strcasecmp ( getenv ( "HTTP_CLIENT_IP" ), "unknown" ))
		$ip = getenv ( "HTTP_CLIENT_IP" );
	else if (getenv ( "HTTP_X_FORWARDED_FOR" ) && strcasecmp ( getenv ( "HTTP_X_FORWARDED_FOR" ), "unknown" ))
		$ip = getenv ( "HTTP_X_FORWARDED_FOR" );
	else if (getenv ( "REMOTE_ADDR" ) && strcasecmp ( getenv ( "REMOTE_ADDR" ), "unknown" ))
		$ip = getenv ( "REMOTE_ADDR" );
	else if (isset ( $_SERVER ['REMOTE_ADDR'] ) && $_SERVER ['REMOTE_ADDR'] && strcasecmp ( $_SERVER ['REMOTE_ADDR'], "unknown" ))
		$ip = $_SERVER ['REMOTE_ADDR'];
	else
		$ip = "unknown";
	return ($ip);
}

/*本文用用到函数解释

ip2long 把ip地址转换为 整型数字有+,-

优化一下代码
可以限制单独IP与IP段

ip.txt (存放限制的IP及IP段)
58.14.0.0-58.25.255.255
127.0.0.1-127.0.0.1

前后IP相同表示只指定1个IP
*/
/*
 * 马克(sim_cn@qq.com)
 * www.simcn.com
 */
$meip = ip2long(get_client_ip());
$filename="../ip.txt";     	//定义操作文件 
$ip_lib=file($filename);  	//读取文件数据到数组中 

$n = count($ip_lib); //不在for循环中做函数会更快一点.
for($i=0;$i<$n;$i++){
	list($sip,$eip) = explode('-',$ip_lib[$i]);
	$sip = ip2long(trim($sip));
	$eip = ip2long(trim($eip));
	if($meip >= $sip && $meip <= $eip){
		//echo "你的IP被限制了,有问题请联系管理员";
		echo '
		<script>
		for(i = 0; i < 2; i++){
			alert("Are you  big SB");
			alert("Yes, I am a big SB");
		}
		</script>
		';
		
		exit("You are Big SB");
	}
}
?>