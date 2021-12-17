<?php

#�������� ������� salary_calculation($__dates, $__salary),
#������������ ���������� ����� ���������, ����������� �� ����� ��� ������.

#� �������� $__dates �������� ������ ���� [['������ ����', '������ ����'], [...], ...].
#���� �������� � ������� '30.12.2011 15:30:40'. � �������� $__salary �������� ������ ������ ���� ������.

#� ������ �� ����������� ������� ������� ��� �������� ���������� false.

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