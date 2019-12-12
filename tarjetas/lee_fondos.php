<?php //lee_fondos.php

$ruta = "./fondos";
$sep = "/";
//$dir = opendir("./fondos");
$dir = opendir($ruta.$sep);
print "<br>$ruta";
while($f = readdir($dir)){
	//descartamos los que empiezan por .
	if(strpos($f, ".")==0){
		//continue;
	}

	print "<br>$f";
	if(is_file($ruta.$sep.$f)){
		print " es fichero";
	}

	if(is_dir($ruta.$sep.$f)){
		print " es directorio";
	}
}


?>