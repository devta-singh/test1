<?php //texto_sobre_imagen_v4.03a.php
/*
Fichero: texto_sobre_imagen_v4.03a.php
Version: v4.02a

Url: http://localhost:8888/toolbox/tarjetas/texto_sobre_imagen.php
Aplicación: Tarjetas personalizadas

Autor: Devta Singh
Fecha: 2018-01-31
Con un enlace que Monta las 8 tarjetas en un solo png

Cambios:
//Genera el código QR con una URL para esta tarjeta

Añade la tarjeta a la base de datos
1 Crea una redirección para esta url (personalizada)
2 Graba la tarjeta en una carpeta de tarjetas acabadas, para poder listarla
3 Borra las tarjetas anteriores

*/

//http://localhost:8888/toolbox/tarjetas/texto_sobre_imagen.php?buscar_imagen=1&lugar=madrid&tel=662%20529%20000&email=madrid@circulodesanacion.org&poblacion=Madrid&direccion1=O%27donnell&direccion2=C/Hermosilla,%20126


error_reporting(15);
ini_set("display_errors",1);

require("inc/config.inc.php");

$directorio="./fondos";
$ruta_cfg="./cfg";
$msg="";

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
//cambiado en v4.03a
$fondo = "fondos/Tarjeta_MDC_con_fondo_prueba_SIN_TITULO_para_QR.png";

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

	<script type="text/javascript" src="http://www.technicalkeeda.com/js/javascripts/plugin/jquery.js"></script>
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
	<input type="submit" value="Generar Imagen">

<!--
//////////////////////
// CONFIGURACION
//////////////////////	
	<hr>Guardar como:<br><input type="text" name="configuracion" value=""><br>
	<input type="submit" value="Guardar" name="guardar_configuracion" title="Guardar configuracion de textos y posiciones">
	<hr>
	Recuperar configuración:<br>$html_configuraciones
	<hr>
//////////////////////
// FIN CONFIGURACION
//////////////////////
-->

	<input type="hidden" name="fondo" value="$fondo">
	<br><a href="listado_tarjetas.php">Listado de Tarjetas</a>
	<!--<br><a href="seleccionar_tarjeta.php">Cambiar imagen de fondo</a>-->
	<!--<br>X:<span id="x_axis">0</span> / Y:<span id="y_axis">0</span>-->

	<br><span onclick="$('#instrucciones').toggle();">Instrucciones...</span>
	<div id="instrucciones">Creador de tarjetas - v3.01a<br>
	1. Utilizar los campos para poner los textos (de una sola línea)
	<br>2. pulsa en el botón GENERAR IMAGEN tarjeta
	<br>3. Sobre la imagen, dale a guardar imagen como  (botón secundario o derecho del ratón) y utilizala para imprimir las tarjetas
	<br>4.Corta utilizando las lineas de corte, para que el color llegue al borde de la tarjeta.
	</div>
	<br>
fin;

////////////////
//FUENTES
////////////////

// 	//cargamos las fuentes
// 	$raiz = "./fuentes/";

// 	//print "Cargamos las fuentes en $raiz";

// 	$fuentes=array();
// 	$df = opendir($raiz);
// 	while($ff = readdir($df)){
// 		//print "<br>Leyendo el item $ff";
// 		if(!is_dir($raiz.$ff)){
// 			//print "<br>NO Es una carpeta: $ff";
// 			$inicio = substr($ff,0,1);
// 			//print " +++ inicio: $inicio +++ ";
// 			if($inicio == "."){
// 				//print "<br>Es un fichero OCULTO: $raiz - $ff";
// 			}else{
// 				//print "<br>LO LEEMOS: $raiz.$ff";
// 				$dttf = opendir($raiz.$ff);
// 			}

// 		}else{
// 			//print "<br>Es una carpeta: $raiz.$ff";
// 			$dttf = opendir($raiz.$ff);
// 			while($fttf = readdir($dttf)){
// 				//$ruta = "$raiz$ff/$fttf";
// 				$ruta = "fuentes/$ff/$fttf";
// 				if(!is_dir($raiz.$ff.$fttf)){
// 					//no es un directorio
// 					//leemos la extension del fichero
// 					if(substr($fttf, -3) == "ttf"){
// 						//tiene extensión TTF
// 						//print "<br>fuente: $fttf";
// 						$fuentes[$fttf]=$ruta;
// 					}
// 				}
// 			}		
// 		}
// 	}//fin while

// 	$html_fuentes=<<<fin
// 	<select name="#campo#">
// fin;
// 	foreach($fuentes as $fuente=>$ruta_fuente){
// 		//print "--- $fuente --- $ruta_fuente";
// 		$html_fuentes.=<<<fin
// 		<option value="$ruta_fuente">$fuente</option>
// fin;
// 	}//fin foreach
// 	$html_fuentes.=<<<fin
// 	</select>
// fin;

////////////////
//FIN FUENTES
////////////////
$html_fuentes="";





////////////////
//FIN CAMPOS
////////////////
// 	//$campos = array("nombre", "titulo", "telefono");
// 	$campos = array("campo1", "campo2", "campo3", "campo4", "campo5");
// 	//$html.="<iframe name=\"resultado\">";

// 	$XX=100;
// 	$YY=100;

// 	$html.=<<<fin
// 		<br><table>
// 		<tr>
// 		<th>X</th>
// 		<th>Y</th>
// 		<th>Tam</th>
// 		<th>Ang</th>
// 		</tr>
// fin;
	
// 	foreach($campos as $c=>$campo){
// 		$chk[$campo]="checked";
// 		//$fuentes["titulo"] = str_replace("#campo#", "textos[titulo][y][font]", $html_fuentes);
// 		$fuentes[$campo] = str_replace("#campo#", "textos[$campo][font]", $html_fuentes);
// 		$YY+=100;

// 		if(isset($_REQUEST["textos"]["$campo"]["texto"])){$_texto = $_REQUEST["textos"]["$campo"]["texto"];}else{$_texto = "$campo";}

// 		if(isset($_REQUEST["textos"]["$campo"]["x"])){$_x = $_REQUEST["textos"]["$campo"]["x"];}else{$_x = "$XX";}
// 		if(isset($_REQUEST["textos"]["$campo"]["y"])){$_y = $_REQUEST["textos"]["$campo"]["y"];}else{$_y = "$YY";}
// 		if(isset($_REQUEST["textos"]["$campo"]["tam"])){$_tam = $_REQUEST["textos"]["$campo"]["tam"];}else{$_tam = "15";}
// 		if(isset($_REQUEST["textos"]["$campo"]["ang"])){$_ang = $_REQUEST["textos"]["$campo"]["ang"];}else{$_ang = "0";}
		
// 		if(isset($_REQUEST["chk_campo"][$campo])){
// 			$chk[$campo]="checked";
// 		}else{
// 			$chk[$campo]="";
// 		}

// 	//añadimos una fila a la tabla
// 	$html.=<<<fin

		

// 		<tr>
// 		<td colspan="4"><strong>
// 		<input type="checkbox" name="chk_campo[$campo]" value="1" $chk[$campo]/><a href="#_" onclick="campo_activo='$campo';">$c</a></strong> <input type="text" name="textos[$campo][texto]" value="$_texto"></td>
// 		</tr>

// 		<tr>
// 		<td class="discreto">x:<input type="text" id="textos_x_$campo" name="textos[$campo][x]" value="$_x" class="corto" onclick="campo_activo='$campo';"></td>
// 		<td class="discreto">y:<input type="text" id="textos_y_$campo" name="textos[$campo][y]" value="$_y" class="corto" onclick="campo_activo='$campo';"></td>
// 		<td class="discreto">tam:<input type="text" name="textos[$campo][tam]" value="$_tam" class="corto"></td>
// 		<td class="discreto">ang:<input type="text" name="textos[$campo][ang]" value="$_ang" class="corto"></td>
// 		</tr>

// 		<tr>
// 		<td colspan="4">$fuentes[$campo]<hr></td>
// 		</tr>

// 		<br>	
// fin;
// 	}//fin foreach

// 	//fin de la tabla
// 	$html.=<<<fin
// 		</table>
// fin;

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

	if(isset($_REQUEST["titulo"])){
		$titulo = $_REQUEST["titulo"];
	}else{
		$titulo="";
	}

	if(isset($_REQUEST["lugar"])){
		$lugar = $_REQUEST["lugar"];
	}else{
		$lugar="";
	}

	if(isset($_REQUEST["tel"])){
		$tel = $_REQUEST["tel"];
	}else{
		$tel="";
	}

	if(isset($_REQUEST["tel2"])){
		$tel2 = $_REQUEST["tel2"];
	}else{
		$tel2="";
	}

	if(isset($_REQUEST["email"])){
		$email = $_REQUEST["email"];
	}else{
		$email="";
	}

	if(isset($_REQUEST["poblacion"])){
		$poblacion = $_REQUEST["poblacion"];
	}else{
		$poblacion="";
	}

	if(isset($_REQUEST["direccion1"])){
		$direccion1 = $_REQUEST["direccion1"];
	}else{
		$direccion1="";
	}

	if(isset($_REQUEST["direccion2"])){
		$direccion2 = $_REQUEST["direccion2"];
	}else{
		$direccion2="";
	}

	if(isset($_REQUEST["direccion3"])){
		$direccion3 = $_REQUEST["direccion3"];
	}else{
		$direccion3="";
	}


}//fin else
	$html.=<<<fin
		<table>
			<!-- añadido en version 4.03a -->
			<tr>
				<td>Titulo:</td>
				<td><input type="text" name="titulo" value="$titulo"/>
				</td>
			</tr>
			<!-- fin añadido en version 4.03a -->

			<tr>
				<td>Lugar:</td>
				<td><input type="text" name="lugar" value="$lugar"/>
				</td>
			</tr>
			</tr>
				<td>Tel:</td>
				<td><input type="text" name="tel" value="$tel"/>
				</td>
			</tr>
			</tr>
				<td>Tel2:</td>
				<td><input type="text" name="tel2" value="$tel2"/>
				</td>
			</tr>			

			</tr>
				<td>email:</td>
				<td><input type="text" name="email" value="$email"/>
				</td>
			</tr>			
			</tr>
				<td>poblacion:</td>
				<td><input type="text" name="poblacion" value="$poblacion"/>
				</td>
			</tr>			
			</tr>
				<td>direccion1:</td>
				<td><input type="text" name="direccion1" value="$direccion1"/>
				</td>
			</tr>			
			</tr>
				<td>direccion2:</td>
				<td><input type="text" name="direccion2" value="$direccion2"/>
				</td>
			</tr>
			</tr>
				<td>direccion3:</td>
				<td><input type="text" name="direccion3" value="$direccion3"/>
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

	$fuente1="fuentes/Pirulen/pirulen.ttf";
	$fuente2="fuentes/lato/Lato-Heavy.ttf";
	$fuente3="fuentes/lato/Lato-ThinItalic.ttf";
	$fuente4="fuentes/windings/wingdings.ttf";


	$x = 107;
	$ang=0;
	$tam1=28;
	$tam2=27;
	$esp1=24;
	$esp2=37;
	$y = 160;//200;

	//para el título, añadido en v4.03a
	if(isset($_REQUEST["titulo"]) && !empty($_REQUEST["titulo"])){
		//imprimimimos titulo
		imagettftext($im, 28, $ang, $x, $y, $blanco, $fuente1, $titulo);
		$y+=30;
	}
	$y+=24;//espacio extra

	if(isset($_REQUEST["lugar"]) && !empty($_REQUEST["lugar"])){
		//imprimimimos lugar
		imagettftext($im, 28, $ang, $x, $y, $blanco, $fuente1, $lugar);
		$y+=30;
	}
	$y+=24;//espacio extra

	if(isset($_REQUEST["tel"]) && !empty($_REQUEST["tel"])){
		//imprimimimos tel
		imagettftext($im, $tam2, $ang, $x, $y, $blanco, $fuente2, $tel);
		//imagettftext($im, $tam2, $ang, 80, 370, $blanco, $fuente4, ")H");
		$y+=$esp2;
	}

	if(isset($_REQUEST["tel2"]) && !empty($_REQUEST["tel2"])){
		//imprimimimos tel2
		imagettftext($im, $tam2, $ang, $x, $y, $blanco, $fuente2, $tel2);
		//imagettftext($im, $tam2, $ang, 80, 370, $blanco, $fuente4, ")H");
		$y+=$esp2;
	}

	if(isset($_REQUEST["email"]) && !empty($_REQUEST["email"])){
		//imprimimimos email
		imagettftext($im, $tam2, $ang, $x, $y, $blanco, $fuente2, $email);
		$y+=$esp2;
	}

	$y+=20;//espacio extra

	if(isset($_REQUEST["poblacion"]) && !empty($_REQUEST["poblacion"])){
		//imprimimimos poblacion
		imagettftext($im, $tam2, $ang, $x, $y, $blanco, $fuente2, $poblacion);
		$y+=$esp2;
	}

	if(isset($_REQUEST["direccion1"]) && !empty($_REQUEST["direccion1"])){
		//imprimimimos direccion1
		imagettftext($im, $tam2, $ang, $x, $y, $blanco, $fuente2, $direccion1);
		$y+=$esp2;
	}

	if(isset($_REQUEST["direccion2"]) && !empty($_REQUEST["direccion2"])){
		//imprimimimos direccion2
		imagettftext($im, $tam2, $ang, $x, $y, $blanco, $fuente2, $direccion2);
		$y+=$esp2;
	}

	if(isset($_REQUEST["direccion3"]) && !empty($_REQUEST["direccion3"])){
		//imprimimimos direccion3
		imagettftext($im, $tam2, $ang, $x, $y, $blanco, $fuente2, $direccion3);
		$y+=$esp2;
	}

	//print "Trozos:";
	$trozos = explode("/", $fondo);
	$n=sizeof($trozos);
	//print_r($trozos);
	
	$fichero=$trozos[($n -1)];
	$ahora=time();
	$imagen = "$lugar-$ahora.png";

	//$imagen = "$lugar-$ahora.jpeg";
	$destino = "imagenes/$imagen";
	//print "<br>n: $n - fichero: $fichero - destino: $destino<br>";
	




//////////////////
// QR
//////////////////
	//retomamos la imagen generada y le creamos un QR
	$url="http://circulodesanacion.org/r/?r=v5001&l=$lugar";
	$_url = $url;
	while(strpos($_url, " ")){
		$_url = str_replace(" ", "-", $_url);
	}
	$_lugar = str_replace(" ", "-", $_url);

	$url_destino = "http://www.circulodesanacion.org/r/?r=5001&lugar=$_lugar";

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

      $im_filtro=imagecreatefrompng("qr/".$qr_filename);
      //bool imagefilter ( resource $image , int $filtertype [, int $arg1 [, int $arg2 [, int $arg3 [, int $arg4 ]]]] )
      
      if(_p){print "<br>filtro imagen invertida B/N ";}
      if(imagefilter($im_filtro, IMG_FILTER_NEGATE)){
      	if(_p){print "transformación exitosa";}
      }else{
      	if(_p){print "error en la transformación";}
      }

      //IMG_FILTER_GRAYSCALE
      if(_p){print "<br>filtro escala de grises ";}
      if(imagefilter($im_filtro, IMG_FILTER_GRAYSCALE)){
      	if(_p){print "transformación exitosa";}
      }else{
      	if(_p){print "error en la transformación";}
      }

      imagepng($im_filtro, "qr/".$qr_filename2);
      $im_filtro=imagecreatefrompng("qr/".$qr_filename2);
      
      //IMG_FILTER_BRIGHTNESS //cambia el brillo de -255 a 255
      //if($im && (imagefilter($im, IMG_FILTER_BRIGHTNESS, 80))){
      if(_p){print "<br>filtro COLORIZE ";}
      if($im_filtro && (imagefilter($im_filtro, IMG_FILTER_COLORIZE, 160, 0, 180, 0))){
      	if(_p){print "transformación exitosa";}
      }else{
      	if(_p){print "error en la transformación";}
      }
      
      //IMG_FILTER_COLORIZE //colorea la imagen con tonos RGB y alfa
      //imagefilter($im_filtro, IMG_FILTER_COLORIZE, 9, 30, 55, 50);
      imagepng($im_filtro, "qr/".$qr_filename2);
      $qr2="<br><image src='qr/$qr_filename2'>";
      $qr0="qr/$qr_filename2";


      //print $qr2;

    //AHORA LE HACEMOS UN FILTRO
        
/////////////////////////////
//MONTAMOS EL QR EN LA IMAGEN
/////////////////////////////

$im_qr=imagecreatefrompng("qr/".$qr_filename2);
//Copiamos el QR de la imagen del QR en la imagen de la tarjeta
//bool imagecopy ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h )

//Establecemos el ancho y alto del código QR
list($src_w, $src_h)=getimagesize("qr/$qr_filename2");

//Posicion Y inferior del codigo QR
$base = 680;

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
$dst_x=95;//la posicion X, es la separación del margen izquierdo
$dst_y=$pos_y; //($y - 15);//$base - $src_h;//la posición superior izquierda del QR
$src_x=0;//esquina inicio izquierda del QR
$src_y=0;//esquina inicio superior del QR
//$src_w="";//tomamos el ancho del QR
//$src_h="";//tomamos el alto dle QR

imagecopy($im, $im_qr, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h);





/////////////////////////////
//GENERAMOS LA IMAGEN DEFINITIVA
/////////////////////////////

	//imageinterlace ( resource $image [, int $interlace = 0 ] )
	imageinterlace ($im, 0);
	imagepng($im,"$destino",0,PNG_NO_FILTER);
	//imagepng($im,"$destino",0,PNG_NO_FILTER);
	$tarjeta = $destino;

/////////////////////////////
// FIN - GENERAMOS LA IMAGEN DEFINITIVA
/////////////////////////////
/*
CREATE TABLE tarjetas(
	id int not null AUTO_INCREMENT primary key,
	lugar varchar(50) not null unique key,
	tel varchar(35) null,
	tel2 varchar(35) null,
	email varchar(90) null,
	poblacion varchar(60) null,
	direccion1 varchar(60) null,
	direccion2 varchar(60) null,
	direccion3 varchar(60) null,
	qr varchar(255) null,
	tarjeta varchar(255) null,
	visitas int not null default 0,
	alta datetime not null,
	ultimo timestamp null default CURRENT_TIMESTAMP,
	ip varchar(50) null,
	nav text null,
	activo int default 0,
	notas text null
);
*/

//Esto va al inicio
// $visitas = 0;
// $cambios = 0;
// $ip = $_SERVER["REMOTE_ADDR"];
// $nav = $_SERVER["HTTP_USER_AGENT"];
// $alta = date("Y-m-d H:i:s", time());
// $activo=1;
// $notas="";

// $campos_texto=explode(",", "lugar,tel1,tel2,email,direccion1,direccion2,direccion3,notas");
// foreach($campos_texto as $campo => $valor){
// 	$valor = addslashes($valor);
// 	//$valor = str_replace("'","´",$valor);
// 	$$campo = $valor;
// }

$sql_nueva="INSERT INTO tarjetas SET lugar='$lugar',
	tel='$tel', tel2='$tel2', email='$email', poblacion='$poblacion', 
	direccion1='$direccion1', direccion2='$direccion2', direccion3='$direccion3', 
	qr='$qr0', tarjeta='$tarjeta', 
	visitas='$visitas', cambios='$cambios', 
	alta='$alta', ip='$ip', nav='$nav',
	activo='$activo', notas='$notas'
";

$sql_buscar="SELECT id, cambios FROM tarjetas WHERE lugar='$lugar'";

$_sql_modifica="UPDATE tarjetas SET lugar='$lugar',
	tel='$tel', tel2='$tel2', email='$email', poblacion='$poblacion', 
	direccion1='$direccion1', direccion2='$direccion2', direccion3='$direccion3', 
	qr='$qr0', tarjeta='$tarjeta', 
	cambios=#cambios#, ip='$ip', nav='$nav', notas='$notas' WHERE id='#id#'
";



if($mysqli->query($sql_nueva) && !$mysqli->error){
	//insertada como tarjeta nueva
	$id= $mysqli->insert_id;
	$msg = "Tarjeta ($id) modificada con éxito";

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



        
/////////////////////////////
//VOLCAMOS EL HTML RESULTANTE
/////////////////////////////


	//imagejpeg($im,"$destino",100);
	print <<<fin

	<img src="$destino" id="tarjeta" class="imagen"><br>
	<br><form action="montar_tarjetas.php?imagen=$imagen" method="post">	
	<input type="submit" value="Montar tarjetas en A4" class="chillon">
	</form>
	</div>
fin;
	
}//fin if else



print <<<fin
	$msg
	<img src="http://circulodesanacion.org/r/limpieza.php"/>
	</div>
</body>
</html>
fin;
?>