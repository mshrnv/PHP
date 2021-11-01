<?php

function PercentageOfBrowserUsage(){

    //$sessId = session_id();
    $fileName = 'sessions.txt';
    touch($fileName);
    $userAgent = $_SERVER['HTTP_USER_AGENT'];
    $data = file_get_contents($fileName);
    $dataArr = $data ? unserialize($data) : ['opr' => 0, 'firefox' => 0];

    if (mb_strripos($userAgent, 'OPR')) {
        $dataArr['opr']++;
    }

    if (mb_strripos($userAgent, 'Firefox')) {
        $dataArr['firefox']++;
    }

    $opera_counter = $dataArr['opr'];
    $firefox_counter = $dataArr['firefox'];
    $sum = $opera_counter + $firefox_counter;

    $percentageUsedOpera = $sum ? round($opera_counter / $sum, 2) * 100 : 0;
    $percentageUsedFirefox = $sum ? round($firefox_counter / $sum, 2) * 100 : 0;

    file_put_contents($fileName, serialize($dataArr));

    return "Firefox - {$percentageUsedFirefox}%; Opera - {$percentageUsedOpera}%;";

}

PercentageOfBrowserUsage();