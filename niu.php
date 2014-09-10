<?php 
/*$start = 0; //起始数,即根节点
$last = 0; //上一层的第一个切点
$sum = 0; //总数
//1层
$last +=4;
if($last <= 12){
	$sum ++;
	$start_line = $last;
	$i = $start_line; //4
	while($i++ <= 12){
		$sum++;
	}
}

//2层，4的子孙个数
$last += 4; //8

if($last <= 12){ //8
	$sum++;
	$start_line = $last;
	
	while($start_line++ < 12){ //8
		$i = $start_line; 
		while($i++ <= 12){
			$sum++;
		}	
	}
}
//2层,5的子孙个数
$start_line = $last;
while($start_line++ < 12){ //5
	//$i = $start; //5
	$start = $start_line;
	$start+=4; //9
	$i = $start; //9
	while($i++ <=12 ){
		$sum++;
	}
	
}

//3层
$last +=4;


*/
$a = $b = $c = 0;
/*$a = $a +4;
$c = $b = $a ;
while($b <= 12){
	$b++;
	$sum ++;
}*/

define('N',12);
//返回到c
while($c <= N){
	
	if($c){
		
		$a = $c;
		$c++;
		
		$a = $a +4;
		$b = $a;
	}else{
		
		$a = $a +4;
		$c = $b = $a;
	}
	
	
	while($b <= N){
		
		echo $b."<br />";
		//echo "c = $c <br />";
		$sum++;
		
		$b++;
		
	}
	echo "<hr />";
	
	/*$c++; //5
	if($c <=12){
		$a = $c;
		$a = $a + 4; //9
		$c = $b = $a;
		while($b <= 12){
			$b++;
			$sum++;
		}
		
		
	}*/
}
$sum++; //算上初始0

echo $sum;


?>