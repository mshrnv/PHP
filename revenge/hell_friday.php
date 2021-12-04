<?php

// Написать функцию hell_friday($__year),
// возвращающую массив пятниц 13 в этом году в формате d-m-Y
// Если ввод неправильный - функция возвращает false.

function hell_friday($__year)
{
    if (strtotime($__year) === false) {
        return false;
    }

    $resArr = array();

    foreach (range(1,12) as $month) {
        $timestamp = strtotime("13.{$month}.{$__year}");
        if (date('l', $timestamp) == 'Friday') {
            $resArr[] = date('d-m-Y', $timestamp);
        }
    }

    return $resArr;
}