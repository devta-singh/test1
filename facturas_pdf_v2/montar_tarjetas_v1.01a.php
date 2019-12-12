<?php //montar_tarjetas_v1.01a.php
ini_set("display_errors", 1);
error_reporting(15);

$ahora=time()+microtime();
$fecha=date("Y-m-d H:i:s", $ahora);
$ip = $_SERVER["REMOTE_ADDR"];
$nav = $_SERVER["HTTP_USER_AGENT"];
$imagen_indicada = $_REQUEST["imagen"];
//$imagen = "imagenes/madrid-1516930809.png";
$imagen = "imagenes/$imagen_indicada";

//$imagen = "imagenes/Tarjeta_MDC_para_personalizar.png";
//$imagen = "imagenes/caja.jpeg";

require('inc/fpdf/fpdf.php');

$unit="mm";
//$pdf = new FPDF();
//$pdf = new FPDF('P','mm',array(100,150));
//$pdf = new FPDF('P','mm',array(210,297));

$pdf = new FPDF('P',$unit,'A4');
//$pdf->k=2.84;

/*
//esto solo puede ir en el constructor
if($unit=='pt'){
    $pdf->k=1;
}elseif($unit=='mm'){
    $pdf->k=72/25.4;
}elseif($unit=='cm'){
    $pdf->k=72/2.54;
}elseif($unit=='in'){
    $pdf->k=72;
}else{
    $pdf->Error('Incorrect unit: '.$unit);
}
*/

$title = "Montaje $imagen - $ahora - $ip -$nav - CirculoDeSanacion.Org";
$pdf->SetTitle($title);
$pdf->SetAuthor("Devta Singh para Medicos del Cielo");

$pdf->AddPage();
$pdf->SetFont('Arial','B',8);


$pdf->Cell(0,5,"$imagen - $fecha ($ahora) - IP: $ip - CirculoDeSanacion.Org", 0, 2);
$pdf->Cell(0,7,"$nav");


$y=0;
/*
$y+=10;
$pdf->Cell(10,$y,"IP: $ip");
$y+=10;
$pdf->Cell(10,$y,"nav: $nav");
//$y+=10;
//Image(string file, x,y,w,h
*/
//cargamos la imagen
$y=20;

//$ancho = round(95/2.83);
$ancho = 95;

$pdf->Image($imagen,10,$y,$ancho);
$pdf->Image($imagen,105,$y,$ancho);

$y+=65;
$pdf->Image($imagen,10,$y,$ancho);
$pdf->Image($imagen,105,$y,$ancho);

$y+=65;
$pdf->Image($imagen,10,$y,$ancho);
$pdf->Image($imagen,105,$y,$ancho);

$y+=65;
$pdf->Image($imagen,10,$y,$ancho);
$pdf->Image($imagen,105,$y,$ancho);

/*

$pdf->Image($imagen,10,$y,95,65);
$pdf->Image($imagen,105,$y,95,65);

$y+=65;
$pdf->Image($imagen,10,$y,95,65);
$pdf->Image($imagen,105,$y,95,65);

$y+=65;
$pdf->Image($imagen,10,$y,95,65);
$pdf->Image($imagen,105,$y,95,65);

$y+=65;
$pdf->Image($imagen,10,$y,95,65);
$pdf->Image($imagen,105,$y,95,65);

*/
//$pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 33,78);
//$pdf->Cell( 40, 40, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 33,78), 0, 0, 'L', false );



//Salida
$pdf->Output();
?>
