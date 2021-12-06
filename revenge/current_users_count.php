<?php

// Написать функцию current_users_count(),
// которая возвращает количество пользователей, находящихся в текущий момент на сайте.
// Пользователи считаются находящимися на сайте,
// если они проявляли активность не более 5 секунд назад.
// Функция возвращает int - количество пользователей,
// которые в настоящий момент на сайте.
// При решении задачи учесть, что функция session_start() уже была вызвана.

function current_users_count()
{
    $fileName = 'session.txt';
    touch($fileName);
    $data = file_get_contents($fileName);
    $dataArr = $data ? unserialize($data) : array();

    $sessId = session_id();
    $now = time();

    $dataArr[$sessId] = $now;

    file_put_contents($fileName, serialize($dataArr));

    $counter = 0;

    foreach ($dataArr as $time) {
        if ($now - $time <= 5) {
            $counter++;
        }
    }

    return $counter;
}