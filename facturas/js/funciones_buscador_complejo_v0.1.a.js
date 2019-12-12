//funciones_buscador_complejo_v0.1.a.js

function componer_url(){

}
function coleccionar_datos(){
	var lista_campos=Array('nombre','apellidos','telefono','email');
	var nombre,apellidos,telefono,email;
	var like_nombre, like_apellidos, like_telefono, like_email;

	var tipo, tipo_or, tipo_and;
	var chk_nombre, chk_apellidos, chk_telefono, chk_email;

	var nombre_campo, campo;
	var chk;

	var variables=Array();
	var _campo_texto,_campo_radio;
	//vaciamos el campo de información
	//$('#condiciones').html("");
	//obtenemos los campos activos
	for(i=0;i<lista_campos.length;i++){
		campo = lista_campos[i];

		nombre_campo = '#_campo_'+campo;
		//alert(campo+" -- "+nombre_campo);
		//chk = $(nombre_campo).checked();
		//if(chk){

		if($(nombre_campo).prop("checked")){
			$('#condiciones').html(" campo: "+campo+" esta marcado<br>");
			variables[campo]=array)
			//recuperamos el texto de busqueda para este campo
			//buscar[nombre]
			_campo_texto = '#buscar_'+campo;
			//alert('nombre del campo con el texto: '+_campo_texto+$(_campo_texto).val());
			variables[campo]=$(_campo_texto).val();

			//informamos del dato en el DIV condiciones
			$('#condiciones').html(
				$('#condiciones').html()
				+"el texto que se busca en el campo "+campo+" es: "+variables[campo]+"<br>"
			);

			//comprobamos los 3 tipos de busqueda para este campo
			_campo_radio='#_like_email_fin';
			if($(_campo_radio).prop("checked")){

				variables[campo]=$(_campo_texto).val();
			}
			
			
		}else{
			$('#condiciones').html(
				$('#condiciones').html()
				+"no esta marcado el campo "+campo+"<br>"
			);
		}
		break;
	}
	chk_nombre, chk_apellidos, chk_telefono, chk_email;

	var like_nombre, like_apellidos, like_telefono, like_email;


}
/*
$.post( "ajax/test.html", function( data ) {
  $( ".result" ).html( data );
});
*/