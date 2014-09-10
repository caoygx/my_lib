<?php
$arr = array(1,5,-2,5,-3,-8,1);
$total_sum = array();
$elements = array();

for($i = 0; $i < count($arr); $i++){
	$sum = $arr[$i];
	$e = $arr[$i];
	for($j = $i+1; $j < count($arr); $j++){
		$total_sum[] = $sum;
		$elements[$sum] = $e;
		
		$sum += $arr[$j];
		$e.=",".$arr[$j];
	}
	$total_sum[] = $sum;
	$elements[$sum] = $e;
}
sort($total_sum);
/*$max = array_pop($total_sum);
echo "max = ",$max,"\r\n";
echo $elements[$max];
//var_dump($total_sum);
var_dump($elements);*/

test();
function test()
    {
        $arr = array(1,-1000,5,-2,5,-3,-8,1,90,);

        $max = $tmp = 0;
        foreach($arr as $v)
        {
             
            $tmp += $v;
            $max =  max($max, $tmp);
            
            //$max = max($max, $tmp);
			//$tmp=$max;
        }
		var_dump($max);
        if (!$max) $max = max($arr);
        echo $max;
    }

?>