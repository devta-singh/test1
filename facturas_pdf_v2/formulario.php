<?php //formulario.php

error_reporting(15);
ini_set("display_errors", 1);

require("inc/config.inc.php");

//op=listado_facturas
if(isset($_REQUEST["op"]) && $_REQUEST["op"]=="listado_facturas"){
	//mostrar listado de facturas

	//creamos el html del listado

	$_datos_factura = "id, idk, idkp, FACtitulo, FACdescripcion1, FACdescripcion2, FACdescripcion3, FACnombre, FACcif, FACdireccion1, FACdireccion2, FACdireccion3, FACcodigopostal, FACemail, FACtelefono, FACcontacto, FACnumero, FACfecha, FACbase, FACiva, FACimporte, FACqr, alta, ultimo, estado FROM FACfacturas";

	$sql_facturas = "SELECT $_datos_factura FROM FACfacturas ORDER BY FACfecha ASC, FACnombre ASC";
	$sql_facturas = "SELECT * FROM FACfacturas ORDER BY FACfecha ASC, FACnombre ASC";

	if($resultado = $mysqli->query($sql_facturas)){
	

		$html_facturas =<<<fin
		<table>
		<tr>
			<td colspan="6">FACTURAS</td>
		</tr>
		<tr>
			<th>nombre</th>
			<th>cif</th>
			<th>fecha</th>
			<th>base</th>
			<th>iva</th>
			<th>importe</th>
		</tr>
fin;
		//recorremos las facturas
		while($datos = $resultado->fetch_assoc()){

			//recorremos los campos de la factura
			// foreach($variables as $variable){
			// 	if(isset($datos[$variable])){
			// 		$$variable == $datos[$variable];
			// 	}else{
			// 		$$variable == "";
			// 	}
			// }
			$id = $datos["id"];
			$idk = $datos["idk"];
			$idkp = $datos["idkp"];
			$FACtitulo = utf8_encode($datos["FACtitulo"]);
			$FACdescripcion1 = utf8_encode($datos["FACdescripcion1"]);
			$FACnombre = utf8_encode($datos["FACnombre"]);
			$FACcif = utf8_encode($datos["FACcif"]);
			$FACfecha = utf8_encode($datos["FACfecha"]);
			$FACnumero = utf8_encode($datos["FACnumero"]);
			$FACbase = $datos["FACbase"];
			$FACimporte = $datos["FACimporte"];
			$FACiva = $datos["FACiva"];
			
			/*
			$FACiva = $datos["FACiva"];
			$FACiva = $datos["FACiva"];
			$FACiva = $datos["FACiva"];
			$FACiva = $datos["FACiva"];
			$FACiva = $datos["FACiva"];
			$FACiva = $datos["FACiva"];
			$FACiva = $datos["FACiva"];
			$FACiva = $datos["FACiva"];
			$FACiva = $datos["FACiva"];
			$FACiva = $datos["FACiva"];
			*/

			//imprimimos la factura
			$html_facturas.=<<<fin
			<table>
			<tr>
				<td colspan="6">$FACtitulo</td>
			</tr>
			<tr>
				<td colspan="6">$FACdescripcion1</td>
			</tr>


			<tr>
				<td colspan="6">



				</td>
			</tr>

			<tr>
				<td>

					<table>
						<tr>
							<td>Nombre:</td>
							<td><strong>$FACnombre</strong></td>
						</tr>
						<tr>
							<td>CIF:</td>
							<td><strong>$FACcif</strong></td>
						</tr>
					</table>

					<table>
						<tr>	
							<td>Fecha: </td>
							<td>Número: </td>
						</tr>
						<tr>
							<td>$FACnumero:</td>
							<td>$FACnumero</td>
						</tr>
					</table>

					<table>
						<tr>
							<td>Base</td>							
							<td>Iva</td>
							<td>Importe</td>
						</tr>
						<tr>	
							<td>$FACbase &euro;</td>
							<td>$FACiva &euro;</td>
							<td>$FACimporte &euro;</td>
						</tr>						
					</table>



				</td>
			</tr>
<!--
			<tr>
				$FACnombre</td>
				<td>$FACcif</td>
				<td>$FACfecha</td>
				<td><strong>$FACnumero</strong></td>
				<td>$FACbase &euro;</td>
				<td>$FACiva &euro;</td>
				<td>$FACimporte &euro;</td>
			</tr>
-->
fin;

		}

		$html_facturas.=<<<fin
		</table>
		<br>CODIGO DE PRUEBA - INICIO
		<br><a href="#_" onclick="window.close();">cerrar</a>
		<br><a href="#_" onclick="window.opener.location.href='http://localhost:8888/toolbox/facturas_pdf/formulario.php?CAMBIANDO_LA_URL=1#_';window.close();">a otro sitio</a>
		<br>FIN _ CODIGO PRUEBA
		<br>
fin;

		print $html_facturas;
		exit();

	}else{
		//gestionamos el error
		$errno = $mysqli->errno;
		$error = $mysqli->error;
		print "Error ($errno) al generar listado de FACTURAS:<br>$error";
	}
}



//la lista de variables
$_variables ="FACtitulo,FACdescripcion1,FACdescripcion2,FACdescripcion3,FACnombre,FACcif,FACdireccion1,FACdireccion2,FACdireccion3,FACcodigopostal,FACemail,FACtelefono,FACcontacto,FACnumero,FACfecha,FACbase,FACiva,FACimporte";

//lo convertimos en un array
$variables=explode(",", $_variables);

//recorremos el array
foreach($variables as $variable){
	if(isset($_REQUEST["$variable"])){
		$$variable = $_REQUEST["$variable"];
	}else{
		$$variable = "";
	}
}


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
	<br><a href="?op=listado_facturas" target="_blank">Listado de FACTURAS T</a>
	<br><a href="#_" onclick="window.open('?op=listado_facturas','nueva','width=600,height=500,left=100,top=100');">Listado de FACTURAS W</a>




	<br>
	$html_facturas
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


?>