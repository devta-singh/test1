<?php // /toolbox/utilities/iva.php

if(isset($_REQUEST["valor_original"])){
	$valor_original = $_REQUEST["valor_original"];
}else{
	$valor_original = 100;
}

if(isset($_REQUEST["tipo_iva"])){
	$tipo_iva = $_REQUEST["tipo_iva"];
}else{
	$tipo_iva = 21;
}

//$valor_original tomado como base
$base1 = $valor_original;
$iva1 = $base1 * $tipo_iva / 100;
$subtotal1 = $base1 + $iva1; 

//$valor_original tomado como IVA
$iva2 = $valor_original;
$base2 = $iva2 * 100 / $tipo_iva;
$subtotal2 = $base2 + $iva2;

//$valor_original tomado como subtotal
$subtotal3 = $valor_original;
$base3 = $subtotal3 / ((100 + $tipo_iva)/100);
$iva3 = $subtotal3 - $base3;

//presentamos los datos con 2 decimales
$_base1 = sprintf("%01.2f", $base1);
$_iva1 = sprintf("%01.2f", $iva1);
$_subtotal1 = sprintf("%01.2f", $subtotal1);

$_base2 = sprintf("%01.2f", $base2);
$_iva2 = sprintf("%01.2f", $iva2);
$_subtotal2 = sprintf("%01.2f", $subtotal2);

$_base3 = sprintf("%01.2f", $base3);
$_iva3 = sprintf("%01.2f", $iva3);
$_subtotal3 = sprintf("%01.2f", $subtotal3);



$html=<<<fin
<html>
<head>
	<link href="css/estilos.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<form action="?" method="post">
	valor original: <input type="text" name="valor_original" value="$valor_original"/>
	<br>tipo iva: <input type="text" name="tipo_iva" value="$tipo_iva"/>%

	<br><input type="submit" value="calcular"/>

</form>
Valor original: <span class="original">$valor_original</span>
<br>Tipo_iva: $tipo_iva (%)
<table>

	<tr>
		<th></th>
		<th>base<br>&nbsp;</th>
		<th>IVA<br>($tipo_iva%)</th>
		<th>subtotal<br>&nbsp;</th>
	</tr>
	<tr>
		<td>$valor_original tomado como base&nbsp;&nbsp;&nbsp;</td>
		<td class="original">$_base1</td>
		<td>$_iva1</td>
		<td>$_subtotal1</td>
	</tr>
	<tr>
		<td>$valor_original tomado como IVA&nbsp;&nbsp;&nbsp;</td>
		<td>$_base2</td>
		<td class="original">$_iva2</td>
		<td>$_subtotal2</td>
	</tr>
	<tr>
		<td>$valor_original tomado como subtotal&nbsp;&nbsp;&nbsp;</td>
		<td>$_base3</td>
		<td>$_iva3</td>
		<td class="original">$_subtotal3</td>
	</tr>
	
</table>

</body>
</html>
fin;

header("Content-type: text/html; charset=utf8;");
print $html;

?>