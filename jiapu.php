<?php
/*$split = str_repeat('&nbsp;', 512);

$lpos = 512;
$rpos = 512;

$lpos = $split / 2;
$pos = 1024;
*/
$currentgap = 4096;
for($i = 1; $i <= 10; $i++){
	//echo pow(2,$i);
	$currentgap = $currentgap/2;
	for($j = 1; $j <= pow(2,$i-1); $j++){
		if($j == 1){
			$gap = $currentgap/2;
		}else{
			$gap = $currentgap;
		}
		//echo $gap;
		$split = str_repeat('&nbsp;', $gap-1);
		//$split = $gap;
		echo $split.($i-1);
	}
	echo  str_repeat('<br />',$i);
	
}
?>