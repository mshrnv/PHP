<?php

// Написать функцию booking($__date, $__rooms), которая осуществляет 
//бронирование комнаты в отеле.

// $__date представляет собой пару дат вида '20.12.2018 - 26.12.2018', $__rooms - 
// массив вида ['номер комнаты' => '13.02.2018 - 16.02.2018', ...], 
// который содержит даты, когда комната свободна.

// Функция возвращает номер комнаты, если искомая имеется или false 
// в случае некорректного формата времени.

function booking($__rooms, $__date){

    $datePare = explode('-', $__date);
    $begin_date = strtotime($datePare[0]);
    $end_date   = strtotime($datePare[1]);
    
    if ($begin_date == false || $end_date == false) {
    	return false;
    }

    foreach($__rooms as $number => $interval) {
        $dates = explode('-', $interval);
        $booking_begin = strtotime($dates[0]);
        $booking_end   = strtotime($dates[1]);

        if ($begin_date >= $booking_begin and $end_date <= $booking_end) {
            return $number;
        }
        
    }

    return false;
}