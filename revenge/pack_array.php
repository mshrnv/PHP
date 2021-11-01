<?php

function pack_array($__array){
	$current_element = 0;
	$counter = 0;
	if (empty($__array)) {
		return false;
	}
	foreach ($__array as $key => $value) {
		if ($value < 0 || $value > 1) {
			return false;
		}
		if ($current_element == $value) {
			$counter += 1;
		} else {
			$res_array[] = $counter;
			$counter = 1;
			$current_element++;
			$current_element %= 2;
		}		
	}
	$res_array[] = $counter;

	return $res_array;
}
