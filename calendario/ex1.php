<?php //ex1.php

error_reporting(15);
ini_set("display_errors",1);

//print "ex1.php";

///Applications/MAMP/htdocs/toolbox/calendario
//require('inc/fpdf/fpdf.php');
require_once('/Applications/MAMP/htdocs/toolbox/calendario/inc/fpdf/fpdf.php');

/*
$carpeta="/Applications/MAMP/htdocs/toolbox/calendario/inc/fpdf/extras";
$d=opendir($carpeta);
if($d){
	print "Contenido de la carpeta: $carpeta<br>";
	while($f = readdir($d)){
		print "$f<br>";

	}
}else{
	print "No existe esa carpeta: $carpeta";
}
*/

//require('textbox.php');
require_once('/Applications/MAMP/htdocs/toolbox/calendario/inc/fpdf/extras/textbox.php');


$pdf=new PDF_TextBox();
$pdf->AddPage();
$pdf->SetFont('Arial','',15);
$pdf->SetXY(80,35);
$pdf->drawTextBox('This sentence is centered in the middle of the box.', 50, 50, 'C', 'T');
$pdf->Output();
?>
