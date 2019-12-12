<?php //seleccionar_tarjeta.php


error_reporting(15);
ini_set("display_errors",1);

if(isset($_REQUEST["msg"])){
	$msg=$_REQUEST["msg"];
}else{
	$msg="";
}

$directorio="./fondos";
$d= opendir($directorio);
//print "Abierto el directorio: $directorio<br>";
$html=<<<fin
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.css"/>

	<script type="text/javascript" src="http://www.technicalkeeda.com/js/javascripts/plugin/jquery.js"></script>


</head>
<body>
<div>
<div id="nav">Menu</div>$msg
	<form action="texto_sobre_imagen.php?buscar_imagen=1" method="post">
	<input type="submit" value="Utilizar la imagen seleccionada">
	<br>Seleccionar una imagen de las siguientes:<br>
fin;
	$n=0;
	while($f = readdir($d)){
		//print "Item: $f ";
		$fich = $directorio."/".$f;

		if(is_dir($f)){
			//print "Es directorio...<br>";
		}else{
			//print "Es fichero...<br>";
			$html.=<<<fin
			<label for="id$n"><input type="radio" id="id$n" name="fondo" value="$fich">$f<br><img id="id_imagen_$n" src="$fich" style="border:solid black 1px;width:100px;"></label><br>
fin;
	$n++;
		}

	}//fin while

			$html.=<<<fin
<input type="submit" value="Utilizar la imagen seleccionada">
</form>
</div>
</body>
</html>
fin;

header("Content-type: text/html");
print $html;

?>