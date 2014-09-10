<?php  
/*$argv;
$argc;
*/
for($i = 1; $i< $argc; $i++){
	echo date('y-m-d h:i:s',$argv[$i]);
	echo "\r\n";
}

?> 