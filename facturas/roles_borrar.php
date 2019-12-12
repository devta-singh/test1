<?php //roles_borrar.php

require_once("inc/config.inc.php");

//tomo la plantilla principal
$plantilla = new plantilla(_ruta_plantillas."_html.html", ES_FICHERO);

$errores=0;
$sql="";
if(isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];
	$sql="DELETE FROM roles WHERE id='$id'";
}else{
	$errores++;
	$msg="No se indicó ni ID ni IDK, imposible localizar registro";
}

if(!$errores && ($sql != "")){
	$resultados=$mysqli->query($sql);
	if($mysqli->error){
		//getionamos el error
		$errores++;
		$error= $mysqli->error;
		$errno= $mysqli->errno;
		$msg = "Error($errno) al cargar rol($id): $error<br>SQL: $sql";
	}else{
		$n = $mysqli->affected_rows;
		if($n > 0){
			//hay filas afectadas (borradas)
			$msg="Rol $id borrado";
		}else{
			//no hay resultados para el rol indicado
			$errores++;
			$msg="no hay filas borradasresultados para el rol indicado ($id) ¿Existe?";
		}
	}

}else{
	$errores++;
	$msg="Debe indicarse un rol a borrar, no se ha indicado ninguno";
}

if($errores > 0){
	$contenido = "Hay errores, verifique los datos y repita el proceso.
	<br>$msg<br>
	O hable con el administrador.";
}else{
	//asignamos el contenido para crear el formulario de edición
	$contenido=<<<fin
	$msg<br>
	Vuelva al menú...
	<br>
	<br><a href="roles_nuevo.php">Nuevo Rol</a>
	<br><a href="roles_listado.php">Listado de Roles</a>
	<br><a href="roles_buscar.php">Buscar Roles</a>
	<br><a href="menu.php">Volver al Menu</a>
fin;
}//fin asignación contenido

//y la envío
$plantilla->reemplazar("#titulo#", "Rol Nuevo");
$plantilla->reemplazar("#contenido#", $contenido);
$plantilla->cabecera_html();
$plantilla->imprimir();

?>