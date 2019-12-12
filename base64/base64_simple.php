<?php //base64_simple.php
error_reporting(15);
ini_set("display_errors", 1);

$original = "";
$resultado = "";

if(isset($_REQUEST["original"])){
	$original = $_REQUEST["original"];
}else{
	$original = "";
}

//print $original;

if(isset($_REQUEST["que"])){
	$que = $_REQUEST["que"];
	
	if($que=="base64_encode"){
		$resultado = base64_encode($original);
	}elseif($que == "base64_decode"){
		$resultado = base64_decode($original);
	}
}

$html=<<<fin
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form method="post" action="?">
		<input type="radio" name="que" value="base64_encode"/>base64 CODIFICAR
		<br><input type="radio" name="que" value="base64_decode"/>base64 DESCODIFICAR
		<br>Texto a codficar:<br><textarea name="original" onclick="this.select();">$original</textarea>
		<br>
		Resultado:<br><textarea name="resultado" onclick="select();">$resultado</textarea>
		<hr>$resultado<hr>
		<input type="submit" value="procesar"/>
	</form>	
</body>
</html>
fin;

header("Content-type: text/html; charset: utf8;");
print $html;
?>