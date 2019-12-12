<?php
class campo_html {
	var $rotulo;
	var $nombre;
	var $tipo_html;
	var $valor;
	var $id;
	var $js;
	var $estilo_css;
	var $clase_css;

	function campo_html($datos=""){
		if(isset($datos["nombre"])){
			$this->nombre = $datos["nombre"];
		}else{
			$this->nombre = "anonimo";
		}
		if(isset($datos["rotulo"])){
			$this->rotulo = $datos["rotulo"];
		}else{
			$this->rotulo = $this->nombre;
		}
		if(isset($datos["tipo_html"])){
			$this->tipo_html = $datos["tipo_html"];
		}else{
			$this->tipo_html = "text";
		}
		if(isset($datos["valor"])){
			$this->valor = $datos["valor"];
		}else{
			$this->valor = "";
		}
		if(isset($datos["id"])){
			$this->id = $datos["id"];
		}else{
			$this->id = $this->nombre;
		}
		if(isset($datos["js"])){
			$this->js = $datos["js"];
		}else{
			$this->js = "";
		}
		if(isset($datos["estilo_css"])){
			$this->estilo_css = $datos["estilo_css"];
		}else{
			$this->estilo_css = "";
		}
		if(isset($datos["clase_css"])){
			$this->clase_css = $datos["clase_css"];
		}else{
			$this->clase_css = "";
		}
		return(true);
	}

	function genera_html($mostrar=0){

		if($this->estilo_css != ""){
			$estilo_css = 'style="'.$this->estilo_css.'"';
		}else {
			$estilo_css = '';
		}

		if($this->clase_css != ""){
			$clase_css = 'class="'.$this->clase_css.'"';
		}else {
			$clase_css = '';
		}
		switch($this->tipo_html) {
			case 'password':
			{
				$html=<<<fin
$this->rotulo<input type="text" id="$this->id" name="$this->nombre" value="$this->valor" $this->js $estilo_css $clase_css>
fin;
				break;
			}
			case 'hidden':
			{
				$html=<<<fin
$this->rotulo<input type="text" id="$this->id" name="$this->nombre" value="$this->valor" $this->js $estilo_css $clase_css>
fin;
				break;
			}

			case 'textarea':
			{
				$html=<<<fin
$this->rotulo<BR /><textarea rows="6" rows="60" id="$this->id" name="$this->nombre" $this->js $estilo_css $clase_css>$this->valor</textarea>
fin;
				break;
			}

			default:
			{
				$html=<<<fin
$this->rotulo<input type="text" id="$this->id" name="$this->nombre" value="$this->valor" $this->js $estilo_css $clase_css>
fin;
				break;
			}
		}
		return($html);
	}
}//fin clase campo v1a

?>