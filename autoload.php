<?php


class Foo {
    public function test($name) {
        print '[['. $name .']]';
    }
}

spl_autoload_register(array('Foo',test));

new InexistentClass;

