<?php //solo_qr.php
	$lugar = "menorca";
	$_lugar = $lugar;//trabajamos con una copia de $lugar

	//eliminamos los espacios sustituyendolos por -
	while(strpos(" ", $_lugar)){
		$_lugar = str_replace(" ", "-", $_lugar);
	}

	$ahora = time();

	//ponemos la url para las tarjetas
	$url = "http://circulodesanacion.org/r/?r=$_lugar&t=$ahora";
	$_url = $url;
	

	//$url_destino = "http://www.circulodesanacion.org/r/?r=5001&lugar=$_lugar&t=$ahora";
	$url_destino = "http://cscmc.es/r/?r=5001&l=$_lugar";

	$PNG_TEMP_DIR = "QR";//dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "inc/qr/qrlib.php";

    $qr_filename = $PNG_TEMP_DIR.'test'.md5($url_destino.'|L|'.'4').'.png';
        QRcode::png($url_destino, "qr/".$qr_filename, 'L', 4, 2);

    header("Content: text/html;");
    print <<<fin

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<img src="qr/$qr_filename"/>
</body>
</html>
fin;

?>