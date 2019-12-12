<?php //menu.php

require("inc/config.inc.php");

$html=new plantilla(_ruta_plantillas."_html.html", ES_FICHERO);

$titulo="Facturación - Menu principal";

$menu_nav=<<<fin
<ul id="menu" class="dropdown">
	<li>Factura_png
		<ul class="dropdown-content">
			<li><a href="../factura_nueva.php">Nueva</a></li>
			<li><a href="factura_buscar.php">Buscar</a></li>
			<li><a href="factura_borrar.php">Borrar</a></li>
		</ul>
	</li>

	<li>Facturas
		<ul class="dropdown-content">
			<li><a href="factura_nueva.php">Nueva</a></li>
			<li><a href="factura_buscar.php">Buscar</a></li>
			<li><a href="factura_borrar.php">Borrar</a></li>
		</ul>
	</li>
	
	<li>Contactos
		<ul class="dropdown-content">	
			<li><a href="contacto_nuevo.php">Nuevo</a></li>
			<li><a href="contacto_listado.php">Listado</a></li>
			<li><a href="contacto_buscar.php">Buscar</a></li>
			<li><a href="contacto_buscar_complejo.php">Busqueda compleja de Contactos</a></li>
			<li><a href="contacto_borrar.php">Borrar</a></li>
		</ul>
	</li>

	<li>Roles
		<ul class="dropdown-content">
			<li><a href="roles_asignar.php">Asignar Rol</a></li>
			<li><a href="roles_listado.php">Listado</a></li>
			<li><a href="roles_nuevo.php">Nuevo</a></li>
			<li><a href="roles_buscar.php">Buscar</a></li>
			<li><a href="roles_borrar.php">Borrar</a></li>
		</ul>
	</li>
</ul>
fin;


$resto_html="Bla bla bla";

$pie_html=<<<fin
<ul class="dropdown"><li>Facturas</li><li>Contactos</li><li>Roles</li></ul>
fin;

$contenido=<<<fin
<div id="contenido">
	Elige un item del menu para empezar...
	<div id="menu_nav">$menu_nav</div>
	$resto_html
	$pie_html
</div>
fin;

header("Content-type: text/html; utf-8");
$html->r("#titulo#",$titulo);
$html->r("#contenido#",$contenido);
print $html->volcar();

?>