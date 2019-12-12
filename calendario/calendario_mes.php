<?php //toolbox/calendario/calendario_mes.php
ini_set("display_errors",1);
error_reporting(15);
require_once("moonphase.php");

function rescale($ab, $cd)
{
    list($a, $b) = $ab;
    list($c, $d) = $cd;
    if($a == $b)
    {
        trigger_error("Invalid scale", E_USER_WARNING);
        return false;
    }
    $o = ($b * $c - $a * $d) / ($b - $a);
    $s = ($d - $c) / ($b - $a);
    return function($x)use($o, $s)
    {
        return $s * $x + $o;
    };
}

$fahr2celsius = rescale([32, 212], [0, 100]);
$fase2mifase = rescale([0, 1], [0, 7]);

//echo  $fahr2celsius(98.6); // 37°C

print <<<fin
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Calendario del mes</title>
</head>
<body>
fin;

/*
next_new_moon(): the time of the next New Moon (UNIX timestamp).
full_moon(): the time of the Full Moon in the current lunar cycle (UNIX timestamp).
next_full_moon(): the time of the next Full Moon in the current lunar cycle (UNIX timestamp).
first_quarter(): the time of the first quarter in the current lunar cycle (UNIX timestamp).
next_first_quarter(): the time of the next first quarter in the current lunar cycle (UNIX timestamp).
last_quarter(): the time of the last quarter in the current lunar cycle (UNIX timestamp).
next_last_quarter(): the time of the next last quarter in the current lunar cycle (UNIX timestamp).
phase_name()
*/




$rotulos_dias = array(
	0=>"D",
	1=>"L",
	2=>"M",
	3=>"X",
	4=>"J",
	5=>"V",
	6=>"S",
	7=>"D",
	8=>"L"

);

$meses = array(
	0=>"Diciembre",
	1=>"Enero",
	2=>"Febrero",
	3=>"Marzo",
	4=>"Abril",
	5=>"Mayo",
	6=>"Junio",
	7=>"Julio",
	8=>"Agosto",
	9=>"Septiembre",
	10=>"Octubre",
	11=>"Noviembre",
	12=>"Diciembre",
	13=>"Enero"
);

$mes = 2;
$ano = 2017;
$time_dia1 = mktime(0,0,0,$mes, 1, $ano);

$luna = new Solaris\MoonPhase($time_dia1);

$fase = $luna->phase($time_dia1);
//$mifase = rescale([0, 1], [0, 7]);
$mifase = round($fase2mifase($fase));
$img_luna = array();
$img_luna[0]="img/0.jpg";
$img_luna[1]="img/1.jpg";
$img_luna[2]="img/2.jpg";
$img_luna[3]="img/3.jpg";
$img_luna[4]="img/4.jpg";
$img_luna[5]="img/5.jpg";
$img_luna[6]="img/6.jpg";
$img_luna[7]="img/7.jpg";

$mifase = round($fase2mifase($fase));


$ant_luna_nueva = $luna->new_moon()."<br>";
$ant_luna_creciente = $luna->first_quarter()."<br>";
$ant_luna_llena = $luna->full_moon()."<br>";
$ant_luna_menguante = $luna->last_quarter()."<br>";

$_ant_luna_nueva = date("Y-m-d H:i:s", round($ant_luna_nueva));
$_ant_luna_creciente = date("Y-m-d H:i:s", round($ant_luna_creciente));
$_ant_luna_llena = date("Y-m-d H:i:s", round($ant_luna_llena));
$_ant_luna_menguante = date("Y-m-d H:i:s", round($ant_luna_menguante));

$__ant_luna_nueva = date("Y-m-d", round($ant_luna_nueva));list($l_ano, $l_a_mes, $dia_ant_luna_nueva) = explode("-", $__ant_luna_nueva); 
$__ant_luna_creciente = date("Y-m-d", round($ant_luna_creciente));list($l_ano, $l_a_mes, $dia_ant_luna_creciente) = explode("-", $__ant_luna_creciente);
$__ant_luna_llena = date("Y-m-d", round($ant_luna_llena));list($l_ano, $l_a_mes, $dia_ant_luna_llena) = explode("-", $__ant_luna_llena);
$__ant_luna_menguante = date("Y-m-d", round($ant_luna_menguante));list($l_ano, $l_a_mes, $dia_ant_luna_menguante) = explode("-", $__ant_luna_menguante);

$luna_nueva = $luna->next_new_moon()."<br>";
$luna_creciente = $luna->next_first_quarter()."<br>";
$luna_llena = $luna->next_full_moon()."<br>";
$luna_menguante = $luna->next_last_quarter()."<br>";

$_luna_nueva = date("Y-m-d H:i:s", round($luna_nueva));
$_luna_creciente = date("Y-m-d H:i:s", round($luna_creciente));
$_luna_llena = date("Y-m-d H:i:s", round($luna_llena));
$_luna_menguante = date("Y-m-d H:i:s", round($luna_menguante));

$__luna_nueva = date("Y-m-d", round($luna_nueva));list($l_ano, $l_mes, $dia_luna_nueva) = explode("-", $__luna_nueva); 
$__luna_creciente = date("Y-m-d", round($luna_creciente));list($l_ano, $l_mes, $dia_luna_creciente) = explode("-", $__luna_creciente); 
$__luna_llena = date("Y-m-d", round($luna_llena));list($l_ano, $l_mes, $dia_luna_llena) = explode("-", $__luna_llena); 
$__luna_menguante = date("Y-m-d", round($luna_menguante));list($l_ano, $l_mes, $dia_luna_menguante) = explode("-", $__luna_menguante); 

print <<<fin
Phase: $fase / $mifase<br>
<br>Anterior<br>
Luna nueva: $ant_luna_nueva / $_ant_luna_nueva<br>
Luna creciente: $ant_luna_creciente / $_ant_luna_creciente<br>
Luna llena: $ant_luna_llena / $_ant_luna_llena<br>
Luna menguante: $ant_luna_menguante / $_ant_luna_menguante<br>
<br>Siguiente:<br>
Luna nueva: $luna_nueva / $_luna_nueva<br>
Luna creciente: $luna_creciente / $_luna_creciente<br>
Luna llena: $luna_llena / $_luna_llena<br>
Luna menguante: $luna_menguante / $_luna_menguante<br>

fin;



$nombre_mes = $meses[$mes];
$dia_mes = 0;
$casilla = 0;
$dia_semana_inicial = 4;
$dia_mes_final = 28;

print "<table style=\"border:1px solid black;padding:3px;margin:5px;\">";
print "<tr>";
	print "<th colspan=\"8\">";
		print "<span style=\"font-size:45px;\">$nombre_mes</span>";
	print "</th>";
print "</tr>";
print "<tr>";
	for($dia_semana = 0; $dia_semana <= 7; $dia_semana++){
		if($dia_semana == 0){
			print "<th>";
			print "";
			print "</th>";
		}else{
			print "<th>";
			print $rotulos_dias[$dia_semana];
			print "</th>";
		}
	}
print "</tr>";	

for($semanas = 1; $semanas <= 5; $semanas++){
	print "<tr>";
	for($dia_semana = 0; $dia_semana <= 7; $dia_semana++){
		
		if($dia_semana == 0){
			print "<td style=\"border:1px solid black;padding:3px;margin:5px;\">";
			print "$semanas";
			print "</td>";
		}else{
			$casilla++;
			if($semanas==1){
				if($dia_semana >= $dia_semana_inicial){
					$dia_mes++;
				}
			}else{
				$dia_mes++;
			}
			
			print "<td style=\"border:1px solid black;padding:3px;margin:5px;vertical-align:top;\">";
			print "<div style=\"float:left;z-index:10;\">$casilla</div>";

			$con_fase_lunar=0;
			//luna_nueva
			if((($dia_mes == $dia_ant_luna_nueva) AND ($l_a_mes == $mes))){
				$imagen=$img_luna[0];
				$con_fase_lunar=1;
			}elseif((($dia_mes == $dia_ant_luna_creciente) AND ($l_a_mes == $mes)) ){
				$imagen=$img_luna[2];
				$con_fase_lunar=1;
			}elseif((($dia_mes == $dia_ant_luna_llena) AND ($l_a_mes == $mes)) ){
				$imagen=$img_luna[4];
				$con_fase_lunar=1;
			}elseif((($dia_mes == $dia_ant_luna_menguante) AND ($l_a_mes == $mes)) ){
				$imagen=$img_luna[6];
				$con_fase_lunar=1;
			}

			if($con_fase_lunar){
				print "<div style=\"float:right;z-index:1;\"><img src=\"$imagen\"/></div>";
			}


			

			if(
				($semanas==1 AND ($dia_semana >= $dia_semana_inicial))
				OR (($dia_mes <= $dia_mes_final) AND ($dia_mes >= 1))
			)
			{
				print "<div style=\"float:right;z-index:5;\"><span style=\"font-size:75px;\">$dia_mes</span></div>";
			}
			//print "$casilla";
			print "</td>";
		}
	}
	print "</tr>";	
}
print "</table>";

print <<<fin
</body>
</html>
fin;

?>