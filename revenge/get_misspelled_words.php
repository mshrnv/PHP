<?php

// Написать функцию get_misspelled_words($__text, $__check_text),
// которая по данному тексту $__text и проверочному тексту
// $__check_text выведет слова с ошибками, в каждом из которых неправильная буква
// поднята в верхний регистр. Слова должны быть разделенны запятыми.
// Под ошибкой подразумевается неправильная буква(ы) в слове.

function get_misspelled_words($__text, $__check_text)
{
    $__text = str_replace(',', '', $__text);
    $__check_text = str_replace(',', '', $__check_text);

    $__text = str_replace('.', '', $__text);
    $__check_text = str_replace('.', '', $__check_text);

    $text = explode(' ', $__text);
    $check_text = explode(' ', $__check_text);
    $resArr = array();

    foreach ($text as $index => $word) {
        if ($word != $check_text[$index]) {
            $len = mb_strlen($word);
            $newWord = '';
            for ($i = 0; $i < $len; $i++) {
                $letter = substr($word, $i, 1);
                $check_letter = substr($check_text[$index], $i, 1);
                if ($letter != $check_letter) {
                    $newWord .= mb_strtoupper($letter);
                } else {
                    $newWord .= $letter;
                }
            }
            $resArr[] = $newWord;
        }
    }

    return implode(',', $resArr);
}