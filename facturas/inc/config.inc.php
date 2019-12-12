<?php //login/inc/config.inc.php

//control de errores
error_reporting(15);
ini_set("display_errors", 1);

//para el debug
define("_d", TRUE);//habilita el debug
//define("_d", FALSE);//deshabilita el debug

//para el debug
define("_p", TRUE);//habilita la salida con print en debug
//define("_p", FALSE);//deshabilita la salida con print en debug

//para el debug
define("_ver_sql", 1);//habilita que se muestre el SQL
//define("_ver_sql", 0);//deshabilita que se muestre el SQL


//datos para conexion Mysqli
define("_db_server", "localhost");
define("_db_user", "root");
define("_db_pass", "root");
define("_db_database", "facturas");

//rutas
define("_ruta_base", "/Applications/MAMP/htdocs/toolbox/facturas/");
define("_ruta_plantillas", _ruta_base."plantillas/");
define("_ruta_inc", _ruta_base."inc/");
define("_ruta_clases", _ruta_inc."clases/");

define("ES_FICHERO", 1);


//incluimos las funciones generales
require_once(_ruta_inc."funciones_generales.inc.php");

//incluimos la clase plantilla
require_once(_ruta_clases."clase_plantilla.php");


//clases
//require_once(_ruta_clases."clase_base.inc.php");
//require_once(_ruta_clases."clase_login.inc.php");
//require_once(_ruta_clases."clase_login_usuario.inc.php");

//abrimos una sesion
//con el nombre "login_usuarios"
define("_nombre_sesion", "facturas");
session_name(_nombre_sesion);//ponemos nombre a la sesión
session_start();//abrimos la sesión

//leemos el navegador, la ip y el timestamp
$nav = $_SERVER["HTTP_USER_AGENT"];
$ip = $_SERVER["REMOTE_ADDR"];

//con todo ello creamos un identificador de sesión y lo registramos en la BBDD

//marcamos el navegador con una cookie


ini_set("display_errors", 1);
error_reporting(15);




//$socket  = "/tmp/mysql5.sock";
$socket  = "localhost";

$mysqli = mysqli_connect(_db_server, _db_user, _db_pass, _db_database);
$mysqli->query("SET NAMES 'utf8'");

if(mysqli_connect_errno())
{
	echo '<p>Error MySQL Server: '.mysqli_connect_error().'</p>';
}else{
	//echo '<p>Conectado a MySQL Server.</p>';
}



?>