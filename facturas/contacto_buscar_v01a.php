<?php //contacto_buscar_v01a.php

require_once("inc/config.inc.php");
//establezco la lista de campos

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

if(!isset($_REQUEST["buscar"])){
	$buscar="";
}else{
	$buscar=$_REQUEST["buscar"];
}

$chk_like_contenga="";
$chk_like_comience="";
if(isset($_REQUEST["_like"])){
	
	//$_like="$buscar%";//$_REQUEST["_like[comience]"];
	if($_REQUEST["_like"]=="contenga"){
		$_like="%$buscar%";//$_REQUEST["_like[comience]"];
		$chk_like_contenga="checked";
	}elseif($_REQUEST["_like"]=="comience"){
		$_like="$buscar%";//$_REQUEST["_like[comience]"];
		$chk_like_comience="checked";
	}else{
		$_like="";	
	}
}else{
	$_like="";
}

$chk_campos_nombre="";
$chk_campos_apellidos="";
$chk_campos_telefono="";
$chk_campos_email="";

if(isset($_REQUEST["_campos"])){
	$lista_campos=$_REQUEST["_campos"];
	$campos=array();
	foreach($lista_campos as $nombre_campo){
		$campos[]=$nombre_campo;
		//preparamos el checked para el checkbox correspondiente a este campo
		$nombre_chk = "chk_campos_".$nombre_campo;
		$$nombre_chk = "checked";
	}
	$_campos = implode(",", $campos);
	
}else{
	$_campos ="";
}

$datos_recibidos=<<<fin
Buscar: $buscar
Campos: $_campos
Tipo_Busqueda: $_like
fin;

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
<form action="?" method="post">
$datos_recibidos
<br>
<table border="1">

	<tr>
		<td colspan="5">
			Buscar por: 
			<input type="text" name="buscar" id="buscar" value="$buscar"/>
			en Los campos marcados
			<input type="submit" value="Buscar"/>
		</td>
		<td rowspan="2" colspan="2">
			<input type="radio" name="_like" id="_like_contenga" value="contenga" $chk_like_contenga/><label for="_like[contenga]">que contenga</label>
			<br><input type="radio" name="_like" id="_like_comience" value="comience" $chk_like_comience/><label for="_like[comience]">que comience por</label>
		</td>
	</tr>
	<tr>
		<td></td>
		<td class="centrada"><input type="checkbox" name="_campos[nombre]" id="_campos[nombre]" value="nombre" $chk_campos_nombre/><label for="_campos[nombre]">nombre</label></td>
		<td class="centrada"><input type="checkbox" name="_campos[apellidos]" id="_campos[apellidos]" value="apellidos" $chk_campos_apellidos/><label for="_campos[apellidos]">apellidos</label></td>
		<td class="centrada"><input type="checkbox" name="_campos[telefono]" id="_campos[telefono]" value="telefono" $chk_campos_telefono/><label for="_campos[telefono]">telefono</label></td>
		<td class="centrada"><input type="checkbox" name="_campos[email]" id="_campos[email]" value="email" $chk_campos_email/><label for="_campos[email]">email</label></td>
		<!-- aqui van las dos columnas que hemos extendido desde arriba -->
	</tr>	
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
		$nombre = utf8_encode($datos["nombre"]);
		$apellidos = utf8_encode($datos["apellidos"]);
		$telefono = utf8_encode($datos["telefono"]);
		$email = utf8_encode($datos["email"]);
		$activo = utf8_encode($datos["activo"]);

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
	$salida.="</table></form>";
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
<br><a href="menu.php">Volver al Menu</a>
fin;

//y la envío
$plantilla->reemplazar("#titulo#", "Contacto Nuevo");
$plantilla->reemplazar("#contenido#", $contenido);
$plantilla->cabecera_html();
$plantilla->imprimir();


?>