<?php

// Написать функцию buildCalculationMatrix($__size),
// которая генерирует массив для заполнения таблицы умножения, которая задана следующим шаблоном:

    // <style>
    // 	table {border-collapse: collapse;}
    // 	td {border: 1px #000 solid; }
    // </style>
    // <table>
    // <!-- rows -->
    // <tr>
    // 	<!-- cols -->
    // 	<td<!-- cols.$title_cell=1 --> style="font-weight:bold;"<!-- cols.$title_cell_ends -->>
    // 		<!-- .$value -->
    // 	</td><!-- cols_ends -->
    // </tr>
    // <!-- rows_ends -->
    // </table>

function buildCalculationMatrix($__size)
{
    $resArr = array();
    for($i = 1; $i <= $__size; $i++){
        for ($j = 1; $j <= $__size ; $j++){ 
            $resArr['rows'][$i-1]['cols'][$j-1]['value'] = $i * $j;
            if ($i == 1 || $j == 1) {
                $resArr['rows'][$i - 1]['cols'][$j - 1]['title_cell'] = 1;
            } else {
                $resArr['rows'][$i - 1]['cols'][$j - 1]['title_cell'] = 0;
            }
        }
    }

    return $resArr;
}
$template = '   <style>
    	table {border-collapse: collapse;}
    	td {border: 1px #000 solid; }
    </style>
    <table>
    <!-- rows -->
    <tr>
    	<!-- cols -->
    	<td<!-- cols.$title_cell=1 --> style="font-weight:bold;"<!-- cols.$title_cell_ends -->>
    		<!-- .$value -->
    	</td><!-- cols_ends -->
    </tr>
    <!-- rows_ends -->
    </table>';

require_once 'Template.php';
print_r(buildCalculationMatrix(3));

print Template::build($template, buildCalculationMatrix(5));