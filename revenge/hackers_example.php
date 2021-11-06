<?php

session_start();

function get_hackers_ip()
{

    //Открыли, считали данные из файла, закинули в массив $dataArr
    $fileName = 'sessions.txt';
    touch($fileName);
    $data = file_get_contents($fileName);
    $dataArr = $data ? unserialize($data) : [];

    //Узнали айпишник клиента и айди сессии
    $ip     = $_SERVER['REMOTE_ADDR'];
    $sessId = session_id();

    #Будем хранить данные след образом:
    #Массив: ip => [session1, session2, ...]

    //Если такого айпишника нет в массиве, то создаем и сразу кладем в массив номер сессии
    if (!isset($dataArr[$ip])) {
        $dataArr[$ip] = array($sessId);
    } else {
        
        //Если такой айпишник уже есть в массиве, то проверяем есть ли у него такой номер сессии или нет
        if (!in_array($sessId, $dataArr[$ip])) {
            //Если такого номера сессии у этого айпи еще не было, то кладем эту сессию в массив
            $dataArr[$ip][] = $sessId;
        }
    }

    //Завернули обновленный массив обратно в файл
    file_put_contents($fileName, serialize($dataArr));

    $res = array(); //Массив в который будем закидывать айпишники, у которых больше одной сессии
    foreach ($dataArr as $ip => $sessionsArr) {
        if (count($sessionsArr) > 1) {
            $res[] = $ip;
        }
    }

    //
    return implode(',', $res);
}