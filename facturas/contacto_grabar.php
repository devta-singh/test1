<?php //contacto_grabar.php

require_once("inc/config.inc.php");
//establezco la lista de campos

// if(!isset($_REQUEST["cs"])){
// 	header("Location: menu.php");
// }

$mensaje="";
$error=Array();
$errores=0;
if(isset($_REQUEST["nombre"])){
	$nombre=utf8_decode(trim($_REQUEST["nombre"]));
}else{
	$errores++;
	$error[]="Falta el campo nombre";
	$nombre="";
}
if(isset($_REQUEST["apellidos"])){
	$apellidos=utf8_decode(trim($_REQUEST["apellidos"]));
}else{
	$errores++;
	$error[]="Falta el campo apellidos";
	$apellidos="";
}
if(isset($_REQUEST["telefono"])){
	$telefono=utf8_decode(trim($_REQUEST["telefono"]));
}else{
	$errores++;
	$error[]="Falta el campo telefono";
	$telefono="";
}
if(isset($_REQUEST["email"])){
	$email=utf8_decode(trim($_REQUEST["email"]));
}else{
	$errores++;
	$error[]="Falta el campo email";
	$email="";
}
if(isset($_REQUEST["activo"])){
	$activo=1;
}else{
	$activo="0";
}

if(isset($_REQUEST["id_contacto"])){
	$id=utf8_decode(trim($_REQUEST["id_contacto"]));
}else{
	$errores++;
	$error[]="Falta el campo id";
	$id="0";
}


if($errores){
	print "Hay $errores errores:<br>";
	print implode("<br>",$error);
}

$sql =<<<fin
UPDATE contactos SET
nombre= '$nombre',
apellidos= '$apellidos',
telefono= '$telefono',
email= '$email',
activo= '$activo'
WHERE id='$id'
fin;

//print $sql;

$mysqli->query($sql);
if($mysqli->error){
	$mensaje = "Un error al ejecutar la consulta: $sql";
	//exit();
}else{
	$n = $mysqli->affected_rows;
	if($n){
		$mensaje = "Operación exitosa!<br>Contacto con ID: ".$id." modificado con éxito...";
	}else{
		$mensaje = "No se ha actualizado el contacto $id ¿No ha cambiado ningún dato?";
	}
	$mensaje.= "<br><br>ahora puede:<br><a href=\"contacto_editar.php?id=$id\">editar el contacto creado</a>";
	$mensaje.= "<br><a href=\"contacto_listado.php\">ver el Listado de Contactos</a>";
	//exit();
}



//print "Hola";

//exit();

//tomo la plantilla principal
$plantilla = new plantilla(_ruta_plantillas."_html.html", ES_FICHERO);

$contenido=<<<fin
$mensaje
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