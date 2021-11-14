<?php

// PCRE. Написать функцию one_two_star($__text), которая преобразовывает текст,
// обрамленный в звездочки, в курсив. Не трогать текст в двойных звездочках.

function one_two_star($__text)
{
    $__text = str_replace('**', '@', $__text);
    $__text = preg_replace(
        '/\*(.*?)\*/uis',
        '<em>$1</em>',
        $__text
    );

    return str_replace('@', '**', $__text);
}