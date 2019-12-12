<?php

include_once("clase_campo_v1a.php");

$datos0=array(
	"nombre"=>"telefono"
	,"rotulo"=>"Teléfono fijo:"
	,"tipo_html"=>"text"
	,"valor"=>"966222356"
	,"id"=>"telefono"
	,"estilo_css"=>""
	,"clase_css"=>""
	,"js"=>""
);

$datos1=array(
	"nombre"=>"nombre"
	,"rotulo"=>"Nombre:"
	,"tipo_html"=>""
	,"valor"=>""
);

$datos2=array(
	"nombre"=>"email"
	,"rotulo"=>"Email:"
	,"tipo_html"=>"text"
	,"valor"=>"nombre@servidor.com"
	,"id"=>"email"
	,"js"=>"onfocus=\"select();\""
);

$miscampos=array();

//con constructor
$miscampos[0]= new campo_html($datos0);
$miscampos[1]= new campo_html($datos1);
$miscampos[2]= new campo_html($datos2);

foreach ($miscampos as $campo){
	$html=$campo->genera_html();
	print "<BR />".$html;
}

?>