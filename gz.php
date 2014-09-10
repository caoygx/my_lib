<?php 
$string = "8aeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeer8aaaaaaaaaaaaaaaaaaaaaaadasd456as
d456asd456asd456asd456asd456asd456asd456asd456asd456asd456asd456fasdf45645645645645645
6456456456456456456456456456456456456456456456456456456456456456456456456a56fs4s4s4s4s
4s4s4s4s4s4s4s4s4s4dsdga133333333333333333333w8etw7q9999999999999999999a23s1dfffffffff
fffffffffffffffa456ssssssssssssdv2sdddddddddddddddddddf";
echo "字符串长度：";
echo strlen($xx);
echo "<br/>gzcompress压缩后长度 ：";
echo strlen(gzcompress($string,9));
echo gzcompress($string,9);

echo "<br/>gzencode压缩后长度：";
echo strlen(gzencode($string,9));
echo gzencode($string,9);


echo "<br/>gzdeflate压缩后长度：";
echo strlen(gzdeflate($string,9));
echo gzdeflate($string,9);


?>