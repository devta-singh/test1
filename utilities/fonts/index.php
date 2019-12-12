<?php

$dir="/Users/devta/Library/Fonts";
///Users/devta/Library/Fonts
print "\n<br>Directorio: $dir";
$d= opendir($d);
while($f=readdir($d)){
	if(substr($f,0,1)=="."){
		//continue;
	}
	print "\n<br>$f";
}
?>