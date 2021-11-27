<?php

// PCRE. Написать функцию get_count_comments($__code),
// которая выводит кол-во многострочных (/*...*/) комментариев в коде $__code на языке Си.

function get_count_comments($__code)
{
    return preg_match_all(
        '/\/\*.*?\*\//uis',
        $__code,
        $matches
    );
}
