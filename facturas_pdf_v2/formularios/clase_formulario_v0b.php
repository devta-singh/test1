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

class formulario {

	var $datos;
	var $miscampos=array();
	var $html_campos;

	function formulario($datos) {
		$this->datos=$datos;
		$this->html_campos="";
		foreach ($this->datos as $c => $dato){
			$this->miscampos[$c]=new campo_html($dato);
			$this->html_campos .= "<BR />".$this->miscampos[$c]->genera_html();
		}
	}//fin funcion

	function salida() {
		print "Salida del formulario:<BR />".$this->html_campos;
	}
}//fin clase

$miformulario=new formulario($datos);
$miformulario->salida();
?>