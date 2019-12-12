<?php
//ESTA CLASE GENERA UN FORMULARIO HTML A PARTIR DE UNA TABLA Y LISTA DE CAMPOS
class formulario_html {
	var $datos;//almacenamos los datos
	var $miscampos=array();//la lista de objetos campo es un array, vac�o inicialmente
	var $html_campos;//donde guardamos el c�digo html generado
	var $id_form;
	var $nombre;
	var $tabla;
	
	var $datos_botones=array();//la variable con los datos de los botones
	var $datos_campos=array();//la variable con los datos de los campos
	var $datos_seguridad=array();//control de seguridad
	var $lista_campos=array();//lista de campos
	
	function tipo_html($tipo_sql){
		
		$cadena = trim($tipo_sql);//"abcdef";
		$expresion = '/^def/';
		preg_match($expresion, $cadena, $matches, PREG_OFFSET_CAPTURE, 3);
		print_r($matches);
		
		
		$cadena="VARCHAR (90)";	
		
		$regex_varchar="/(VARCHAR).+\(([0-9]+)\)/";
			
		if($n=preg_match($regex_varchar, $cadena, $resultados)){
			//se ha dado el VARCHAR
			$longitud=$resultados[2];
		}elseif($n=preg_match($regex_text, $cadena, $resultados)){
			//TEXT
		}	

		
		
		return("text");
		switch($tipo_sql) {
			case 'VARCHAR':
			{

				break;
			}

			case 'TEXT':
			{

				break;
			}

			default:
			{

				break;
			}
		}//fin switch
	}

	function informe($datos=""){
		print "<hr/>Informe Errores:";
		_e("*");
		print "<hr/>Informe Mensajes:";
		_m("*");
	}
	
	/*
	 * Esta función, recibe los datos de un formulario generado por esta clase.
	 * Ha de comprobar en $_GET y en $_POST los valores enviados
	 * La lista de campos, y el campo de seguridad
	 * */
	function recibir_form($datos_form=""){
		//analizamos si hay un parametro ID que llega por GET
		if(isset($_GET["id"])){
			//si lo hay
			if(strstr($_GET["id"], "tabla:")){				
				//comprobamos si contiene información sobre una tabla
				$datos_tabla=$_GET["id"];//recuperamos el dato
				list($nom, $tabla)=explode(":", $datos_tabla);//lo troceamos por el caracter :
				
				//comprobamos que el parametro tabla no esté vacío
				if(trim($tabla) != ""){
					//la tabla tiene un nombre no vacío
					$this->tabla=trim($tabla);
					_m("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."Se va a intentar recuperar el form para la tabla: $tabla");
					//continuamos!!!
					
				}else{
					//no, la tabla no se indica, está vacío
					_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nError: "."Nombre de tabla no indicado");
					return(false);
				}
			}elseif(is_int($_GET["id"])){
				//comprobamos si es un entero			
				$id_form=$_GET["id"];
				//recuperamos ese form
				_m("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."Se va  aintentar recuperar el form con id_form: $id_form");
				return(true);
			}else{
				//no es una tabla ni un entero, no hay datos con los que trabajar
				_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nError: "."No se ha encontrado un id_form (entero) ni tabla sobre la que trabajar, el dato era: ".nl2br(print_r($datos_form,1)));
				return(false);
			}
		
			
		}else{
			//no se ha indicado un ID en GET, habrá que probar otra forma
			//for ahora no se ha implementado otra forma,
			//salimos con un error
			_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nError: "."No se ha indicado ni id del formulario ni una tabla sobre la que trabajar");
			return(false);
		}
		
		////ahora recuperamos los campos
		$codigo=$_POST["_campo_control_"];
		//$codigo=strrev(base64_encode(serialize($lista_campos)));
		$lista_campos=unserialize(base64_decode(strrev($codigo)));
			
		//recorremos losa campos para obtener los valores
		foreach($lista_campos as $campo => $datos_campo){
			print "\n<br/>campo: $campo =".$datos_campo;
		}
		
		//llamamos a la función que carga la estructura de tabla SQL
		//indicando el tipo de campo y el nombre
		//y hacemos una traslación al tipo de campo HTML a representar
		//cargamos la estructura, indicando tabla y lista de campos
		$datos_campos = $this->cargar_estructura($this->tabla, $lista_campos);
		
		//ahora recorremos los datos obtenidos, para generar un array de los datos (recibidos por POST)
		//print_r($datos_campos);
		foreach($datos_campos as $c => $datos_campo){
			$nombre=$datos_campo["nombre"];
			$tipo_html=$datos_campo["tipo_html"];
			$tipo_sql=$datos_campo["tipo_sql"];
			if(isset($_POST[$nombre])){
				$valor=$_POST[$nombre];
			}else{
				$valor="****";
			}
			$datos_consulta[$nombre]=$valor;
			$tipo_campo_sql[$nombre]=$tipo_sql;
		}

		_m("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."Formulario procesado");
		
		//la opcion para generar la consulta SQL
		$opcion="insertar";
		//ahora comprobamos si la URL (GET) o el POST incluye un campo _opcion_ 
		if(isset($_GET["_opcion_"])){
			$opcion=$_GET["_opcion_"];			
		}elseif(isset($_POST["_opcion_"])){
			$opcion=$_POST["_opcion_"];			
		}else{
			//no hay una opcion, así que la damos por defecto
			$opcion="insertar";	
		}
		
		print "\n<br>Opcion: $opcion";
		
		if($opcion=="nuevo"){
			//en la opcion modificar hemos de indicar una clave
			if(isset($_POST["_key_"])){
				$key=$_POST["_key_"];
			}
		}else{
			_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nError: "."No se ha indicado una clave para localizar el registro");
			return(false);
		}
		
		
		if($this->procesar_consulta($datos_consulta, $tipo_campo_sql, $tipo_consulta, $key)){
			return(true);
		}else{
			return(false);
		}	
	}//fin funcion recibir_form()
	
	function procesar_consulta($datos_consulta="", $tipo_campo_sql="", $tipo_consulta="", $claves=""){
		if($datos_consulta==""){
			_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nError: "."No se han indicado datos para generar la consulta");
			return(false);
		}
		if($tipo_campo_sql==""){
			_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nError: "."No se han indicado los tipos SQL de cada campo");
			return(false);
		}
		
		if($tipo_consulta=="insertar" || $tipo_consulta=="nuevo"){

			//ahora generamos la consulta SQL apropiada
			//para una insercion nueva:
			$sql1=implode(", ", array_keys($datos_consulta));
			$sql2="'".implode("', '", $datos_consulta)."'";
			$sql="INSERT INTO ".$this->tabla."($sql1) VALUES ($sql2)";
			_m("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."Consulta generada\nSQL: $sql");

			if($cursor=mysql_query($sql)){
				if($id=mysql_insert_id()){
					$this->insert_id=$id;
					_m("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."\nDato insertado con id: $id en la tabla $this->tabla");
					return($id);
				}else{
					_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."\nImposible insertar dato en la tabla $this->tabla\nError Mysql (".mysql_errno()."):".mysql_error());
					return(false);
				}
			}elseif(mysql_errno()=="1062"){
				_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."\nImposible insertar dato, clave duplicada. ¿Ya existe el registro? En la tabla $this->tabla");	
				return(false);
			}else{
				_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."\nImposible insertar dato, Error al ejecutar la consulta:\n$sql.\nEn la tabla $this->tabla");
				return(false);
			}

		}elseif($tipo_consulta=="modificar" || $tipo_consulta=="actualizar"){


			//ahora generamos la consulta SQL apropiada
			//para una modificación:
			
			$sql1=array();
			foreach($datos_consulta as $campo => $valor){
				$sql1[]="$campo = '$valor'";
			}
			$sql1=implode(", ", $sql1);
			
			$sql_condicion=array();
			foreach($claves as $campo => $valor){
				$sql_condicion[]="$campo = '$valor'";			
			}
			
			if(sizeof($sql_condicion) > 1){
				$sql_condicion = " ( ".implode(" AND ", $sql_condicion)." ) ";
			}elseif(sizeof($sql_condicion)==0){
				_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."\nNo se indicaron campos clave, Error al componer la consulta en la tabla $this->tabla");
				return(false);				
			}else{
				$sql_condicion = implode(" ", $sql_condicion);
			}
			
			
			$sql="UPDATE ".$this->tabla." SET $sql1 WHERE $sql_condicion";
			_m("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."Consulta generada\nSQL: $sql");

			if($cursor=mysql_query($sql)){
				if($id=mysql_insert_id()){
					$this->insert_id=$id;
					_m("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."\nDato insertado con id: $id en la tabla $this->tabla");
					return($id);
				}else{
					_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."\nImposible insertar dato en la tabla $this->tabla\nError Mysql (".mysql_errno()."):".mysql_error());
					return(false);
				}
			}elseif(mysql_errno()=="1062"){
				_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."\nImposible insertar dato, clave duplicada. ¿Ya existe el registro? En la tabla $this->tabla");	
				return(false);
			}else{
				_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."\nImposible insertar dato, Error al ejecutar la consulta:\n$sql.\nEn la tabla $this->tabla");
				return(false);
			}
		
		}else{
			_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."\nNo se ha indicado el tipo de consulta, no se hizo nada en la tabla $this->tabla");
			return(false);			
		}
	}

	function cargar_estructura($tabla="", $campos="", $cadena_conexion=""){
		//obtener los datos de la tabla
		
		//si se ha indicado el parametro $cadena_conexion, comprobamos si hay un array serializado y camuflado
		if($cadena_conexion != ""){
			
			
		}else{
			//usamos los datos de conexion definidos en el config.inc.php
			mysql_connect(_db_server,'root','');//conectamos
			mysql_select_db('tienda');//seleccionamos la BBDD

			//datos de conexion por defecto
			//mysql_connect('_db_serverlocalhost','root','');//conectamos
			//mysql_select_db('tienda');//seleccionamos la BBDD
			
		}
		if($tabla==""){
		//no se ha indicado la tabla de trabajo, salimos de la función
			_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nError: "."No se ha indicado una tabla");
			return(false);
		}else{
			_m("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."Generando form para la tabla $tabla");
			$this->tabla=$tabla;
		}
		
		if(is_array($campos)){
		//contamos los campos solicitados
			$num_campos_solicitados=sizeof($campos);
		}else{
			$num_campos_solicitados=0;			
		}
		
		/*
		print "<br/>Cargar_Estructura()";
		print "<br/>tabla: $tabla";
		print "<br/>campos:". nl2br(print_r($campos, 1));
		*/
		_m("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: campos: ". nl2br(print_r($campos, 1)));
			
		
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
					$campo_clave=$nombre;//el campo es una clave primaria
				}

				//si se ha indicado una lista de campos
				if(is_array($campos)) {
					//es un array el parametro con la lista de campos
					//print "<br/>La lista de campos es un array";
					
					//si el campo no esta en la lista de campos
					if(!in_array($nombre, $campos)) {
						//salto a la siguiente iteracion del bucle
						//print "<br/>Saltando el campo <strong>$nombre</strong> (no esta en la lista de campos)";
						continue;//saltamos la iteración actual del bucle
					}else {
						//(esta en la lista) lo incluyo en la lista
						
						//print "<br/>*El campo <strong>$nombre</strong> se usar&aacute;, (est&aacute; en la lista de campos)";
						_m("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."*El campo <strong>$nombre</strong> se usar&aacute;, (est&aacute; en la lista de campos)");
						$lista_campos[]=$nombre;//en la lista de campos

						//cargamos alguno de sus datos
						$datos_campo[$c]["nombre"]=$nombre;//el nombre
						$datos_campo[$c]["tipo_html"]="text";//el tipo de campo html
						$datos_campo[$c]["tipo_sql"]=$tipo_sql;//el tipo de campo html

						$c++;//actualizamos el contador
					}
				}else{
					//incluimos todos los campos en la lista
					//print "<br/>La lista de campos es un array";
					_m("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."La lista de campos es un array.");	
					$lista_campos[]=$nombre;//añadimos el campo a la lista de campos

					$datos_campo[$c]["nombre"]=$nombre;//el nombre
					$datos_campo[$c]["tipo_html"]="text";//el tipo de campo html
					$datos_campo[$c]["tipo_sql"]=$tipo_sql;//el tipo de campo html	

					$c++;//actualizamos el contador
				}
			}//fin while
			
			//contamos el numero de campos obtenidos
			$num_campos_obtenidos=sizeof($datos_campo);

			//si no se han recuperados campos
			if($num_campos_obtenidos == 0){
				//print "<br/>No se han obtenido campos, no se puede seguir.";
				_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nError: "."No se han obtenido campos, no se puede seguir.");	
				return(false);
			}
			
			//comparamos el numero de campos solicitado con los que hemos obtenido
			if($num_campos_solicitados > $num_campos_obtenidos){
				//print "<br/>No todos los campos se han podido recuperar";
				_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nError: "."No todos los campos solicitados se han podido recuperar.");			
			}else{
				_m("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: "."Todos los campos solicitados se han podido recuperar.");			
			}

/*
	array(
		"nombre"=>"telefono"
		,"rotulo"=>"Tel�fono fijo:"
		,"tipo_html"=>"text"
		,"valor"=>"966222356"
		,"id"=>"telefono"
		,"estilo_css"=>""
		,"clase_css"=>""
		,"js"=>""
	)
*/
			
			$this->datos_campos=$datos_campo;//la variable con los datos de los campos
			//$this->datos_seguridad=$datos_seguridad;//control de seguridad
			$this->lista_campos=$lista_campos;//lista de campos

			//generamos el codigo de control con la lista de campos
			$codigo=strrev(base64_encode(serialize($lista_campos)));
			
			//generamos el campo hidden que transporta el codigo de seguridad
			$campo_control_campos="<input type=\"hidden\" name=\"_campo_control_\" value=\"$codigo\">";
			
			//lo metemos en la variable de la clase
			$this->datos_seguridad=$campo_control_campos;

			return($datos_campo);//devolvemos los datos generados
		}else{
			//la consulta ha fallado ¿existe esta tabla?
			_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nError: "."la consulta ha fallado ¿existe esta tabla?");			
			
			return(false);
		}
	}//fin funcion cargar_estructura
		
	function cargar_datos($tabla="", $valor_clave="1", $campos=""){
		
		//la consulta ha fallado ¿existe esta tabla?
		if($tabla==""){
			_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nError: "."No se ha indicado ninguna tabla, no se puede seguir.");			
			return(false);
		}		
		
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
					//$campos_clave$nombre;
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
			_e("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nError: "."la consulta ha fallado ¿existe esta tabla ($tabla)?");
			return(false);
		}
	}

	function generar($datos, $tipo_consulta="insertar") {
		$this->datos=$datos;
		$this->html_campos="";
		$lista_campos=array();//preparamos la lista de campos
		foreach ($this->datos as $c => $dato){
			//print "<br/>Generar: ".print_r($dato)."<br/>";//mostramos los datos para ver que toma como origen
			_m("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: Generar".nl2br(print_r($dato,1)));
			$this->miscampos[$c]=new campo_html($dato);
			$this->html_campos .= "<BR />".$this->miscampos[$c]->genera_html();
			//$lista_campos[]="";
		}
		
		//añadimos el campo de control con la lsita encriptada de campos
		$this->html_campos .=$this->datos_seguridad;
		
		//$lista_campos[]
		$datos_campos_form=implode(", ", $lista_campos);
		
		$onsubmit="onsubmit=\"\"";
		$method="post";
		
		if(isset($this->id_form) && ($this->id_form!="")){
			$id_form=$this->id_form;
		}else{
			$id_form="tabla:".$this->tabla;
		}
		
		//ahora procesamos el tipo de consulta para el que se construye el formulario
		//puede ser: insertar o modificar
		//si se elige modificar, hay que añadir la información para el campo clave _key_
		
		//$action="test_carga_formulario_v2b.php?id=$id_form";
		
		/*
		 * Posibles valores (estados) actual (formulario) -> después (tratamiento formulario)
		 * Nada= nuevo -> insertar
		 * 
		 * Registro existente = editar -> modificar
		*/
		if($tipo_consulta=="modificar"){
			//modificar
			$action="test_carga_formulario_v2b.php?id=tabla:$this->tabla&opcion=modificar&id=";
			$campos_extra=<<<fin
<input type="hidden" name="opcion" value="modificar">
<input type="hidden" name="tabla" value="$this->tabla">
<input type="hidden" name="" value="">
fin;
			
		}else{
			//insertar
			$action="test_carga_formulario_v2b.php?id=tabla:$this->tabla&opcion=insertar";
			$campos_extra=<<<fin
<input type="hidden" name="opcion" value="nuevo">
<input type="hidden" name="tabla" value="$this->tabla">
fin;
		}
		
		
		$_id_formulario="formulario_automatico";
		
		//generamos el formulario
		//print "<br/>Ahora generamos el formulario";
		_m("\nFile: ".__FILE__."\nClase: ".__CLASS__."\nFuncion: ".__FUNCTION__."\nLinea:".__LINE__."\nMsg: Ahora generamos el formulario");
		
		//html que abre el form
		$this->html_form_pre="\n"."<FORM action=\"$action\" method=\"$method\" id_form=\"$_id_formulario\" $onsubmit>$campos_extra".$datos_campos_form;
		
		//html de los botones
		$this->html_form_post="\n<br/>"."<input type=\"submit\" value=\"Procesar\" onclick=\"\">";
		$this->html_form_post.="\n"."<input type=\"reset\" value=\"Reset\" onclick=\"\">";
		
		//html que cierra el form
		$this->html_form_post.="\n"."</FORM>";		
		
		$this->html_form=$this->html_form_pre."\n".$this->html_campos."\n".$this->html_form_post;
	}//fin funcion

	function salida($solo_campos=0) {
		if($solo_campos){
			print "fn salida / Salida del formulario:<BR />".$this->html_campos;
		}else{
			print "fn salida / Salida del formulario:<BR />".$this->html_form;
		}
	}
		
}//fin clase
?>