<?php
    
function unpack_array($__array){
    
    $len = count($__array);

    if ( $len == 0 )
        return false;
    foreach ($__array as $num) {
        if (is_float($num) || $num < 0)
            return false;
    }

    $result = array();

    for ($i=0; $i < $len; $i++) { 
        for ($j = 0; $j < $__array[$i]; $j++) { 
            $result[] = $i % 2;
        }
    }

    return $result;
}