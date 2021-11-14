<?php

// PCRE. Написать функцию yandex_search_links($__text),
// которая превращает все восклицательные предложения в тексте в ссылки,
// ведущие на http://yandex.ru/yandsearch?text=предложение.

function yandex_search_links($__text)
{
    return preg_replace(
        '/(\s+)([^.?!]+[?!]+)/ui',
        '$1<a href="http://yandex.ru/yandsearch?text=$2">$2</a>',
        $__text
    );
}