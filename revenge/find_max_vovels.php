<?php

// PCRE. Написать функцию find_max_vovels($__text), которая вычленяет из html-кода предложение, 
// содержащее максимальное количество слов, после чего находит в нем слово с наибольшим количеством слогов.
// Возвращает слово с наибольшим количеством слогов.

function find_max_vovels($__text)
{
    $__text = strip_tags($__text);
    preg_match_all(
        '/[^.!?]+/ui',
        $__text,
        $matches
    );

    $maxIndex = 0;
    $maxLen   = 0;
    foreach ($matches[0] as $index => $sent) {
        $len = mb_strlen($sent);
        if ($len > $maxLen
        ) {
            $maxLen   = $len;
            $maxIndex = $index;
        }
    }

    $maxSent = $matches[0][$maxIndex];
    preg_match_all(
        '/[\w-]+/ui',
        $maxSent,
        $words
    );
    $maxWord = '';
    $maxCount = 0;
    foreach ($words[0] as $index => $word) {
        $count = preg_match_all('/[aouieyаеёиоуыэюя]/ui', $word, $temp);
        if ($count > $maxCount
        ) {
            $maxCount = $count;
            $maxWord  = $word;
        }
    }

    return $maxWord;
}