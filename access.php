<?php //读取mdb数据库例程
ob_start();
$conn = new com("ADODB.Connection");
$connstr = "DRIVER={Microsoft Access Driver (*.mdb)}; DBQ=". realpath("./SpiderResult.mdb");
$conn->Open($connstr);
$rs = new com("ADODB.RecordSet");
$rs->Open("select * from content",$conn,1,1);
echo '<style type="text/css">
p{ line-height:22px; }
</style>';
echo '<h1>PHP扩展开发及内核应用</h1>';
for($j=1; $j<= 107; $j++){
	echo '<a href="#index_'.$j.'">'.$j.'</a> &nbsp;&nbsp;';
}
$i = 1;
while(! $rs->eof) {
	echo '<div id="index_'.$i.'" style="border-bottom:2px solid #ccc; margin-top:10px;"></div>';
	echo $rs->Fields(3)->value;
	echo $rs->Fields(4)->value;
	$rs->MoveNext();
	$i++;
	//echo "<hr />";
}

$content = ob_get_contents();
ob_end_clean();
file_put_contents('./phpbook/phpbook.html',$content);
/*mysql_connect("10.240.130.87", "root", "2144testmysql") or die("Could not connect: " . mysql_error());
mysql_select_db("app_2144_cn");
$result = mysql_query("SELECT * FROM t_comment where f_image <>'' order by f_id desc limit 10");
*/
?>