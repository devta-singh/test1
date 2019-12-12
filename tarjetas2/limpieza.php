<?php //limpieza.php

error_reporting(15);
ini_set("display_errors", 1);

require("inc/config.inc.php");

/*
Este programa hace una limpieza de la carpeta imagenes
*/

$msg="";

$sql_recupera = "SELECT * FROM tarjetas";
if($resultados = $mysqli->query($sql_recupera)){

	if($resultados->num_rows > 0){
		$tarjetas=array();
		$qrs=array();
		while($datos = $resultados->fetch_assoc()){
			$id = $datos["id"];
			$tarjeta = $datos["tarjeta"];
			$qr = $datos["qr"];
			
			$tarjetas[$id] = $tarjeta;
			$qrs[$id] = $qr;
		}

		//ahora leemos los ficheros del directorio imagenes
		$d = opendir("./imagenes/");
		while($f=readdir($d)){
			$msg.="<br>leido: $f ";
			if(is_dir("./imagenes/$f")){
				$msg.="Es directorio";
				continue;
			}else{
				$msg.="NO Es directorio";
			}

			if(in_array(("imagenes/".$f), $tarjetas)){
				//no hacemos nada
				$msg.="Esta registrado";
			}else{
				$msg.="No Está registrado";
				//lo borramos
				if(unlink("imagenes/".$f)){
					$msg.="Borrado";
				}else{
					$msg.="No se pudo borrar";
				}
			}
		
		}

	//ahora leemos los ficheros del directorio imagenes
		$msg.="<br>ahora leemos los qr ";
		$d = opendir("./qr/");
		while($f=readdir($d)){
			$msg.="<br>leido: $f ";
			if(is_dir("./qr/$f")){
				$msg.="Es directorio";
				continue;
			}else{
				$msg.="NO Es directorio";
			}

			if(in_array(("qr/".$f), $tarjetas)){
				//no hacemos nada
				$msg.="Esta registrado";
			}else{
				$msg.="No Está registrado";
				//lo borramos
				if(unlink("qr/".$f)){
					$msg.="Borrado";
				}else{
					$msg.="No se pudo borrar";
				}
			}
		
		}		
	}else{
		$msg.="No hay FILAS";
	}
}else{
	$errno = $mysqli->errno;
	$error = $mysqli->error;
	$msg.="<br>error ($errno) $error <br>al ejecutar consulta<br>SQL: $sql_recupera;";
}

if(_p){
	//print $msg;
}

if(_donde == "remoto"){
	header("Location: http://circulodesanacion.org/r/img/transp.png");
}

?>