<?php //clase_plantilla.php

class plantilla{
	var $contenido;
	function plantilla($origen, $es_fichero=0){
		if($es_fichero){
			if(file_exists($origen)){
				$this->contenido = file_get_contents($origen);
			}else{
				//el fichero no existe
				$this->contenido="EL FICHERO $origen NO EXISTE";
			}
		}else{
			$this->contenido = $origen;
		}
	}

	function cabecera_html(){
		if(!headers_sent()){
			header("Content-Type: text/html; charset: utf-8");
		}else{
			//print "CABECERAS YA ENVIADAS";		
		}
	}

	function r($a, $b){
		$this->reemplazar($a, $b);
		//return($this->contenido);
	}

	function reemplazar($a, $b){
		$this->contenido = str_replace($a, $b, $this->contenido);
	}

	function buscar($a){
		$n=$strpos($a, $this->contenido);
		return($n);
	}

	function imprimir(){
		print $this->contenido;
	}

	function volcar(){
		return $this->contenido;
	}
}

?>