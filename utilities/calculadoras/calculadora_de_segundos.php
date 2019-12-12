<?php //calculadora_de_segundos.php
//calculadora de segundos
//https://www.youtube.com/watch?v=yLIPbjPuZpY
//31:59
//Miguel Ballester
//Fairphone.com

/*
$hora = 0;
$minuto = 0;
$segundo = 0;
$dia = 0;
$mes = 0;
$ano = 0;
$eon = 0;
$mensaje = 0;
*/

if(isset($_REQUEST["hora"])){$hora = $_REQUEST["hora"];}else{$hora="0";}
if(isset($_REQUEST["minuto"])){$minuto = $_REQUEST["minuto"];}else{$minuto="0";}
if(isset($_REQUEST["segundo"])){$segundo = $_REQUEST["segundo"];}else{$segundo="0";}
if(isset($_REQUEST["dia"])){$dia = $_REQUEST["dia"];}else{$dia="0";}
if(isset($_REQUEST["mes"])){$mes = $_REQUEST["mes"];}else{$mes="0";}
if(isset($_REQUEST["ano"])){$ano = $_REQUEST["ano"];}else{$ano="0";}
if(isset($_REQUEST["eon"])){$eon = $_REQUEST["eon"];}else{$eon="0";}

//if(isset($_REQUEST["hora"])){$hora = $_REQUEST["hora"];}else{$hora="0";}
//if(isset($_REQUEST["hora"])){$hora = $_REQUEST["hora"];}else{$hora="0";}

$segundos = ($eon * 1000000000 * 365 * 86400) + ($ano * 365 * 86400) + ($mes * 30 * 86400) + ($dia * 86400) + ($hora * 3600) + ($minuto * 60) + $segundo;

$mensaje =<<<fin
El calculo de segundos es: $segundos
<br>para $eon eons 
<br>para $ano anos
<br>para $mes mess
<br>para $dia dias
<br>para $hora horas
<br>para $minuto minutos
<br>para $segundo segundos
fin;


//creamos el html del formulario
$html =<<<fin
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form>
		Introduzca el número de unidades a calcular para obtener en segundos
		<br>#mensaje#
		<br>
		hora: <input type="text" name="hora" value="#hora#"/>
		<br>minuto: <input type="text" name="minuto" value="#minuto#"/>
		<br>segundo: <input type="text" name="segundo" value="#segundo#"/>
		<br>dia: <input type="text" name="dia" value="#dia#"/>
		<br>mes: <input type="text" name="mes" value="#mes#"/>
		<br>ano: <input type="text" name="ano" value="#ano#"/>
		<br>eon: <input type="text" name="eon" value="#eon#"/>

		<br><input type="submit" name="boton" value="#calcular#"/>
	</form>
</body>
</html>
fin;


$html = str_replace("#mensaje#", $mensaje, $html);
$html = str_replace("#hora#", $hora, $html);
$html = str_replace("#minuto#", $minuto, $html);
$html = str_replace("#segundo#", $segundo, $html);
$html = str_replace("#dia#", $dia, $html);
$html = str_replace("#mes#", $mes, $html);
$html = str_replace("#hora#", $hora, $html);
$html = str_replace("#ano#", $ano, $html);
$html = str_replace("#eon#", $eon, $html);

$html = str_replace("#calcular#", "Calcular", $html);


//$html = str_replace("mensaje", $mensaje, $html);


header("Content-type: text/html; charset=utf8");
print $html;
?>