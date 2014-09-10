<form id="form1" name="form1" method="post" action="?">
  <label for="func_name">º¯ÊýÃû</label>
  <input type="text" name="func_name" id="func_name" />
  <input type="submit" name="button" id="button" value="²éÕÒ" />
</form>
<?php 
if ($_GET['func_name']) {
	$arr = include ('func.php');
	echo $_GET['func_name'],':',$arr[$_GET['func_name']];
}
?>

<?php
set_time_limit(0);
//$file = 'E:\web\php-5.3.28\ext\standard\type.c';

global $arr_func;
$arr_func = array();
myscandir('E:/web/php-5.3.28');
 

function match_contents($file){
	global $arr_func;
	$c = file_get_contents($file);

	$reg = "/PHP_FUNCTION\((.*?)\)/";
	preg_match_all($reg, $c, $o);
	//return $o;
	foreach($o[1] as $k => $v){
		//echo $v,'<br />';
		$arr_func[$v] = $file;
	}
	//echo '<hr />';
	

}
//var_dump($arr_func);
$data = var_export($arr_func, true);
file_put_contents("func.php", "<?php $data; ?>");
//PHP_FUNCTION(is_numeric)





function myscandir($pathname){
//echo $pathname,'<br />';
	foreach( glob($pathname.'/*') as $filename ){

		if(is_dir($filename)){
			
			myscandir($filename);
		}else{
			$info = pathinfo($filename);
			if($info['extension'] == 'c'){
				//echo $filename.'<hr/>';
				match_contents($filename);
			}
			
		}
	}
}

   



?>

