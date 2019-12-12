<?php //factura_nueva.php

require_once("inc/config.inc.php");
//establezco la lista de campos

//print "Hola";

//exit();

//tomo la plantilla principal
$plantilla = new plantilla(_ruta_plantillas."_html.html", ES_FICHERO);

$contenido=<<<fin
Hola maja...
"Yo soy el contenido"

<form action="factura_alta.php" method="post">
	<br>Nombre: <input type="submit" value="Enviar"/>
	<br><input type="submit" value="Enviar"/>
</form>

fin;

//y la envío
$plantilla->reemplazar("#titulo#", "Factura Nueva");
$plantilla->reemplazar("#contenido#", $contenido);
$plantilla->cabecera_html();
$plantilla->imprimir();


?>