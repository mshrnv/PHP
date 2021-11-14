<?php

// PCRE. Написать функцию capitalize_first_letter($__text), которая заменяет в самом длинном (в символах)
// предложении текста все 'СЛОВА' (только заглавные) на 'Слова' (первая заглавная).

function capitalize_first_letter($__text)
{
    preg_match_all('/[^.!?]+/uis',
                   $__text,
                   $matches);

    $maxIndex = 0;
    $maxLen   = 0;
    foreach ($matches[0] as $index => $sentence) {
        $len = mb_strlen($sentence);
        if ($len > $maxLen) {
            $maxLen   = $len;
            $maxIndex = $index;
        }
    }

    $maxSentence = $matches[0][$maxIndex];
    $res  = preg_replace_callback('/\b([A-ZА-ЯЁ])([A-ZА-ЯЁ]+)\b/u',
                                function ($matches) {
                                    return $matches[1].mb_strtolower($matches[2]);
                                }, 
                  		        $maxSentence);


    return str_replace($maxSentence, $res, $__text);
}
