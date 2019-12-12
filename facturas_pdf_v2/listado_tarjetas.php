<?php //listado_tarjetas.php

error_reporting(15);
ini_set("display_errors", 1);

require_once("inc/config.inc.php");

$sql="SELECT * FROM tarjetas ORDER BY lugar ASC";

$recursos = $mysqli->query($sql);

$html=<<<fin
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Listado de Tarjetas</title>
</head>
<body>
fin;


if(!$mysqli->error){
	//recuperamos los datos
	$html.=<<<fin
			<table>
fin;

	while($datos = $recursos->fetch_assoc()){
		$id=$datos["id"];
		$lugar=$datos["lugar"];
		$tarjeta=$datos["tarjeta"];

		$html.=<<<fin
			<tr>
				<td>$id</td>
				<td><a href="texto_sobre_imagen.php?id=$id">$lugar</a></td>
			</tr>
fin;

	}
	$html.="</table>";
}else{
	
}

$html.="</body></html>";

print $html;
?>