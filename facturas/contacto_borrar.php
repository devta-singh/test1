<?php //contacto_borrar.php

require_once("inc/config.inc.php");
//establezco la lista de campos

$mensaje="";
$orden=0;
if(!isset($_REQUEST["id"])){
	$mensaje="No se ha indicado contacto a borrar";
}else{
	$id=$_REQUEST["id"];
}

$sql="DELETE FROM contactos WHERE id='$id'";
$mysqli->query($sql);

if($mysqli->error){
	$mensaje= "Error: ".$mysqli->error;
}elseif($mysqli->affected_rows){
	$n = $mysqli->affected_rows;
	$mensaje = "Operación exitosa!<br>Contacto con id: $id, eliminado";
	$mensaje.= "<br><a href=\"contacto_listado.php\">ver el Listado de Contactos</a>";

	
}	


	
$salida="";


//tomo la plantilla principal
$plantilla = new plantilla(_ruta_plantillas."_html.html", ES_FICHERO);

$contenido=<<<fin
$mensaje
<br>
$salida
<br>
<br><a href="contacto_nuevo.php">Nuevo Contacto</a>
<br><a href="menu.php">Volver al Menu</a>
fin;

//y la envío
$plantilla->reemplazar("#titulo#", "Contacto Nuevo");
$plantilla->reemplazar("#contenido#", $contenido);
$plantilla->cabecera_html();
$plantilla->imprimir();


?>