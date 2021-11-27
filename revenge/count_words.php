<?php

// PCRE. Написать функцию count_words($__text),
// которая во втором абзаце считает количество слов,
// в которых более трех согласных.

// Возвращает int - количество слов, в которых более трех согласных.

function count_words($__text)
{
    preg_match_all(
        '/<p.*?>(.*?)<\/p>/ui',
        $__text,
        $matches
    );

    $text = strip_tags($matches[1][1]);

    preg_match_all(
        '/[^\s.,!?:;]+/ui',
        $text,
        $matches
    );

    $words   = $matches[0];
    $counter = 0;

    foreach ($words as $word) {
        if (preg_match_all('/[^aouieyАЕЁИОУЫЭЮЯаеёиоуыэюя\-]/ui', $word, $m) > 3) {
            $counter++;
            $res[] = $word;
        }
    }

    return $counter;
}