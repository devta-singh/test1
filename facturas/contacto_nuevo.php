<?php //factura_nueva.php

require_once("inc/config.inc.php");
//establezco la lista de campos

//print "Hola";

//exit();

//tomo la plantilla principal
$plantilla = new plantilla(_ruta_plantillas."_html.html", ES_FICHERO);

$contenido=<<<fin
Hola, esta es la ficha de un nuevo contacto,
<br>Por favor, rellene los siguientes campos:

<form action="contacto_alta.php" method="post">
	<br>Nombre: <input type="text" name="nombre" id="nombre" value=""/>
	<br>Apellidos: <input type="text" name="apellidos" id="apellidos" value=""/>
	<br>Tel&eacute;fono: <input type="text" name="telefono" id="telefono" value=""/>
	<br>eMail: <input type="text" name="email" id="email" value=""/>
	<br><input type="checkbox" name="activo" id="activo" value="1"/> Activo

	<br><input type="submit" value="Enviar"/>
</form>
<br>
<br><a href="contacto_nuevo.php">Nuevo Contacto</a>
<br><a href="contacto_listado.php">Listado de Contacto</a>
<br><a href="contacto_buscar.php">Buscar Contacto</a>
<br><a href="menu.php">Volver al Menu</a>
fin;

//y la envío
$plantilla->reemplazar("#titulo#", "Contacto Nuevo");
$plantilla->reemplazar("#contenido#", $contenido);
$plantilla->cabecera_html();
$plantilla->imprimir();


?>