<?php

// Написать функцию diff_dates($__left, $__right),
// которая находит абсолютное расстояние между двумя датами $__left и $__right.
// Даты представлены в формате timestamp.
// Функция возвращает строку вида: '$days." d ".$hours." h";',
// где $days - разница в полных днях. $hours - разница в полных часах.

function diff_dates($__left, $__right)
{

    $diff = abs($__right - $__left);
    $days = intval($diff / 86400);
    $hours = intval($diff / 3600) - $days*24;
    return "{$days} d {$hours} h";
}