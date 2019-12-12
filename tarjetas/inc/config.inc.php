<?php //config.inc.php
error_reporting(15);
ini_set("display_errors",1);

if(file_exists("/Applications/MAMP/htdocs/local.txt")){
	//local
	define("_donde", "local");

	define("_db_server", "localhost");
	define("_db_user", "root");
	define("_db_pass", "root");
	define("_db_database", "redirecciones");

}else{
	//remoto
	define("_donde", "remoto");

	define("_db_server", "localhost");
	define("_db_user", "dbo721000029");
	define("_db_pass", "1Clave+Facil!");
	define("_db_database", "db721000029");

}

//activa la informacion de debug
define('_d', TRUE);
//define('_d', FALSE);

//activa la impresion de la info de debug
define('_p', TRUE);
//define('_p', FALSE);

$mysqli = new Mysqli(_db_server, _db_user, _db_pass, _db_database);
?>