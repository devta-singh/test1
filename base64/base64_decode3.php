<?php //base64_decode2.php

$texto = $_REQUEST["texto"];

$binario = base64_decode($texto);

if(isset($_REQUEST["accion"])){
	$accion = $_REQUEST["accion"];
}
if($accion == "codificar"){
	$n_texto = base64_encode($texto);
}else{
	$n_texto = base64_decode($texto);
}

//lo mostramos como tipo
header("Content-type: text/text");
echo $n_texto;
?>