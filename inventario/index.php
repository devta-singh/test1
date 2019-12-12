<?php //toolbox/inventario/index.php

error_reporting(15);
ini_set("display_errors", 1);

//require("inc/config.inc.php");

$user = 'root';
$password = 'root';
$db = 'espacio';
$host = 'localhost';
$port = 8889;

//$link = mysql_connect("$host:$port", $user, $password);
$link = mysql_connect("$host:$port", $user, $password);

$mysqli = new Mysqli("$host:$port", $user, $password, $db);
$db_selected = mysql_select_db(
   $db, 
   $link
);

//$mysqli = new Mysqli("localhost:8889", "root", "root", "/Applications/MAMP/tmp/mysql/mysql.sock");




if(!isset($_REQUEST["_ruta"])){
	$d = opendir("/VOLUMES");
	$carpeta = "/VOLUMES";
	while($f=readdir($d)){
		$ruta = $d."/";
		$ruta_completa = $ruta.$f;
		$carpeta_completa = $carpeta."/".$f;

		$es_dir = 0;
		$es_fich = 0;
		$tam = 0;

		$alta = time();


		
		//print "$f";
		print "<br><a href=\"?_ruta=$carpeta_completa\">$f</a>";
		if(is_dir($ruta_completa)){
			print " D ";
			$es_dir=1;
		}
		if(is_file($ruta_completa)){
			print " F ";
			$es_fich = 1;
		}
		$tam=0;
		if($tam = @filesize($ruta_completa)){
			//print "/ tam: $tam bytes ";
		}else{
			//print "/ vacío (tam: $tam bytes) ";
		}

		//CREAMOS EL DISCO
		$sql = "INSERT INTO discos SET nombre='$ruta_completa', alta='$alta'";
		$recursos = $mysqli->query($sql);
		if(!$mysqli->error){
			if($mysqli->affected_rows){
				$id_disco = $mysqli->insert_id;
			}else{
				$sql2 = "SELECT id, nombre FROM discos WHERE nombre = '$ruta_completa'";
				$r=$mysqli->query($sql2);
				if($r && $r->num_rows){
					$datos = $r->fetch_assoc();
					$id_disco = $datos["id"];
				}
			}
		}else{
			$num_filas = $mysqli->affected_rows;
			print "$num_filas Filas afectadas ";
		}
	}
}//fin if
else{
	$_ruta = $_REQUEST["_ruta"];
	recorrer($_ruta);
}


//leemos en la carpeta /VOLUMES
function recorrer($_ruta){
	set_time_limit(30);
	$d = opendir($_ruta);//"/VOLUMES");
	while($f=readdir($d)){
		if(!strpos($ruta,"$f")){
			$ruta = $_ruta."/";
		}
		$ruta_completa = $ruta.$f;

		//print "$f";
		print "<br><a href=\"?_ruta=$ruta_completa\">$f</a>";
		if(is_dir($ruta_completa)){
			print " D ";

			//LLAMADA RECURSIVA
			recorrer($ruta_completa);
		}
		if(is_file($ruta_completa)){
			print " F ";
		}
		$tam = @filesize($ruta_completa);
		if($tam > 0){
			print " $tam bytes ";
		}else{
			print " vacío";
		}
	}
}

?>