<?php
include 'inc.php';
$type=$_REQUEST['type'];

$path=APP_PATH."/{$type}";
$files=  get_file($path);
//echo $_REQUEST['type']; var_dump($files);
$arg=array();
foreach ($files as $key => $value) {
    $code=  file_get_contents($value);
    if(!$code)	continue;
    $ret=debug::get_class($code);
    var_dump($ret);
	if(is_array($ret)){
	$arg=  array_merge($arg,$ret);
    }
}
//var_dump($arg);exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
<title>Debug Tools</title>
<link type="text/css"  href="css.css" rel="stylesheet" />
<script type="text/javascript" src="jquery.js"></script>
</head>
<body>
<div id="wrapper">

    <h1>Debug Tools</h1>
    
    <ul id="nav">
	<?php 
	    foreach ($config as $key => $val) {
		$className=($key==$type)?'cur':'';
		echo "<li><a href=\"index.php?type={$key}\" class=\"{$className}\">{$key}</a></li>\n";
	    }

	?>
    </ul>

    <div id="main">
    	<div id="panel">
        	<form action="gateway.php" method="get" id="callfrm" target="main_frame">
		<input type="hidden" name="c"  value="get_result" >
		<input type="hidden"  name="arg[0]" id="arg0"  value="<?php echo $type; ?>" >
		<p><b>数据格式</b><br />
		    <select name="arg[3]" id="arg3">
			<option value="array">array</option>
			<option value="json">json</option>						
                    </select>
                </p>
            	<p><b>控制器</b><br />
		    <select  name="arg[1]" id="arg1" onchange="get_method(this.value)">
                    	<option value="">请选择</option>
			<?php			
				foreach ($arg as $key => $val) {
				    echo '<option value="'. $key .'">'.$val.'('.$key.')</option>';
				}
			?>
                    </select>
                </p>
            	<p><b>方法</b><br />
		    <select   name="arg[2]"  id="arg2"  onchange="get_param(this.value)">
                    	<option value="" >请选择</option>
                    </select>
                </p>
            	<p><b>参数列表:</b><br />
		    <span id="parames"></span>
                </p>
                <p class="submit">
		    <input type="button" id="callbtn" value="执行" onclick="this.form.submit()" />
                </p>
            </form>
        </div>
        <div id="content">
            <div id="results">
		<iframe id="main_frame" name="main_frame" marginheight="0" frameborder="0" marginwidth="0" src=""   style="height:400px; width:100%;"></iframe>
            </div>
        </div>    
    </div>

    <div id="foot">        
        <span><a href="#">About</a>　<a href="#">Documentation</a></span>
        <a href="#" target="_blank">Debug Tool</a> © 2009
    </div>
    
</div>
<script type="text/javascript">
function get_method(arg1){
    if(arg1=="") {
	set_method();
	return ;
    }
    var arg=$('#arg0').val()+'/'+arg1;
    var url='gateway.php?c=get_method&t=json&arg='+arg;
	prompt('tt', url);
    $.ajax({url:url,dataType:'json',success:set_method,error:function(){alert('获取方法错误')}});
}
function get_param(arg2){
    if(arg2=="") {
	set_param();
	return ;
    }
    var arg=$('#arg0').val()+'/'+$('#arg1').val()+'/'+arg2;
    var url='gateway.php?c=get_param&t=json&arg='+arg;
    $.ajax({url:url,dataType:'json',success:set_param,error:function(){alert('获取参数错误')}});
}
function set_method(data){
    var option='<option value="" >请选择</option>';

    if(typeof(data)=='object'){
	for(k in data ){
	    option+='<option value="'+data[k].name+'" >';
	    
	    if(data[k].desc) {
		option+=data[k].desc;
		option+='('+data[k].name+')';
	    }
	    else{
		option+=''+data[k].name+'';
	    }
	    option+='</option>';

	}
    }

    $('#arg2').empty();
    
    
    $('#arg2').append($(option));
}
function set_param(data){
    $('#parames').empty();
    var html='';
    if(typeof(data)=='object'){
	
	for(k in data ){
	    html+='<span>';
	    html+=data[k].desc;
	    //html+=' [ '+data.result[k].name+' ]';
	    html+=' ( '+data[k].type+' )：';
	    html+='</span>';
	    html+='<input type="hidden" name="k['+k+']" value="'+data[k]['name']+'" >';
	    html+='<input type="text" name="v['+k+']" value="" >';
	    html+='<br>';
	}
	if(html==''){
	    html='<span>不需要参数</span>';
	}
    }
    $('#parames').append($(html));
}


</script>
</body>
</html>
