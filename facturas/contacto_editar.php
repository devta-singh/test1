<?php //contacto_editar.php

require_once("inc/config.inc.php");
//establezco la lista de campos

//print "Hola";

//exit();

$error=array();
$errores=0;

if(isset($_REQUEST["id"])){
	$id=$_REQUEST["id"];

	$sql="SELECT * FROM contactos WHERE id = '$id'";
	$recurso = $mysqli->query($sql);

	$datos = $recurso->fetch_assoc();

	$nombre= utf8_encode($datos["nombre"]);
	$apellidos= utf8_encode($datos["apellidos"]);
	$telefono= utf8_encode($datos["telefono"]);
	$email= utf8_encode($datos["email"]);
	$activo= utf8_encode($datos["activo"]);
	//$nombre= utf8_encode($datos["nombre"]);
	//$nombre= utf8_encode($datos["nombre"]);

	if ($activo){
		$chk_activo = "checked";
	}else{
		$chk_activo = "";
	}

	$contenido=<<<fin
	Hola, para editar el contacto $id, utilice este formulario:
	<br>
	<form action="contacto_grabar.php" method="post">
		<br>Nombre: <input type="text" name="nombre" id="nombre" value="$nombre"/>
		<br>Apellidos: <input type="text" name="apellidos" id="apellidos" value="$apellidos"/>
		<br>Tel&eacute;fono: <input type="text" name="telefono" id="telefono" value="$telefono"/>
		<br>eMail: <input type="text" name="email" id="email" value="$email"/>
		<br><input type="checkbox" name="activo" id="activo" value="$activo" $chk_activo/> Activo

		<input type="hidden" name="id_contacto" id="id_contacto" value="$id"/>
		<input type="hidden" name="chk_activo" id="chk_activo" value="$activo"/>

		<br><input type="submit" value="Enviar"/>
	</form>
<br>
<br><a href="contacto_nuevo.php">Nuevo Contacto</a>
<br><a href="contacto_listado.php">Listado de Contacto</a>
<br><a href="contacto_buscar.php">Buscar Contacto</a>
<br><a href="menu.php">Volver al Menu</a>
fin;

}else{

	$contenido=<<<fin
	Editar contacto.
	<br>ERROR<br>No se ha indicado el id del contacto
fin;

}

//tomo la plantilla principal
$plantilla = new plantilla(_ruta_plantillas."_html.html", ES_FICHERO);

//y la envío
$plantilla->reemplazar("#titulo#", "Contacto Editar");
$plantilla->reemplazar("#contenido#", $contenido);
$plantilla->cabecera_html();
$plantilla->imprimir();


?>