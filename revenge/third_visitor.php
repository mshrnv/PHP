<?php

// Написать функцию third_visitor(), которая выдает третьему посетителю, побывавшему на сайте, поздравление.

// Функция возвращает поздравительную строку 'Congratulation!' в случае третьего посетителя и 'Not Yet!' в ином случае.

// При решении задачи учесть, что функция session_start() уже была вызвана.

session_start();

function third_visitor() {

    $fileName = 'sessions.txt';
    touch($fileName);
    $data = file_get_contents($fileName);
    $dataArr = $data ? unserialize($data) : [];

    $sessId = session_id();

    if(!in_array($sessId, $dataArr)){
        array_push($dataArr, $sessId);
    }

    $index = array_search($sessId, $dataArr);

    file_put_contents($fileName, serialize($dataArr));

    if($index % 3 == 2){
        return 'Congratulation!';
    } else {
        return 'Not Yet!';
    }

}

print third_visitor();