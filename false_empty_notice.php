<?php
/**/
$r = '';
echo $r['name']; //有Warning,notice

$r = false;
echo $r['name']; //没有

$r = 0;
echo $r['name']; //没有

$r = array();
echo $r['name']; //有notice

?>