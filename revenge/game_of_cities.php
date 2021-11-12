<?php

$citiesArr = Array
(
  0 => 'Орел',
  1 => 'Архангельск',
  2 => 'Липецк',
  3 => 'Воронеж',
  4 => 'Саратов',
  5 => 'Новосибирск',
  6 => 'Ростов',
  7 => 'Царицино',
  8 => 'Киров',
);

function game_of_cities($__citiesArr, $__startCityName){
    $res = $__startCityName;

    $arrLength = count($__citiesArr);
    for($i = 0; $i < $arrLength; $i++){
        $hasCity = false;
        $lastChar = mb_substr($res, -1);
        foreach($__citiesArr as $index => $city){
            if (mb_substr($city, 0, 1) == mb_strtoupper($lastChar)) {
                $res = mb_substr($res, 0, -1);
                $res .= $city;
                $hasCity = true;
                unset($__citiesArr[$index]);
                break;
            }
        }

        if ($hasCity === false) {
            break;
        }
        
    }

    return $res;
}

echo game_of_cities($citiesArr, 'Орел');