<?php

function search_files($__start_dir, $__min_size = 10, $__depth = -1){
    $res = array();

    foreach(glob("$__start_dir/*") as $obj) {
        if (is_dir($obj)) {
            $res = array_merge($res, search_files($obj, $__min_size, $__depth - 1));
        } else {
            if ((filesize($obj) / (8*1024)) >= $__min_size) {
                $res[] = $obj;
            }
        }
    }

    return $res;
}