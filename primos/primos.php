<?php //primos.php

$inicio = 1;
$final = 100000;
for($n=$inicio;$n<=$final;$n++){
	print "\n<br/>N: $n - ";
	$multiplos=0;
	for($c=($n-1);$c>1;$c--){
		//$c
		//calcula el resto
		$r = $n%$c;
		
		if($r==0){
			//es multiplo de $c
			print "$c ";
			$multiplos++;
		}else{
			//no es multiplo de $c

		}
	}
	if(!$multiplos){
		print "PRIMO";
	}
}




?>