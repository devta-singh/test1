<?php //test.php

error_reporting(15);
ini_set("display_errors",1);

require('inc/fpdf/fpdf.php');


/*
Tablas
Este tutorial se explicará como crear tablas fácilmente.
*/

class PDF extends FPDF
{
    // Cargar los datos
    function LoadData($file)
    {
        // Leer las líneas del fichero
        $lines = file($file);
        $data = array();
        foreach($lines as $line)
            $data[] = explode(';',trim($line));
        return $data;
    }

    // Tabla simple
    function BasicTable($header, $data)
    {
        // Cabecera
        foreach($header as $col)
            $this->Cell(40,7,$col,1);
        $this->Ln();
        // Datos
        foreach($data as $row)
        {
            foreach($row as $col)
                $this->Cell(40,6,$col,1);
            $this->Ln();
        }
    }

    // Una tabla más completa
    function TablaMes($header, $data)
    {
        // Anchuras de las columnas
        $w = array(40, 40, 40, 40, 40, 40, 40);
        $h = 60;
        // Cabeceras
        for($i=0;$i<count($header);$i++){
            $this->Cell($w[$i],9,$header[$i],1,0,'C');
        }
        $this->Ln();
        // Datos
        foreach($data as $row)
        {
            //$this->Cell($w[0],6,$row[0],'R');
            //$this->Cell($w[1],6,$row[1],'R');
            $this->SetFont('Arial','',44);
            //Cell(float w [, float h [, string txt [, mixed border [, int ln [, string align [, boolean fill [, mixed link]]]]]]])

            $this->Cell($w[0],$h,number_format($row[0]),'LRBT',0,'R');
            $this->Cell($w[1],$h,number_format($row[1]),'LRBT',0,'R');
            $this->Cell($w[2],$h,number_format($row[2]),'LRBT',0,'R');
            $this->Cell($w[3],$h,number_format($row[3]),'LRBT',0,'R');
            $this->Cell($w[3],$h,number_format($row[4]),'LRBT',0,'R');
            $this->Cell($w[3],$h,number_format($row[5]),'LRBT',0,'R');
            $this->Cell($w[3],$h,number_format($row[6]),'LRBT',0,'R');
            $this->Ln();
        }
        // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
    }

    // Tabla coloreada
    function FancyTable($header, $data)
    {
        // Colores, ancho de línea y fuente en negrita
        $this->SetFillColor(255,0,0);
        $this->SetTextColor(255);
        $this->SetDrawColor(128,0,0);
        $this->SetLineWidth(.3);
        $this->SetFont('','B');
        // Cabecera
        $w = array(40, 35, 45, 40);
        for($i=0;$i<count($header);$i++)
            $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
        $this->Ln();
        // Restauración de colores y fuentes
        $this->SetFillColor(224,235,255);
        $this->SetTextColor(0);
        $this->SetFont('');
        // Datos
        $fill = false;
        foreach($data as $row)
        {

            $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
            $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
            $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
            $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
            $this->Ln();
            $fill = !$fill;
        }
        // Línea de cierre
        $this->Cell(array_sum($w),0,'','T');
    }
}

//genero la cabecera
$cabecera = explode(",", "Lunes,Martes,Miercoles,Jueves,Viernes,Sábado,Domingo");

//genero los datos
$datos = array(
    array(1,2,3,4,5,6,7),//semana1
    array(8,9,10,11,12,13,14),//semana2
    array(15,16,17,18,19,20,21),//semana3
    array(22,23,24,25,26,27,28),//semana4
    array(29,30,31, null, null , null, null)//semana5
);

//Usamos la clase
$miPDF = new PDF('L');
$miPDF->SetFont('Arial','',14);
$miPDF->AddPage();
//$miPDF->ImprovedTable($cabecera, $datos);
$miPDF->TablaMes($cabecera, $datos);
$miPDF->Output();


?>