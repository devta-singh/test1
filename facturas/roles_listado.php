<?php //roles_listado.php

require_once("inc/config.inc.php");
//establezco la lista de campos

$_fichero = __FILE__;

$mensaje="";
$orden=0;
if(!isset($_REQUEST["orden"])){
	$ordenacion="ASC";
}else{
	$ordenacion=$_REQUEST["orden"];
	$orden++;
}

if(!isset($_REQUEST["campo"])){
	$campo="";
}else{
	$campo=$_REQUEST["campo"];
	$orden++;
}

if(!$orden){
	$sql =<<<fin
		SELECT * FROM roles ORDER BY nombre ASC, descripcion ASC
fin;

}else{
	$sql =<<<fin
		SELECT * FROM roles ORDER BY $campo $ordenacion
fin;

}

//print $sql;
$salida="Sin salida";
$resultado = $mysqli->query($sql);
if($mysqli->error){
	$mensaje = "Un error al ejecutar la consulta: $sql";
	//exit();
}else{
	$salida=<<<fin
<h1>Listado de roless</h1>
<table>
	<tr>
		<th><a href="?campo=activo&orden=ASC">activo</a> <a 

		href="?campo=activo&orden=DESC">^</a></th>

		<th><a href="?campo=id&orden=ASC">id</a> <a href="?campo=id&orden=DESC">^</a></th>
		<th><a href="?campo=idk&orden=ASC">idk</a> <a href="?campo=idk&orden=DESC">^</a></th>

		<th><a href="?campo=nombre&orden=ASC">nombre</a> <a href="?campo=nombre&orden=DESC">^</a></th>
		<th><a href="?campo=descripcion&orden=ASC">descripcion</a> <a href="?campo=descripcion&orden=DESC">^</a></th>
		<th><a href="?campo=alta&orden=ASC">alta</a> <a href="?campo=alta&orden=DESC">^</a></th>
		<th><a href="?campo=ultimo&orden=ASC">ultimo</a> <a href="?campo=ultimo&orden=DESC">^</a></th>


		

		<th>editar</th>
		<th>borrar</th>
	</tr>
fin;

	while($datos = $resultado->fetch_assoc()){
		$id = utf8_encode($datos["id"]);
		$idk = utf8_encode($datos["idk"]);
		$nombre = utf8_encode($datos["nombre"]);
		$descripcion = utf8_encode($datos["descripcion"]);
		$notas = utf8_encode($datos["notas"]);
		$alta = utf8_encode($datos["alta"]);
		$ultimo = utf8_encode($datos["ultimo"]);
		$activo = utf8_encode($datos["activo"]);


		$link_editar ="<a class=\"con\" href=\"roles_editar.php?id=$id\">editar</a>";

		$link_borrar ="<a class=\"con\" href=\"roles_borrar.php?id=$id\" onclick=\"return(confirm('¿Está seguro de borrar el registro del rol: $nombre $descripcion?'));\">borrar</a>";


		if($activo){
			$chk_activo = "<input type=\"checkbox\" checked>";
		}else{
			$chk_activo = "<input type=\"checkbox\">";
		}

		$salida.=<<<fin
	<tr>
		<td>$chk_activo</td>
		<td><a class="sin" href="roles_editar.php?id=$id">$id</a></td>
		<td><a class="sin" href="roles_editar.php?id=$id">$idk</a></td>

		<td><a class="sin" href="roles_editar.php?id=$id">$nombre</a></td>
		<td><a class="sin" href="roles_editar.php?id=$id">$descripcion</a></td>
		<td><a class="sin" href="roles_editar.php?id=$id">$alta</a></td>
		<td><a class="sin" href="roles_editar.php?id=$id">$ultimo</a></td>

		<td>$link_editar</td>
		<td>$link_borrar</td>
	</tr>
fin;

	}
	$salida.="</table>";
	//exit();
}

// if(!isset($_REQUEST["cs"])){
// 	header("Location: menu.php");
// }


//tomo la plantilla principal
$plantilla = new plantilla(_ruta_plantillas."_html.html", ES_FICHERO);

$contenido=<<<fin
$mensaje
<br>
$salida
<br>
<br><a href="roles_nuevo.php">Nuevo rol</a>
<br><a href="roles_listado.php">Listado de roles</a>
<br><a href="roles_buscar.php">Buscar rol</a>
<br><a href="menu.php">Volver al Menu principal</a>
fin;

//y la envío
$plantilla->reemplazar("#titulo#", "roles Nuevo");
$plantilla->reemplazar("#contenido#", $contenido);
$plantilla->cabecera_html();
$plantilla->imprimir();


?>