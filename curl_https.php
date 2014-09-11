<?php
header("content-type:text/html;charset='utf-8'");
$url = 'https://kyfw.12306.cn/otn/leftTicket/queryT?leftTicketDTO.train_date=2014-09-30&leftTicketDTO.from_station=SHH&leftTicketDTO.to_station=BJP&purpose_codes=ADULT';
            $ch = curl_init();
            $timeout = 50;

$header = array(
                'Host: kyfw.12306.cn',
                'User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64; rv:31.0) Gecko/20100101 Firefox/31.0 FirePHP/0.7.4',
                'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Language: zh-cn,zh;q=0.8,en-us;q=0.5,en;q=0.3',
                'Accept-Encoding: gzip, deflate',
                'Referer: http://i.cn/test/12306.php',
                'Cookie: JSESSIONID=0A01D48260B369291544E3EB36F0FCF28B19C709C5; BIGipServerotn=2194931978.24610.0000',
                'x-insight: activate',
                'Connection: keep-alive',
                'Cache-Control: max-age=0',
            );
            
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
                 
            curl_setopt ($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HTTPHEADER,$header);
            curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            
            $c = curl_exec($ch);
            echo $c;exit;
            $c= json_decode($c,true);
            var_dump($c);
