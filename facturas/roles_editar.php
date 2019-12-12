<?php //roles_editar.php

require_once("inc/config.inc.php");

//tomo la plantilla principal
$plantilla = new plantilla(_ruta_plantillas."_html.html", ES_FICHERO);

//id, idk, nombre, descripcion, alta, ultimo, notas, activo
//establecemos las variables vacías para que no de la lata...
$id= $idk= $nombre= $descripcion= $alta= $ultimo= $notas = $chk_activo ="";

$errores=0;
$sql="";
if(isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];
	$sql="SELECT * FROM roles WHERE id='$id'";
}elseif(isset($_REQUEST["id"])){
	$id = $_REQUEST["id"];
	$sql="SELECT * FROM roles WHERE id='$id'";
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
		$n = $resultados->num_rows;
		if($n > 0){
			//existe y lo cargamos
			$datos = $resultados->fetch_assoc();
			foreach($datos as $campo => $valor){
				//cargamos las variables por su nombre y el uso de $$ tomando el valor
				//desde el registro que leemos ($datos)
				$$campo = $valor;
			}
			//ahora personalizamos el campo alta
			//1990-12-31T23:59:60Z
			print "Alta: $alta";
			// list($d,$t)=explode(" ", $alta);
			// list($ano,$mes,$dia) = explode("-", $d);
			// list($hora,$min,$seg) = explode(":", $t);
			// $alta = "$ano-$mes-$dia"."T$hora:$min:$seg"."Z";

		}else{
			//no hay resultados para el rol indicado
			$errores++;
			$msg="no hay resultados para el rol indicado ($id) ¿Existe?";
		}
	}

}else{
	$errores++;
	$msg="Debe indicarse un rol a editar, no se ha indicado ninguno";
}

if($errores > 0){
	$contenido = "Hay errores, verifique los datos y repita el proceso.
	<br>$msg<br>
	O hable con el administrador.";
}else{
	//asignamos el contenido para crear el formulario de edición
	$contenido=<<<fin
	Hola, esta es la ficha de un nuevo ROL,
	<br>Por favor, rellene los siguientes campos:

	<form action="roles_grabar.php" method="post">
		<br>id: <input type="text" name="id" id="id" value="$id" disabled/>
		<br>idk: <input type="text" name="idk" id="idk" value="$idk"/>

		<br>Nombre: <input type="text" name="nombre" id="nombre" value="$nombre"/>
		<br>Descripcion: <br><textarea name="descripcion" id="descripcion">$descripcion</textarea>
		
		<br>Alta: <input type="datetime-local" name="alta" id="alta" value="$alta" />
		<br>Ultimo: <input type="text" name="ultimo" id="ultimo" value="$ultimo" disabled/>

		<br>Notas: <br><textarea name="notas" id="notas">$notas</textarea>	
		<br><input type="checkbox" name="activo" id="activo" value="1" $chk_activo/> Activo
		<br><input type="submit" value="Enviar"/>
	</form>
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