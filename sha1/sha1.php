<?php //sha1.php
if(isset($_REQUEST["clave"])){
	$clave = $_REQUEST["clave"];
	$sha1= sha1($clave);
	$mensaje = "$clave --> $sha1";
	
}else{
	$mensaje = "pon la clave a encriptar";
}

print <<<fin
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>MD5</title>
</head>
<body>
	$mensaje<br>
<form action="?" method="post">
	Clave: <input type="text" name="clave"/>
	<br><input type="submit" valule="Encriptar"/>
</form>
</body>
</html>
fin;

?>