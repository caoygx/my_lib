<?php
class basic {
    public function testA() {
        echo get_class($this);
    }
}

class sub extends basic {
    public function testB() {
        
    }
}
$b = new sub;
$b->testA();
?>