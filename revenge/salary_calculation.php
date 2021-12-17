<?php

#Написать функцию salary_calculation($__dates, $__salary),
#возвращающую заработную плату работника, посчитанную за время его работы.

#В качестве $__dates подается массив вида [['первая дата', 'вторая дата'], [...], ...].
#Дата задается в формате '30.12.2011 15:30:40'. В качестве $__salary задается оплата одного часа работы.

#В случае не корректного формата времени или зарплаты возвращать false.

function salary_calculation($__dates, $__salary)
{
    $summary = 0;
	foreach($__dates as $dates){
    	$date1 = strtotime($dates[0]);
        $date2 = strtotime($dates[1]);
        
        $summary += $date2 - $date1;
    }
    
    $res = floatval(intval($summary / 3600) * $__salary);
        
    if ($res < 0) {
    	return false;
    }
    return $res;
}