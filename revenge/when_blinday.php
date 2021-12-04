<?php

function when_blinday($__year)
{
    $timestamp = strtotime("last Sunday March " . $__year);
    if ($timestamp === false) {
        return false;
    }
    return date('Y-m-d', $timestamp);
}
