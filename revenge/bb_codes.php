<?php

// PCRE. Написать функцию bb_codes($__text), которая заменяет в строке выражения вида [b]текст[/b]
// на текст для тегов b, em, i.

function bb_codes($__text)
{
    $res = preg_replace(
        '/(\[(b|i|em)\](\w*)\[\/(b|i|em)\])/uis',
        "<$2>$3</$4>",
        $__text
    );
    return $res;;
}