<?php

// Написать функцию dif_hours($__left, $__right),
// которая вычисляет сколько часов прошло между двумя днями.
// $__left и $__right заданы в формате Timestamp.

function dif_hours($__left, $__right)
{
    $diff = abs($__left - $__right);
    return ($diff / 3600) % 24;
}