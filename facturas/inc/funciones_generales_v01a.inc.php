<?php //funciones_generales_v01a.inc.php
/*
Este fichero carga una serie de funciones generales para utilizar al importar
el fichero config.inc.php

Fichero: funciones_generales_v01a.inc.php
Autor: Devta
Version: 01a
Fecha: 2018-01-19
*/

/*
//comprobamos si en la sesion existe un historial de URIs
if(
	!isset($_SESSION["sesion"])
){
	$_SESSION["sesion"]=array();
}

//establece el inicio de la sesion
if(!isset($_SESSION["sesion"]["inicio"])){
	$_SESSION["sesion"]["inicio"]= tiempo();
}

//establece el ultimo acceso de esta sesion
$_SESSION["sesion"]["ultimo"]= tiempo();

//establece el número de páginas de esta sesion
if(!isset($_SESSION["sesion"]["n_pag"])){
	//si no existe lo ponemos a 1 (esta pagina cuenta)
	$_SESSION["sesion"]["n_pag"] = 0;
}
//si ya existe, le sumamos 1
$_SESSION["sesion"]["n_pag"]++;



//establece la ip de esta sesion
if(!isset($_SESSION["sesion"]["ip"])){
	$_SESSION["sesion"]["ip"]= $_SERVER["REMOTE_ADDR"];
}
//establece el navegador
if(!isset($_SESSION["sesion"]["navegador"])){
	$_SESSION["sesion"]["navegador"]= $_SERVER["HTTP_USER_AGENT"];
}



id_visitante();
// //establece el id de sesion (visitante unico y sesion)
// if(!isset($_SESSION["sesion"]["id_visitante"])){
// 	$_SESSION["sesion"]["id_sesion"]= md5($_SESSION["sesion"]["ip"].$_SESSION["sesion"]["navegador"].tiempo());
// 	setcookie("visitor_id",$_SESSION["sesion"]["id_sesion"],tiempo("1A"));
// }

//establece el id de sesion (visitante unico y sesion)
if(!isset($_SESSION["sesion"]["inicio"])){
	$_SESSION["sesion"]["inicio"]= tiempo();
}




//establece el array de historial de URIs
if(
	!isset($_SESSION["sesion"]["history"])
	OR !is_array($_SESSION["sesion"]["history"])
){
	$_SESSION["sesion"]["history"]=array();
}
//añadimos la presente página al historial
$mt = tiempo();
$_SESSION["sesion"]["history"][$mt] = $_SERVER["REQUEST_URI"];

registrar();


function id_visitante(){
//establece el id de sesion (visitante unico y sesion)
	if(!isset($_SESSION["sesion"]["id_visitante"])){
		$_SESSION["sesion"]["id_sesion"]= md5($_SESSION["sesion"]["ip"].$_SESSION["sesion"]["navegador"].tiempo());
		$_SESSION["sesion"]["id_visitante"] = $_SESSION["sesion"]["id_sesion"];
		setcookie("visitor_id",$_SESSION["sesion"]["id_sesion"],tiempo("1A"));
		return($_SESSION["sesion"]["id_visitante"]);
	}else{
		return($_SESSION["sesion"]["id_visitante"]);
	}
}

//esta funcion reuno los datos de la sesion de navegación y los actualiza
//pagina actual
//pagina referente
//tiempo
//ip
//navegador
//inicio de sesion
//numero de paginas desde inicio de sesion
function registrar(){
	$pagina_actual = $_SERVER["REQUEST_URI"];
	
	if(isset($_SERVER["HTTP_REFERER"])){
		$pagina_referente = $_SERVER["HTTP_REFERER"];
	}else{
		$pagina_referente = "";
	}
	
	$ip = $_SERVER["REMOTE_ADDR"];
	$nav = $_SERVER["HTTP_USER_AGENT"];
	
	if(isset($_SESSION["sesion"]["id_visitante"])){
		$id_visitante = $_SESSION["sesion"]["id_visitante"];
	}else{
		$id_visitante = $_SESSION["sesion"]["id_visitante"];
	}

	$sesion_inicio = $_SESSION["sesion"]["inicio"];
	$sesion_ultimo = $_SESSION["sesion"]["ultimo"];
	$sesion_n_pag = $_SESSION["sesion"]["n_pag"];

	$sql = <<<fin
	INSERT INTO registro SET
	pagina_actual='$pagina_actual',
	pagina_referente='$pagina_referente',
	ip='$ip',
	nav='$nav',
	id_visitante='$id_visitante',
	sesion_inicio='$sesion_inicio',
	sesion_ultimo='$sesion_ultimo',
	sesion_n_pag='$sesion_n_pag'
fin;

	$mysqli2 = new Mysqli(db_server, db_user, db_pass, db_database);
	$mysqli2->query($sql);
	//$id = $mysqli2->last_insert_id;
	//if(_p){print "Registro: $id";}
	//return($id);
}
*/
/*
CREATE TABLE registro (
	id int not null auto_increment primary key,
	pagina_actual VARCHAR(1024) null,
	pagina_referente VARCHAR(1024) null,
	ip VARCHAR(30) null,
	nav VARCHAR(1024) null,
	id_visitante VARCHAR(50) null,
	sesion_inicio DECIMAL(21,9) null,
	sesion_ultimo DECIMAL(21,9) null,
	sesion_n_pag INT null
);
*/

/*
function tiempo($desplazamiento=0){
	list($m,$t)=explode(" ", microtime());
	list($cero,$micro)=explode(".", $m);
	$tiempo = $t.".".$micro;

	if(is_string($desplazamiento)){
		$que = substr($desplazamiento, -1);
		$cuanto = substr($desplazamiento,0,-1);
		if(substr($cuanto,-1)=="-"){
			$cuanto = substr($desplazamiento,0,-2);
			$signo = -1;
		}else{
			$cuanto = substr($desplazamiento,0,-1);	
			$signo = 1;
		}
		
		if(_p){print "desplazamiento: $desplazamiento / que: $que / cuanto: $cuanto / signo: $signo **** ";}
		switch($que){
			case 'A'://años. Cada año son 365 días de 86400 segundos
			{
				$at = 365 * 86400 * $cuanto; 
				break;
			}

			case 'M'://meses de 30 días de 86400 segundos
			{
				$at = 86400 * 30 * $cuanto; 
				break;
			}	

			case 'd'://días de 24 horas de 60 minutos de 60 segundos, 86400 segundos
			{
				$at = 24 * 60 * 60 * $cuanto;//86400 * cuanto
				break;
			}

			case 'h'://horas de 60 minutos de 60 segundos = 3600 segudos
			{
				$at = 3600 * $cuanto;
				break;
			}
			case 'm'://minutos de 60 segundos
			{
				$at = 60 * $cuanto;
				break;
			}						
			case 's'://segundos
			{
				$at = $cuanto;
				break;
			}
			default://por defecto no añadimos ningún segundo
			{
				$at=0;
				break;
			}
		}
	}else{
		$at=0;
	}

	//if($desplazamiento == 0){
	if($at == 0){
		//generamos una cadena con los segundos y microsegundos
		$tiempo = $t.".".$micro;
	}else{
		//generamos una cadena con los segundos y microsegundos
		//pero añadiendo (o restando, depende del signo) el tiempo de desplazamiento
		$tiempo = ($t+($signo * $at)).".".$micro;
	}
	//imprimimos el tiempo y sus componentes
	if(_p){print "t: $t - at: $at - micro: $micro >> tiempo: $tiempo";}
	return($tiempo);
}
*/

/*
//EJEMPLOS DE USO
tiempo("3d");//añade 3 días
tiempo("2-d");//reduce 2 días
tiempo("6M");//añade 6 meses
tiempo("10A");//añade 10 años
tiempo("3h");//añade 3 horas
tiempo("3m");//añade 3 minutos
tiempo("30s");//añade 3 segundos
*/

/*
Esta función lo que hace es generar un identificador alfanumerico corto
basado en un MD5 recortado

A partir de un id dado (un número, una cadena...)
*/
function make_idk($id, $objeto=""){
		if(_p){print "\n<br>CALCULANDO idk para $objeto";}
		$md5 = md5($id);
		$idk = strrev(substr($md5,-3)).strrev(substr($md5,0,3));
		switch($objeto){
			case "tienda":
			{
				$prefijo="t-";
				break;
			}

			case "seccion":
			{
				$prefijo="s-";
				break;
			}

			case "producto":
			{
				$prefijo="p-";
				break;
			}

			case "usuario":
			{
				$prefijo="u-";
				break;
			}

			default:
			{
				$prefijo="";
				break;
			}
		}
		$idk = $prefijo.$idk;
		if(_p){print "\n<br>idk: $idk ****";}
		return($idk);
}
?>