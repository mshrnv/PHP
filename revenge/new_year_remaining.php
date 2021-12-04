<?php

// Написать функцию new_year_remaining($__date),
// возвращающую количество дней до нового года
// от заданной даты $__date в формате '22.11.2017'.
// Если ввод неправильный - функция возвращает false.

function new_year_remaining($__date)
{
    $date = strtotime($__date);
    if ($date === false) {
        return false;
    }
    $year = explode('.', $__date)[2];
    $ny = strtotime('31.12.' . $year);
    $diff = $ny - $date;
    return floatval($diff / 86400);
}