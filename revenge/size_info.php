<?php

// Написать функцию size_info($__filename, $__folder),
// которая осуществляет поиск файла $__filename во всех подкаталогах папки $__folder.
// Если такой файл найден, вернуть размер этого файла. В противном случае вернуть false. 

function size_info($__folder, $__filename)
{
    foreach (glob($__folder . '/*') as $obj) {
        if (is_file($obj)) {
            if (basename($obj) == $__filename) {
                return filesize($obj);
            }
        } else {
            $res = size_info($obj, $__filename);
            if ($res !== false) {
                return $res;
            }
        }
    }

    return false;
}