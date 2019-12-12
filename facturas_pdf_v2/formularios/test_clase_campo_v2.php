<?php

include_once("clase_campo_v1a.php");

$datos=array(
	array(
		"nombre"=>"telefono"
		,"rotulo"=>"Teléfono fijo:"
		,"tipo_html"=>"text"
		,"valor"=>"966222356"
		,"id"=>"telefono"
		,"estilo_css"=>""
		,"clase_css"=>""
		,"js"=>""
	)

	,array(
		"nombre"=>"nombre"
		,"rotulo"=>"Nombre:"
		,"tipo_html"=>""
		,"valor"=>""
	)

	,array(
		"nombre"=>"email"
		,"rotulo"=>"Email:"
		,"tipo_html"=>"text"
		,"valor"=>"nombre@servidor.com"
		,"id"=>"email"
		,"js"=>"onfocus=\"select();\""
	)
);

$miscampos=array();

foreach ($datos as $c => $dato){
	$miscampos[$c]=new campo_html($dato);
	$html= $miscampos[$c]->genera_html();
	print "<BR />".$html;
}

?>