<?php


function matrix_addition($__left_matrix, $__right_matrix){
	$left = explode("\n", $__left_matrix);
	foreach ($left as $key => $value) {
		$left[$key] = explode(' ', $value);
	}

	$right = explode("\n", $__right_matrix);
	foreach ($right as $key => $value) {
		$right[$key] = explode(' ', $value);
	}

	if (count($left) != count($right)) {
		return false;
	}
	$res = array();
	foreach($left as $rowKey => $row){
		if (count($left[$rowKey]) != count($right[$rowKey])) {
			return false;
		}
		foreach ($row as $columnKey => $item) {
			$res[$rowKey][$columnKey] = $left[$rowKey][$columnKey] + $right[$rowKey][$columnKey];
		}
	}
    
	foreach ($res as $key => $value) {
		$res[$key] = implode(" ", $value);
	}

	return implode("\n", $res);
	
}