<?php
$st = gettimeofday(1);
for($i = 0; $i < 100000000; $i++)
{

}
echo gettimeofday(1) - $st,PHP_EOL;
