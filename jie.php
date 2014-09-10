<?php 
$n = 30; //人数
$m = 365;
$sum = 1;
for($i = $m; $i > $m-$n; $i--){
	$sum = $sum*$i;
}
//echo $sum;exit;
echo 1 - $sum/pow($m,$n);

function jie($n){
	if($n == 1)
		return $n;
	return jie($n-1)*$n;
}

//echo jie(6);
?>