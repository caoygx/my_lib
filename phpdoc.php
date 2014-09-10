<?
/** 
* 类名: doc 
* 描述: 文档生成类 
* 其他: 可以对目录进行过滤,设置好源目录后,请用绝对路径指定生成目录,模式可调,模式 
* 1为常规类型,即以 斜线**开头,以*斜线 结束 
* 2为扩展类型,凡是 斜线*开头以*斜线 结束的部分都将成为文档的一部分 
*/ 
class doc 
{ 
var $docdirname; 
var $docdir; 

/** 
* 函数名称: doc() 
* 函数功能: 构造 
* 输入参数: none 
* 函数返回值: 返回值说明 
* 其它说明: 2004-10-13 
*/ 
function doc() 
{ 
$this->docdirname = "doc/"; 
} 

/** 
* 函数名称: createDoc($root,$newdir,$mode="1",$filter=null) 
* 函数功能: 创建文档 
* 输入参数: $root -------------- 源目录 
$newdir ----------- 目标目录 
$mode ------------- 模式,1为普通,2为扩展 
$filter ------------ 过滤目录 
* 函数返回值: 返回值说明 
* 其它说明: 2004-10-13 
*/ 
function createDoc($root,$newdir,$mode="1",$filter=null) 
{ 
$getarr = $this->loopDir($root,$filter); 
$i = 0; 
$this->createFrame($newdir); 
foreach($getarr as $key=>$val) 
{ 
if($this->getPhpFiles($val)) 
{ 
$content = $this->getContent($val); 
$content = $this->getDoc($content,$mode); 
$filepath = $this->setFilepath($val,$root,$newdir); 
$filedir = $this->getFileDir($filepath); 
$this->mkdirs($filedir); 
$this->setDoc($filepath,$content); 
$data[$i]['url'] = "$filepath"; 
$data[$i]['name'] = "$val"; 
$i++; 
} 
} 
if(!empty($data)) 
{ 
$this->createMenu($newdir,$data); 
$this->redirect($this->docdir); 
} 
} 

/** 
* 函数名称: redirect($path) 
* 函数功能: 转向 
* 输入参数: $path ---------------- 转向路径 
* 函数返回值: 返回值说明 
* 其它说明: 2004-10-13 
*/ 
function redirect($path) 
{ 
echo "生成文档成功,点击此处查看"; 
} 

/** 
* 函数名称: loopDir($root,$filter=null) 
* 函数功能: 遍历目录 
* 输入参数: $root ------------------- 源目录 
$filter ----------------- 过滤 
* 函数返回值: array 
* 其它说明: 2004-10-13 
*/ 
function loopDir($root,$filter=null) 
{ 
static $getarr=array(); 
$d = dir($root); 
while (false !== ($entry = $d->read())) 
{ 
if ($entry == "." || $entry == "..") 
{ 
continue; 
} 
if($this->filter($entry,$filter)) 
{ 
if(is_dir($root.$entry)) 
{ 
$this->loopDir($d->path.$entry."/"); 
} 
else 
{ 
$getarr[] = $d->path.$entry; 
} 
} 
} 
$d->close(); 
Return $getarr; 
} 

/** 
* 函数名称: getPhpFiles($path) 
* 函数功能: 提取php文档 
* 输入参数: $path ---------------- 文档路径 
* 函数返回值: bool 
* 其它说明: 2004-10-13 
*/ 
function getPhpFiles($path) 
{ 
$type = preg_replace('/.*\.(.*[^\.].*)/i','\\1',$path); 
$type = strtolower($type); 
if($type=="php") 
{ 
Return true; 
} 
else 
{ 
Return false; 
} 
} 

/** 
* 函数名称: getContent($path) 
* 函数功能: 读取文件内容 
* 输入参数: $path ------------------- 文件路径 
* 函数返回值: string 
* 其它说明: 2004-10-13 
*/ 
function getContent($path) 
{ 
$fp = file($path); 
$content = implode('',$fp); 
Return $content; 
} 

/** 
* 函数名称: getDoc($content,$mode="1") 
* 函数功能: 取出php文件中的注释 
* 输入参数: $content ------------ 文档内容 
$mode --------------- 模式,1为普通,2为扩展 
* 函数返回值: string 
* 其它说明: 2004-10-13 
*/ 
function getDoc($content,$mode="1") 
{ 
switch($mode) 
{ 
case '1': 
$pattern = '/\/(\*)[\r\n].*\*\//isU'; 
break; 
case '2': 
$pattern = '/\/\*.*\*\//isU'; 
break; 
} 

preg_match_all($pattern,$content,$carr); 
$getarr = array(); 
foreach($carr[0] as $key=>$val) 
{ 
$getarr[] = trim($val); 
} 
$str = implode("

",$getarr); 
$str = preg_replace('/[\r]/i','
',$str); 
$style = $this->getStyle(); 
$str = $this->getTable($str); 
$str = $style.$str; 
Return $str; 
} 

/** 
* 函数名称: etFilepath($filepath,$oldroot,$newroot) 
* 函数功能: 设置生成文件的路径 
* 输入参数: $filepath -------------- 源文件路径 
$oldroot -------------- 源目录路径 
$newroot -------------- 目标目录路径 
* 函数返回值: string 
* 其它说明: 2004-10-13 
*/ 
function setFilepath($filepath,$oldroot,$newroot) 
{ 
$oldroot = str_replace('/',"\\/",$oldroot); 
$pattern = "/".$oldroot."(.*)/iU"; 
$filepath = preg_replace($pattern,'\\1',$filepath); 
$newpath = $newroot.$this->docdirname.$filepath;//echo "$newpath"; 
$newpath = preg_replace('/(.*\.)(.*[^\.].*)/i','\\1htm',$newpath); 
Return $newpath; 
} 

/** 
* 函数名称: getFileDir($path) 
* 函数功能: 取得文档目录 
* 输入参数: $path ------------- 文档路径 
* 函数返回值: string 
* 其它说明: 2004-10-13 
*/ 
function getFileDir($path) 
{ 
$getpath = preg_replace('/(.*)(\/.*[^\.].*)/i','\\1',$path); 
Return $getpath; 
} 

/** 
* 函数名称: setDoc 
* 函数功能: 将注释写入指定目录并生成页面 
* 输入参数: $filepath --------------- 目录路径 
$content ---------------- 写入的内容 
* 函数返回值: 返回值说明 
* 其它说明: 说明 
*/ 
function setDoc($filepath,$content) 
{ 
$fp = fopen($filepath,"w+"); 
flock($fp,LOCK_EX); 
fwrite($fp,$content); 
flock($fp, LOCK_UN); 
} 

/** 
* 函数名称: mkdirs($path) 
* 函数功能: 创建目录 
* 输入参数: $path ------------------- 路径 
* 函数返回值: none 
* 其它说明: 2004-10-13 
*/ 
function mkdirs($path) 
{ 
$adir = explode('/',$path); 
$dirlist = ''; 
$rootdir = $adir[0]; 
array_shift ($adir); 
foreach($adir as $key=>$val) 
{ 
if($val!='.'&&$val!='..') 
{ 
$dirlist .= "/".$val; 
$dirpath = $rootdir.$dirlist; 
if(!file_exists($dirpath)&&!is_file($dirpath)) 
{ 
mkdir($dirpath); 
chmod($dirpath,0777); 
} 
} 
} 
} 

/** 
* 函数名称: filter($item,$arr=null) 
* 函数功能: 过滤 
* 输入参数: $item -------------- 内容 
$arr --------------- 过滤项 
* 函数返回值: bool 
* 其它说明: 2004-10-13 
*/ 
function filter($item,$arr=null) 
{ 
$item = strtolower($item); 
$filter = explode(',',$arr); 
if($arr==null||!in_array($item,$filter)) 
{ 
Return true; 
} 
else 
{ 
Return false; 
} 
} 

/** 
* 函数名称: createFrame($root) 
* 函数功能: 生成框架页 
* 输入参数: $root --------------- 首页的存放目录 
* 函数返回值: str 
* 其它说明: 2004-10-13 
*/ 
function createFrame($root) 
{ 
$str = ' '; 
$this->docdir = $root."index.htm"; 
$this->setDoc($this->docdir,$str); 
} 

/** 
* 函数名称: createMenu($root,$data) 
* 函数功能: 生成菜单 
* 输入参数: $root ------------------- 页面存入目录 
$data ------------------- 内容 
* 函数返回值: string 
* 其它说明: 2004-10-13 
*/ 
function createMenu($root,$data) 
{ 
$path = $root."menu.htm"; 
$str = $this->getStyle(); 
$str.= " "; 
foreach($data as $key=>$val) 
{ 
$str.= "  ".$val['name']." 
"; 
} 
$str.= "  "; 
$this->setDoc($path,$str); 
} 

/** 
* 函数名称: getStyle() 
* 函数功能: 样式 
* 输入参数: none 
* 函数返回值: string 
* 其它说明: 2004-10-13 
*/ 
function getStyle() 
{ 
$str = ' 
'; 
Return $str; 
} 

/** 
* 函数名称: getTable($content) 
* 函数功能: 把内容放入table中 
* 输入参数: $content ------------ 内容 
* 函数返回值: string 
* 其它说明: 2004-10-13 
*/ 
function getTable($content) 
{ 
$str = ""; 
Return $str; 
} 
} 

// 使用 
$d = new doc; 
$filter = "adodb,smarty,cvs,templates,templates_c"; 
$d->createDoc("E:/web/test/","E:/web/test/doc/",1,$filter); 
?>