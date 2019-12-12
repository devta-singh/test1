<?php //test.php
error_reporting(15);
ini_set("display_errors", 1);

if(isset($_REQUEST["codigo"])){
	$codigo = $_REQUEST["codigo"];
	$codigo_visible = $codigo;
	$codigo_visible = str_replace("<", "&lt;", $codigo_visible);
	$codigo_visible = str_replace(">", "&gt;", $codigo_visible);
	
	ob_start();
	eval($codigo);
	$salida = ob_get_contents();
	ob_end_clean();

	$mensaje = "//codigo recibido:<br><PRE>$codigo_visible</PRE><br>salida:<br>$salida<br>";

}else{
	$codigo = "//sin codigo";
	$codigo='
$n = 1 + 1;
print "Resultado n:".$n;
eval (\'$n += 5;\');//uso anidado de eval
print "<br>\n";
print $n;
';


	$mensaje = "//No se indicó código";
}

print <<<fin
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Toolbox/Eval/test.php</title>
</head>
<body>
<div id=""container>
	$mensaje
	<br>
	<form action="" method="post">
		Código PHP a ejecutar:
		<br><textarea name="codigo">$codigo</textarea>
		<br><input type="submit" value="Enviar"/>
	</form>
	<!--
	application/x-www-form-urlencoded
	multipart/form-data
	text/plain
	-->
</div>
</body>
</html>
fin;
?>