<?php
echo "IMG_20180426_125919.jpg:<br />\n";
$exif = exif_read_data('IMG_20180426_125919.jpg', 'IFD0');
echo $exif===false ? "No se encontró información de cabecera.<br />\n" : "La imagen contiene cabeceras<br />\n";

$exif = exif_read_data('pruebas/prueba2.jpg', 0, true);
echo "prueba2.jpg:<br />\n";
foreach ($exif as $clave => $sección) {
    foreach ($sección as $nombre => $valor) {
        echo "$clave.$nombre: $valor<br />\n";
    }
}
?>