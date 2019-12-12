<?php //base64_decode.php

$texto = $_REQUEST["texto"];

$binario = base64_decode($texto);

if(isset($_REQUEST["tipo"])){
	$tipo = $_REQUEST["tipo"];
	if(
		$tipo == "otro"
		&& isset($_REQUEST["tipo_otro"])
	){
		$tipo = $_REQUEST["tipo_otro"];
	}
}else{
	$tipo = "image/png";
}
list($a, $ext) = explode("/", $tipo);

if(isset($_REQUEST["disposicion"])){
	$disposicion = $_REQUEST["disposicion"];
	if($disposicion == "descargar"){
		header("Content-disposition: attachment;filename='fichero_descargado.$ext'");
		echo $binario;
	}elseif($disposicion == "descargar_nombre"){
		if($_REQUEST["nombre"]){
			$nombre = $_REQUEST["nombre"];
		}
		header("Content-disposition: attachment;filename='$nombre.$ext'");
		echo $binario;
	}else{
		header("Content-type: $tipo");
		echo $binario;
	}
}else{
	//lo mostramos como tipo
	header("Content-type: $tipo");
	echo $binario;
}



?>