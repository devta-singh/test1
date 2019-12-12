<?php //ex2.php

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





//establecemos los datos de los dias del mes
$ano = 2019;
$mes = 5;
$dia = 1;

$tiempo_actual = mktime(0, 0, 0, $mes, $dia, $ano);
list($_dia,$_mes,$_ano, $_diasem, $_numsem, $_numdiaano, $_bisiesto)=explode(" ", date("d m Y w W z L",$tiempo_actual));

$datos_fecha=<<<fin

La fecha actual:
Año: $_ano
Mes: $_mes
Día: $_dia
Dia de la semana: $_diasem
Semana del año: $_numsem
Día del año: $_numdiaano
Es Bisiesto: $_bisiesto
fin;



$pdf=new PDF_TextBox();
$pdf->AddPage("L");
$pdf->SetFont('Arial','',15);

$ancho = 40;
$alto = 40;
$margen_izquierdo = 8;
$margen_superior = 25;

$posicion_x = $margen_izquierdo;
$posicion_y = $margen_superior;

for($semana=0; $semana <= 5; $semana++){
	//$ancho = 40;
	$posicion_y = $margen_superior + ($semana * 40);

	$pdf->SetXY($posicion_x, $posicion_y);
	$pdf->drawTextBox('1', $ancho, $alto, 'C', 'T');

	$posicion_x += $ancho;
	$pdf->SetXY($posicion_x,$posicion_y);
	$pdf->drawTextBox('2', $ancho, $alto, 'C', 'T');

	$posicion_x += $ancho;
	$pdf->SetXY($posicion_x,$posicion_y);
	$pdf->drawTextBox('3', $ancho, $alto, 'C', 'T');

	$posicion_x += $ancho;
	$pdf->SetXY($posicion_x,$posicion_y);
	$pdf->drawTextBox('4', $ancho, $alto, 'C', 'T');

	$posicion_x += $ancho;
	$pdf->SetXY($posicion_x,$posicion_y);
	$pdf->drawTextBox('5', $ancho, $alto, 'C', 'T');

	$posicion_x += $ancho;
	$pdf->SetXY($posicion_x,$posicion_y);
	$pdf->drawTextBox('6', $ancho, $alto, 'C', 'T');

	$posicion_x += $ancho;
	$pdf->SetXY($posicion_x,$posicion_y);
	$pdf->drawTextBox('7', $ancho, $alto, 'C', 'T');
}

$pdf->Output();
?>
