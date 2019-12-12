<?php //contacto_buscar_activo_V01a.php

error_reporting(15);
ini_set("display_errors", 1);

require_once("inc/config.inc.php");
//establezco la lista de campos


//establecemos el objeto base de datos
$mysqli = mysqli_connect(_db_server, _db_user, _db_pass, _db_database);
$mysqli->query("SET NAMES 'utf8';");

$que="";
$n=0;
$orden = " ORDER BY nombre ASC, apellidos ASC, telefono ASC, email ASC ";
if(isset($_REQUEST["que"])){
	$que = $_REQUEST["que"];

	$sql="SELECT * FROM contactos WHERE nombre LIKE'%$que%' OR apellidos LIKE'%$que%' OR telefono LIKE'%$que%' OR email LIKE'%$que%' $orden";
}else{
	$sql="SELECT * FROM contactos $orden";
}

$_sql= addslashes($sql);

$listado="<table>";
//$listado.="<tr><td colspan=\"6\">Listado</td></tr>";
$listado.="<tr><td colspan=\"6\"><h3>Listado dinámico para: <span style=\"color:red;\">$que</span></h3></td></tr>";

if(_ver_sql){
//$listado.="<tr><td colspan=\"6\">buscando <strong>$que</strong></td></tr>";
$listado.="<tr><td colspan=\"6\">SQL:<input type=\"text\" onclick=\"select();\" value=\"$sql\"></td></tr>";
}

//codigo js comentado para el botón
/*
<!--
	<input type="button" value="Guardar" onclick="
	var busqueda=$('#nombre_busqueda').val();
	var sql='$_sql';
	$('#log').html(busqueda+' --> '+sql);
	guardar_busqueda($('#nombre_busqueda').val(),'$_sql');"/>
-->
*/

//Este codigo contiene la opción de guardar la consulta SQL
//pero como todavía no funciona bien (guardar_busqueda.php)
//la dejamos desactivada
/*
$listado.=<<<fin
<tr><td colspan="6">Guardar esta busqueda como: 
	<input type="text" id="nombre_busqueda" value="" onclick="this.select();"/>


	<input type="button" value="Guardar" onclick="
	var busqueda=$('#nombre_busqueda').val();
	var sql='$_sql';
	guardar_busqueda(busqueda,sql);
	"/>


<!-- 
	<input type="button" value="Guardar" onclick="$('#log').html('$_sql');"/>
-->

</td></tr>
fin;
*/





//ejecutamos la consulta y obtenemos un puntero a los datos devueltos

if($resultado = $mysqli->query($sql)){
	$errores="sin errores";
}else{
	$errores="error (".$mysqli->errno."): ".$mysqli->error;
}
$listado.="<tr><td colspan=\"6\">$errores</td></tr>";

//recorremos los datos devueltos en el puntero
while($datos = $resultado->fetch_assoc()){
	//para cada dato obtenemos los campos
	$n++;
	$id = $datos["id"];
	$alta = $datos["alta"];
	//$nombre = utf8_decode($datos["nombre"]);
	// $apellidos = utf8_decode($datos["apellidos"]);
	// $telefono= utf8_decode($datos["telefono"]);
	// $email = utf8_decode($datos["email"]);

	$nombre = $datos["nombre"];
	$apellidos = $datos["apellidos"];
	$telefono= $datos["telefono"];
	$email = $datos["email"];

	//montamos el html con los datos
	$listado.=<<<fin
	<tr>
		<td>#$n - $id <a href="contacto_editar.php?id=$id ">editar</a> <a href="contacto_borrar.php?id=$id ">borrar</a></td>
		<td>$alta</td>
		<td>$nombre</td>
		<td>$apellidos</td>
		<td>$telefono</td>
		<td>$email</td>
	</tr>
fin;
}//fin while
$listado.="</table>";

header("Content-type: text/html; charset=utf-8;");
print $listado;

?>