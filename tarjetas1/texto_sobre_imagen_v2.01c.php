<?php //texto_sobre_imagen_v2.01c.php
/*
Fichero: texto_sobre_imagen_v2.01c.php
Version: v2.01c

Url: http://localhost:8888/toolbox/tarjetas/texto_sobre_imagen.php
Aplicación: Tarjetas personalizadas

Autor: Devta Singh
Fecha: 2018-01-24
Cambios: Tomamos del ratón la posición X e Y para cada campo
*/

error_reporting(15);
ini_set("display_errors",1);

$directorio="./fondos";

if(!isset($_REQUEST["buscar_imagen"])){
	header("Location: seleccionar_tarjeta.php");
}

$d= opendir($directorio);
//print "Abierto el directorio: $directorio<br>";

if(!isset($_REQUEST["fondo"])){
	 header("Location: seleccionar_tarjeta.php?msg=Debe+Seleccionar+una+Tarjeta");
}
$fich = $_REQUEST["fondo"];


//obtenemos las dimensiones de la imagen
list($a,$b) = getimagesize($fich);
$aa = 600;
$bb = round(($aa*$b)/$a);

//print "a: $a, b:$b, aa:$aa => bb: $bb";


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
<div>
<div id="barra">
	<form action="?buscar_imagen=1" method="post">
	<input type="submit" value="Generar Imagen">
	<input type="hidden" name="fondo" value="$fich">
	<br><a href="seleccionar_tarjeta.php">Cambiar imagen de fondo</a>
	<!--<br>X:<span id="x_axis">0</span> / Y:<span id="y_axis">0</span>-->
	<br><span onclick="$('#instrucciones').toggle();">Instrucciones...</span>
	<div id="instrucciones">
	1. Activar las casillas de los campos que quieras poner
	<br>2. Pinchar en el nombre de campo que quieras colocar y pincha en la imagen donde quieres ponerlo (esto obtiene las coordenadas, que verás en los campos X e Y de ese texto)
	<br>3. Cuando ya tengas los campos en su sitio. Pulsa el botón GENERAR IMAGEN
	</div>

fin;


// $html.=<<<fin
// 	<img src="$fich" style="border:solid black 1px;width:100px;"><br>
// fin;


$html.=<<<fin
 
fin;
	//cargamos las fuentes
	$raiz = "./fuentes/";

	//print "Cargamos las fuentes en $raiz";

	$fuentes=array();
	$df = opendir($raiz);
	while($ff = readdir($df)){
		//print "<br>Leyendo el item $ff";
		if(!is_dir($raiz.$ff)){
			//print "<br>NO Es una carpeta: $ff";
			$inicio = substr($ff,0,1);
			//print " +++ inicio: $inicio +++ ";
			if($inicio == "."){
				//print "<br>Es un fichero OCULTO: $raiz - $ff";
			}else{
				//print "<br>LO LEEMOS: $raiz.$ff";
				$dttf = opendir($raiz.$ff);
			}

		}else{
			//print "<br>Es una carpeta: $raiz.$ff";
			$dttf = opendir($raiz.$ff);
			while($fttf = readdir($dttf)){
				//$ruta = "$raiz$ff/$fttf";
				$ruta = "fuentes/$ff/$fttf";
				if(!is_dir($raiz.$ff.$fttf)){
					//no es un directorio
					//leemos la extension del fichero
					if(substr($fttf, -3) == "ttf"){
						//tiene extensión TTF
						//print "<br>fuente: $fttf";
						$fuentes[$fttf]=$ruta;
					}
				}
			}		
		}
	}//fin while

	$html_fuentes=<<<fin
	<select name="#campo#">
fin;
	foreach($fuentes as $fuente=>$ruta_fuente){
		//print "--- $fuente --- $ruta_fuente";
		$html_fuentes.=<<<fin
		<option value="$ruta_fuente">$fuente</option>
fin;
	}//fin foreach
	$html_fuentes.=<<<fin
	</select>
fin;

	//$campos = array("nombre", "titulo", "telefono");
	$campos = array("campo1", "campo2", "campo3", "campo4", "campo5");
	//$html.="<iframe name=\"resultado\">";

	$XX=100;
	$YY=100;

	$html.=<<<fin
		<br><table>
		<tr>
		<th>X</th>
		<th>Y</th>
		<th>Tam</th>
		<th>Ang</th>
		</tr>
fin;
	
	foreach($campos as $campo){
		$chk[$campo]="checked";
		//$fuentes["titulo"] = str_replace("#campo#", "textos[titulo][y][font]", $html_fuentes);
		$fuentes[$campo] = str_replace("#campo#", "textos[$campo][font]", $html_fuentes);
		$YY+=100;

		if(isset($_REQUEST["textos"]["$campo"]["texto"])){$_texto = $_REQUEST["textos"]["$campo"]["texto"];}else{$_texto = "$campo";}

		if(isset($_REQUEST["textos"]["$campo"]["x"])){$_x = $_REQUEST["textos"]["$campo"]["x"];}else{$_x = "$XX";}
		if(isset($_REQUEST["textos"]["$campo"]["y"])){$_y = $_REQUEST["textos"]["$campo"]["y"];}else{$_y = "$YY";}
		if(isset($_REQUEST["textos"]["$campo"]["tam"])){$_tam = $_REQUEST["textos"]["$campo"]["tam"];}else{$_tam = "15";}
		if(isset($_REQUEST["textos"]["$campo"]["ang"])){$_ang = $_REQUEST["textos"]["$campo"]["ang"];}else{$_ang = "0";}
		
		if(isset($_REQUEST["chk_campo"][$campo])){
			$chk[$campo]="checked";
		}else{
			$chk[$campo]="";
		}

	//añadimos una fila a la tabla
	$html.=<<<fin

		

		<tr>
		<td colspan="4"><strong>
		<input type="checkbox" name="chk_campo[$campo]" value="1" $chk[$campo]/><a href="#_" onclick="campo_activo='$campo';">
		$campo:</a></strong><input type="text" name="textos[$campo][texto]" value="$_texto"></td>
		</tr>

		<tr>
		<td class="discreto">x:<input type="text" id="textos_x_$campo" name="textos[$campo][x]" value="$_x" class="corto"></td>
		<td class="discreto">y:<input type="text" id="textos_y_$campo" name="textos[$campo][y]" value="$_y" class="corto"></td>
		<td class="discreto">tam:<input type="text" name="textos[$campo][tam]" value="$_tam" class="corto"></td>
		<td class="discreto">ang:<input type="text" name="textos[$campo][ang]" value="$_ang" class="corto"></td>
		</tr>

		<tr>
		<td colspan="4">$fuentes[$campo]<hr></td>
		</tr>

		<br>	
fin;
	}//fin foreach

	//fin de la tabla
	$html.=<<<fin
		</table>
fin;

	$html.=<<<fin
	<br>
	<input type="submit" value="Generar Imagen">
	</div>
	<div id="resultado">
fin;

	//imprimimos el html
	print $html;


	if(isset($_REQUEST["textos"])){

	$fondo = $_REQUEST["fondo"];
	$textos = $_REQUEST["textos"];

	$im = imagecreatefrompng($fondo);
	//header("Content-type: image/png;");
	//imagepng($im);
	$color = imagecolorallocate($im, 0,0,0);

	foreach($textos as $campo => $datos){

		if(isset($_REQUEST["chk_campo"][$campo])){
			$x = round($datos["x"]);
			$y = round($datos["y"]);
			$fuente = $datos["font"];
			$texto = $datos["texto"];
			$tam = $datos["tam"];
			$ang = $datos["ang"];
			//$color = $datos["color"];

			imagettftext($im, $tam, $ang, $x, $y, $color, $fuente, $texto);
		}
	}

	//print "Trozos:";
	$trozos = explode("/", $fondo);
	$n=sizeof($trozos);
	//print_r($trozos);
	
	$fichero=$trozos[($n -1)];
	$ahora=time();
	$destino = "imagenes/$ahora.png";
	//print "<br>n: $n - fichero: $fichero - destino: $destino<br>";
	
	imagepng($im,"$destino");
	print <<<fin
	<img src="$destino" id="tarjeta" class="imagen"></div>

fin;
	
}//fin if else



print <<<fin
	</div>
</body>
</html>
fin;
?>