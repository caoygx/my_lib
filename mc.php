<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
$memcache_obj = memcache_connect('192.168.22.150', 11211);

/*
 * 设置'var_key'对应存储的值
 * flag参数使用0,值没有经过压缩
 * 失效时间为30秒
 * */
memcache_set($memcache_obj, 'var_key', 'some variable', 0, 30);

echo memcache_get($memcache_obj, 'var_key');

?>

