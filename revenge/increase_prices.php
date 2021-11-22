<?php

// PCRE. Написать функцию increase_prices($__text), которая вычленяет из предложения числа со знаком доллара на конце
// (в том числе и дробные), увеличивает его на 5% и заменяет в исходном тексте.

function increase_prices($__text)
{
    return preg_replace_callback(
        '/([\d.]+)\$/ui',
        function ($matches) {
            return ($matches[1] * 1.05) . '$';
        },
        $__text
    );
}