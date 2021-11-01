<?php

$arr = Array
(
  0 => 'true',
  1 => 1,
  2 => 'third',
  3 => Array
    (
      0 => Array
        (
          0 => 'first',
          1 => 'second',
        ),

      1 => 'first',
      2 => 'second',
    ),

  4 => Array
    (
      0 => 'first',
      1 => 'second',
    ),

);

function optimize($str){
    if ($str == '1') {
        return 'true';
    } elseif ($str == '0') {
        return 'false';
    }

    return $str;
}



function to_html_list($__list_arr){
	$html = "<ul>";
    foreach($__list_arr as $key1 => $value1){
        if (is_array($value1)) {
            foreach ($value1 as $key2 => $value2) {
                if (is_array($value2)) {
                    foreach ($value2 as $key3 => $value3) {
                        //
                    }
                } else {
                    $html .= "<li>".optimize($value2)."</li>";
                }
            }
        } else {
            $html .= "<li>".optimize($value1)."</li>";
        }
        
    }
    $html .= "</ul>";
    
    return $html;
}
print to_html_list($arr);