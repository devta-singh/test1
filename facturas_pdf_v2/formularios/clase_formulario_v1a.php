<?php
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
?>