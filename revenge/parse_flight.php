<?php

// Написать функцию parse_flight($__text), которая парсит строку вида:
// ' {destination: Москва; number: 666666; planetype: ИЛ-760;} {...}'.
// в ассоциативный двумерный массив вида: $result[0]['destination'] = ...

function parse_flight($__text)
{
    $__text = preg_replace('/- |= /ui',
        ': ',
        $__text
    );
    preg_match_all(
        '/\{([^{}]+)\}/ui',
        $__text,
        $matches
    );
    $res = array();
    foreach ($matches[1] as $index => $flight) {
        $pairs = preg_match_all(
            '/([\w]+ )*[\w]+: [\w\d-]+/ui',
            $flight,
            $result
        );
        foreach ($result[0] as $key => $pair) {
            list($var, $val) = preg_split('/: /ui', $pair, 2);

            $res[$index][$key][$var] = $val;
        }
    }

    return $res;
}
