//funciones_buscador_listado_v0.1.c.js
/*
$.post( "ajax/test.html", function( data ) {
  $( ".result" ).html( data );
});
*/



function buscar(que){
	//alert(que);
	//$('#resultados').html(que);
	//if(que == ''){
	if(que.trim() == ''){
		$( "#resultados" ).html('-nada que buscar-');
	}else{
		//hay algo sobre lo que buscar
		$.post( 'contacto_buscar_activo.php?que='+que, function( datos_devueltos ) {
	  		$( "#resultados" ).html( datos_devueltos );
		});
	}
}

function guardar_busqueda(nombre,sql){
	//alert(que);
	//$('#resultados').html(que);
	$.post( 'guardar_busqueda.php?nombre='+nombre+'&sql='+sql, function( datos_devueltos ) {
  		$( "#resultados" ).html( datos_devueltos );
	});
}