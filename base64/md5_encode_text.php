<?php //md5_encode_text.php
print md5("1Clave+Facil!");
print "<br>";
print md5("1");
print "<br>";
exit();

// 1Clave+Facil!
// $P$BLcgzOlBp2RBva/yG37AODmpxzBu8R. //de wp_local1


// 93d49d731e5b3c87b452ad36ffca804f
// $P$B93d49d731e5b3c87b452ad36ffca804f

//db425460732
// $P$B7u8Cbmc28xKGaPe8L8EQx/pt9Nj651

$texto = $_REQUEST["texto"];
$md5 = MD5($texto);
print "Original:<br> $texto<hr>md5:<br>$md5";
//$txt="Hola";
//MD5()
?>