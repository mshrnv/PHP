<?php

// Написать функцию repeat_letter($__text), которая во всех словах с четными числом букв
// убирает буквы, повторяющиеся более 3 раз.
// Текст в многобайтовой кодировке. Регистр нужно учитывать('А' и 'а' - разные буквы)

function repeat_letter($__text)
{
    preg_match_all(
        '/[^\s.,?!:;]+/ui',
        $__text,
        $matches
    );

    $words = $matches[0];

    foreach ($words as $word) {
        $len = preg_match_all('/\w/ui', $word, $m);
        if ($len % 2 == 0
        ) {
            $newWord = preg_replace('/(\w)(\\1){2,}/ui', '$2', $word);
            $__text  = preg_replace('/' . $word . '/u', $newWord, $__text);
        }
    }

    return $__text;
}