<?php //base64_decode_text.php

$base64 = $_REQUEST["texto"];
$texto = base64_decode($texto);
print "Original: $base64<hr>Texto:<br>$texto";

?>