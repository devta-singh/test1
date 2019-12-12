<?php //Ponle_Nombre.php
/*
Programa que sirve para marcar centros de elipses en una imagen
pide los centros y pinta la imagen con la elipse
Guarda en un fichero de texto la posición de la elipse, el radio y el nombre de la persona
Hay dos modos, el primero va generan el fichero y representa la imagen con las elipses (remarcando las caras de las personas)
Y crea un mapa de imagen para enlazar esa parte de la imagen con un nombre
*/
ini_set("display_errors", 1);
error_reporting(15);

print time();
$imagen_original = "img/IMG_20190203_170753.jpg";
$imagen_original = "img/foto_recortada_r.jpg";

$datos = getimagesize($imagen_original);
list($tamX,$tamY,$otro,$html_img_size)=$datos;
//print "Datos: ";
//print_r($_REQUEST);


//print_r($_REQUEST);

$maxX = 900;
$ratio = $tamX/$maxX;
$maxY = round($tamY/$ratio);

//print "<img src=\"$imagen_original\" width=\"$maxX\" heigth=\"$maxY\">";


$x=0;$y=0;
if(isset($_REQUEST["foto_x"])){
	$x=$_REQUEST["foto_x"]*$ratio;
}
if(isset($_REQUEST["foto_y"])){
	$y=$_REQUEST["foto_y"]*$ratio;
}
$texto_posicion = " Posicion: X: $x, Y: $y";

$im = imagecreatefromjpeg("img/foto_recortada_r.jpg");
//imagestring(image, font, x, y, string, color)



$blanco = imagecolorallocate($im, 255, 255, 255);
$rojo = imagecolorallocate($im, 255, 0, 0);
$negro = imagecolorallocate($im, 0, 0, 0);
//imagearc ( resource $image , int $cx , int $cy , int $width , int $height , int $start , int $end , int $color ) : bool

imagearc($im,$x,$y,20*$ratio,25*$ratio,0,360,$negro);

$imagen_resultante = "img/foto_recortada_r_a.jpg";

imagejpeg($im, $imagen_resultante);
$im = imagecreatefromjpeg($imagen_resultante);
imagestring($im, 5*$ratio, 20*$ratio, 20*$ratio, $texto_posicion, $negro);

$fuente_tam=130;
$fuente_ang=0;
//array imagettftext ( resource $image , float $size , float $angle , int $x , int $y , int $color , string $fontfile , string $text )
imagettftext ($im , $fuente_tam , $fuente_ang , $x*$ratio , $y*$ratio , $negro , "ttf/fuente2.ttf" , $texto_posicion);



imagejpeg($im, $imagen_resultante);

$html =<<<fin
<form action="?" method="post">
<input type="image" name="foto" src="$imagen_resultante" width="$maxX" heigth="$maxY"/>
</form>
fin;
$html.=nl2br(print_r($_REQUEST["foto"],1));

print $html;


?>