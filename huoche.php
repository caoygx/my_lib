<?php

$station = array('BJP','SHH','GZQ','CDW','XAY','HFH');
$station = array('BJP','SHH');
$tos = $froms = $station;
$path = array();
$str = '';
$date = "2014-09-30";
$train = array();
foreach($froms as $from){
    foreach($tos as $to){
        if($from == $to) continue;
//        $urlList = "https://kyfw.12306.cn/otn/leftTicket/queryT?leftTicketDTO.train_date=$date&leftTicketDTO.from_station=$from&leftTicketDTO.to_station=$to&purpose_codes=ADULT";
        $urlList = "https://kyfw.12306.cn/otn/lcxxcx/query?purpose_codes=ADULT&queryDate=$date&from_station=$from&to_station=$to";
        $c = file_get_contents("https://kyfw.12306.cn/otn/lcxxcx/query?purpose_codes=ADULT&queryDate=2014-09-30&from_station=BJP&to_station=SHH");
        var_dump($c);
        $c = json_decode($c,1);
        var_dump($c);exit;
        $list = $c['data'];//所有车次
        foreach($list as $v){
            $train_no = $v['train_no'];
            $train[$train_no] = $v;
            $urlDetails = "https://kyfw.12306.cn/otn/czxx/queryByTrainNo?train_no=$train_no&from_station_telecode=$from&to_station_telecode=$to&depart_date=$date";
            $c = file_get_contents($urlDetails);
            $c = json_decode($c,1);
            $allStation = $c['data'];//所有车站
            foreach($allStation as $sta){
                $train[$train_no]['station'] = $sta['station_name'];
            }
        }
    }
    var_dump($train);
}

