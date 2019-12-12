<?php //base64_decode_text.php

$texto = $_REQUEST["texto"];
$base64 = base64_encode($texto);
print "Original: $texto<hr>base64:<br>$base64";

?>