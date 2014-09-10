<?php

$b = 1 AND 0;
var_dump($b);

$c = ( ($b = 1) and 0 );
var_dump($c);
?>