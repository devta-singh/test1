<?php //roles_nuevo.php

require_once("inc/config.inc.php");

//tomo la plantilla principal
$plantilla = new plantilla(_ruta_plantillas."_html.html", ES_FICHERO);

//id, idk, nombre, descripcion, alta, ultimo, notas
//establecemos las variables vacías para que no de la lata...
$id= $idk= $nombre= $descripcion= $alta= $ultimo= $notas = $chk_activo ="";

//$fecha_hora_actual = date("Y-m-d H:i:s");
$fecha_hora_actual = date("d/m/Y H:i:s");

$contenido=<<<fin
Hola, esta es la ficha de un nuevo ROL,
<br>Por favor, rellene los siguientes campos:

<form action="roles_alta.php" method="post">
	<br>id: <input type="text" name="id" id="id" value="$id" disabled/>
	<br>idk: <input type="text" name="idk" id="idk" value="$idk"/>

	<br>Nombre: <input type="text" name="nombre" id="nombre" value="$nombre"/>
	<br>Descripcion: <br><textarea name="descripcion" id="descripcion">$descripcion</textarea>
	
	<br>Alta: <input type="date" name="alta" id="alta" value="$alta"/> <a href="#_" onclick="this.value='$fecha_hora_actual';">actual ($fecha_hora_actual)</a>
	<br>Ultimo: <input type="text" name="ultimo" id="ultimo" value="$ultimo" disabled/>

	<br>Notas: <br><textarea name="notas" id="notas">$notas</textarea>	
	<br><input type="checkbox" name="activo" id="activo" value="1" $chk_activo/> Activo
	<br><input type="submit" value="Enviar"/>
</form>
<br>
<br><a href="roles_nuevo.php">Nuevo Rol</a>
<br><a href="roles_listado.php">Listado de Roles</a>
<br><a href="roles_buscar.php">Buscar Roles</a>
<br><a href="menu.php">Volver al Menu</a>
fin;

//y la envío
$plantilla->reemplazar("#titulo#", "Rol Nuevo");
$plantilla->reemplazar("#contenido#", $contenido);
$plantilla->cabecera_html();
$plantilla->imprimir();

?>