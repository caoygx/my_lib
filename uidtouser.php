<?php 
function sql_connect(){
	//if(defined('ONLINE')){}
	//mysql_pconnect("10.240.133.59", "root", "2144testmysql") or die("Could not connect: " . mysql_error());
	mysql_pconnect("10.10.16.10", "uc_2144_dbuser", "f82bo96h6") or die("Could not connect: " . mysql_error());
    mysql_select_db("my_2144_cn");
	
	/*mysql_connect("10.10.16.12", "actuser", "63D694LPAd") or die("Could not connect: " . mysql_error());
    mysql_select_db("act_2144_cn");*/
	
	mysql_query("set names utf8");
	
	
}

//查询
function sql_query($sql){
	sql_connect();
	$result = mysql_query($sql) or die('sql error'.$sql);
	mysql_close();
	return $result;
}

//读取数据
function sql_fetch($sql){
	sql_connect(); 
	$result = mysql_query($sql);
	$data = array();
    while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$data[] = $row;
    }
    mysql_free_result($result);
	mysql_close();
	return $data;
}


$sql = "select f_id,f_uid from t_comment_c ";
//echo $sql;
$r = sql_fetch($sql);
//var_dump($r);exit;
foreach($r as $k => $v){
	$sql = "select username from uchome_member where uid = {$v['f_uid']}";
	echo $sql;
	$rs = sql_fetch($sql);
	if($rs[0]){
		$sql = "update t_comment_c set f_username='{$rs[0]['username']}' where f_id = {$v['f_id']}";
		if(sql_query($sql)){
			
		}else{
			echo $sql."<br />";
		}
	}
}



?>