<?php //pinta_sectores.php

//control de errores
error_reporting(15);
ini_set("display_errors", 1);
//ini_set("memory_limit","3000M");

//Depuración
define("_d", true);//imprime codigos debug
//define("_d", false);//no imprime codigos debug
$num_sensores = 8;

$ancho = 2000;
$alto = 2000;

$cx = $ancho / 2;
$cy = $alto / 2;
$radio_base = $ancho / $num_sensores / 2;

$im = imagecreatetruecolor($ancho, $alto);
$negro = imagecolorallocate($im, 0,0,0);
$blanco = imagecolorallocate($im, 255, 255, 255);
$rojo = imagecolorallocate($im, 255, 0, 0);

imagefill($im, 1, 1, $blanco);

$origen = "angulos-8-0-360.csv";
$contenido = file_get_contents($origen);

//cambiamos las , por . para las comas decimales
$contenido = str_replace(",", ".", $contenido);

$lineas = explode("\n", $contenido);
foreach($lineas as $l => $linea){
	list($n_sensor, $n_porcion, $ang_1, $ang_2) = explode(";", $linea);
	//obtenemos el primer punto

	$x1 = $cx + ($radio_base * ($n_sensor - 1)) * cos(deg2rad($ang_1));
	$y1 = $cy + ($radio_base * ($n_sensor - 1)) * sin(deg2rad($ang_1));
	$x2 = $cx + ($radio_base * ($n_sensor)) * cos(deg2rad($ang_1));
	$y2 = $cy + ($radio_base * ($n_sensor)) * sin(deg2rad($ang_1));

	$x3 = $cx + ($radio_base * ($n_sensor - 1)) * cos(deg2rad($ang_1));
	$y3 = $cy + ($radio_base * ($n_sensor - 1)) * sin(deg2rad($ang_1));
	$x4 = $cx + ($radio_base * ($n_sensor)) * cos(deg2rad($ang_1));
	$y4 = $cy + ($radio_base * ($n_sensor)) * sin(deg2rad($ang_1));

	//imageline($im, $x1, $y1, $x2, $y2, $negro);//primera marca
	//imageline($im, $x2, $y2, $x3, $y3, $rojo);//primer cierre
	//imageline($im, $x3, $y3, $x4, $y4, $negro);//segunda marca
	//imageline($im, $x4, $y4, $x1, $y1, $rojo);//segundo cierre

	//imagepolygon(image, points, num_points, color)
	//imagefilledpolygon(image, points, num_points, color)
	imagefilledpolygon($im, array($x1,$y1, $x2,$y2, $x3,$y3, $x4,$y4), 4, $rojo);

	
	$centrox = round(($x1 + $x2 + $x3 + $x4) / 4);
	$centroy = round(($y1 + $y2 + $y3 + $y4) / 4);

	//imagesetpixel($im, $centrox, $centroy, $rojo);


}

//print "hola";
//exit();
header("COntent-type: image/png");
imagepng($im);

?>