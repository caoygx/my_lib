<?php
$a = 'a';
$b = $a;
//echo $a,$b;
$b = "b";
//echo $a,$b;


class C {
    public $foo = 1;
}  

$c = new C();
$d = $c; 
echo $c->foo,$d->foo;

echo "<br />";

$d->foo = 2;
echo $c->foo,$d->foo;

?>