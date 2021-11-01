<?php

function control_hamming_code($__code){
	$powers[] = $__code[0];
	unset($__code[0]);

	$powers[] = $__code[1];
	unset($__code[1]);

	$powers[] = $__code[3];
	unset($__code[3]);

	$powers[] = $__code[7];
	unset($__code[7]);

	$powers[] = $__code[15];
	unset($__code[15]);


}



Array
(
  [0] => 1
  [1] => 1
  [2] => 0
  [3] => 1
  [4] => 1
  [5] => 1
  [6] => 1
  [7] => 0
  [8] => 1
  [9] => 1
  [10] => 0
  [11] => 0
  [12] => 0
  [13] => 0
  [14] => 0
  [15] => 1
  [16] => 0
  [17] => 0
  [18] => 0
  [19] => 1
  [20] => 1
)
// ответ: 5