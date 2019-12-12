<?php

$html<<<fin
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

				<form action="?" method="post">
					Horas: <input type="text" name="hora" value="#hora#"><br>
					Minutos: <input type="text" name="minuto" value="#minuto#"><br>
					Segundos: <input type="text" name="segundo" value="#segundo#"><br>
					<br>
					Segundos totales: <input type="text" name="segundos_totales" valu e="#segundos_totales#"><br>
					<br>
					video: <input type="text" name="video value="#video"><br>
					<br>
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

?>