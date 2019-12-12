<?php //factura_png_v0.04a.php
/*
Fichero: factura_png_v0.04a.php
Version: v0.03a

Url: http://localhost:8888/toolbox/tarjetas/factura_png.php
Aplicación: Tarjetas personalizadas

Autor: Devta Singh
Fecha: 2019-03-27
Con un enlace que Monta las FACTURA EN UN PDF

Cambios:
//Genera el código QR con una URL para esta tarjeta

Añade la tarjeta a la base de datos
1 Crea una redirección para esta FACTURA (personalizada)
2 Graba la FACTURA en una carpeta de tarjetas acabadas, para poder listarla
3 Borra las tarjetas anteriores

*/


/*
Cuando llega desde la lista de facturas:
http://localhost:8888/toolbox/tarjetas/texto_sobre_imagen.php?id=42
Y no carga ninguna imagen, debería cargar al menos la plantilla png seleccionada (id=42)

Cuando se acciona el botón GENERAR del formulario:
http://localhost:8888/toolbox/tarjetas/texto_sobre_imagen.php?buscar_imagen=1


*/


//http://localhost:8888/toolbox/tarjetas/texto_sobre_imagen.php?buscar_imagen=1&lugar=madrid&tel=662%20529%20000&email=madrid@circulodesanacion.org&poblacion=Madrid&direccion1=O%27donnell&direccion2=C/Hermosilla,%20126


error_reporting(15);
ini_set("display_errors",1);

require("inc/config.inc.php");

$directorio="./fondos";
$ruta_cfg="./cfg";
$msg="";

list($segundos,$micro)=explode(" ", microtime());
$pre_idk = (($segundos + $micro).  $_SERVER["HTTP_USER_AGENT"] .  $_SERVER["REMOTE_ADDR"]);
$md5 = md5($pre_idk);
$idkp = substr($md5, -3) . substr($md5, 0,3);

/*
if(!isset($_REQUEST["buscar_imagen"])){
	header("Location: seleccionar_tarjeta.php");
}

$d= opendir($directorio);
//print "Abierto el directorio: $directorio<br>";

if(!isset($_REQUEST["fondo"])){
	 header("Location: seleccionar_tarjeta.php?msg=Debe+Seleccionar+una+Tarjeta");
}
$fich = $_REQUEST["fondo"];
$fondo = $_REQUEST["fondo"];
*/
//$fondo = "fondos/MDC_para_personalizar.png";


//recuperamos las variables de texto

//$fondo = "fondos/Tarjeta_MDC_con_fondo_prueba_para_QR.png";
//$fondo = "$fondofondos/Tarjeta_MDC_con_fondo_prueba_para_QR.png";

if(isset($_REQUEST["fondo"])){
	$fondo = $_REQUEST["fondo"];
//}elseif(file_exists($directorio."/"."")){
//}elseif(file_exists("fondos/Factura_unamente_blanco.png")){	
}elseif(file_exists("./fondos/papel_factura.png")){		
	//$fondo = "./fondos/Factura_unamente_blanco.png";
	$fondo = "./fondos/papel_factura.png";
	//$fondo = $_REQUEST["fondo"];
}else{
	//$fondo = "fondos/Factura_unamente_blanco.png";
	$fondo = "./fondos/papel_factura.png";
	
}

print "fondo: $fondo";
$tamano_bytes = filesize($fondo);

//obtenemos las dimensiones de la imagen
list($a,$b) = getimagesize($fondo);
//$aa = 600;
$aa = 1122;
$bb = round(($aa*$b)/$a);

//$aa = 600;
$aaa = 600;
$bbb = round(($aaa*$b)/$a);


//print "a: $a, b:$b, aa:$aa => bb: $bb";
$datos_imagen = <<<fin
Imagen original <br>$fondo<br>ancho: $a, alto: $b
<br>Mostrada: ancho:$aaa, alto:$bbb
<br>Tamaño: $tamano_bytes bytes
fin;






/////////////////////////////////////////
/////////////////////////////////////////
/////////////////////////////////////////

/////////////
//CONFIGURACIONES
/////////////
/*
Guardamos las configuraciones
*/
// if(isset($_REQUEST["guardar_configuracion"]) && isset($_REQUEST["configuracion"])){
// 	//recuperamos los campos del formulario y los guardamos en un fichero .cfg
// 	print "GUARDANDO CONFIGURACION";
// 	//print nl2br(print_r($_REQUEST,1));
// 	$datos_configuracion=array();
// 	foreach($_REQUEST as $_campo => $_valor){
// 		print "$_campo: $_valor<br>";
// 	}
// 	//abrimos el fichero
// }else{
// 	//no hacemos nada
// }

// $html_configuraciones="<select name=\"configuracion\">";
// $html_configuraciones.="<option>-seleccione configuración-</option>";
// /*
// Recuperamos las configuraciones
// */
// //Buscamos ficheros .cfg
// $d_cfg=opendir($ruta_cfg);
// while($f_cfg=readdir($d_cfg)){
// 	if(is_dir($ruta_cfg."/".$f_cfg)){
// 		print "$f_cfg - seguimos...<br>";
// 		continue;
// 	}
// 	if((substr($f_cfg,-4)!=".cfg")){
// 		print "$f_cfg - saltamos...<br>";
// 		continue;
// 	}else{
// 		print "<strong>$f_cfg</strong> - ENCONTRADO<br>";
// 		$html_configuraciones.="<option value=\"$f_cfg\">$f_cfg</option>";
// 	}
// }
// $html_configuraciones.="</select>";
/////////////
// FIN CONFIGURACIONES
/////////////
$html_configuraciones="";

/////////////////////////////////////////
/////////////////////////////////////////
/////////////////////////////////////////
/////////////////////////////////////////	





$html=<<<fin
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.css"/>

	<!--
	<script type="text/javascript" src="http://www.technicalkeeda.com/js/javascripts/plugin/jquery.js"></script>
	-->
	<script type="text/javascript" src="js/jquery.js"></script>

	<script> 
		var campo_activo="campo1";
		var x,y,xx,yy,a,b,aa,bb;
		var nombre_campo="";

		$(document).ready(function() {
			 $('#tarjeta').click(function(e) {
				a=$a;
				b=$b;
				aa=$aa;
				bb=$bb;
				//alert('leyendo xy en imagen, campo_activo:'+campo_activo);
				var offset = $(this).offset();

				//El codigo viejo hacía todo junto
				//$('#x_axis').html(e.clientX - offset.left);
				//$('#y_axis').html(e.clientY - offset.top);

				//hacemos el calculo para obtener x e y
				x=e.clientX - offset.left;
				y=e.clientY - offset.top;

				$('#x_axis').html(x);
				$('#y_axis').html(y);

				//$bb = round(($aa*$b)/$a);
				xx=Math.round((a*x)/aa); 
				yy=Math.round((b*y)/bb); 

				$('#textos_x_'+campo_activo).val(xx);
				$('#textos_y_'+campo_activo).val(yy);
			 });

			 //ocultamos las instrucciones
			 $('#instrucciones').fadeOut(1000);

		});
	</script>
</head>
<body>
<h3>Creador de Tarjetas</h3>
<div>
<div id="barra">
	<form action="?buscar_imagen=1" method="post">
	<input type="submit" value="Generar FACTURA">



	<input type="text" name="fondo" value="$fondo">
	<br><a href="listado_tarjetas.php">Listado de FACTURAS</a>
	<!--<br><a href="seleccionar_tarjeta.php">Cambiar imagen de fondo</a>-->
	<!--<br>X:<span id="x_axis">0</span> / Y:<span id="y_axis">0</span>-->

	<br><span onclick="$('#instrucciones').toggle();">Instrucciones...</span>
	<div id="instrucciones">Creador de tarjetas - v3.01a<br>
	1. Utilizar los campos para poner los textos (de una sola línea)
	<br>2. pulsa en el botón GENERAR FACTURA
	<br>3. Sobre la imagen, dale a guardar imagen como y descargala
	<br>4. Puedes generar un PDF con la imágen.
	<br>4. Puedes enviar la factura al email del destinatario.
	</div>
	<br>
fin;

////////////////
//FUENTES
////////////////

////////////////
//FIN FUENTES
////////////////
$html_fuentes="";





////////////////
//FIN CAMPOS
////////////////


////////////////
//FIN CAMPOS
////////////////



//Esto va al inicio
$visitas = 0;
$cambios = 0;
$ip = $_SERVER["REMOTE_ADDR"];
$nav = $_SERVER["HTTP_USER_AGENT"];
$alta = date("Y-m-d H:i:s", time());
$activo=1;
$notas="";

$campos_texto=explode(",", "lugar,tel1,tel2,email,direccion1,direccion2,direccion3,notas");
foreach($campos_texto as $campo => $valor){
	$valor = addslashes($valor);
	//$valor = str_replace("'","´",$valor);
	$$campo = $valor;
}




//si se indica el id, podemos probar a recuperar los datos de la tabla
if(isset($_REQUEST["id"])){
	$id=$_REQUEST["id"];


	$sql_recupera = "SELECT * FROM tarjetas WHERE id='$id'";
	if(
		$resultados = $mysqli->query($sql_recupera)
	){
		if($resultados->num_rows > 0){
			$datos = $resultados->fetch_assoc();
			foreach($datos as $campo=>$valor){
				$$campo = $valor;
			}//fin foreach
			//$id= $datos["id"];
			//$cambios = $datos["cambios"] + 1;
			$cambios++;
		}else{
			$msg="No hay ese registro ($id)";
		}
	}else{
		$errno = $mysqli->errno;
		$error = $mysqli->error;
		$msg="error ($errno) $error <br>al ejecutar consulta<br>SQL: $sql_recupera;";
	}




}else{
	//como no llega por id
	//recogemos los valores de los campos de texto
//------------
//FACnombre FACcif FACdireccion1 FACdireccion2 FACdireccion3 FACcodigopostal FACnumero FACfecha FACbase FACiva FACimporte

	if(isset($_REQUEST["id"])){
		$id = $_REQUEST["id"];
	}else{
		$id="";
	}


	if(isset($_REQUEST["FACtitulo"])){
		$FACtitulo = utf8_decode($_REQUEST["FACtitulo"]);
	}else{
		$FACtitulo="";
	}


	if(isset($_REQUEST["FACdescripcion1"])){
		$FACdescripcion1 = utf8_decode($_REQUEST["FACdescripcion1"]);
	}else{
		$FACdescripcion1="";
	}	
	
	if(isset($_REQUEST["FACdescripcion2"])){
		$FACdescripcion2 = utf8_decode($_REQUEST["FACdescripcion2"]);
	}else{
		$FACdescripcion2="";
	}	
	
	if(isset($_REQUEST["FACdescripcion3"])){
		$FACdescripcion3 = utf8_decode($_REQUEST["FACdescripcion3"]);
	}else{
		$FACdescripcion3="";
	}	




	if(isset($_REQUEST["FACnombre"])){
		$FACnombre = utf8_decode($_REQUEST["FACnombre"]);
	}else{
		$FACnombre="";
	}

	if(isset($_REQUEST["FACcif"])){
		$FACcif = utf8_decode($_REQUEST["FACcif"]);
	}else{
		$FACcif="";
	}


	if(isset($_REQUEST["FACdireccion1"])){
		$FACdireccion1 = utf8_decode($_REQUEST["FACdireccion1"]);
	}else{
		$FACdireccion1="";
	}	
	
	if(isset($_REQUEST["FACdireccion2"])){
		$FACdireccion2 = utf8_decode($_REQUEST["FACdireccion2"]);
	}else{
		$FACdireccion2="";
	}	
	
	if(isset($_REQUEST["FACdireccion3"])){
		$FACdireccion3 = utf8_decode($_REQUEST["FACdireccion3"]);
	}else{
		$FACdireccion3="";
	}	

	if(isset($_REQUEST["FACcodigopostal"])){
		$FACcodigopostal = utf8_decode($_REQUEST["FACcodigopostal"]);
	}else{
		$FACcodigopostal="";
	}

	if(isset($_REQUEST["FACcodigopostal"])){
		$FACcodigopostal = utf8_decode($_REQUEST["FACcodigopostal"]);
	}else{
		$FACcodigopostal="";
	}

	if(isset($_REQUEST["FACqr"])){
		$FACqr = utf8_decode($_REQUEST["FACqr"]);
	}else{
		$FACqr="";
	}	



	if(isset($_REQUEST["FACemail"])){
		$FACemail = utf8_decode($_REQUEST["FACemail"]);
	}else{
		$FACemail="";
	}

	if(isset($_REQUEST["FACtelefono"])){
		$FACtelefono = utf8_decode($_REQUEST["FACtelefono"]);
	}else{
		$FACtelefono="";
	}

	if(isset($_REQUEST["FACcontacto"])){
		$FACcontacto = utf8_decode($_REQUEST["FACcontacto"]);
	}else{
		$FACcontacto="";
	}		



	if(isset($_REQUEST["FACnumero"])){
		$FACnumero = utf8_decode($_REQUEST["FACnumero"]);
	}else{
		$FACnumero="";
	}

	if(isset($_REQUEST["FACfecha"])){
		$FACfecha = utf8_decode($_REQUEST["FACfecha"]);
	}else{
		$FACfecha="";
	}

	if(isset($_REQUEST["FACbase"])){
		$FACbase = utf8_decode($_REQUEST["FACbase"]);
	}else{
		$FACbase="";
	}

	if(isset($_REQUEST["FACiva"])){
		$FACiva = utf8_decode($_REQUEST["FACiva"]);
	}else{
		$FACiva="";
	}

	if(isset($_REQUEST["FACimporte"])){
		$FACimporte = utf8_decode($_REQUEST["FACimporte"]);
	}else{
		$FACimporte="";
	}





	// if(isset($_REQUEST["lugar"])){
	// 	$lugar = $_REQUEST["lugar"];
	// }else{
	// 	$lugar="";
	// }	

	// if(isset($_REQUEST["lugar"])){
	// 	$lugar = $_REQUEST["lugar"];
	// }else{
	// 	$lugar="";
	// }

	// if(isset($_REQUEST["lugar"])){
	// 	$lugar = $_REQUEST["lugar"];
	// }else{
	// 	$lugar="";
	// }	

	// if(isset($_REQUEST["lugar"])){
	// 	$lugar = $_REQUEST["lugar"];
	// }else{
	// 	$lugar="";
	// }

	// if(isset($_REQUEST["lugar"])){
	// 	$lugar = $_REQUEST["lugar"];
	// }else{
	// 	$lugar="";
	// }								
//------------


	if(isset($_REQUEST["poner_QR"])){
		$poner_QR = 1;
	}else{
		$poner_QR = 0;
	}

	if(isset($_REQUEST["poner_LOGO"])){
		$poner_LOGO = 1;
	}else{
		$poner_LOGO = 0;
	}

}//fin else


$FACtitulo = utf8_encode($FACtitulo);
$FACdescripcion1 = utf8_encode($FACdescripcion1);
$FACdescripcion2 = utf8_encode($FACdescripcion2);
$FACdescripcion3 = utf8_encode($FACdescripcion3);
$FACnombre = utf8_encode($FACnombre);
$FACcif = utf8_encode($FACcif);
$FACdireccion1 = utf8_encode($FACdireccion1);
$FACdireccion2 = utf8_encode($FACdireccion2);
$FACdireccion3 = utf8_encode($FACdireccion3);
$FACbase = utf8_encode($FACbase);
$FACiva = utf8_encode($FACiva);
$FACimporte = utf8_encode($FACimporte);
$FACfecha = utf8_encode($FACfecha);
$FACnumero = utf8_encode($FACnumero);
$FACemail = utf8_encode($FACemail);
$FACtelefono = utf8_encode($FACtelefono);
$FACcontacto = utf8_encode($FACcontacto);


	$html.=<<<fin
	Datos de la Factura:
		<table>
			<tr>
				<td>Título</td>
				<td><input type="text" name="FACtitulo" value="$FACtitulo"/>
				</td>
			</tr>


			<tr>
				<td>Descripción:<br>\<br>\</td>
				<td>
				<input type="text" name="FACdescripcion1" value="$FACdescripcion1"/>
				<br>
				<input type="text" name="FACdescripcion2" value="$FACdescripcion2"/>
				<br>
				<input type="text" name="FACdescripcion3" value="$FACdescripcion3"/>
				<br>
				</td>
			</tr>									

			<tr>
				<td>Nombre</td>
				<td><input type="text" name="FACnombre" value="$FACnombre"/>
				</td>
			</tr>
			<tr>
				<td>CIF:</td>
				<td><input type="text" name="FACcif" value="$FACcif"/>
				</td>
			</tr>
			<tr>
				<td>Dirección:<br>\<br>\</td>
				<td>
				<input type="text" name="FACdireccion1" value="$FACdireccion1"/>
				<br>
				<input type="text" name="FACdireccion2" value="$FACdireccion2"/>
				<br>
				<input type="text" name="FACdireccion3" value="$FACdireccion3"/>
				<br>
				</td>
			</tr>	
			<tr>
				<td>C.Postal:</td>
				<td>
				<input type="text" name="FACcodigopostal" value="$FACcodigopostal"/>
				</td>
			</tr>

			<tr>
				<td>Email:</td>
				<td><input type="text" name="FACemail" value="$FACemail"/>
				</td>
			</tr>
			<tr>
				<td>Teléfono:</td>
				<td><input type="text" name="FACtelefono" value="$FACtelefono"/>
				</td>
			</tr>
			<tr>
				<td>Contacto:</td>
				<td><input type="text" name="FACcontacto" value="$FACcontacto"/>
				</td>
			</tr>						

			<tr>
				<td>Número:</td>
				<td><input type="text" name="FACnumero" value="$FACnumero"/>
				</td>
			</tr>
			<tr>
				<td>Fecha:</td>
				<td><input type="text" name="FACfecha" value="$FACfecha"/>
				</td>
			</tr>
			<tr>
				<td>Base:</td>
				<td><input type="text" name="FACbase" value="$FACbase"/>
				</td>
			</tr>
			<tr>
				<td>IVA:</td>
				<td><input type="text" name="FACiva" value="$FACiva"/>
				</td>
			</tr>
			<tr>
				<td>Importe:</td>
				<td><input type="text" name="FACimporte" value="$FACimporte"/>
				</td>
			</tr>

		
			</tr>
				<td>logo</td>
				<td>
					<input type="checkbox" name="poner_logo" value="1"/>¿Añadir código logo?
					<br><input type="text" name="direccion3" value="http://www.estemes.com/facturas/logo/?="/>
				</td>
			</tr>

			</tr>
				<td>QR</td>
				<td>
					<input type="checkbox" name="poner_QR" value="1"/>¿Añadir código QR?
					<br><input type="text" name="direccion3" value="http://www.estemes.com/facturas/qr/?="/>
				</td>
			</tr>												
		</table>
		

fin;

	$html.=<<<fin
	<br>
	<input type="submit" value="Generar Imagen">
	</form>
	$datos_imagen
	</div>
	<div id="resultado">
fin;

	//imprimimos el html
	print $html;
	

///////////////
// IMPRESION DE TEXTOS
///////////////	
	// if(isset($_REQUEST["textos"])){

	// $fondo = $_REQUEST["fondo"];
	// $textos = $_REQUEST["textos"];

	// $im = imagecreatefrompng($fondo);
	// //header("Content-type: image/png;");
	// //imagepng($im);
	// //$color = imagecolorallocate($im, 0,0,0);
	// $color = imagecolorallocate($im, 255,255,255);

	// foreach($textos as $campo => $datos){

	// 	if(isset($_REQUEST["chk_campo"][$campo])){
	// 		$x = round($datos["x"]);
	// 		$y = round($datos["y"]);
	// 		$fuente = $datos["font"];
	// 		$texto = $datos["texto"];
	// 		$tam = $datos["tam"];
	// 		$ang = $datos["ang"];
	// 		//$color = $datos["color"];

	// 		imagettftext($im, $tam, $ang, $x, $y, $color, $fuente, $texto);
	// 	}
	// }
///////////////
// IMPRESION DE TEXTOS
///////////////	

if(isset($_REQUEST["fondo"])){

	$im = imagecreatefrompng($fondo);
	//header("Content-type: image/png;");
	//imagepng($im);
	//$color = imagecolorallocate($im, 0,0,0);
	$color = imagecolorallocate($im, 255,255,255);
	$blanco = imagecolorallocate($im, 255,255,255);
	$negro = imagecolorallocate($im, 0,0,0);

	$fuente1="fuentes/Pirulen/pirulen.ttf";
	$fuente2="fuentes/lato/Lato-Heavy.ttf";
	$fuente3="fuentes/lato/Lato-ThinItalic.ttf";
	$fuente4="fuentes/windings/wingdings.ttf";


	$x = 207;
	$ang=0;
	$tam1=28;
	$tam2=27;
	$esp1=24;
	$esp2=37;
	$y = 1500;

	// foreach($_REQUEST as $var=>$val){
	// 	print "<br>$var: $val";
	// }

	if(isset($_REQUEST["FACtitulo"]) && !empty($_REQUEST["FACtitulo"])){
		$x = 207;
		
		//imprimimimos FACtitulo
		imagettftext($im, 48, $ang, $x, $y, $negro, $fuente2, $FACtitulo);
		$y+=30;
	}
	$y+=64;//espacio extra



	if(isset($_REQUEST["FACdescripcion1"]) && !empty($_REQUEST["FACdescripcion1"])){
		$x = 207;

		//imprimimimos FACdescripcion
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente2, $FACdescripcion1);
		$y+=30;
	}
	$y+=34;//espacio extra

	if(isset($_REQUEST["FACdescripcion2"]) && !empty($_REQUEST["FACdescripcion2"])){
		$x = 207;

		//imprimimimos FACdescripcion
		imagettftext($im, 28, $ang, $x, $y, $negro, $fuente2, $FACdescripcion2);
		$y+=30;
	}
	$y+=34;//espacio extra

	if(isset($_REQUEST["FACdescripcion3"]) && !empty($_REQUEST["FACdescripcion3"])){
		$x = 207;

		//imprimimimos FACdescripcion
		imagettftext($im, 28, $ang, $x, $y, $negro, $fuente2, $FACdescripcion3);
		$y+=30;
	}
	$y+=64;//espacio extra	












	if(isset($_REQUEST["FACnombre"]) && !empty($_REQUEST["FACnombre"])){
		$x = 207;
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente3, "Nombre:");
		//imprimimimos FACnombre

		$x=800;
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente2, $FACnombre);
		
		$y+=30;
		print "<br>***FACnombre";
	}else{
		print "<br>---FACnombre";
	}
	$y+=34;//espacio extra

	if(isset($_REQUEST["FACcif"]) && !empty($_REQUEST["FACcif"])){
		$x = 207;
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente3, "CIF:");
		//imprimimimos FACnombre

		$x=800;

		//imprimimimos FACcif
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente2, $FACcif);
		$y+=30;
		print "<br>***FACcif";
	}
	$y+=64;//espacio extra

	if(isset($_REQUEST["FACdireccion1"]) && !empty($_REQUEST["FACdireccion1"])){
		$x = 207;
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente3, "Dirección:");
		//imprimimimos FACnombre

		$x=800;

		//imprimimimos FACdireccion1
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente2, $FACdireccion1);
		$y+=30;
		print "<br>***FACnombre";
	}
	$y+=34;//espacio extra

	if(isset($_REQUEST["FACdireccion2"]) && !empty($_REQUEST["FACdireccion2"])){
		//imagettftext($im, 38, $ang, $x, $y, $negro, $fuente3, "Nombre:");
		//imprimimimos FACnombre

		$x=800;

		//imprimimimos FACdireccion2
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente2, $FACdireccion2);
		$y+=30;
	}
	$y+=34;//espacio extra

	if(isset($_REQUEST["FACdireccion3"]) && !empty($_REQUEST["FACdireccion3"])){
		//imagettftext($im, 38, $ang, $x, $y, $negro, $fuente3, "");
		//imprimimimos FACnombre

		$x=800;

		//imprimimimos FACdireccion3
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente2, $FACdireccion3);
		$y+=30;
	}
	$y+=34;//espacio extra


	if(isset($_REQUEST["FACcodigopostal"]) && !empty($_REQUEST["FACcodigopostal"])){
		$x = 207;
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente3, "Código Postal:");
		//imprimimimos FACnombre

		$x=800;

		//imprimimimos FACcodigopostal
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente2, $FACcodigopostal);
		$y+=30;
	}
	$y+=64;//espacio extra

	if(isset($_REQUEST["FACnumero"]) && !empty($_REQUEST["FACnumero"])){
		$x = 207;
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente3, "Número:");
		//imprimimimos FACnombre

		$x=800;

		//imprimimimos FACnumero
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente2, $FACnumero);
		$y+=30;
	}
	$y+=34;//espacio extra

	if(isset($_REQUEST["FACfecha"]) && !empty($_REQUEST["FACfecha"])){
		$x = 207;
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente3, "Fecha:");
		//imprimimimos FACnombre

		$x=800;

		//imprimimimos FACfecha
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente2, $FACfecha);
		$y+=30;
	}
	$y+=34;//espacio extra



	if(isset($_REQUEST["FACestado"]) && !empty($_REQUEST["FACestado"])){
		$x = 207;
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente3, "Fecha:");
		//imprimimimos FACnombre

		$x=800;

		//imprimimimos FACfecha
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente2, $FACestado);
		$y+=30;
	}
	$y+=64;//espacio extra



	if(isset($_REQUEST["FACbase"]) && !empty($_REQUEST["FACbase"])){
		$x = 207;
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente3, "Base:");
		//imprimimimos FACnombre

		$x=800;

		//imprimimimos FACbase
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente2, $FACbase."€");
		$y+=30;
	}
	$y+=34;//espacio extra

	if(isset($_REQUEST["FACiva"]) && !empty($_REQUEST["FACiva"])){
		$x = 207;
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente3, "Iva:");
		//imprimimimos FACnombre

		$x=800;

		//imprimimimos FACiva
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente2, $FACiva."€");
		$y+=30;
	}
	$y+=34;//espacio extra

	if(isset($_REQUEST["FACimporte"]) && !empty($_REQUEST["FACimporte"])){
		$x = 207;
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente3, "Importe:");
		//imprimimimos FACnombre

		$x=800;

		//imprimimimos FACimporte
		imagettftext($im, 38, $ang, $x, $y, $negro, $fuente2, $FACimporte."€");
		$y+=30;
	}
	$y+=24;//espacio extra





	//print "Trozos:";
	$trozos = explode("/", $fondo);
	$n=sizeof($trozos);
	//print_r($trozos);
	
	$fichero=$trozos[($n -1)];
	$ahora=time();
	
	list($microsegundos, $segundos) = explode(" ", microtime());
	print "<br>segundos: $segundos<br>microsegundos: $microsegundos";
	$imagen = "$ahora.png";

	//$imagen = "$lugar-$ahora.jpeg";
	$destino = "imagenes/$imagen";
	//print "<br>n: $n - fichero: $fichero - destino: $destino<br>";
	




/*
if($poner_LOGO){

	//Leemos el logo en su propio fichero

	$im_logo=imagecreatefrompng("./logos/logo_KY_300px.png");

	/////////////////////////////
	//MONTAMOS EL LOGO EN LA IMAGEN
	/////////////////////////////
	
	//Copiamos el LOGO de la imagen del LOGO en la imagen de la tarjeta
	//bool imagecopy ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h )

	//Establecemos el ancho y alto del código LOGO
	list($src_w, $src_h)=getimagesize("./logos/logo_KY_300px.png");

	//Posicion Y inferior del codigo LOGO
	$base = 180;

	//Calculamos la posición superior del codigo LOGO
	$pos_y = $base - $src_h;

	//Establecemos la posicion superior mínima, para que no se pegue al texto
	//pero que si hay poco texto, se use esta como mínimo
	$pos_y_minima = ($y - 15);

	//Si la posición dada por el ultimo texto, es menor a la posición minima,
	//se utiliza la posición minima establecida anteriormente,
	//así el código LOGO no se sube demasiado, y se queda abajo
	if($pos_y < $pos_y_minima){
		$pos_y = $pos_y_minima;
	}

	//establecemos el resto de posiciones para copiar el LOGO dentro de la tarjeta
	$dst_x=850;//la posicion X, es la separación del margen izquierdo
	//$dst_y=$pos_y; //($y - 15);//$base - $src_h;//la posición superior izquierda del LOGO
	$dst_y=100; //($y - 15);//$base - $src_h;//la posición superior izquierda del LOGO

	$src_x=0;//esquina inicio izquierda del LOGO
	$src_y=0;//esquina inicio superior del LOGO

	//copiamos el LOGO de su imagen a la imagen de la tarjeta
	imagecopy($im, $im_logo, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h);

}//fin LOGO
*/


if($poner_QR){
	//////////////////
	// QR
	//////////////////
		//retomamos la imagen generada y le creamos un QR
		$url="http://unamente.es/r/f?idkp=$idkp";
		$_url = $url;
		while(strpos($_url, " ")){
			$_url = str_replace(" ", "-", $_url);
		}
		$_lugar = str_replace(" ", "-", $_url);

		$url_destino = "http://unamente.es/r/f?idkp=$idkp";

		$PNG_TEMP_DIR = "QR";//dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
	    
	    //html PNG location prefix
	    $PNG_WEB_DIR = 'temp/';

	    include "inc/qr/qrlib.php";
	    $tam_qr = 6;//así es un poco más grande y se lee mejor en la tarjeta
	    $qr_filename = $PNG_TEMP_DIR.'QR_'.md5($url_destino.'|L|'.$tam_qr).'.png';
	    $qr_filename2 = $PNG_TEMP_DIR.'QR_'.md5($url_destino.'|L|'.$tam_qr).'_2.png';
	    QRcode::png($url, "qr/".$qr_filename, 'L', $tam_qr, 2);


	/////////////////
	// FILTRO
	/////////////////      

	    //Leemos el QR Generado en su propio fichero

		$im_filtro=imagecreatefrompng("qr/".$qr_filename);
		//bool imagefilter ( resource $image , int $filtertype [, int $arg1 [, int $arg2 [, int $arg3 [, int $arg4 ]]]] )

		//Invertimos el color
		//if(_p){print "<br>1. filtro imagen invertida B/N ";}
		if(imagefilter($im_filtro, IMG_FILTER_NEGATE)){
			//if(_p){print "1. transformación exitosa";}
		}else{
			//if(_p){print "1. error en la transformación";}
		}

		//Lo ponemos en escala de grises
		//IMG_FILTER_GRAYSCALE
		//if(_p){print "<br>2. filtro escala de grises ";}
		if(imagefilter($im_filtro, IMG_FILTER_GRAYSCALE)){
			//if(_p){print "2. transformación exitosa";}
		}else{
			//if(_p){print "2. error en la transformación";}
		}

		/*
		//volcamos a la imagen qr temporal
		imagepng($im_filtro, "qr/".$qr_filename2);


		//leemos esa imagen del QR con filtros aplicados
		//para colorearlo de morado
		$im_filtro=imagecreatefrompng("qr/".$qr_filename2);

		//IMG_FILTER_BRIGHTNESS //cambia el brillo de -255 a 255
		//if($im && (imagefilter($im, IMG_FILTER_BRIGHTNESS, 80))){
		//if(_p){print "<br>3. filtro COLORIZE ";}
		if($im_filtro && (imagefilter($im_filtro, IMG_FILTER_COLORIZE, 66, 66, 99, 0))){
			//if(_p){print "3. transformación exitosa";}
		}else{
			//if(_p){print "3. error en la transformación";}
		}
		*/

		//IMG_FILTER_COLORIZE //colorea la imagen con tonos RGB y alfa
		//imagefilter($im_filtro, IMG_FILTER_COLORIZE, 9, 30, 55, 50);
		//volcamos a la imagen qr
		imagepng($im_filtro, "qr/".$qr_filename2);
		//establecemos la ruta a la imagen para el HTML
		$qr2="<br><image src='qr/$qr_filename2'>";
		//Establecemos la ruta para la imagen
		$qr0="qr/$qr_filename2";


	      //print $qr2;

	    //AHORA LE HACEMOS UN FILTRO



	        
	/////////////////////////////
	//MONTAMOS EL QR EN LA IMAGEN
	/////////////////////////////

	//recuperamos la imagen qr
	//$im_qr=imagecreatefrompng("qr/".$qr_filename2);
	$im_qr=imagecreatefrompng("$qr0");
	//Copiamos el QR de la imagen del QR en la imagen de la tarjeta
	//bool imagecopy ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h )

	//Establecemos el ancho y alto del código QR
	list($src_w, $src_h)=getimagesize("qr/$qr_filename2");

	//Posicion Y inferior del codigo QR
	$base = 1780;

	//Calculamos la posición superior del codigo QR
	$pos_y = $base - $src_h;

	//Establecemos la posicion superior mínima, para que no se pegue al texto
	//pero que si hay poco texto, se use esta como mínimo
	$pos_y_minima = ($y - 15);

	//Si la posición dada por el ultimo texto, es menor a la posición minima,
	//se utiliza la posición minima establecida anteriormente,
	//así el código QR no se sube demasiado, y se queda abajo
	if($pos_y < $pos_y_minima){
		$pos_y = $pos_y_minima;
	}

	//establecemos el resto de posiciones para copiar el QR dentro de la tarjeta
	$dst_x=2050;//la posicion X, es la separación del margen izquierdo
	//$dst_y=$pos_y; //($y - 15);//$base - $src_h;//la posición superior izquierda del QR
	$dst_y=1600; //($y - 15);//$base - $src_h;//la posición superior izquierda del QR

	$src_x=0;//esquina inicio izquierda del QR
	$src_y=0;//esquina inicio superior del QR
	//$src_w="";//tomamos el ancho del QR
	//$src_h="";//tomamos el alto dle QR

	//copiamos el QR de su imagen a la imagen de la tarjeta
	imagecopy($im, $im_qr, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h);

}//fin QR



/////////////////////////////
//GENERAMOS LA IMAGEN DEFINITIVA
/////////////////////////////

	//imageinterlace ( resource $image [, int $interlace = 0 ] )
	imageinterlace ($im, 0);
	print "<br>*** DESTINO: $destino ***";
	imagepng($im,"$destino",0,PNG_NO_FILTER);
	//imagepng($im,"$destino",0,PNG_NO_FILTER);
	$tarjeta = $destino;

/////////////////////////////
// FIN - GENERAMOS LA IMAGEN DEFINITIVA
/////////////////////////////




if(!isset($qr0)){
	$qr0 = "";
}



/*
FACtitulo
FACdescripcion1
FACdescripcion2
FACdescripcion3
FACnombre
FACcif
FACdireccion1
FACdireccion2
FACdireccion3
FACcodigopostal
FACnumero
FACfecha
FACbase
FACiva
FACimporte
FACqr
*/

/*
'FACtitulo', 'FACdescripcion1', 'FACdescripcion2', 'FACdescripcion3', 'FACnombre', 'FACcif', 'FACdireccion1', 'FACdireccion2', 'FACdireccion3', 'FACcodigopostal', 'FACnumero', 'FACfecha', 'FACbase', 'FACiva', 'FACimporte', 'FACqr'
*/

/*
'$FACtitulo', '$FACdescripcion1', '$FACdescripcion2', '$FACdescripcion3', '$FACnombre', '$FACcif', '$FACdireccion1', '$FACdireccion2', '$FACdireccion3', '$FACcodigopostal', '$FACnumero', '$FACfecha', '$FACbase', '$FACiva', '$FACimporte', '$FACqr'
*/



/*
'FACtitulo', 'FACdescripcion1', 'FACdescripcion2', 'FACdescripcion3', 'FACnombre', 'FACcif', 'FACdireccion1', 'FACdireccion2', 'FACdireccion3', 'FACcodigopostal', 'FACnumero', 'FACfecha', 'FACbase', 'FACiva', 'FACimporte', 'FACqr'
*/

/*
'$FACtitulo', '$FACdescripcion1', '$FACdescripcion2', '$FACdescripcion3', '$FACnombre', '$FACcif', '$FACdireccion1', '$FACdireccion2', '$FACdireccion3', '$FACcodigopostal', '$FACnumero', '$FACfecha', '$FACbase', '$FACiva', '$FACimporte', '$FACqr'
*/


///////////////////////////////
///////////////////////////////
///////////////////////////////
///////////////////////////////



//////////////////////////
/*
$SQL_buscar = "SELECT * FROM facturas WHERE
FACtitulo = '$FACtitulo' OR 
FACdescripcion1 = '$FACdescripcion1' OR 
FACdescripcion2 = '$FACdescripcion2' OR 
FACdescripcion3 = '$FACdescripcion3' OR 
FACnombre = '$FACnombre' OR 
FACcif = '$FACcif' OR 
FACdireccion1 = '$FACdireccion1' OR 
FACdireccion2 = '$FACdireccion2' OR 
FACdireccion3 = '$FACdireccion3' OR 
FACcodigopostal = '$FACcodigopostal' OR 
FACnumero = '$FACnumero' OR 
FACfecha = '$FACfecha' OR 
FACbase = '$FACbase' OR 
FACiva = '$FACiva' OR 
FACimporte = '$FACimporte' OR 
FACqr = '$FACqr'
";




$SQL_nueva = "INSERT INTO facturas SET
FACtitulo = '$FACtitulo',
FACdescripcion1 = '$FACdescripcion1',
FACdescripcion2 = '$FACdescripcion2',
FACdescripcion3 = '$FACdescripcion3',
FACnombre = '$FACnombre',
FACcif = '$FACcif',
FACdireccion1 = '$FACdireccion1',
FACdireccion2 = '$FACdireccion2',
FACdireccion3 = '$FACdireccion3',
FACcodigopostal = '$FACcodigopostal',
FACnumero = '$FACnumero',
FACfecha = '$FACfecha',
FACbase = '$FACbase',
FACiva = '$FACiva',
FACimporte = '$FACimporte',
FACqr = '$FACqr'
";





$SQL_modifica = "UPDATE facturas SET
FACtitulo = '$FACtitulo',
FACdescripcion1 = '$FACdescripcion1',
FACdescripcion2 = '$FACdescripcion2',
FACdescripcion3 = '$FACdescripcion3',
FACnombre = '$FACnombre',
FACcif = '$FACcif',
FACdireccion1 = '$FACdireccion1',
FACdireccion2 = '$FACdireccion2',
FACdireccion3 = '$FACdireccion3',
FACcodigopostal = '$FACcodigopostal',
FACnumero = '$FACnumero',
FACfecha = '$FACfecha',
FACbase = '$FACbase',
FACiva = '$FACiva',
FACimporte = '$FACimporte',
FACqr = '$FACqr'
WHERE id='$id'
";
*/
//////////////////////////
//////////////////////////
/*
//$_md5 = md5($id);
//$idk = substr($_md5, -3) . substr($_md5, 0,3);


CREATE TABLE FACfacturas (
	id int not null auto_increment primary key,
	idk varchar(50) not null unique key,
	idkp varchar(50) not null unique key,
	FACtitulo varchar(255) null,
	FACdescripcion1 varchar(255) null, 
	FACdescripcion2 varchar(255) null,
	FACdescripcion3 varchar(255) null,
	FACnombre varchar(255) null,
	FACcif varchar(25) null,
	FACdireccion1 varchar(90) null,
	FACdireccion2 varchar(90) null,
	FACdireccion3 varchar(90) null,
	FACcodigopostal varchar(25) null,
	FACemail varchar(255) null, 
	FACtelefono varchar(50) null, 
	FACcontacto varchar(50) null,
	FACnumero varchar(50) null,
	FACfecha datetime null,
	FACbase float(10,2) null default '0.0',
	FACiva float(10,2) null default '0.0',
	FACimporte float(10,2) null default '0.0',
	FACqr text null,
	alta datetime null,
	ultimo timestamp default CURRENT_TIMESTAMP,
	estado enum('borrador','proforma','emitida','corregida','anulada','sustituida','cancelada','eliminada') default 'emitida'
);
//por si no hemos incluido el campo idkp
//ALTER TABLE `FACfacturas` ADD `idkp` VARCHAR(50) NOT NULL AFTER `idk`, ADD UNIQUE (`idkp`);
*/

//////////////////////////
//////////////////////////

$SQL_buscar = "SELECT * FROM FACfacturas WHERE
FACtitulo = '$FACtitulo' OR 
idkp = '$idkp' OR 
idk = '$idk' OR 
FACdescripcion1 = '$FACdescripcion1' OR 
FACdescripcion2 = '$FACdescripcion2' OR 
FACdescripcion3 = '$FACdescripcion3' OR 
FACnombre = '$FACnombre' OR 
FACcif = '$FACcif' OR 
FACdireccion1 = '$FACdireccion1' OR 
FACdireccion2 = '$FACdireccion2' OR 
FACdireccion3 = '$FACdireccion3' OR 

FACemail = '$FACemail' OR 
FACtelefono = '$FACtelefono' OR 
FACcontacto = '$FACcontacto' OR 

FACcodigopostal = '$FACcodigopostal' OR 
FACnumero = '$FACnumero' OR 
FACfecha = '$FACfecha' OR 
FACbase = '$FACbase' OR 
FACiva = '$FACiva' OR 
FACimporte = '$FACimporte'
";
/*
 OR 
FACqr = '$FACqr'

FACalta = '$FACalta'
";
*/



$fecha_actual = date("Y-m-d H:i:s", time());

$sql_nueva = "INSERT INTO FACfacturas SET
FACtitulo = '$FACtitulo',
FACdescripcion1 = '$FACdescripcion1',
FACdescripcion2 = '$FACdescripcion2',
FACdescripcion3 = '$FACdescripcion3',
FACnombre = '$FACnombre',
FACcif = '$FACcif',
FACdireccion1 = '$FACdireccion1',
FACdireccion2 = '$FACdireccion2',
FACdireccion3 = '$FACdireccion3',
FACcodigopostal = '$FACcodigopostal',

FACemail = '$FACemail',
FACtelefono = '$FACtelefono',
FACcontacto = '$FACcontacto',

FACnumero = '$FACnumero',
FACfecha = '$FACfecha',
FACbase = '$FACbase',
FACiva = '$FACiva',
FACimporte = '$FACimporte',

FACqr = '$FACqr',

alta = '$fecha_actual',
ultimo = CURRENT_TIMESTAMP,
estado = 'emitida'
";


if(isset($id) && !empty($id) && ($id > 0)){
	$_md5 = md5($id);
	$idk = substr($_md5, -3) . substr($_md5, 0,3);
}else{
	$idk = "";
}


$sql_modifica = "UPDATE facturas SET
FACtitulo = '$FACtitulo',
FACdescripcion1 = '$FACdescripcion1',
FACdescripcion2 = '$FACdescripcion2',
FACdescripcion3 = '$FACdescripcion3',
FACnombre = '$FACnombre',
FACcif = '$FACcif',
FACidk = '$FACidk',
FACidkp = '$FACidkp',
FACdireccion1 = '$FACdireccion1',
FACdireccion2 = '$FACdireccion2',
FACdireccion3 = '$FACdireccion3',
FACcodigopostal = '$FACcodigopostal',
FACemail = '$FACemail',
FACtelefono = '$FACtelefono',
FACcontacto = '$FACcontacto',
FACnumero = '$FACnumero',
FACfecha = '$FACfecha',
FACbase = '$FACbase',
FACiva = '$FACiva',
FACimporte = '$FACimporte',
FACqr = '$FACqr'
WHERE id='$id'
";




///////////////////////////////
///////////////////////////////
///////////////////////////////
///////////////////////////////
/*
$sql_nueva="INSERT INTO facturas SET lugar='$lugar',
	tel='$tel', tel2='$tel2', email='$email', poblacion='$poblacion', 
	direccion1='$direccion1', direccion2='$direccion2', direccion3='$direccion3', 
	qr='$qr0', tarjeta='$tarjeta', 
	visitas='$visitas', cambios='$cambios', 
	alta='$alta', ip='$ip', nav='$nav',
	activo='$activo', notas='$notas'
";
*/
/*
$sql_buscar="SELECT id, cambios FROM tarjetas WHERE lugar='$lugar'";
*/
/*
$_sql_modifica="UPDATE tarjetas SET lugar='$lugar',
	tel='$tel', tel2='$tel2', email='$email', poblacion='$poblacion', 
	direccion1='$direccion1', direccion2='$direccion2', direccion3='$direccion3', 
	qr='$qr0', tarjeta='$tarjeta', 
	cambios=#cambios#, ip='$ip', nav='$nav', notas='$notas' WHERE id='#id#'
";
*/


if($mysqli->query($sql_nueva) && !$mysqli->error){
	//insertada como tarjeta nueva
	$id= $mysqli->insert_id;
	$msg = "Tarjeta ($id) modificada con éxito<br>";
	
	//generamos el idk famoso...
	$_md5 = md5($id);
	$idk = substr($_md5, -3) . substr($_md5, 0,3);


}elseif($mysqli->errno == 1062){

	//fila duplicada, ya existe, hay que usar la otra SQL de modificación
	//Averiguamos la id de este registro
	if(($resultados = $mysqli->query($sql_buscar)) && !$mysqli->error){
		if($resultados->num_rows > 0){
			$datos = $resultados->fetch_assoc();
			$id= $datos["id"];
			$cambios = $datos["cambios"] + 1;
		}

		$sql_modifica = $_sql_modifica;
		$sql_modifica = str_replace("#id#", $id, $sql_modifica);
		$sql_modifica = str_replace("#cambios#", $cambios, $sql_modifica);

		if($mysqli->query($sql_modifica) && !$mysqli->error){
			$errno = $mysqli->errno;
			$error = $mysqli->error;

			//modificada con éxito
			if($mysqli->affected_rows > 0){
				//modificada
				$msg = "Tarjeta ($id) modificada con éxito, con $cambios cambios";
			}else{
				//no modificada
				$msg = "Tarjeta NO modificada ¿Datos idénticos? <br>$sql_modifica";

			}
		}else{
			$msg = "Tarjeta NO modificada. Error($errno): <br>$error, en <br>SQL: $sql_modifica";
		}
	}else{
		//hay errores al buscar la id
		$errno = $mysqli->errno;
		$error = $mysqli->error;
		$msg = "Tarjeta NO encontrada. Error($errno): <br>$error, en <br>SQL: $sql_buscar";
	}
}else{
	//otro error en la consulta
	$errno = $mysqli->errno;
	$error = $mysqli->error;
	$msg = "Tarjeta no guardada. Error($errno): <br>$error, en <br>SQL: $sql_nueva";
}
print "<br>*** $msg +++";



        
/////////////////////////////
//VOLCAMOS EL HTML RESULTANTE
/////////////////////////////


	//imagejpeg($im,"$destino",100);
	print <<<fin

	<img src="$destino" id="tarjeta" class="imagen"><br>
	<br>
	<form action="montar_tarjetas.php?imagen=$imagen" method="post">	
	<input type="submit" value="Montar tarjetas en A4" class="chillon">
	</form>
	</div>
fin;
	
}//fin if else



print <<<fin
	<!--$msg-->
	<img src="http://circulodesanacion.org/r/limpieza.php"/>
	</div>
</body>
</html>
fin;
?>