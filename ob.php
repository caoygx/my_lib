
<?php

ob_start();

echo "Hello ";



echo "World";

$out2 = ob_get_contents();

file_put_contents("ob.html",$out2);
//ob_end_clean();
?>
