<?php

// Написать функцию weekends_count($__year),
// возвращающую количество выходных (суббота и воскресенье) в этом году в формате d-m-Y

// В случае некорректного формата года возвращать false.

function weekends_count($__year)
{
    $begin_date     = strtotime('01.01.'.$__year);
    $end_date       = strtotime('31.12.'.$__year);
    $weekends_count = 0;

    if ($begin_date == false) {
        return false;
    }

    while ($begin_date <= $end_date) {
        $day = date('N', $begin_date);
        if ($day == 6) {
            $weekends_count++;
            $begin_date += 86400;
            continue;
        } elseif ($day == 7) {
            $weekends_count++;
            $begin_date += (6 * 86400);
            continue;
        }
        $begin_date += 86400;
    }

    return $weekends_count;
}