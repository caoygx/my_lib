<?php
/**
 * 分布式缓存部署方案
 * 当有1台cache服务器不能满足我们的需求，我们需要布置多台来做分布式服务器，但是
 * 有个问题，怎么确定一个数据应该保存到哪台服务器上呢？
 * 有两种方案，第一种普通hash分布，第二种一致性哈希分布
 * 
 * 普通hash分布
 * 首先将key处理为一个32位字符串，取前8位，在经过hash计算处理成整数并返回，然后映射到其中一台服务器
 * $servers[mHash2($key) % 2] 这样得到其中一台服务器的配置，利用这个配置完成分布式部署
 * 在服务器数量不发生变化的情况下，普通hash分布可以很好的运作，当服务器的数量发生变化，问题就来了
 * 试想，增加一台服务器，同一个key经过hash之后，与服务器取模的结果和没增加之前的结果肯定不一样，这就导致了，之前保存的数据丢失
 * 
 * 一致性哈希算法
 * 优点：在分布式的cache缓存中，其中一台宕机，迁移key效率最高
 * 将服务器列表进行排序，根据mHash2($key) 匹配相邻服务器
 */

/**
 * hash算法
 * @param string $key
 * @return int
 */
function mHash2($key)
{
    $md5 = substr(md5($key), 0, 8);
    $seed = 31;
    $hash = 0;
    
    for($i = 0; $i < 8; $i++){
        $hash = $hash * $seed + ord($md5{$i});
        $i++;
    }
	//var_dump($hash & 0x7FFFFFFF);
    return $hash & 0x7FFFFFFF;
}

class FlexiHash
{
    // 服务器列表
    private $serverList = array();
	// 服务器列表key数组
	 private $serverKeys = array();
    // 是否排序
    private $isSorted = false;
    
    /**
     * 添加服务器
     * @param string $server
     * @return boolean
     */
    function addServer($server)
    {
        $hash = mHash2($server);
        if (!isset($this->serverList[$hash])) {
            $this->serverList[$hash] = $server;
        }
        $this->isSorted = false;
        return true;
    }
    
    /**
     * 移除服务器
     * @param string $server
     * @return boolean
     */
    function removeServer($server) 
    {
        $hash = mHash2($server);
        if (isset($this->serverList[$hash])) {
            unset($this->serverList[$hash]);
        }
        $this->isSorted = false;
        return true;
    }
    
    /**
     * 根据$key逆时针查找相邻的服务器
     * @param string $key
     * @return string
     */
    function lookup($key)
    {
        $hash = mHash2($key);
        // 对服务器列表逆排序
        if (!$this->isSorted) {
            krsort($this->serverList, SORT_NUMERIC);
            $this->isSorted = true;
			  $this->serverKeys = array_keys($this->serverList);
        }
        // 查找相邻的数据
        foreach ($this->serverList as $pos => $server) {
            if ($hash >=  $pos) return $server;
        }
        // 找不到，返回最后一个
        return $this->serverList[$this->serverKeys[count($this->serverList) - 1]];
    }
}

$st = gettimeofday(1);
$hserver = new FlexiHash();
$hserver->addServer('192.168.1.1');
$hserver->addServer('192.168.1.2');
$hserver->addServer('192.168.1.3');
$hserver->addServer('192.168.1.4');
$hserver->addServer('192.168.1.5');
$hserver->addServer('192.168.1.6');

echo "<pre>";
for($i=0; $i < 10000; $i++) {
  $t = $hserver->lookup('key'.$i);
  $arr[] = $t;
}
print_r($arr);
echo gettimeofday(1) - $st;