<?php //contacto_buscar_complejo_v2.01a.php

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
		$_like="LIKE '%$buscar%'";//$_REQUEST["_like[comience]"];
		$chk_like_contenga="checked";
	}elseif($_REQUEST["_like"]=="comience"){
		$_like="LIKE '$buscar%'";//$_REQUEST["_like[comience]"];
		$chk_like_comience="checked";
	}else{
		$_like="";	
	}
}else{
	$_like="";
}

$chk_tipo_AND = "";
$chk_tipo_OR = "";
if(isset($_REQUEST["_tipo"])){
	if($_REQUEST["_tipo"]=="AND"){
		//el tipo más restrictivo, se tienen que dar TODAS las condiciones
		$_tipo = "AND";
		$__tipo = "* RECIBIDO AND * ";
		$chk_tipo_AND = " checked";
	}elseif($_REQUEST["_tipo"]=="OR"){
		//el tipo más inclusivo, si se da cualquier condición
		$_tipo = "OR";
		$__tipo = "* RECIBIDO OR * ";
		$chk_tipo_OR = " checked";
	}else{
		$chk_tipo_OR = " checked";
	}
}else{
	$__tipo = "* SIN RECIBIR _tipo * ";
	$_tipo = "OR";
	//$chk_tipo_OR = " checked";
}

$chk_campos_nombre="";
$chk_campos_apellidos="";
$chk_campos_telefono="";
$chk_campos_email="";

//$buscar_nombre="";
$chk_like_nombre_ini="";
$chk_like_nombre_fin="";
$chk_like_nombre_con="";

//$buscar_apellidos="";
$chk_like_apellidos_ini="";
$chk_like_apellidos_fin="";
$chk_like_apellidos_con="";

//$buscar_telefono="";
$chk_like_telefono_ini="";
$chk_like_telefono_fin="";
$chk_like_telefono_con="";

//$buscar_email="";
$chk_like_email_ini="";
$chk_like_email_fin="";
$chk_like_email_con="";

if(isset($_REQUEST["_campo"]["nombre"])){
	$chk_nombre="checked";
	//$chk_campos_nombre="checked";

}else{
	$chk_nombre="";	
}

if(isset($_REQUEST["_campo"]["apellidos"])){
	$chk_apellidos="checked";		
}else{
	$chk_apellidos="";	
}

if(isset($_REQUEST["_campo"]["telefono"])){
	$chk_telefono="checked";		
}else{
	$chk_telefono="";	
}

if(isset($_REQUEST["_campo"]["email"])){
	$chk_email="checked";		
}else{
	$chk_email="";	
}
/*
<input type="checkbox" name="_campo[nombre]" id="_campo_nombre" value="nombre" $chk_nombre title="Buscar en el campo nombre"/><label for="_campo_nombre" title="Buscar en el campo nombre">en Nombre:</label>
*/


//Esto es para los campos de busqueda
if(isset($_REQUEST["buscar"]["nombre"])){
	$buscar_nombre=$_REQUEST["buscar"]["nombre"];
}else{
	$buscar_nombre="";
}

if(isset($_REQUEST["buscar"]["apellidos"])){
	$buscar_apellidos=$_REQUEST["buscar"]["apellidos"];
}else{
	$buscar_apellidos="";
}

if(isset($_REQUEST["buscar"]["telefono"])){
	$buscar_telefono=$_REQUEST["buscar"]["telefono"];
}else{
	$buscar_telefono="";
}

if(isset($_REQUEST["buscar"]["email"])){
	$buscar_email=$_REQUEST["buscar"]["email"];
}else{
	$buscar_email="";
}

$_like=array();
//Ahora los tipos de busqueda para cada campo
if(isset($_REQUEST["_like"]["nombre"])){
	$_like["nombre"]=$_REQUEST["_like"]["nombre"];
}else{
	$_like["nombre"]="con";
	$chk_like_nombre_con="checked";
}

if(isset($_REQUEST["_like"]["apellidos"])){
	$_like["apellidos"]=$_REQUEST["_like"]["apellidos"];
}else{
	$_like["apellidos"]="con";
	$chk_like_apellidos_con="checked";
}

if(isset($_REQUEST["_like"]["telefono"])){
	$_like["telefono"]=$_REQUEST["_like"]["telefono"];
}else{
	$_like["telefono"]="con";
	$chk_like_telefono_con="checked";
}

if(isset($_REQUEST["_like"]["email"])){
	$_like["email"]=$_REQUEST["_like"]["email"];
}else{
	$_like["email"]="con";
	$chk_like_email_con="checked";
}





//controla los radio de los campos de busqueda
if($_like["nombre"] == "ini"){//ini
	$condiciones["nombre"]="nombre LIKE '%$buscar_nombre'";
	$chk_like_nombre_ini="checked";
}elseif($_like["nombre"] == "fin"){//fin
	$condiciones["nombre"]="nombre LIKE '%$buscar_nombre'";
	$chk_like_nombre_fin="checked";
}else{//con
	$condiciones["nombre"]="nombre LIKE '%$buscar_nombre%'";
	$chk_like_nombre_con="checked";
}

if($_like["apellidos"] == "ini"){//ini
	$condiciones["apellidos"]="apellidos LIKE '%$buscar_apellidos'";
	$chk_like_apellidos_ini="checked";
}elseif($_like["apellidos"] == "fin"){//fin
	$condiciones["apellidos"]="apellidos LIKE '%$buscar_apellidos'";
	$chk_like_apellidos_fin="checked";
}else{//con
	$condiciones["apellidos"]="apellidos LIKE '%$buscar_apellidos%'";
	$chk_like_apellidos_con="checked";
}

if($_like["telefono"] == "ini"){//ini
	$condiciones["telefono"]="telefono LIKE '%$buscar_telefono'";
	$chk_like_telefono_ini="checked";
}elseif($_like["telefono"] == "fin"){//fin
	$condiciones["telefono"]="telefono LIKE '%$buscar_telefono'";
	$chk_like_telefono_fin="checked";
}else{//con
	$condiciones["telefono"]="telefono LIKE '%$buscar_telefono%'";
	$chk_like_telefono_con="checked";
}

if($_like["email"] == "ini"){//ini
	$condiciones["email"]="email LIKE '%$buscar_email'";
	$chk_like_email_ini="checked";
}elseif($_like["email"] == "fin"){//fin
	$condiciones["email"]="email LIKE '%$buscar_email'";
	$chk_like_email_fin="checked";
}else{//con
	$condiciones["email"]="email LIKE '%$buscar_email%'";
	$chk_like_email_con="checked";
}




//el selected del radio de TIPO
if(isset($_REQUEST["_tipo"])){
	if($_REQUEST["_tipo"]=="AND"){
		$chk_tipo_AND = " checked";
	}else{
		$chk_tipo_OR = " checked";
	}	

}else{
	$chk_tipo_OR = " checked";
}

$condiciones_filtradas=array();
//$_condiciones = implode(" $_tipo ", $condiciones);
foreach($condiciones as $campo => $condicion){
	if(isset($_REQUEST["_campo"][$campo])){
		$condiciones_filtradas[$campo]=" $condicion ";
	}
}
//$_condiciones = implode(" $_tipo ", $condiciones);
$_condiciones = implode(" $_tipo ", $condiciones_filtradas);


//print "_campos: $_campos + _like: $_like + _condiciones: $_condiciones";
//if($_campos!="" && $_like!=""){
if($_condiciones){	
	$where=<<<fin
	WHERE $_condiciones
fin;
}else{
	$where = " ";
}

if(!$orden){
	$sql =<<<fin
		SELECT * FROM contactos $where ORDER BY nombre ASC, apellidos ASC 
fin;

}else{
	$sql =<<<fin
		SELECT * FROM contactos $where ORDER BY $campo $ordenacion
fin;

}

$datos_recibidos=<<<fin

Condiciones: $_condiciones 
<br>SQL: $sql
nombre: $buscar_nombre
chk: $chk_nombre

fin;



//print $sql;
$salida="Sin salida";
$resultado = $mysqli->query($sql);
if($mysqli->error){
	$mensaje = "Un error al ejecutar la consulta: $sql";
	//exit();
}else{
	$salida=<<<fin
<script src="js/funciones_buscador_complejo_v0.1.a.js"></script>	
<form action="?" method="post">
$datos_recibidos
<br>
<table id="tabla_listado">

	<tr class="fondo_form">
		<td colspan="5">
			Tipo de búsqueda, combinando con:
			<input type="radio" name="_tipo" id="_tipo_AND" value="AND" $chk_tipo_AND title="Restricciones de b&uacute;squeda:\nCon AND es Más RESTRICTIVA, HA DE CUMPLIR TODAS las condiciones"/><label for="_tipo_AND" title="Restricciones de b&uacute;squeda:\nCon AND es Más RESTRICTIVA, HA DE CUMPLIR TODAS las condiciones">AND</label>
			<input type="radio" name="_tipo" id="_tipo_OR" value="OR" $chk_tipo_OR title="Restricciones de b&uacute;squeda:\nCon OR es Más INCLUSIVA, PUEDE CUMPLIR CUALQUIERA de las condiciones"/><label for="_tipo_OR" title="Restricciones de b&uacute;squeda:\nCon OR es Más INCLUSIVA, PUEDE CUMPLIR CUALQUIERA de las condiciones">OR</label>
		</td>
		<td rowspan="2" colspan="2">
			<input type="submit" value="buscar"/>
		</td>
	</tr>
	<tr class="fondo_form">
		<td>Buscar:</td>
		<td class="centrada">

			<input type="checkbox" name="_campo[nombre]" id="_campo_nombre" value="nombre" $chk_nombre title="Buscar en el campo nombre"/><label for="_campo_nombre" title="Buscar en el campo nombre">en Nombre:</label>
			 
			<input type="text" name="buscar[nombre]" id="buscar_nombre" value="$buscar_nombre"/>
			<br>
			<input type="radio" name="_like[nombre]" id="_like_nombre_ini" value="ini" $chk_like_nombre_ini title="Que nombre comience por"/><label for="_like_nombre_ini" title="Que nombre comience por">ini.</label> / 
			<input type="radio" name="_like[nombre]" id="_like_nombre_fin" value="fin" $chk_like_nombre_fin title="Que nombre acabe en"/><label for="_like_nombre_fin" title="Que nombre acabe en">fin.</label> /
			<input type="radio" name="_like[nombre]" id="_like_nombre_con" value="con" $chk_like_nombre_con title="Que nombre contenga"/><label for="_like_nombre_con" title="Que nombre contenga">con</label>
		</td>

		<td class="centrada"><!--<input type="checkbox" name="_campos[apellidos]" id="_campos[apellidos]" value="apellidos" $chk_campos_apellidos/><label for="_campos[apellidos]">apellidos</label>
			-->

			<input type="checkbox" name="_campo[apellidos]" id="_campo_apellidos" value="apellidos" $chk_apellidos title="Buscar en el campo apellidos"/><label for="_campo_apellidos" title="Buscar en el campo apellidos">en Apellidos:</label>

			<input type="text" name="buscar[apellidos]" id="buscar_apellidos" value="$buscar_apellidos"/>
			<br>
			<input type="radio" name="_like[apellidos]" id="_like_apellidos_ini" value="ini" $chk_like_apellidos_ini title="Que apellidos comience por"/><label for="_like_apellidos_ini" title="Que apellidos comience por">ini.</label> / 
			<input type="radio" name="_like[apellidos]" id="_like_apellidos_fin" value="fin" $chk_like_apellidos_fin title="Que apellidos acabe en"/><label for="_like_apellidos_fin" title="Que apellidos acabe en">fin.</label> /
			<input type="radio" name="_like[apellidos]" id="_like_apellidos_con" value="con" $chk_like_apellidos_con title="Que apellidos contenga"/><label for="_like_apellidos_con" title="Que apellidos contenga">con</label></td>

		<td class="centrada"><!--<input type="checkbox" name="_campos[telefono]" id="_campos[telefono]" value="telefono" $chk_campos_telefono/><label for="_campos[telefono]">telefono</label>
			-->

			<input type="checkbox" name="_campo[telefono]" id="_campo_telefono" value="telefono" $chk_telefono title="Buscar en el campo telefono"/><label for="_campo_telefono" title="Buscar en el campo telefono">en Telefono:</label>

			<input type="text" name="buscar[telefono]" id="buscar_telefono" value="$buscar_telefono"/>
			<br>
			
			<input type="radio" name="_like[telefono]" id="_like_telefono_ini" value="ini" $chk_like_telefono_ini title="Que telefono comience por"/><label for="_like_telefono_ini" title="Que telefono comience por">ini.</label> / 
			<input type="radio" name="_like[telefono]" id="_like_telefono_fin" value="fin" $chk_like_telefono_fin title="Que telefono acabe en"/><label for="_like_telefono_fin" title="Que telefono acabe en">fin.</label> /
			<input type="radio" name="_like[telefono]" id="_like_telefono_con" value="con" $chk_like_telefono_con title="Que telefono contenga"/><label for="_like_telefono_con" title="Que telefono contenga">con</label></td>

		<td class="centrada"><!--<input type="checkbox" name="_campos[email]" id="_campos[email]" value="email" $chk_campos_email/><label for="_campos[email]">email</label>
			-->

			<input type="checkbox" name="_campo[email]" id="_campo_email" value="email" $chk_email title="Buscar en el campo email"/><label for="_campo_email" title="Buscar en el campo email">en eMail:</label>

			<input type="text" name="buscar[email]" id="buscar_email" value="$buscar_email"/>
			<br>
			<input type="radio" name="_like[email]" id="_like_email_ini" value="ini" $chk_like_email_ini title="Que email comience por"/><label for="_like_email_ini" title="Que email comience por">ini.</label> / 
			<input type="radio" name="_like[email]" id="_like_email_fin" value="fin" $chk_like_email_fin title="Que email acabe en"/><label for="_like_email_fin" title="Que email acabe en">fin.</label> /
			<input type="radio" name="_like[email]" id="_like_email_con" value="con" $chk_like_email_con title="Que email contenga"/><label for="_like_email_con" title="Que email contenga">con</label></td>

		<!-- aqui van las dos columnas que hemos extendido desde arriba -->
	</tr>	
	<tr>
		<th><a href="?campo=activo&orden=ASC">activo</a> <a href="?campo=activo&orden=DESC">^</a></th>
		<th><a href="?campo=nombre&orden=ASC">nombre</a> <a href="?campo=nombre&orden=DESC">^</a></th>
		<th><a href="?campo=apellidos&orden=ASC">apellidos</a> <a href="?campo=apellidos&orden=DESC">^</a></th>
		<th><a href="?campo=telefono&orden=ASC">telefono</a> <a href="?campo=telefono&orden=DESC">^</a></th>
		<th><a href="?campo=email&orden=ASC">email</a> <a href="?campo=email&orden=DESC">^</a></th>
		<th></th>
		<th></th>
	</tr>
	<tr>
	<td colspan="7">
	
	<div id="botones"><input type="button" value="Coleccionar datos" onclick="coleccionar_datos();"/>
	</div>
	<div id="condiciones">+++</div>
	<div id="listado_remoto">***</div>
	</td>
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