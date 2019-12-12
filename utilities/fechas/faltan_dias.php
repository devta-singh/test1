<?php //faltan_dias.php

if(isset($_REQUEST["desde"])){
	$desde = $_REQUEST["desde"];
}else{
	$desde = date("d-m-Y",time());
	$c_desde = date("d/m/Y",time());
}

if(isset($_REQUEST["hasta"])){
	$hasta = $_REQUEST["hasta"];
}else{
	$hasta = date("d-m-Y",time());
	$c_hasta = date("d/m/Y",time());
}

if(!isset($_REQUEST["t1"]) || !isset($_REQUEST["t2"])){
	$t1 = "";
	$t1 = "";
}

if(isset($_REQUEST["t1"])){
	$t1 = $_REQUEST["t1"];
}else{
	$t1 = date("H:i:s",time());
}

if(isset($_REQUEST["t2"])){
	$t2 = $_REQUEST["t2"];
}else{
	$t2 = date("H:i:s",time());
}

if(isset($_REQUEST["con_t1"])){
	$con_t1 = $_REQUEST["con_t1"];
	$chk_t1 = " checked";
}else{
	$con_t1 = null;
	$chk_t1 = "";
}

if(isset($_REQUEST["con_t2"])){
	$con_t2 = $_REQUEST["con_t2"];
	$chk_t2 = " checked";
}else{
	$con_t2 = null;
	$chk_t2 = "";
}

list($h_t1, $m_t1, $s_t1)=explode(":", $t1);
list($h_t2, $m_t2, $s_t2)=explode(":", $t2);
list($Y_desde, $m_desde, $d_desde)=explode("-", $desde);
list($Y_hasta, $m_hasta, $d_hasta)=explode("-", $hasta);

print "Desde día: $d_desde dias, mes: $m_desde, año: $Y_desde<br>";
print "Hasta día: $d_hasta dias, mes: $m_hasta, año: $Y_hasta<br>";

if(isset($_REQUEST["con_t1"])){
	$t_desde = mktime($h_t1, $m_t1, $s_t1, $m_desde, $d_desde, $Y-desde);
}else{
	$t_desde = mktime(0, 0, 0, $m_desde, $d_desde, $Y-desde);
}

if(isset($_REQUEST["con_t2"])){
	$t_hasta = mktime($h_t2, $m_t2, $s_t2, $m_hasta, $d_hasta, $Y-hasta);
}else{
	$t_hasta = mktime(0,0,0, $m_hasta, $d_hasta, $Y-hasta);
}

print <<<fin
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="" method="post">
		Desde: <input type="date" name="desde" value="$desde"/> <input type="checkbox" value="1" name="cont_t1"$chk_t1/> a las <input type="time" value="$t1" name="t1"/><a href="#_" onClick="this.value='';return(false);">poner a 00:00:00</a><br>
		Hasta: <input type="date" name="hasta" value="$hasta"/> <input type="checkbox" value="1" name="cont_t2"$chk_t2/> a las <input type="time" value="$t2" name="t1"/><br>
		<input type="submit" value="Enviar"/>
	</form>
</body>
</html>
fin;



//$t_desde = mktime(0,0,0, $m_desde, $d_desde, $Y-desde);
//$t_hasta = mktime(0,0,0, $m_hasta, $d_hasta, $Y-hasta);

$diferencia = $t_hasta - $t_desde;
$dias = ceil ($diferencia / 86400);

//procesamos lo que no son días
$resto_horas = $diferencia % 86400;

//obtenemos las horas
$horas = $resto_horas / 3600;

//procesamos lo restante como minutos
$resto_minutos = $resto_horas % 3600;
$minutos = $resto_minutos / 60;

//procesamos los segundos
$segundos = $resto_minutos % 60;

print "Desde $desde, hasta $hasta hay $dias días, $horas horas, $minutos minutos y $segundos segundos";

?>