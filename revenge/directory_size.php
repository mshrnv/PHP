<?php

function directory_size($__folder){
    $size = 0;
    foreach (glob("$__folder/*") as $object) {
        if (is_file($object)) {
            $size += filesize($object);
        } else {
            $size += directory_size($object);
        }
    }

    return $size;
}
print directory_size('codesniffer');