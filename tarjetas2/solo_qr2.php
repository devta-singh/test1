<?php //solo_qr2.php

//////////////////
// QR
//////////////////
	//retomamos la imagen generada y le creamos un QR
	$url="http://circulodesanacion.org/r/?r=v5001&l=$lugar";
	$_url = $url;
	while(strpos($_url, " ")){
		$_url = str_replace(" ", "-", $_url);
	}
	$_lugar = str_replace(" ", "-", $_url);

	$url_destino = "http://www.circulodesanacion.org/r/?r=5001&lugar=$_lugar";

	$PNG_TEMP_DIR = "QR";//dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
    
    //html PNG location prefix
    $PNG_WEB_DIR = 'temp/';

    include "inc/qr/qrlib.php";
    $tam_qr = 6;
    $qr_filename = $PNG_TEMP_DIR.'test'.md5($url_destino.'|L|'.$tam_qr).'.png';
    $qr_filename2 = $PNG_TEMP_DIR.'test'.md5($url_destino.'|L|'.$tam_qr).'_2.png';
        QRcode::png($url, "qr/".$qr_filename, 'L', $tam_qr, 2);


/////////////////
// FILTRO
/////////////////      

      $im_filtro=imagecreatefrompng("qr/".$qr_filename);
      //bool imagefilter ( resource $image , int $filtertype [, int $arg1 [, int $arg2 [, int $arg3 [, int $arg4 ]]]] )
      
      print "<br>filtro imagen invertida B/N ";
      if(imagefilter($im_filtro, IMG_FILTER_NEGATE)){
      	if(_p){print "transformación exitosa";}
      }else{
      	if(_p){print "error en la transformación";}
      }

      //IMG_FILTER_GRAYSCALE
      print "<br>filtro escala de grises ";
      if(imagefilter($im_filtro, IMG_FILTER_GRAYSCALE)){
      	if(_p){print "transformación exitosa";}
      }else{
      	if(_p){print "error en la transformación";}
      }
      imagepng($im_filtro, "qr/".$qr_filename2);
      $im_filtro=imagecreatefrompng("qr/".$qr_filename2);
      
      //IMG_FILTER_BRIGHTNESS //cambia el brillo de -255 a 255
      //if($im && (imagefilter($im, IMG_FILTER_BRIGHTNESS, 80))){
      if(_p){print "<br>filtro COLORIZE ";}
      if($im_filtro && (imagefilter($im_filtro, IMG_FILTER_COLORIZE, 170, 0, 190, 0))){
      	if(_p){print "transformación exitosa";}
      }else{
      	if(_p){print "error en la transformación";}
      }
      
      //IMG_FILTER_COLORIZE //colorea la imagen con tonos RGB y alfa
      //imagefilter($im_filtro, IMG_FILTER_COLORIZE, 9, 30, 55, 50);
      imagepng($im_filtro, "qr/".$qr_filename2);
      $qr2="<br><image src='qr/$qr_filename2'>";

      print $qr2;

?>