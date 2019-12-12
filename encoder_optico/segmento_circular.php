<?php //segmento_circular.php

//control de errores
error_reporting(15);
ini_set("display:errors", 1);

$im = imagecreatetruecolor(500,500);
$blanco = imagecolorallocate($im, 255,255,255);
$negro = imagecolorallocate($im, 0, 0, 0);

//bool imagefilledarc ( resource $image , int $cx , int $cy , int $width , int $height , int $start , int $end , int $color , int $style )
//Draws a partial arc centered at the

imagefill($im, 1, 1, $blanco);

$cx = 250;
$cy = 250;
$ancho= 200;$ancho2= 180;
$alto=200;$alto2=180;
$inicio=0;
$fin=90;

//imagefilledarc ($im, $cx, $cy, $ancho, $alto, $inicio, $fin, $negro, IMG_ARC_PIE);
imagefilledarc ($im, $cx, $cy, $ancho, $alto, $inicio, $fin, $negro, IMG_ARC_EDGED);
imagefilledarc ($im, $cx, $cy, $ancho2, $alto2, $inicio, $fin, $blanco, IMG_ARC_EDGED);
/*
IMG_ARC_PIE
IMG_ARC_CHORD
IMG_ARC_NOFILL
IMG_ARC_EDGED
IMG_ARC_PIE and IMG_ARC_CHORD are mutually exclusive; IMG_ARC_CHORD just connects the starting and ending angles with a straight line, while IMG_ARC_PIE produces a rounded edge. IMG_ARC_NOFILL indicates that the arc or chord should be outlined, not filled. IMG_ARC_EDGED, used together with IMG_ARC_NOFILL, indicates that the beginning and ending angles should be connected to the center - this is a good way to outline (rather than fill) a 'pie slice'.
*/


imagepng($im, "img/arco.png");

print <<<fin
<html>
<body>
Arco
<img src="img/arco.png">

</body>
</html>
fin;

?>