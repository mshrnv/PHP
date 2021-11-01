<?php

function generate_key(){
	$array = [];
	$hex = ['0', '1', '2', '3', '4', '5' , '6', '7', '8', '9', 'a', 'b', 'c', 'd', 'e', 'f'];
	for ($i=0; $i < 4; $i++) { 
		$sum = 0;
		for ($j=0; $j < 3; $j++) {
			$elem = rand(0,15);
			$sum += $elem;
			$array[$j][$i] = $hex[$elem];
		}
		$array[3][$i] = $hex[$sum % 16];
	}

	foreach ($array as $key => $value) {
		$array[$key] = implode('', $value);
	}
	print implode('-', $array);
	return implode('-', $array);
}

generate_key();