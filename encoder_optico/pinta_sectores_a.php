<?php //pinta_sectores_a.php

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
$last_n_sensor=0;
$ultimo_color=0;
foreach($lineas as $l => $linea){
	//if($l >73){
		//break;
	//}
	list($n_sensor, $n_porcion, $ang_1, $ang_2) = explode(";", $linea);

	//si es la primera linea
	// if($l<1){
	// 	//establecemos el color de fondo
	// 	$last_n_sensor=0;
	// }

	//si cambia el $n_sensor actualizamos el ultimo_color
	// if($n_sensor != $last_n_sensor){
	// 	$last_n_sensor = $n_sensor;
	// 	//$ultimo_color=0;
	// 	if($ultimo_color == 0){
	// 		$ultimo_color=0;
	// 	}else{
	// 		$ultimo_color=1;
	// 	}
	// }

	//cambiamos de color
	//if($ultimo_color==0){
	if(($l/2) == (round($l/2))){	
		$fondo = $blanco;
		$ultimo_color=1;
	}else{
		$fondo = $negro;
		$ultimo_color=0;
	}
	//print "$n_sensor;$n_porcion;$ultimo_color;$ang_1<br>";

	//obtenemos el primer punto
	$x1 = $cx + ($radio_base * ($n_sensor - 1)) * cos(deg2rad($ang_1));
	$y1 = $cy + ($radio_base * ($n_sensor - 1)) * sin(deg2rad($ang_1));
	//obtenemos el segundo punto
	$x2 = $cx + ($radio_base * ($n_sensor)) * cos(deg2rad($ang_1));
	$y2 = $cy + ($radio_base * ($n_sensor)) * sin(deg2rad($ang_1));

	//obtenemos el tercer punto
	$x3 = $cx + ($radio_base * ($n_sensor - 1)) * cos(deg2rad($ang_2));
	$y3 = $cy + ($radio_base * ($n_sensor - 1)) * sin(deg2rad($ang_2));
	//obtenemos el cuarto punto
	$x4 = $cx + ($radio_base * ($n_sensor)) * cos(deg2rad($ang_2));
	$y4 = $cy + ($radio_base * ($n_sensor)) * sin(deg2rad($ang_2));

	$tx1 = $cx + ( ($radio_base * $num_sensores) +30) * cos(deg2rad(($ang_1+$ang_2)/2));
	$ty1 = $cy + ( ($radio_base * $num_sensores) +30) * sin(deg2rad(($ang_1+$ang_2)/2));

	 imageline($im, $x1, $y1, $x2, $y2, $negro);//primera marca
	// imageline($im, $x2, $y2, $x4, $y4, $rojo);//primer cierre
	 imageline($im, $x3, $y3, $x4, $y4, $negro);//segunda marca
	// imageline($im, $x3, $y3, $x1, $y1, $rojo);//segundo cierre

	$texto = "$n_sensor, $n_porcion, $ultimo_color";

	//imagettftext(image, size, angle, x, y, color, fontfile, text)

	//imagettftext($im, 10, $ang_1+90, $tx1, $ty1, $negro, "ttf/Arcon-Regular.otf", $texto);
	//imagestring($im, 1, $tx1, $ty1, $texto, $negro);

	imagefilledpolygon($im, array($x1, $y1, $x2, $y2, $x4, $y4, $x3, $y3), 4, $fondo);

	
	$centrox = round(($x1 + $x2 + $x3 + $x4) / 4);
	$centroy = round(($y1 + $y2 + $y3 + $y4) / 4);

	//imagesetpixel($im, $centrox, $centroy, $rojo);


}

//print "hola";
//exit();
header("COntent-type: image/png");
imagepng($im);

?>