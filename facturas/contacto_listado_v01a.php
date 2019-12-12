<?php //contacto_listado_v01b.php

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
		SELECT * FROM contactos ORDER BY nombre ASC, apellidos ASC
fin;

}else{
	$sql =<<<fin
		SELECT * FROM contactos ORDER BY $campo $ordenacion
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
<!-- <script src="js/funciones_buscador_listado_v0.1.a.js"></script> -->
<!-- <script src="js/funciones_buscador_listado_v0.1.b.js"></script> -->
<script src="js/funciones_buscador_listado_v0.1.c.js"></script>
<!-- Fichero: $_fichero -->
<div id="busqueda">
	buscar: <input type="text" id="buscar" name="buscar" onkeyup="buscar(this.value);">
</div>
<div id="resultados"></div>
<h1>Listado de Contactos</h1>
<table>
	<tr>
		<th><a href="?campo=activo&orden=ASC">activo</a> <a href="?campo=activo&orden=DESC">^</a></th>
		<th><a href="?campo=nombre&orden=ASC">nombre</a> <a href="?campo=nombre&orden=DESC">^</a></th>
		<th><a href="?campo=apellidos&orden=ASC">apellidos</a> <a href="?campo=apellidos&orden=DESC">^</a></th>
		<th><a href="?campo=telefono&orden=ASC">telefono</a> <a href="?campo=telefono&orden=DESC">^</a></th>
		<th><a href="?campo=email&orden=ASC">email</a> <a href="?campo=email&orden=DESC">^</a></th>
		<th>editar</th>
		<th>borrar</th>
	</tr>
fin;

	while($datos = $resultado->fetch_assoc()){
		$id = utf8_encode($datos["id"]);
		//$nombre = utf8_encode($datos["nombre"]);
		// $apellidos = utf8_encode($datos["apellidos"]);
		// $telefono = utf8_encode($datos["telefono"]);
		// $email = utf8_encode($datos["email"]);
		// $activo = utf8_encode($datos["activo"]);


		$nombre = $datos["nombre"];
		$apellidos = $datos["apellidos"];
		$telefono = $datos["telefono"];
		$email = $datos["email"];
		$activo = $datos["activo"];

		$link_editar ="<a class=\"con\" href=\"contacto_editar.php?id=$id\">editar</a>";

		$link_borrar ="<a class=\"con\" href=\"contacto_borrar.php?id=$id\" onclick=\"return(confirm('¿Está seguro de borrar el registro: $nombre $apellidos ?'));\">borrar</a>";


		if($activo){
			$chk_activo = "<input type=\"checkbox\" checked>";
		}else{
			$chk_activo = "<input type=\"checkbox\">";
		}

		$salida.=<<<fin
	<tr>
		<td>$chk_activo</td>
		<td><a class="sin" href="contacto_editar.php?id=$id">$nombre</a></td>
		<td><a class="sin" href="contacto_editar.php?id=$id">$apellidos</a></td>
		<td><a class="sin" href="contacto_editar.php?id=$id">$telefono</a></td>
		<td><a class="sin" href="contacto_editar.php?id=$id">$email</a></td>
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