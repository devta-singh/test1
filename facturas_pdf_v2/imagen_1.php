<?php
ini_set("display_errors", 1);
error_reporting(15);

$ahora=time()+microtime();
$fecha=date("Y-m-d H:i:s", $ahora);
$ip = $_SERVER["REMOTE_ADDR"];
$nav = $_SERVER["HTTP_USER_AGENT"];
$imagen = "imagenes/madrid-1516930809.png";
//$imagen = "imagenes/Tarjeta_MDC_para_personalizar.png";
//$imagen = "imagenes/caja.jpeg";

require('../fpdf.php');

$pdf = new FPDF();

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
//$pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 33,78);
//$pdf->Cell( 40, 40, $pdf->Image($image1, $pdf->GetX(), $pdf->GetY(), 33,78), 0, 0, 'L', false );



//Salida
$pdf->Output();
?>
