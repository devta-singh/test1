<?php //texto_sobre_imagen_v3.03a.php
/*
Fichero: texto_sobre_imagen_v3.03a.php
Version: v3.03a

Url: http://localhost:8888/toolbox/tarjetas/texto_sobre_imagen.php
Aplicación: Tarjetas personalizadas

Autor: Devta Singh
Fecha: 2018-01-26
Monta las 8 tarjetas en un solo png
*/

//http://localhost:8888/toolbox/tarjetas/texto_sobre_imagen.php?buscar_imagen=1&lugar=madrid&tel=662%20529%20000&email=madrid@circulodesanacion.org&poblacion=Madrid&direccion1=O%27donnell&direccion2=C/Hermosilla,%20126

error_reporting(15);
ini_set("display_errors",1);

$directorio="./fondos";
$ruta_cfg="./cfg";

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
$fondo = "fondos/MDC_para_personalizar.png";

//obtenemos las dimensiones de la imagen
list($a,$b) = getimagesize($fondo);
//$aa = 600;
$aa = 1122;
$bb = round(($aa*$b)/$a);

print "a: $a, b:$b, aa:$aa => bb: $bb";




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
	<br><a href="seleccionar_tarjeta.php">Cambiar imagen de fondo</a>
	<!--<br>X:<span id="x_axis">0</span> / Y:<span id="y_axis">0</span>-->

	<br><span onclick="$('#instrucciones').toggle();">Instrucciones...</span>
	<div id="instrucciones">Creador de tarjetas - v3.01a<br>
	1. Utilizar los campos para poner los textos (de una sola línea)
	<br>2. pulsa en el botón GENERAR IMAGEN tarjeta
	<br>3. Sobre la imagen, dale a guardar imagen como  (botón secundario o derecho del ratón) y utilizala para imprimir las tarjetas
	<br>4.Corta utilizando las lineas de corte, para que el color llegue al borde de la tarjeta.
	</div>

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

	$html.=<<<fin
		<table>
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
		</form>

fin;

	$html.=<<<fin
	<br>
	<input type="submit" value="Generar Imagen">
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
$y = 200;

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
	
	//imageinterlace ( resource $image [, int $interlace = 0 ] )
	imageinterlace ($im, 0);
	imagepng($im,"$destino",0,PNG_NO_FILTER);
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
	</div>
</body>
</html>
fin;
?>