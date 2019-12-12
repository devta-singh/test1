<?php

//print "Hola";

include_once("config.inc.php");

$campos=array('nombre', 'email', 'clave');

//$miformulario=new formulario_html($datos);
$miformulario=new formulario_html();

//esta funcion (cargar_datos) da los datos de tabla, valor_clave, y lista de campos (en un array)
//$datos_form=$miformulario->cargar_datos("usuarios", 1, $campos);

//esta funcion (cargar_estructura) toma los ados de los campos desde la tabla SQL
//$datos_form=$miformulario->cargar_estructura("usuarios", $campos);//llamada con un array de campos, buscara los campos pasados (si existen en la tabla)
//$datos_form=$miformulario->cargar_estructura("usuarios", "")//llamada sin campos, buscara TODOS los campos de la tabla
if($datos_form=$miformulario->cargar_estructura("usuarios", $campos)){
	$miformulario->generar($datos_form);
	$miformulario->salida();
}else{
	print "<br/>No se pudo completar la tarea... sorry";
	_e("*");
}
	//_m("*");
?>