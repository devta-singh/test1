<?php //contacto_buscar_activo_V01a.php
//	/Applications/MAMP/htdocs/toolbox/facturas/guardar_busqueda.php

error_reporting(15);
ini_set("display_errors", 1);

require_once("inc/config.inc.php");
//establezco la lista de campos

//print nl2br(print_r($_REQUEST),1);
//exit();
//print "nombre: ".$_REQUEST["nombre"]."<br>";
//print "sql: ".$_REQUEST["sql"]."<br>";

//establecemos el objeto base de datos
$mysqli = mysqli_connect(_db_server, _db_user, _db_pass, _db_database);
$mysqli->query("SET NAMES 'utf8'");

$nombre= $_REQUEST["nombre"];
$sql= ($_REQUEST["sql"]);
$_sql= addslashes($_REQUEST["sql"]);
$__sql = $mysqli->real_escape_string($sql);

$cuando = time();

print "SQL: $sql<br>";
print "_SQL: $_sql<br>";
print "__SQL: $__sql<br>";



//buscamos una consulta con ese SQL
$sql_consulta="SELECT * FROM busquedas WHERE consulta='$_sql'";
$sql_insercion="INSERT INTO busquedas SET nombre ='$nombre', consulta='$sql' , alta = '$cuando'";

print "SQL consulta: $sql_consulta<br>";
print "SQL inserción: $sql_insercion<br>";


$resultado = $mysqli->query($sql_consulta);
$n = $resultado->num_rows;
print "filas devueltas: $n<br>";
//comprobamos si hay una busqueda con ese SQL
if($n>0){
	//hay una busqueda con ese SQL

	//recuperamos los datos de esa busqueda
	$datos = $resultado->fetch_assoc();

	//obtenemos su id
	$id = $datos["id"];

	$mensaje = "Consulta recuperada con éxito con id: $id";

}else{
	//no hay una consulta con ese SQL

	//insertamos ese SQL, creando una consulta nueva
	$resultado2=$mysqli->query($sql_insercion);
	if($mysqli->error){
		//error al ejecutar la consulta

		//recuperamos el numero de error
		$numerror = $mysqli->errno;
		//recuperamos el texto del error
		$error = $mysqli->error;
		//montamos el mensaje
		$mensaje="Erro ($numerror) al insertar la consulta $sql:<br>$error";
	}else{
		//no hay error al ejecutar la consulta
		$id = $mysqli->insert_id;
		$mensaje = "Consulta almacenada con éxito con id: $id";

		//ahora le generamos el idk
		$idk = make_idk($id);
		//ahora actualizamos el idk en la tabla
		$sql_idk = "UPDATE busquedas SET idk='$idk' WHERE id='$id'";
		print $sql_idk;
		$mysqli->query($sql_idk);
		if($mysqli->error){
			$errornum=$mysqli->errno;
			$error=$mysqli->error;
			print "Ha fallado ($errornum) el poner el idk al registro <strong>$id</strong><br>$error";
		}else{
			// no hay error
			if($mysqli->affected_rows){
				print "Parece que hubo éxito";
			}else{
				//quizá el valor ya estaba establecido?
				print "quizá el valor ya estaba establecido?";
			}
		}
	}

}
	
/*
CREATE TABLE `busquedas` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `idk` varchar(35) NOT NULL DEFAULT '-sin-clave-',
  `nombre` varchar(255) NOT NULL,
  `consulta` text NOT NULL,
  `bbdd` varchar(255) NOT NULL DEFAULT '',
  `alta` datetime DEFAULT NULL,
  `ultimo` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `errores` int(11) NOT NULL DEFAULT '0',
  `funciona` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `busquedas`
  ADD UNIQUE KEY `idk` (`idk`),
  ADD UNIQUE KEY `consulta` (`consulta`(255));
*/

$listado="<table>";
$listado.="<tr><td colspan=\"6\">Nombre: $nombre</td></tr>";
$listado.="<tr><td colspan=\"6\">SQL: $sql</td></tr>";
$listado.="<tr><td colspan=\"6\">$mensaje</td></tr>";
$listado.="</table>";

header("Content-type: text/html; charset=utf-8;");
print $listado;

?>