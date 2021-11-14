<?php

// PCRE. Написать функцию popular_email_username($__text),
// которая ищет в тексте имена пользователей с ящиками более чем в двух различных доменных зонах.
// $__text - текст, содержащий адреса Email.
// Возвращает array - список имен пользователей с ящиками более чем в двух различных доменных зонах.

function popular_email_username($__text)
{
    preg_match_all(
        '/([\w-]+)@(\w+)\.(\w+)/ui',
        $__text,
        $matches
    );

    $names = array_unique($matches[1]);
    $res = array();
    foreach ($names as $name) {
        $count = preg_match_all(
            '/'.$name.'@\w+\.(\w+)/ui',
            $__text,
            $temp
        );

        $zones = array_unique($temp[1]);
        if (count($zones) > 1) {
            $res[] = $name;
        }
    }

    return $res;
}