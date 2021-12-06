<?php
//Написать функцию first_word_to_upper($__text), которая преобразует первые слова предложений в верхний регистр.
//Функция возвращает строку, содержащую модифицированный текст.
//Все предложения состоят более чем из одного слова.
//После знаков препинания обязательно идет как минимум один пробел.
//Не использовать регулярные выражения.

function first_word_to_upper($__text){
    $word = explode(" ", $__text);
    $word[0] = mb_strtoupper($word[0]);
    foreach($word as $key => $value){
        if(strpos($value, ".") || strpos($value, "!") || strpos($value, "?")){
            $word[$key + 1] = mb_strtoupper($word[$key + 1]);
        }
        $resText = implode(" ", $word);
    }
    
    return rtrim($resText);
}
