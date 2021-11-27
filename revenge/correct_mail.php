<?php

// PCRE. Написать функцию correct_mail($__mail), которая определяет,
// является ли $__mail - Email адресом и возвращает true в случае соответствия
// и false в ином случае.

// Учесть все возможные варианты, в том числе, и с русским языком.

function correct_mail($__mail)
{
    $res = preg_match(
        '/^\w([\w\d-]\.?)*[\w\d-]+@\w([\w\d-]\.?)*[\w\d-]+\.[^-]+\D$/uis',
        $__mail
    );

    return $res == 1 ? true : false;
}