<?php //roles_grabar.php

require_once("inc/config.inc.php");
//establezco la lista de campos

// if(!isset($_REQUEST["cs"])){
// 	header("Location: menu.php");
// }

if(isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];
}else{
	print "ID no indicado...";
}

//$_s_lista_campos = "id,idk,nombre,descripcion,alta,ultimo,notas,activo";
$_s_lista_campos = "idk,nombre,descripcion,alta,ultimo,notas,activo";
$_s_lista_campos_alta = "nombre,descripcion,alta,notas,activo";
$campos = explode(",", $_s_lista_campos_alta);
$error=Array();
$errores=0;

foreach($campos as $n => $campo){
	if($campo=='id'){continue;}
	if(isset($_REQUEST[$campo])){
		//usamos el $$ para crear el nombre de la variable con el nombre del campo
		$$campo=utf8_decode(trim($_REQUEST[$campo]));
	}else{
		$errores++;
		$error[]="Falta el campo <strong>$campo</strong>";
		$$campo="";
	}
}



// if(isset($_REQUEST["nombre"])){
// 	$nombre=utf8_decode(trim($_REQUEST["nombre"]));
// }else{
// 	$errores++;
// 	$error[]="Falta el campo nombre";
// 	$nombre="";
// }

// if(isset($_REQUEST["activo"])){
// 	$activo=utf8_decode(trim($_REQUEST["activo"]));
// }else{
// 	$errores++;
// 	$error[]="Falta el campo activo";
// 	$activo="0";
// }

if($errores){
	print "Hay $errores errores:<br>";
	print implode("<br>",$error);
}

$sql =<<<fin
UPDATE roles SET 
fin;
// nombre= '$nombre',
// apellidos= '$apellidos',
// telefono= '$telefono',
// email= '$email',
// activo= '$activo'
// fin;

foreach($campos as $campo){
	$valor = $$campo; 
	$sql2[]="$campo='$valor'";
}

$sql.=implode(", ", $sql2);
$sql.=" WHERE id = '$id'";

//print $sql;

$mysqli->query($sql);
if($mysqli->error){
	$mensaje = "Un error al ejecutar la consulta: $sql";
	//exit();
}else{
	$id = $mysqli->insert_id;
	$mensaje = "Operación exitosa!<br>rol nuevo, insertado con ID: ".$id;
	$mensaje.= "<br><br>ahora puede:<br><a href=\"rol_editar.php?id=$id\">editar el rol creado</a>";
	$mensaje.= "<br><a href=\"rol_listado.php\">ver el Listado de roles</a>";
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