<?php

// PCRE. Написать функцию delete_tags($__code),
// которая удаляет все теги с классом delete_me вместе с содержимым.

function delete_tags($__code)
{
    return preg_replace(
        '/<(\w+)\s+class\s*=\s*"\s*delete_me\s*"\s*>.+?<\s*\/\s*\\1\s*>/uis',
        '',
        $__code
    );
}