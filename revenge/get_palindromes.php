<?php

// PCRE. Написать функцию get_palindromes($__text, $__len),
// которая выводит массив слов-палиндромов длинны $__len.

function get_palindromes($__text, $__len)
{

    preg_match_all('/\b\w{'.$__len.'}\b/uis',
                    $__text,
                    $matches);
    // По хорошему - нужна еще проверка на палиндромность
    return $matches[0];
}