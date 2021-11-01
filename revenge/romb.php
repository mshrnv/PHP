<?php

function prettyDump($__data){
    usort($__data, function ($a, $b) {return strlen($a) > strlen($b);});
    $maxLen = strlen($__data[count($__data) - 1]);
    for($i = 0; $i < count($__data); $i++){
        $__data[$i] = spaceAdding($__data[$i], $maxLen - strlen($__data[$i]));
    }
    $arr = array();
    for($i = count($__data) - 1; $i >= 0; $i--){
        if($i % 2 == 1){
            array_push($arr, $__data[$i]);
        } else {
            array_unshift($arr, $__data[$i]);
        }
    }
    $html = implode("<br>", $arr);
    echo "<pre>".$html."</pre>";
}

function spaceAdding($__str, $numOfSpaces){
    $numOfLeftSpaces = ceil( $numOfSpaces / 2 );
    $spaces = "";
    $spaces2 = "";
    for($i = 0; $i < $numOfLeftSpaces; $i++){
        $spaces.= " ";
    }
    for($i = 0; $i < $numOfSpaces - $numOfLeftSpaces; $i++){
        $spaces2.= " ";
    }
    return $spaces.$__str.$spaces2;
}

$array = ["a", "aaa", "aaa", "aaaaa", "bbb", "bba", "b"];
prettyDump($array);