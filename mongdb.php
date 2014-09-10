<?php
//phpinfo();exit;
error_reporting(7);
$conn = new Mongo();$db = $conn->PHPDataBase;$collection = $db->PHPCollection;

for($i = 0;$i <= 50;$i++) {    $data = array("name" => "xixi".$i,"email" => "673048143_".$i."@qq.com","age" => $i*1+20);    $collection->insert($data);}


$res = $collection->find(array("age" => array('$gt' => 25,'$lt' => 40)),array("name" => true));foreach($res as $v) {    print_r($v);}

?>