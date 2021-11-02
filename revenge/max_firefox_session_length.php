<?php

// Написать функцию max_firefox_session_length(), которая возвращает длину самого длинного пользовательского сеанса в браузере Firefox.

// Длина сеанса измеряется в количестве переходов по страницам.

// Функция возвращает int - длину самого длинного сеанса.

// При решении задачи учесть, что функция session_start() уже была вызвана.

session_start();

function max_firefox_session_length() {
    $fileName = 'sessions.txt';
    touch($fileName);
    $data = file_get_contents($fileName);
    $dataArr = $data ? unserialize($data) : [];
    $sessId = session_id();
    $userAgent = $_SERVER['HTTP_USER_AGENT'];

    if (mb_strripos($userAgent, 'Firefox')) {
        if (isset($dataArr[$sessId])) {
            $dataArr[$sessId]++;
        }
        else {
            $dataArr[$sessId] = 1;
        }
    }

    file_put_contents($fileName, serialize($dataArr));

    asort($dataArr);
    return array_pop($dataArr);

}

print max_firefox_session_length();