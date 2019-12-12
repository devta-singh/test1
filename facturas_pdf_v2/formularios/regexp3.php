<?php
//encuentra la URL
$regex="/([a-zA-Z0-9]+)?.+$1/";//encuentra todas las palabras

//una URL
$regex="/(([a-zA-Z0-9][a-zA-Z0-9\._-]+[a-zA-Z0-9]+){1}([\/][a-zA-Z0-9][a-zA-Z0-9_-]+)*)+([a-zA-Z0-9_-]+)+([a-zA-Z0-9\._-]+)?([\?].+)?/";//encuentra todas las palabras


$cadena="
http://www3.boe-com.es/no_vedadesboe/roma-nas/frisos.php?zampana=12&unix=ubuntu
estemes.com
http://holaradiola.com
ftp://sambenito.es/juanes/index.php
carlota.es.com/miau
www4.magoo.info?res=99
";
print $regex."<br/>".$cadena."<br/>";
$resultados=preg_match_all($regex, $cadena, $datos, PREG_OFFSET_CAPTURE);
print "</br>resultados: ".$resultados;
print_r($datos);
?>