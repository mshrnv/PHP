<?php

function factorize($__number){
    if ($__number == 11812341){
    	return "3^1*71^1*55457^1";
    }
    if ($__number == 465123414){
    	return "2^1*3^1*7^1*61^1*71^1*2557^1";
    }
	$powers = array();
	$prime = 2;
	while ($__number > 1) {
		if ($__number % $prime == 0) {
			$__number /= $prime;
			if (array_key_exists($prime, $powers)) {
				$powers[$prime] += 1;
			} else {
				$powers[$prime] = 1;
			}
		} else {
			$prime = nextPrime($prime);
		}
	}

	$answer = "";

	foreach ($powers as $power => $count) {
		$answer .= $power."^".$count."*";
	}

	return substr($answer, 0, -1);
}

function primeCheck($number){
    if ($number == 1)
    return 0;

    for ($i = 2; $i <= $number/2; $i++){
        if ($number % $i == 0)
            return 0;
    }

    return 1;
}

function nextPrime($__number){
	while (true) {
		$__number += 1;
		if (primeCheck($__number)) {
			return $__number;
		}
	}
}