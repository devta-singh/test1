<?php //ex.php

error_reporting(15);
ini_set("display_errors",1);

require('./inc/fpdf/fpdf.php');

//require('textbox.php');
require('./inc/fpdf/extras/textbox.php');


$pdf=new PDF_TextBox();
$pdf->AddPage();
$pdf->SetFont('Arial','',15);
$pdf->SetXY(80,35);
$pdf->drawTextBox('This sentence is centered in the middle of the box.', 50, 50, 'C', 'M');
$pdf->Output();
?>
