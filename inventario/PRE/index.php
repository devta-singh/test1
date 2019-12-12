<?php //toolbox/inventario/index.php

//leemos en la carpeta /VOLUMES

$d = $open_dir("/VOLUMES");
while($f=readdir($d){
	$ruta = $d."/";
	$ruta_completa = $ruta.$f;
	print "$f";
	if(issdir($ruta_completa)){
		print " es directorio ";
	}
	if(isfile($ruta_completa)){
		print " es fichero ";
	}
	$tam=0;
	if($tam = filesize($ruta_completa)){
		print "/ tam: $tam bytes ";
	}else{
		print "/ vacío (tam: $tam bytes) ";
	}
}


?>