<?php //encoder_linear_v1.01beta.php

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
2019-11-09
version 1.01 beta

Cambios:
hacer que pinte las bandas de colores blanco y negro de cada sensor. 
Pero bien hecho
*/

//control de errores
error_reporting(15);
ini_set("display:errors", 1);

//Depuración
//define("_d", true);//imprime codigos debug
define("_d", false);//no imprime codigos debug

//iniciamos la captura de la salida
//ob_start();




$_lineas = 1;
$chk_lineas = "checked";

$_sectores = 1;
$chk_sectores = "checked";

$_marco = 1;
$chk_marco = "checked";

$_relleno = 1;
$chk_relleno = "checked";



if(isset($_REQUEST["_num_sensores"])){
	$_num_sensores = $_REQUEST["_num_sensores"];
}

if(isset($_REQUEST["_num_porciones"])){
	$_num_porciones = $_REQUEST["_num_porciones"];
}


if(isset($_REQUEST["_ancho"])){
	$_ancho = $_REQUEST["_ancho"];
}


if(isset($_REQUEST["_alto"])){
	$_alto = $_REQUEST["_alto"];
}


if(isset($_REQUEST["_lineas"])){
	$_lineas = $_REQUEST["_lineas"];
	$chk_lineas = "checked";
}else{
	//$_lineas = 0;
	$chk_lineas = "";
}


if(isset($_REQUEST["_sectores"])){
	$_sectores = $_REQUEST["_sectores"];
	$chk_sectores = "checked";
}else{
	//$_sectores = 0;
	$chk_sectores = "";
}


if(isset($_REQUEST["_marco"])){
	$_marco = $_REQUEST["_marco"];
	$chk_marco = "checked";
}else{
	//$_marco = 0;
	$chk_marco = "";
}

if(isset($_REQUEST["_relleno"])){
	$_relleno = $_REQUEST["_relleno"];
	$chk_relleno = "checked";
}else{
	//$_relleno = 0;
	$chk_relleno = "";
}


//Variables generales del sitio
$titulo = "encoder optico linear";
$version = "1.01 beta";
$descripcion = "encoder optico linear";
$autor = "Devta Singh Khalsa";
$contacto = "devtas@gmail.com";
$fecha = date("Y-m-a H:i:s");


//establecemos los atributos básicos
$num_sensores = 4;//el numero de sensores
$px_ancho=500;//el ancho
$px_alto=200;//el alto

if(isset($_num_sensores)){
	$num_sensores = $_num_sensores;//el numero de sensores
}else{
	$_num_sensores = $num_sensores = 4;//el numero de sensores
}

if(isset($_ancho)){
	$px_ancho=$_ancho;//el ancho
}else{
	$_ancho=$px_ancho=500;//el ancho	
}

if(isset($_alto)){
	$px_alto=$_alto;//el alto
}else{
	$_alto=$px_alto=200;//el alto	
}

$margen=20;

$margen_ar = $margen;
$margen_ab = $margen;
$margen_iz = $margen;
$margen_dc = $margen;

$px_x_min = $margen_iz;
$px_x_max = ($px_ancho - 1) - $margen_dc;

$px_y_min = $margen_ar;
$px_y_max = ($px_alto - 1) - $margen_ab;

$rango_x = $px_x_max - $px_x_min;
$rango_y = $px_y_max - $px_y_min;


//creamos la imagen
//creamos la imagen con esas dimensiones en pixels
$im=imagecreatetruecolor($px_ancho,$px_alto);


$titulo_imagen = "Encoder optico de $px_ancho pixeles";


//creamos los colores
//el primer color en usar es asignado al fondo
$negro = imagecolorallocate($im, 0, 0, 0);
$blanco = imagecolorallocate($im, 255, 255, 255);
$rojo = imagecolorallocate($im, 255, 0, 0);
$verde = imagecolorallocate($im, 0, 255, 0);
$azul = imagecolorallocate($im, 0, 0, 255);


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

$titulo_imagen.= " y $n_sensores sensores";
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
}

for($n_sensor=1;$n_sensor<=$num_sensores;$n_sensor++){
	//para el sensor n vamos a crear el número de pixels por división
	//son divisiones binarias
	//cada sensor tiene 2^n_sensor divisiones
	$n_divisiones = pow(2,$n_sensor);

	$ancho_porcion = $px_ancho / $n_divisiones;
	

	if(_d){
	print <<<fin
	Sensor $n_sensor, $n_divisiones divisiones, ancho de la division $ancho_porcion px alto $alto_porcion px\n<br>

fin;
}

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
		$x1 =  (($n_porcion - 1) * $ancho_porcion);
		$x2 =  ($n_porcion * $ancho_porcion);

		$y1 =  (($n_sensor - 1) * $alto_porcion);
		$y2 =  ($n_sensor * $alto_porcion);

		
		//pintamos la linea
		//print "linea: ($im, $x1, $y1, $x2, $y2, $color_porcion)";
		//
		

		if($_sectores){
			imagefilledrectangle($im, $x1, $y1, $x2, $y2, $color_porcion);
		}

		if($_lineas){
			imageline($im, $x1, $y1, $x2, $y1, $rojo);	
		}
				
	}//fin for porcion

}//fin for sensor

//print $texto_divisiones;
$mensajes="";
$mensajes.="<br><br>El encoder tiene $pc_ancho pixeles de recorrido máximo 
	<br>La resolución máxima del sistema es de $resolucion pixeles 
	<br>cada $resolucion pixeles, se puede contar un dato, o un paso.
	<br><br>Para $num_sensores sensores \n<br>$texto_divisiones";


//con estas divisiones pintamos el encoder

//ahora generamos la imagen en un fichero

//creamos el nombre en el que se va a guardar
$ahora = microtime();
$destino = "img/encoder_".$ahora.".png";


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
	<dl id="info_basica">
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

	<form action="?" method="post">
		num_sensores:<input type="text" name="_num_sensores" value="$_num_sensores">
		<br>ancho:<input type="text" name="_ancho" value="$_ancho">
		<br>alto:<input type="text" name="_alto" value="$_alto">

		<br><input type="checkbox" name="_lineas" $chk_lineas"> pintar lineas
		<br><input type="checkbox" name="_sectores" $chk_sectores"> pintar sectores

		<br><input type="checkbox" name="_marco" $chk_marco"> pintar marco
		<br><input type="checkbox" name="_relleno" $chk_relleno"> pintar relleno

		<br><input type="submit" value="generar">
	</form>

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