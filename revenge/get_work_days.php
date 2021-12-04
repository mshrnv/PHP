<?php

// Студент учится в московском университете.
// Учебой заняты все дни кроме вторника и воскресенья.
// Необходмо написать функцию get_work_days($__start_date, $__end_date, $__holidays),
// которая вернет массив его рабочих дней в виде 'dd.mm.YYYY l'
// $__start_date и $__end_date задают промежутки времени которые необходимо рассмотреть
// $__holidays - массив выходных в виде: 'dd.mm'.

function get_work_days($__start_date, $__end_date, $__holidays)
{
    $start_date = strtotime($__start_date);
    $end_date   = strtotime($__end_date);
    $resArr = array();
    for ($date = $start_date; $date < $end_date; $date += 86400) {
        $day_of_week = date('l', $date);
        if (!in_array($day_of_week, ['Tuesday', 'Sunday']) &&
            !in_array(date('d.m', $date), $__holidays)) {
                $resArr[] = date('d.m.Y l', $date);
            }
    }

    return $resArr;
}