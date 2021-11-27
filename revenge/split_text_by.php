<?php

// PCRE. Написать функцию split_text_by($__code),
// которая разобьет HTML код $__code по преносу строк (</br>).
// Необходимо вернуть массив разбитых строк, но без тегов.

function split_text_by($__code)
{
    $arr = preg_split(
        '/<\s*\/\s*br *>/ui',
        $__code
    );

    foreach ($arr as $key => $value) {
        $arr[$key] = preg_replace('/<.*?>/ui', '', $value);
    }

    return $arr;
}