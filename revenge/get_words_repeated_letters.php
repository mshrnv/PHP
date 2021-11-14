<?php

// PCRE. Написать функцию get_words_repeated_letters($__text, $__count),
// которая выводит массив, слов имеющих не менее $__count идущих подряд повторяющихся букв.

function get_words_repeated_letters($__text, $__count)
{
    $repeat = '';
    for ($i = 0; $i < $__count - 1; $i++) {
        $repeat .= '\\1';
    }
    preg_match_all('/\b\w*(\w)'.$repeat.'\w*\b/uis',
                    $__text,
                    $matches);

    return $matches[0];
}