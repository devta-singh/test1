<?php //primero.php
//require('../fpdf.php');

// //$pdf = new FPDF();//original, funciona
// //$pdf=new FPDF(‘L’,’cm’,’Legal’);//ejemplo de por ahí
// //$pdf=new FPDF(‘P’,’cm’,’A4’);
// $pdf = new PDF('P','mm',array(210,297));
// $pdf->AddPage('P', 'A4'); 

// //$pdf->AddPage();
// $pdf->SetFont('Arial','B',16);
// $pdf->Cell(40,10,'¡Hola, Mundo!');
// $pdf->Output();

require('../fpdf.php');

$pdf = new FPDF('P','mm','A4');

$pdf->SetFont('Arial','B',16);
//$pdf->Cell(40,10,'Hello World!');

//$this->Image('logo.jpg',10,8,22);

// $pdf->AddPage();
// $pdf->Image('img/Inscripcion_p01.jpeg',10,8,190);

// $pdf->AddPage();
// $pdf->Image('img/Inscripcion_p02.jpeg',10,8,190);

// $pdf->AddPage();
// $pdf->Image('img/estatutos_p01.jpeg',10,8,190);

// $pdf->AddPage();
// $pdf->Image('img/estatutos_p02.jpeg',10,8,190);

// $pdf->AddPage();
// $pdf->Image('img/estatutos_p03.jpeg',10,8,190);

// $pdf->AddPage();
// $pdf->Image('img/estatutos_p04.jpeg',10,8,190);

// $pdf->AddPage();
// $pdf->Image('img/estatutos_p05.jpeg',10,8,190);

// $pdf->AddPage();
// $pdf->Image('img/estatutos_p06.jpeg',10,8,190);

$pdf->AddPage();
$pdf->Image('img/Acta_fundacional_p01.jpeg',10,8,190);

$pdf->Cell(40,10,utf8_decode("¡Hola, Mundo!"));
$pdf->Cell(50,10,'¡Hola, Mundo2!');

$pdf->AddPage();
$pdf->Image('img/Acta_fundacional_p02.jpeg',10,8,190);


$pdf->Output();
?>