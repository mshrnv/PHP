<?php

function print_sand_clock($__data){
    usort($__data, function ($a, $b) {return strlen($a) > strlen($b);});
    $maxLen = strlen($__data[count($__data) - 1]);
    for($i = 0; $i < count($__data); $i++){
        $__data[$i] = spaceAdding($__data[$i], $maxLen - strlen($__data[$i]));
    }
    $arr = array();
    for($i = 0; $i < count($__data); $i++){
        if($i % 2 == 1){
            array_push($arr, $__data[$i]);
        } else {
            array_unshift($arr, $__data[$i]);
        }
    }
    $html = implode("\n", $arr);
    return "<pre>".$html."\n</pre>";
}

function spaceAdding($__str, $numOfSpaces){
    $numOfLeftSpaces = floor( $numOfSpaces / 2 );
    $spaces = "";
    $spaces2 = "";
    for($i = 0; $i < $numOfLeftSpaces; $i++){
        $spaces.= " ";
    }
    return $spaces.$__str;
}