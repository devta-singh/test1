<?php
//iniciamos una sesion con un nombre independiente
session_name("test");
session_start();

$_SESSION["log_mensajes"]=array();	
$_SESSION["log_errores"]=array();

//inicializamos el control de errores
if(!isset($_SESSION["log_mensajes"])){
	$_SESSION["log_mensajes"]=array();	
}
if(!isset($_SESSION["log_errores"])){
	$_SESSION["log_errores"]=array();	
}

function microtiempo(){
	list($microtiempo, $tiempo)=explode(" ", microtime());
	list($ano, $mes, $dia, $hora, $min, $seg)=explode(" ", date("Y m d H i s", $tiempo));
	$cadena="$ano-$mes-$dia $hora:$min:$seg";
	$cadena_completa=$cadena." ".$microtiempo;
	return($cadena_completa);
}
//funcion que genera el log de errores (en la sesión)
function _e($error){
	if(!isset($_SESSION["log_errores"])){
		$_SESSION["log_errores"]=array();
	}
	
	if($error=="*"){
		$errores=$_SESSION["log_errores"];
		foreach($errores as $cuando => $error){
			print "<br/><br/>$cuando<br/>------------------------------------<br/>Error:".nl2br($error);
		}
		return(true);		
	}
	
	$_SESSION["log_errores"][microtiempo()]=$error;
}

//funcion que genera el log de mensajes (en la sesión)
function _m($mensaje){
	if(!isset($_SESSION["log_mensajes"])){
		$_SESSION["log_mensajes"]=array();
	}
	if($mensaje=="*"){
		$mensajees=$_SESSION["log_mensajes"];
		foreach($mensajees as $cuando => $mensaje){
			print "<br/><br/>$cuando<br/>------------------------------------<br/>Mensaje:".nl2br($mensaje);
		}
		return(true);		
	}	
	$_SESSION["log_mensajes"][microtiempo()]=$mensaje;
}

//definimos algunos valores dependientes del servidor donde se ejecuta,
//como los parametros de conexion MySQL
//if(file_exists("/opt/lampp/htdocs/test/formularios/config.inc.php")){
if(file_exists("/Applications/MAMP/htdocs/toolbox/facturas_pdf/formularios/config.inc.php")){	
	//rutas de la aplicación
	//define("_ruta_base", "/opt/lampp/htdocs/test/formularios/");
	//define("_url_base", "http://localhost/test/formularios/");


	define("_ruta_base", "/Applications/MAMP/htdocs/toolbox/facturas_pdf/formularios/");
	define("_url_base", "http://localhost:8888/facturas_pdf/formularios/");
	

	// //valores de MySQL
	// define("_db_server", "localhost");
	// define("_db_user", "root");
	// define("_db_pass", "");
	// define("_db_database", "unamente");
	define("_donde", "local");

	define("_db_server", "localhost");
	define("_db_user", "root");
	define("_db_pass", "root");
	define("_db_database", "redirecciones");

//}elseif(file_exists("/opt/lampp/htdocs/test/formularios/inc/config.inc.php")){
}elseif(file_exists("/homepages/24/d256952972/htdocs/unamente.es/test/formularios/")){
	//phpinfo();
	//rutas de la aplicación
	//	/homepages/24/d256952972/htdocs/unamente.es/test/formularios/test_form_suscripcion_v1.php
	define("_ruta_base", "/test/formularios/");
	define("_url_base", "http://localhost/test/formularios/");
	
	//valores de MySQL
	define("_db_server", "localhost:/tmp/mysql5.sock");
	define("_db_user", "dbo331629839");
	define("_db_pass", "selena12");
	define("_db_database", "db331629839");
}else{
	die("Servidor desconocido, revise la configuración");
	//phpinfo();
	//rutas de la aplicación
	//	/homepages/24/d256952972/htdocs/unamente.es/test/formularios/test_form_suscripcion_v1.php
	define("_ruta_base", "/homepages/24/d256952972/htdocs/unamente.es/test/formularios/");
	define("_url_base", "http://localhost/test/formularios/");
	
	//valores de MySQL
	define("_db_server", "localhost:/tmp/mysql5.sock");
	define("_db_user", "dbo331629839");
	define("_db_pass", "selena12");
	define("_db_database", "db331629839");
}

//ahora conectamos a MySQL
if(
	($cnx=mysql_connect(_db_server, _db_user, _db_pass)) 
	&& ($res=mysql_select_db(_db_database, $cnx)
)){
	define('_db_cnx', $cnx);
	print "Conectado";
}else{
	print "Error al conectar";	
}

include_once("clase_campo_html_v1b.php");
include_once("clase_formulario_html_v2c.php");

?>