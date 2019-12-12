<?php //encoder_linear.php

/*
Esta aplicación pinta en un rectángulo
una seria de barras negras y blancas, en filas
para estimular los sensores opticos de un decodificador de posicion
el resultado de este fichero es un fichero grafico para imprimir como plantilla
para el decodificador.
Este encoder codifica la posición del cursor en varios campos binarios
que son el resultado de la lectura de los sensores.
Con los que se puede determinar la posicion del cursor o del aparato en relacion
al código grafico impreso aquí.
De esta forma, imprimiendo el encoder en una impresora laser sobre un acetato transparente, se puede usar como elemento escala para unsistema de sensores opticos.
y obtener un valor numérico de posición.
Esto en un encoder linear sería para una longitud,
y en un encoder angular o circular, sería para un ángulo.
*/

/*
©Devta Singh
Devta Singh Khalsa
devtas@gmail.com
2019
version 0.1a alpha
*/

//control de errores
error_reporting(15);
ini_set("display:errors", 1);

//iniciamos la captura de la salida
ob_start();

//Variables generales del sitio
$titulo = "encoder optico linear";
$version = "0.1a alpha";
$descripcion = "encoder optico linear";
$autor = "Devta Singh Khalsa";
$contacto = "devtas@gmail.com";
$fecha = date("Y-m-a H:i:s");

//creamos la imagen
$px_ancho=500;
$px_alto=200;

//creamos la imagen con esas dimensiones en pixels
$im=imagecreate($pc_ancho,$px_alto);
$titulo_imagen = "Encoder optico de $px_ancho pixeles";


//creamos los colores
//el primer color en usar es asignado al fondo

$blanco = imagecolorset($im, 0, 255, 255, 255);
$negro = imagecolorset($im, 1, 0, 0, 0);

//pintamos el marco de la imagen (borde)
imageline($im, 0,0, $px_ancho, 0, $negro);
imageline($im, $px_ancho,0, $px_ancho, $px_alto, $negro);
imageline($im, $px_ancho, $px_alto, 0, $px_alto, $negro);
imageline($im, 0, $px_alto, 0, 0, $negro);

//establecemos el numero de sensores
$num_sensores = 4;
$titulo_imagen.= " y $n_sensores sensores";
//obtenemos la resolucion máxima por el número de sensores
$resolucion = $px_ancho / (pow(2,$num_sensores));
$pixels = $px_ancho;

$pixels_sensor=array();
$divisiones_sensor=array();
$texto_divisiones="";
//recorremos los sensores
for($n_sensor=1;$n_sensor<=$num_sensores;$n_sensor++){
	//para el sensor n vamos a crear el número de pixels por división
	//son divisiones binarias
	//cada sensor tiene 2^n_sensor divisiones
	$n_divisiones = pow(2,$n_sensor);
	//print "<br>Sensor: $n_sensor, ";
	//print "Divisiones: $n_divisiones";
	$n_pixels = $px_ancho / $n_divisiones;
	$texto_divisiones.="\n<br>Sensor $n_sensor - $n_divisiones divisiones - cada $n_pixels pixels";
	$divisiones_sensor[$n_sensor]=$n_divisiones;
}
//print $texto_divisiones;

print "<br><br>El encoder tiene $pc_ancho pixeles de recorrido máximo 
	<br>La resolución máxima del sistema es de $resolucion pixeles 
	<br>cada $resolucion pixeles, se puede contar un dato, o un paso.
	<br><br>Para $num_sensores sensores \n<br>$texto_divisiones";


//con estas divisiones pintamos el encoder

//ahora generamos la imagen en un fichero

//creamos el nombre en el que se va a guardar
$ahora = $microtime();
$destino = "img/encoder_".$ahora.".png";
imagepng($im, $destino);

print $destino;


//finalizamos la captura de la salida
//$mensajes = ob_end_flush();
$mensajes = ob_get_contents();

//creamos el HTML con la llamada a la imagen en HTML
$html=<<<fin
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>$titulo - $version - $fecha</title>
</head>
<body>
	<h1>$titulo</h1>
	<h2></h2>
	<dl>
		<dt>Autor</dt>
		<dd>$autor</dd>

		<dt>Contacto</dt>
		<dd>$contacto</dd>

		<dt>Fecha</dt>
		<dd>$fecha</dd>				

		<dt>Titulo</dt>
		<dd>$titulo</dd>

		<dt>Version</dt>
		<dd>$version</dd>

		<dt>Fecha</dt>
		<dd>$fecha</dd>

		<dt>Descripcion</dt>
		<dd>$descripcion</dd>				
	</dl>
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
print $html;

?>