<?php

// Написать функцию buildMaze($__mazeDataArr),
// которая генерирует массив для заполнения лабиринта, который задан следующим шаблоном:

// <style>
// 	* {border-collapse:collapse; margin:0px; padding:0px;}
// 	td {width:20px; height: 20px;}
// 	.top {border-top:1px #000 solid;}
// 	.right {border-right:1px #000 solid;}
// 	.bottom {border-bottom:1px #000 solid;}
// 	.left {border-left:1px #000 solid;}
// </style>
// <table>
// <!-- row -->
// <tr>
// 	<!-- cell -->
// 	<td class="<!-- classes --><!-- .$class --> <!-- classes_ends -->"></td>
// 	<!-- cell_ends -->
// </tr>
// <!-- row_ends -->
// </table>

//     $mazeDataArr = [
// 	//row
// 	[
// 		//column
// 		["left",  "top", "bottom"],
// 		...	
// 	],
// [
    // 		//column
    // 		["left",  "top", "bottom"],
    // 		...	
    // 	],
    // [
    // 		//column
    // 		["left",  "top", "bottom"],
    // 		...	
    // 	],
    // 	...
    // ]

// При заполнении лабиринта учесть, что порядок следования классов должен быть:
// top, right, bottom, left (как в css).

function buildMaze($__mazeDataArr)
{
    $resArr = array();
    foreach ($__mazeDataArr as $rowNumber => $rowArr) {
        foreach ($rowArr as $cellNumber => $classesArr) {
                #$resArr['row'][$rowNumber]['cell'][$cellNumber]['classes'][$classNumber]['class'] = $class;
                if (in_array('top', $classesArr)) {
                    $resArr['row'][$rowNumber]['cell'][$cellNumber]['classes'][]['class'] = 'top';
                }
                if (in_array('right', $classesArr)) {
                    $resArr['row'][$rowNumber]['cell'][$cellNumber]['classes'][]['class'] = 'right';
                }
                if (in_array('bottom', $classesArr)) {
                    $resArr['row'][$rowNumber]['cell'][$cellNumber]['classes'][]['class'] = 'bottom';
                }
                if (in_array('left', $classesArr)) {
                    $resArr['row'][$rowNumber]['cell'][$cellNumber]['classes'][]['class'] = 'left';
                }
        }
    }

    return $resArr;
}

require_once 'Template.php';

$arr = [
    [
        ['left', 'right', 'top'],
        ['top', 'bottom'],
        ['left', 'right']
    ],
    [
        ['left', 'right'],
        ['top', 'bottom'],
        ['left', 'right']
    ],
    [
        ['left'],
        ['top', 'bottom'],
        ['left', 'right']
    ],

];

$template = '<style>
	* {border-collapse:collapse; margin:0px; padding:0px;}
	td {width:20px; height: 20px;}
	.top {border-top:1px #000 solid;}
	.right {border-right:1px #000 solid;}
	.bottom {border-bottom:1px #000 solid;}
	.left {border-left:1px #000 solid;}
</style>
<table>
<!-- row -->
<tr>
	<!-- cell -->
	<td class="<!-- classes --><!-- .$class --> <!-- classes_ends -->"></td>
	<!-- cell_ends -->
</tr>
<!-- row_ends -->
</table>';

print Template::build($template, buildMaze($arr));