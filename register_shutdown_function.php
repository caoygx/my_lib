<?php
$clean = false;
function shutdown_func(){
    global $clean;
    if (!$clean){
        die("not a clean shutdown");
    }
    return false;
}
register_shutdown_function("shutdown_func");
$a = 1;
//����Ϊ���������ʧ��
$a = new FooClass();
$clean = true;
?>