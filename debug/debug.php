<?php
/**
 * @name debug PHP Debug Tool
 * @author huangwanchao
 */
class debug
{
   
    /**
     * @name get_vclass 获取类信息
     * @param string $code 程序代码
     * @access public
     * @return array    
     */    
    public static function get_class( $code )
    {
	$ret=self::resolve($code);
	if(empty($ret)){
	    return false;
	}
	if( empty( $ret[0] ) )
	{
	    return false;
	}
	if(isset($ret[0]['param'])||isset($ret[0]['access'])||isset($ret[0]['return']))
	{
	    return false;
	}
	return $ret[0];
    }

     /**
     * @name get_method 获取方法信息
     * @param string $code 程序代码
     * @access public
     * @return array    
     */    
    public static function get_method( $code )
    {
	$ret=self::resolve($code);
	if( empty( $ret ) )
	{
	    return array();
	}
	if( !isset($ret[0]['param']) || !isset($ret[0]['access']) || !isset($ret[0]['return'] ))
	{
	   array_shift($ret);
	}
	return $ret;
    }
     /**
     * @name get_method 获取方法信息
     * @param string $code 程序代码
     * @access public
     * @return array    
     */    
    public static function get_param( $code ,$method )
    {
	$arg=self::resolve($code);
	if( empty( $arg ) )
	{
	    return array();
	}
	foreach ($arg as $key => $val) {
	    if(empty($val['name'])){
		continue;
	    }
	    if($val['name']==$method)
	    {
		if(empty($val['param'])){
		    $val['param']=array();
		}
		return $val['param'];
	    }
	}
	return array();
    } 
    /**
     * @name get_method 分析备注信息获取程序中的方法
     * @param string $code 程序代码
     * @access public
     * @return array    
     */
    public static function resolve($code)
    {   
	$ret=array();
	if(empty($code)) return $ret;
	preg_match_all('/(\/\*\*.*?\*\/)/s', $code, $matches);
	if(empty($matches[0])) return $ret;
	foreach ($matches[0] as $key => $val) {
		
	    $tem=self::param($val);
	    if(!empty($tem)) $ret[]=$tem;
	}
	return $ret;
    }
     /**
     * @name get_param 解析程序中的备注信息
     * @param string $desc 程序备注
     * @access private
     * @return mixed    
     */   
     private static function param($desc)
    {
	$ret=array();
	if(empty($desc)) return FALSE;
	$arr=explode("\n", $desc);
	foreach ($arr as $key => $val)
	{
	    if(strpos($val, '@')===false) continue;
	    $val=preg_replace('/[\s]+/','|',$val);
	    $tmp=explode('|', $val);
	    if($tmp[2]=='@param')
	    {		
		$t=array();		
		$t['name']=empty($tmp[4])?'Unknown':trim($tmp[4],'$');
		$t['type']=empty($tmp[3])?'Unknown':$tmp[3];
		if(count($tmp)>5)
		{
		    unset($tmp[0],$tmp[1],$tmp[2],$tmp[3],$tmp[4]);
		    $t['desc']=implode(' ', $tmp);
		}
		$ret['param'][]=$t;
	    }
	    elseif($tmp[2]=='@name')
	    {
		$ret['name']=empty($tmp[3])?'Unknown':$tmp[3];
		if(count($tmp)>4)
		{
		    unset($tmp[0],$tmp[1],$tmp[2],$tmp[3]);
		    $ret['desc']=implode(' ', $tmp);
		}
	    }
	    else
	    {
		$name=trim($tmp[2],'@');
		unset($tmp[0],$tmp[1],$tmp[2]);
		$ret[$name]=implode(' ', $tmp);
	    }
	}
	var_dump($ret);
	return $ret;
    }
}
?>
