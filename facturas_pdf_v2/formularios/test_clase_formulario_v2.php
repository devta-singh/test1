<?php

//print "Hola";

include_once("clase_campo_html_v1a.php");
include_once("clase_formulario_html_v2a.php");

$campos=array('nombre', 'email', 'clave');

$miformulario=new formulario_html($datos);

$datos_form=$miformulario->cargar_datos("usuarios", 1, $campos);

$miformulario->generar($datos_form);

$miformulario->salida();


?>