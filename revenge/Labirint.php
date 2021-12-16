<?php

// Реализуйте шаблон, для отображения лабиринта.

    // <style>
    // 	* {border-collapse:collapse; margin:0px; padding:0px;}
    // 	td {width:20px; height: 20px;}
    // 	.top {border-top:1px #000 solid;}
    // 	.right {border-right:1px #000 solid;}
    // 	.bottom {border-bottom:1px #000 solid;}
    // 	.left {border-left:1px #000 solid;}
    // </style>
    // <table>
    // <tr>
    // 	<td class="left top right"></td>
    // 	<td class="left right top"></td>
    // 	...
    // </tr>
    // ...
    // </table>

//     Array
// (
//     [row] => Array
//         (
//             [0] => Array
//                 (
//                     [cell] => Array
//                         (
//                             [0] => Array
//                                 (
//                                     [classes] => Array
//                                         (
//                                             [0] => Array
//                                                 (
//                                                     [class] => top
//                                                 )
//                                             [1] => Array
//                                                 (
//                                                     [class] => bottom
//                                                 )


<style>
	* {border-collapse:collapse; margin:0px; padding:0px;}
	td {width:20px; height: 20px;}
	.top {border-top:1px #000 solid;}
	.right {border-right:1px #000 solid;}
	.bottom {border-bottom:1px #000 solid;}
	.left {border-left:1px #000 solid;}
</style>

<table><!-- row -->
<tr><!-- cell -->
	<td class="<!-- classes[-1] --><!-- .$class --> <!-- classes_ends --><!-- classes --><!-- .$class --><!-- classes_ends -->"></td><!-- cell_ends -->
</tr><!-- row_ends -->
</table>