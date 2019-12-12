<?php //menu.php

require("inc/config.inc.php");
$html=new plantilla(_ruta_plantillas."_html.html");

$titulo="Facturación - Menu principal";

$menu_nav=<<<fin
<ul>
	<li>Facturas</li>
	<li><a href="factura_nueva.php">Nueva</a></li>
	<li><a href="factura_buscar.php">Buscar</a></li>
	<li><a href="factura_borrar.php">Borrar</a></li>
	<li><ul>
		<li>Contactos</li>
		<li><a href="contacto_nuevo.php">Nuevo</a></li>
		<li><a href="contacto_buscar.php">Buscar</a></li>
		<li><a href="contacto_borrar.php">Borrar</a></li>
	</li>
	<li><ul>
		<li>Roles</li>
		<li><a href="roles_asignar.php">Asignar Rol</a></li>
		<li><a href="roles_nuevo.php">Nuevo</a></li>
		<li><a href="roles_buscar.php">Buscar</a></li>
		<li><a href="roles_borrar.php">Borrar</a></li>
	</li>
</ul>
</ul>
fin;


$contenido=<<<fin
<div id="menu_nav">$menu_nav</div>
<div id="contenido">
	Elige un item del menu para empezar...
</div>
fin;


?>