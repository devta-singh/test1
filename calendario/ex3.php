<?php //ex3.php

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


$nombres_mes = Explode(",", "Diciembre,Enero,Febrero,Marzo,Abril,Mayo,Junio,Julio,Agosto,Septiembre,Noviembre,Diciembre,Enero");

$nombres_dia = Explode(",", "Domingo,Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo");



//establecemos los datos de los dias del mes
$ano = 2019;
$mes = 12;
$dia = 2;

$timestamp_dia_dado = mktime(0, 0, 0, $mes, $dia, $ano);
list($_dia,$_mes,$_ano, $_diasem, $_numsem, $_numdiaano, $_bisiesto, $_dias_mes)=explode(" ", date("d n Y w W z L t",$timestamp_dia_dado));
$_numsem=round($_numsem);
$tiempo_ultimo_dia = mktime(0, 0, 0, $mes, $_dias_mes, $ano);

$ultima_semana = round(date("W",$tiempo_ultimo_dia));
if(($ultima_semana == 1) && ($mes==12)){
	$ultima_semana = 53;
}
$semanas_del_mes = $ultima_semana - $_numsem + 1;

/*
Dia sem: $_diasem
Sem año: $_numsem
Día año: $_numdiaano
Bisiesto: $_bisiesto
Dias mes: $_dias_mes

*/

$dia_de_la_semana_nombre = $nombres_dia[$_diasem];

$datos_fecha=<<<fin
FECHA
<br>
Año: $_ano
<br>
Mes: $_mes
<br>
Día: $_dia
<br>

<br>
Dia sem: $_diasem
<br>
Sem año: $_numsem
<br>
Día año: $_numdiaano
<br>

<br>
Dia de la semana: $dia_de_la_semana_nombre
<br>


Bisiesto: $_bisiesto
<br>
Dias mes: $_dias_mes
<br>

<br>
1ª sem mes $_mes: $_numsem
<br>
Ult. sem mes $_mes: $ultima_semana
<br>

<br>
Sem mes: $semanas_del_mes
<br>
 
fin;
 print $datos_fecha;
 exit();



$datos_fecha=<<<fin
FECHA
Año: $_ano
Mes: $_mes
Día: $_dia

1ª sem mes $_mes: $_numsem
Ult. sem mes $_mes: $ultima_semana

Sem mes: $semanas_del_mes
 
fin;

//print $datos_fecha;

//$_mes = round($_mes);



$pdf=new PDF_TextBox();
$pdf->AddPage("L");
$pdf->SetFont('Arial','',15);

$margen_izquierdo = 8;
$margen_superior = 5;

$ancho_cabecera = 280;
$alto_cabecera = 10;

$ancho = 40;
$alto = 30;

$posicion_x = $margen_izquierdo;
$posicion_y = $margen_superior;


$_datos_fecha = str_replace("\n", " - ", $datos_fecha);
$_datos_fecha = str_replace("\r", "", $_datos_fecha);
$_datos_fecha = utf8_decode($_datos_fecha);

//pintamos la cabecera
$posicion_x = $margen_izquierdo;
$pdf->SetXY($posicion_x,$posicion_y);
$mes_texto = $nombres_mes[$_mes];
$pdf->SetFont('Arial','',15);
$pdf->drawTextBox($mes_texto." ".$_ano."*** ".$_datos_fecha, $ancho_cabecera, $alto_cabecera, 'C', 'M');





//pintamos las otras semanas
$num_dia_mes=0;
//$num_dia_mes++;
for($semana_num = 0; $semana_num < $semanas_del_mes; $semana_num++){

	print "\n<hr>SEMANA $semana_num";

	//$ancho = 40;
	$posicion_x = $margen_izquierdo;
	$posicion_y = $margen_superior + $alto_cabecera + ($semana_num * $alto);

	$pdf->SetFont('Arial','',22);

	for($dia = 0; $dia<7; $dia++){
		$num_dia = $dia + 1;

		print "\n<br>DIA $dia / 7";
		print "\n$num_dia -> ";
		print "\n$num_dia_mes";

		$_rot_num_dia_mes="*";

		//ahora vemos que pasa con las semanas
		//puedes ser la primera semana
			//en ese caso el primer día del mes puede no ser el primer dia de la semana

		//puede ser una semana intermedia

		//puede ser la última semana
			//solo pintamos hasta el ultimo dia del mes


		//ahora vemos que pasa con las semanas
		
		//puedes ser la primera semana
		if($semana_num <= 1){
			//en ese caso el primer día del mes puede no ser el primer dia de la semana
			if($num_dia > $_diasem){
				//el dia actual es anterior al primer día del mes en esta semana
				$num_dia_mes++;
				print "\n$num_dia_mes";
				$_rot_num_dia_mes="$num_dia";
			}else{
				//ya hemos iniciado
				$_rot_num_dia_mes="PP";	
			}

		}elseif($semana_num >= $semanas_del_mes){
		//puede ser la última semana
			//solo pintamos hasta el ultimo dia del mes
			if($num_dia_mes <= $_num_dias_mes){
				$num_dia_mes++;
				$_rot_num_dia_mes="us";
			}else{

			}

		}else{
			//puede ser una semana intermedia
			$num_dia_mes++;
			$_rot_num_dia_mes="+";
		}

		//$num_dia_mes++;
		//$num_dia_mes++;
/*
		//si es la primera semana
		if($semana_num == 0){
			//si es la primera semana
			if($_diasem >= $num_dia){
				//verificamos que el día que pintamos esté
				//dentro del rango que inicia el primer dia del mes
				if($_diasem <= $num_dia){
					$num_dia_mes = 1;
					$_rot_num_dia_mes = 1;
					$num_dia_mes++;
				}else{
					//$num_dia_mes = "";
					$_rot_num_dia_mes = "";
					$num_dia_mes++;
				}
			}else{
				//				
				$_rot_num_dia_mes = $num_dia_mes;

			}

		}elseif($semana_num <= ($semanas_del_mes - 1)){
			if($num_dia_mes > $_dias_mes ){
				//$num_dia_mes = "";	
				$_rot_num_dia_mes = "";
			}else{
				$num_dia_mes++;
				$_rot_num_dia_mes=$num_dia_mes; 

			}
		}else{
			//$num_dia_mes = "";
			$_rot_num_dia_mes = "";
		}
*/

		//$_diasmes

		$posicion_x = $margen_izquierdo + ($ancho * $dia);
		$pdf->SetXY($posicion_x,$posicion_y);
		$pdf->drawTextBox($_rot_num_dia_mes, $ancho, $alto, 'R', 'T');
	}
}

$pdf->Output();
?>