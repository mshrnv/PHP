<?php

function matrix_shift($__matrix, $__shift){
    $rows = count($__matrix);
    if ( $rows == 0 ){
        return false;
    }
    
    for($i = 0; $i < $rows; $i++){
    	$cols = count($__matrix[$i]);
    	for($j = 0; $j < $cols; $j++){
    		if(!is_int($__matrix[$i][$j])){
    			return false;
    		}
    	}
    	if ($rows != $cols){
    		return false;
    	}
    }

    for($i = 0; $i < $rows; $i++){
        $cols = count( $__matrix[$i] );
        $temp = $__matrix[$i];
        for ($j=0; $j < $cols; $j++) { 
            $index = $j - $__shift;
            while ($index < 0){
                $index += $cols;
            }
            $__matrix[$i][$index] = $temp[$j];
        }
    }

    return $__matrix;
}

