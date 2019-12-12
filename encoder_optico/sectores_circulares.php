<?php //sectores_circulares.php

//control de errores
error_reporting(15);
ini_set("display_errors", 1);

//Depuración
define("_d", true);//imprime codigos debug
//define("_d", false);//no imprime codigos debug


//establecemos los atributos básicos
$num_sensores = 4;//el numero de sensores
$px_ancho=800;//el ancho
$px_alto=800;//el alto

$ang_ini = 0;
$ang_fin = 360;
$radio_max =  $px_ancho / 2;//400;
$radio_min = 100;

//creamos la imagen
//creamos la imagen con esas dimensiones en pixels
$im=imagecreatetruecolor($px_ancho,$px_alto);

//creamos los colores
//el primer color en usar es asignado al fondo
$negro = imagecolorallocate($im, 0, 0, 0);
$blanco = imagecolorallocate($im, 255, 255, 255);
$rojo = imagecolorallocate($im, 255, 0, 0);
$verde = imagecolorallocate($im, 0, 255, 0);
$azul = imagecolorallocate($im, 0, 0, 255);

imagefill ($im, 1, 1 , $blanco);

$titulo_imagen = "Encoder optico de $px_ancho pixeles";

$cx = $px_ancho / 2;//400;
$cy = $px_alto / 2;// 400;

$ancho_sensor = ($radio_max - $radio_min) / $num_sensores;

$color1 = $negro;
$color2 = $blanco;

for($n_sensor = 1; $n_sensor <= $num_sensores; $n_sensor++){
	//va cambiando de sensor
	$radio_max =  $px_ancho / 2;//400;
	$radio_min = 100;

	$ancho2 = $radio_max - ($ancho_sensor * ($n_sensor - 1));
	$ancho1 = $radio_max - ($ancho_sensor * $n_sensor);

	$num_porciones = pow(2, $n_sensor);
	$ang_porcion = ($ang_fin - $ang_ini) / $num_porciones;

	$n=0;

	for($n_porcion = 1; $n_porcion <= $num_porciones; $n_porcion++){


		//va cambiando de porcion
		$ang_1 = $ang_ini + ($ang_porcion * ($n_porcion - 1));
		$ang_2 = $ang_ini + ($ang_porcion * $n_porcion);
		

		//cambio de color
		if(fmod($n,2)){
			$color1 = $blanco;
			$color2 = $negro;
		}else{
			$color1 = $negro;
			$color2 = $blanco;
		}

		imagefilledarc ($im, $cx, $cy, $ancho2, $ancho2, $ang_1, $ang_2, $color1, IMG_ARC_EDGED);
		//imagefilledarc ($im, $cx, $cy, $ancho2, $ancho2, $ang_1, $ang_2, $color2, IMG_ARC_EDGED);
		$n++;
	}

	imagefilledarc ($im, $cx, $cy, $ancho1, $ancho1, $ang_ini, $ang_fin, $blanco, IMG_ARC_EDGED);
}

/*

//primer sector externo
imagefilledarc ($im, $cx, $cy, 400, 400, 0, 360, $negro, IMG_ARC_EDGED);
imagefilledarc ($im, $cx, $cy, 350, 350, 0, 120, $blanco, IMG_ARC_EDGED);

//segundo sector, hacia el interior
//primer sector externo
imagefilledarc ($im, $cx, $cy, 350, 350, 0, 150, $negro, IMG_ARC_EDGED);
//imagefilledarc ($im, $cx, $cy, 300, 300, 90, 150, $blanco, IMG_ARC_EDGED);

imagefilledarc ($im, $cx, $cy, 350, 350, 150, 170, $blanco, IMG_ARC_EDGED);
//imagefilledarc ($im, $cx, $cy, 300, 300, 150, 170, $negro, IMG_ARC_EDGED);

imagefilledarc ($im, $cx, $cy, 350, 350, 170, 210, $negro, IMG_ARC_EDGED);
//imagefilledarc ($im, $cx, $cy, 300, 300, 170, 210, $blanco, IMG_ARC_EDGED);

imagefilledarc ($im, $cx, $cy, 300, 300, 0, 360, $blanco, IMG_ARC_EDGED);
*/
header("Content-type: image/png;");
imagepng($im);
exit();

//rellenamos de blanco la imagen
if($_relleno){
	imagefill ($im, 1, 1 , $blanco);
}


//pintamos el marco de la imagen (borde)
if($_marco){
	imageline($im, 0,0, $px_ancho -1, 0, $negro);
	imageline($im, $px_ancho -1,0, $px_ancho -1, $px_alto -1, $negro);
	imageline($im, $px_ancho -1, $px_alto -1, 0, $px_alto -1, $negro);
	imageline($im, 0, $px_alto -1, 0, 0, $negro);
}

$titulo_imagen.= " y $num_sensores sensores";
//obtenemos la resolucion máxima por el número de sensores
$resolucion = $px_ancho / (pow(2,$num_sensores));
$pixels = $px_ancho;

$pixels_sensor=array();
$divisiones_sensor=array();
$texto_divisiones="";

//recorremos los sensores
$alto_porcion = $px_alto / $num_sensores;
if(_d){
	print <<<fin
	Ancho total: $px_ancho px, alto: $px_alto px\n<br>
	$num_sensores Sensores, alto por sensor: $alto_porcion px\n<br>
fin;
}//fin del if(_d)

//angulo final - angulo inicial
$ang_total = $ang_fin - $ang_ini;
//angulo final - angulo inicial
$ancho_total = $radio_max - $radio_min;	
$radio_incremento = $ancho_total / $num_sensores;


//bucle para cada anillo
for($n_sensor=1;$n_sensor<=$num_sensores;$n_sensor++){
	//para el sensor n vamos a crear el número de pixels por división
	//son divisiones binarias
	//cada sensor tiene 2^n_sensor divisiones

	$n_divisiones = pow(2,$n_sensor);
	$angulo_porcion = $ang_total / $n_divisiones;

	//según el sensor, establecemos el ancho
	$radio_ini = $radio_max;
	$radio_fin = $radio_max - $radio_incremento; 
	

	if(_d){
	print <<<fin
	Sensor $n_sensor, $n_divisiones divisiones, ancho de la division $angulo_porcion px alto $alto_porcion px\n<br>

fin;
}//fin del if(_d)

	$ultimo_color = 0;
	$color_porcion = $blanco;
	for($n_porcion=1; $n_porcion <= $n_divisiones; $n_porcion++){
		//establecemos el color
		if($ultimo_color == 0){
			$color_porcion = $blanco;
			$ultimo_color = 1;
		}else{
			$color_porcion = $negro;
			$ultimo_color = 0;
		}

		//Establecemos los puntos X de la porcion
		$ang1 =  $ang_ini + (($n_porcion - 1) * $angulo_porcion);
		$ang2 =  $ang_ini + ($n_porcion * $angulo_porcion);

		$y1 =  (($n_sensor - 1) * $alto_porcion);
		$y2 =  ($n_sensor * $alto_porcion);

		
		$cx = 400;
		$cy = 400;
		//$ancho= 200;$ancho2= 150;
		//$alto=200;$alto2=150;
		$ancho= 400;$ancho2= 300;
		$alto=400;$alto2=300;
		$inicio=$ang1;
		$fin=$ang2;

		imagefilledarc ($im, $cx, $cy, $ancho, $alto, 90, 120, $negro, IMG_ARC_EDGED);
		imagefilledarc ($im, $cx, $cy, $ancho2, $alto2, 90, 120, $blanco, IMG_ARC_EDGED);

	}//fin for porcion

}//fin for sensor

//print $texto_divisiones;
$mensajes="";
$mensajes.="<br><br>El encoder tiene $px_ancho pixeles de recorrido máximo 
	<br>La resolución máxima del sistema es de $resolucion pixeles 
	<br>cada $resolucion pixeles, se puede contar un dato, o un paso.
	<br><br>Para $num_sensores sensores \n<br>$texto_divisiones";


//con estas divisiones pintamos el encoder

//ahora generamos la imagen en un fichero

//creamos el nombre en el que se va a guardar




$ahora = microtime();


$destino = "img/encoder_circular_".$ahora.".png";


imagepng($im, $destino);

$mensajes.="Destino: $destino";


//finalizamos la captura de la salida
//$mensajes = ob_get_flush();
//$mensajes = ob_get_contents();
//ob_end_flush();

//creamos el HTML con la llamada a la imagen en HTML
$html=<<<fin
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>$titulo - $version - $fecha</title>
	
	<style type="text/css">
		#info_basica{
			width: 400px;
		}

	  dl {
	    display: flex;
	    flex-flow: row wrap;
	    border: solid #333;
	    border-width: 1px 1px 0 0;
	  }
	  dt {
	    flex-basis: 20%;
	    padding: 2px 4px;
	    background: #999;
	    text-align: right;
	    color: #fff;
	  }
	  dd {
	    flex-basis: 70%;
	    flex-grow: 1;
	    margin: 0;
	    padding: 2px 4px;
	    border-bottom: 1px solid #333;
	  }

</style>
	</style>
</head>
<body>
	<h1>$titulo</h1>
	<h2></h2>
	
	<br>
	Salida del programa:<br>
	$mensajes<br>
	Imagen:<br>
	<img src="$destino" title="$titulo_imagen"/>

	<br>Fin del programa
</body>
</html>

fin;

header('Content-Type: text/html; charset=utf-8');
//$salida = ob_end_flush();
print $html;


?>