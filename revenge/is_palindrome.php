<?php

// PCRE. Написать функцию is_palindrome($__word),
// которая по заданному слову $__word определяет является ли оно палиндромом.

function is_palindrome($__word)
{
    $len = mb_strlen($__word);
    for ($i = 0; $i < $len / 2; $i++) { 
        if ($__word[$i] != $__word[$len - $i - 1])
            return false;
    }

    return true;
}