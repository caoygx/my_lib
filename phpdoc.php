<?
/** 
* ����: doc 
* ����: �ĵ������� 
* ����: ���Զ�Ŀ¼���й���,���ú�ԴĿ¼��,���þ���·��ָ������Ŀ¼,ģʽ�ɵ�,ģʽ 
* 1Ϊ��������,���� б��**��ͷ,��*б�� ���� 
* 2Ϊ��չ����,���� б��*��ͷ��*б�� �����Ĳ��ֶ�����Ϊ�ĵ���һ���� 
*/ 
class doc 
{ 
var $docdirname; 
var $docdir; 

/** 
* ��������: doc() 
* ��������: ���� 
* �������: none 
* ��������ֵ: ����ֵ˵�� 
* ����˵��: 2004-10-13 
*/ 
function doc() 
{ 
$this->docdirname = "doc/"; 
} 

/** 
* ��������: createDoc($root,$newdir,$mode="1",$filter=null) 
* ��������: �����ĵ� 
* �������: $root -------------- ԴĿ¼ 
$newdir ----------- Ŀ��Ŀ¼ 
$mode ------------- ģʽ,1Ϊ��ͨ,2Ϊ��չ 
$filter ------------ ����Ŀ¼ 
* ��������ֵ: ����ֵ˵�� 
* ����˵��: 2004-10-13 
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
* ��������: redirect($path) 
* ��������: ת�� 
* �������: $path ---------------- ת��·�� 
* ��������ֵ: ����ֵ˵�� 
* ����˵��: 2004-10-13 
*/ 
function redirect($path) 
{ 
echo "�����ĵ��ɹ�,����˴��鿴"; 
} 

/** 
* ��������: loopDir($root,$filter=null) 
* ��������: ����Ŀ¼ 
* �������: $root ------------------- ԴĿ¼ 
$filter ----------------- ���� 
* ��������ֵ: array 
* ����˵��: 2004-10-13 
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
* ��������: getPhpFiles($path) 
* ��������: ��ȡphp�ĵ� 
* �������: $path ---------------- �ĵ�·�� 
* ��������ֵ: bool 
* ����˵��: 2004-10-13 
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
* ��������: getContent($path) 
* ��������: ��ȡ�ļ����� 
* �������: $path ------------------- �ļ�·�� 
* ��������ֵ: string 
* ����˵��: 2004-10-13 
*/ 
function getContent($path) 
{ 
$fp = file($path); 
$content = implode('',$fp); 
Return $content; 
} 

/** 
* ��������: getDoc($content,$mode="1") 
* ��������: ȡ��php�ļ��е�ע�� 
* �������: $content ------------ �ĵ����� 
$mode --------------- ģʽ,1Ϊ��ͨ,2Ϊ��չ 
* ��������ֵ: string 
* ����˵��: 2004-10-13 
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
* ��������: etFilepath($filepath,$oldroot,$newroot) 
* ��������: ���������ļ���·�� 
* �������: $filepath -------------- Դ�ļ�·�� 
$oldroot -------------- ԴĿ¼·�� 
$newroot -------------- Ŀ��Ŀ¼·�� 
* ��������ֵ: string 
* ����˵��: 2004-10-13 
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
* ��������: getFileDir($path) 
* ��������: ȡ���ĵ�Ŀ¼ 
* �������: $path ------------- �ĵ�·�� 
* ��������ֵ: string 
* ����˵��: 2004-10-13 
*/ 
function getFileDir($path) 
{ 
$getpath = preg_replace('/(.*)(\/.*[^\.].*)/i','\\1',$path); 
Return $getpath; 
} 

/** 
* ��������: setDoc 
* ��������: ��ע��д��ָ��Ŀ¼������ҳ�� 
* �������: $filepath --------------- Ŀ¼·�� 
$content ---------------- д������� 
* ��������ֵ: ����ֵ˵�� 
* ����˵��: ˵�� 
*/ 
function setDoc($filepath,$content) 
{ 
$fp = fopen($filepath,"w+"); 
flock($fp,LOCK_EX); 
fwrite($fp,$content); 
flock($fp, LOCK_UN); 
} 

/** 
* ��������: mkdirs($path) 
* ��������: ����Ŀ¼ 
* �������: $path ------------------- ·�� 
* ��������ֵ: none 
* ����˵��: 2004-10-13 
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
* ��������: filter($item,$arr=null) 
* ��������: ���� 
* �������: $item -------------- ���� 
$arr --------------- ������ 
* ��������ֵ: bool 
* ����˵��: 2004-10-13 
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
* ��������: createFrame($root) 
* ��������: ���ɿ��ҳ 
* �������: $root --------------- ��ҳ�Ĵ��Ŀ¼ 
* ��������ֵ: str 
* ����˵��: 2004-10-13 
*/ 
function createFrame($root) 
{ 
$str = ' '; 
$this->docdir = $root."index.htm"; 
$this->setDoc($this->docdir,$str); 
} 

/** 
* ��������: createMenu($root,$data) 
* ��������: ���ɲ˵� 
* �������: $root ------------------- ҳ�����Ŀ¼ 
$data ------------------- ���� 
* ��������ֵ: string 
* ����˵��: 2004-10-13 
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
* ��������: getStyle() 
* ��������: ��ʽ 
* �������: none 
* ��������ֵ: string 
* ����˵��: 2004-10-13 
*/ 
function getStyle() 
{ 
$str = ' 
'; 
Return $str; 
} 

/** 
* ��������: getTable($content) 
* ��������: �����ݷ���table�� 
* �������: $content ------------ ���� 
* ��������ֵ: string 
* ����˵��: 2004-10-13 
*/ 
function getTable($content) 
{ 
$str = ""; 
Return $str; 
} 
} 

// ʹ�� 
$d = new doc; 
$filter = "adodb,smarty,cvs,templates,templates_c"; 
$d->createDoc("E:/web/test/","E:/web/test/doc/",1,$filter); 
?>