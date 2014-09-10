<?php
include_once('FirePHPCore/fb.php');
FB::log('Hello World !');// �����¼
FB::group('Test Group A'); // ��¼����// ����Ϊ���ղ�ͬ���������ͽ�����Ϣ��¼
FB::log('Plain Message');
FB::info('Info Message');
FB::warn('Warn Message');
FB::error('Error Message');

FB::log('Message','Optional Label');
FB::groupEnd();
FB::group('Test Group B');
FB::log('Hello World B');
FB::log('Plain Message');
FB::info('Info Message');
FB::warn('Warn Message');
FB::error('Error Message');

FB::log('Message','Optional Label');
FB::groupEnd();

// ����Ϣ��Ϊtable���
$table[] = array('Col 1 Heading','Col 2 Heading','Col 2 Heading');
$table[] = array('Row 1 Col 1','Row 1 Col 2','Row 1 Col 2');
$table[] = array('Row 2 Col 1','Row 2 Col 2');
$table[] = array('Row 3 Col 1','Row 3 Col 2');

FB::table('Table Label', $table);

// ���쳣������ʹ��FirePHP
class MyException extends Exception{
    public function  __construct($message, $code) {
        parent::__construct($message, $code);
    }
    public function log(){
        FB::log($this->getMessage());
    }
}

try{
    echo 'MoXie';
    throw new MyException('some description',1);
}catch(MyException $e){
    $e->log();
}

?>