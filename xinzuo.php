<?php
$file = "xinzuo.html";
$content = file_get_contents($file);
$content=str_replace(PHP_EOL,"",$content);

/*$fp = fopen('xinzuo.html', 'r');
while (false !== ($char = fgetc($fp))) {
    echo "$char";
}
*/
$reg = "/\d{1,2}\.\d{1,2}(.*?)<h2>/is";
preg_match_all($reg,$content,$out);
var_dump($out);

// 如果文件不可读取或者不存在，fopen 函数返回 FALSE
/*$file = @fopen('xinzuo.html', "r");
// 来自 fopen 的 FALSE 会发出一条警告信息并在这里陷入无限循环
while (!feof($file)) {
	$c = fgetc($fp);
  // ... do something with $c
  echo ftell($fp);
}
fclose($file);*/

?>