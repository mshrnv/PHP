<?php

// PCRE. Написать функцию highlight_variables($__text),
// которая заключает все переменные в php коде в тег , учесть,
// что $variable['key'] - нужно заключить в теги полностью.

function highlight_variables($__text)
{
    return preg_replace(
        '/(\$[^\s,.]+)/ui',
        '<b>$1</b>',
        $__text
    );
}