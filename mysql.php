<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
//mysqli_report(MYSQLI_REPORT_ALL);
   // $mysql=new mysqli("localhost","root","","test");
    $sql="update test set value='asdasda' where id=1";
    //$mysql->query($sql);

    $conn=mysql_connect("192.168.45.131","root","123123");
    mysql_select_db("test",$conn);
    mysql_query($sql);
