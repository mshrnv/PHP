<?php

// Написать функцию download_file($__filename, $__speed), реализующую выгрузку файла с определенной скоростью.

// $__filename - имя файла для выгрузки.

// $__speed - скорость загрузки в байтах/c.

// Заголовки Content-Type устанавливать не обязательно.

// Если запрошенного файла нет, вернуть false

function download_file($__filename, $__speed) {
    if (!file_exists($__filename)) {
        return false;
    }
    $file = fopen($__filename, "r");
    while(!feof($file)) {
        $content = fread($file, $__speed);
        echo $content;
        ob_flush();
        sleep(1);
    }
}