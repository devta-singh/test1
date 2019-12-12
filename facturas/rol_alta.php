<?php //rol_alta.php

require_once("inc/config.inc.php");
//establezco la lista de campos

// if(!isset($_REQUEST["cs"])){
// 	header("Location: menu.php");
// }

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
	$activo=utf8_decode(trim($_REQUEST["activo"]));
}else{
	$errores++;
	$error[]="Falta el campo activo";
	$activo="0";
}

if($errores){
	print "Hay $errores errores:<br>";
	print implode("<br>",$error);
}

$sql =<<<fin
INSERT INTO rols SET
nombre= '$nombre',
apellidos= '$apellidos',
telefono= '$telefono',
email= '$email',
activo= '$activo'
fin;

//print $sql;

$mysqli->query($sql);
if($mysqli->error){
	$mensaje = "Un error al ejecutar la consulta: $sql";
	//exit();
}else{
	$id = $mysqli->insert_id;
	$mensaje = "Operación exitosa!<br>rol nuevo, insertado con ID: ".$id;
	$mensaje.= "<br><br>ahora puede:<br><a href=\"rol_editar.php?id=$id\">editar el rol creado</a>";
	$mensaje.= "<br><a href=\"rol_listado.php\">ver el Listado de rols</a>";
	//exit();
}



//print "Hola";

//exit();

//tomo la plantilla principal
$plantilla = new plantilla(_ruta_plantillas."_html.html", ES_FICHERO);

$contenido=<<<fin
$mensaje
<br>
<br><a href="rol_nuevo.php">Nuevo rol</a>
<br>
<br><a href="menu.php">Volver al Menu</a>
fin;

//y la envío
$plantilla->reemplazar("#titulo#", "rol Nuevo");
$plantilla->reemplazar("#contenido#", $contenido);
$plantilla->cabecera_html();
$plantilla->imprimir();


?>