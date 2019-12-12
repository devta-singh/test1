<?php
$ano = 2019;
$mes = 12;
$dia = 31;

$tiempo_actual = mktime(0, 0, 0, $mes, $dia, $ano);
$_numsem=round(date("W",$tiempo_actual));
if(($_numsem == "01" ) && ($mes==12)){
	$_numsem = 53;
}

print "$ano-$mes-$dia Semana $_numsem";

?>