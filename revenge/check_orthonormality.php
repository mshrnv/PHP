<?php

function check_orthonormality($__matrix, $__size){
	foreach ($__matrix[0] as $index => $val) {
        $trans_matrix[$index] = array_column($__matrix, $index);
        $index++;
    }

    for ($i=0; $i < count($__size); $i++) { 
        for ($j=0; $j < count($__size); $j++){
            $sum = 0;
            for ($k=0; $k < $__size; $k++) { 
                $sum += $__matrix[$i][$k]*$trans_matrix[$k][$j];
            }
            $prod[$i][$j] = $sum;
        }
    }

    for ($i=0; $i < count($__size); $i++) { 
        for ($j=0; $j < count($__size); $j++){
            if($i == $j && $prod[$i][$j] != 1)
                return false;
            if ($i != $j && $prod[$i][$j] != 0) {
                return false;
            }
        }
    }

    return true;
}