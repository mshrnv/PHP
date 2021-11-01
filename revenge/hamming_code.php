<?php

$code = [0,0,1,1,0,1,1,1,0,0,1,0,1,0,0,0];

function hamming_code($__code){

	$powers = [1,2,4,8,16];

	foreach ($powers as $grade) {
		array_splice($__code, $grade - 1, 0, 0);
	}
	$len = count($__code);
	foreach ($powers as $grade) {
		$counter = 0;
		for($i = $grade - 1; $i < $len; $i += $grade){
			for($j = 0; $j < $grade && $j < $len; $j++, $i++){
				$counter += $__code[$i];
			}
		}
		$__code[$grade-1] = $counter % 2;
	}
	$__code[] = array_sum($__code) % 2;
    return serialize($__code);
}


echo hamming_code($code);