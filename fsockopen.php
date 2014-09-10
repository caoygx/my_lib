<?php
ini_set("display_errors", "On");
error_reporting(E_ALL);
$result = fsockopen("216.218.206.141", "10051");
	var_dump($result);
	//var_dump($ZBX_SERVER_PORT);
	