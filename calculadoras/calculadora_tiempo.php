<?php

if(isset($_REQUEST["horas"])){$horas=$_REQUEST["horas"];}else{$horas=0;}
if(isset($_REQUEST["minutos"])){$minutos=$_REQUEST["minutos"];}else{$minutos=0;}
if(isset($_REQUEST["segundos"])){$segundos=$_REQUEST["segundos"];}else{$segundos=0;}
$ahora=time();

$segundos_totales = ($horas * 3600) + ($minutos * 60) + $segundos;

if(isset($_REQUEST["video"])){$video=$_REQUEST["video"];}else{$video="";}
$enlace_video = $video."&t=".$segundos_totales;

$html=<<<fin
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>#titulo#</title>
	<!--#head_scripts#-->
</head>
<body>
	<!--#body_scripts#-->
	<div id="contenedor">
		<div id="cabecera"><!--#cabecera#--></div>
			<div id="barra"><!--#barra#--></div>
			<div id="contenido"><!--#contenido#-->

				<form action="?t=$ahora" method="get">
					Horas: <input type="text" name="horas" value="$horas" onfocus="this.select()"><br>
					Minutos: <input type="text" name="minutos" value="$minutos"onfocus="this.select()"><br>
					Segundos: <input type="text" name="segundos" value="$segundos"onfocus="this.select()"><br>
					<br>
					Segundos totales: <input type="text" name="segundos_totales" value="$segundos_totales"><br>
					<br>
					video: <input type="text" name="video" value="$video"><br>
					<br>$video
					<br>$enlace_video<br>
					<input type="checkbox" name="cambiar_url value="#cambiar_url#">video:<br><br>

					<input type="submit" name="enviar" value="Calcular"><br>
				</form>

			</div>
		<div id="pie"><!--#pie#--></div>
	</div>
	<!--#end_scripts#-->
</body>
</html>
fin;

print $html;
?>