<?php
//ESTA CLASE GENERA UN FORMULARIO HTML A PARTIR DE UNA TABLA Y LISTA DE CAMPOS
class formulario {
	var $datos;//almacenamos los datos
	var $miscampos=array();//la lista de objetos campo es un array, vacío inicialmente
	var $html_campos;//donde guardamos el código html generado

	function cargar_datos($tabla="usuarios", $clave="1", $campos=""){
		//obtener los datos de la tabla
		mysql_connect('localhost','root','');//conectamos
		mysql_select_db('tienda');//seleccionamos la BBDD

		//consulta para obtener la estructura de la tabla
		//para poder saber que tipo de dato son los campos
		$sql="SHOW FIELDS FROM $tabla";
		if($cursor=mysql_query($sql)) {//ha funcionado
			//establezco un par de variables inicialmente
			$campo_clave="";//cual es el campo con clave primaria
			$lista_campos=array();//la lista de campos
			$datos_campo=array();//los datos de los campos
			$c=0;//un contador

			//iniciamos el bucle que recupera los campos
			while($datos=mysql_fetch_assoc($cursor)){
				//apuntamos sus propiedades
				$nombre=$datos["Field"];
				$tipo_sql=$datos["Type"];
				$nulo=$datos["Null"];
				$clave=$datos["Key"];
				$defecto=$datos["Default"];
				$extra=$datos["Extra"];

				//si el campo es clave primaria, apuntamos su nombre
				if($clave=="PRI") {
					$campo_clave=$nombre;
				}

				//si se ha indicado una lista de campos
				if(is_array($campos)) {
					//si el campo no esta en la lista de campos
					if(!in_array($nombre, $campos)) {
						//salto a la siguiente iteracion del bucle
						continue;
					}else {
						//(esta en la lista) lo incluyo en la lista
						$lista_campos[]=$nombre;//en la lista de campos

						//cargamos alguno de sus datos
						$datos_campo[$c]["nombre"]=$nombre;//el nombre
						$datos_campo[$c]["tipo_html"]="text";//el tipo de campo html

						$c++;
					}
				}else{
					//incluimos todos los campos en la lista
					$lista_campos[]=$nombre;
				}
			}//fin while

/*
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
*/



			return($datos_campo);
		}else{
			//la consulta ha fallado ¿existe esta tabla?
			return(false);
		}
	}

	function generar($datos) {
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