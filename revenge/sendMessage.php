<?php

// Написать функцию sendMessage($__message), которая проверяет, отправлял ли данный пользователь сообщение $__message.

// Функция возвращает сколько раз пользователь пытался отправить данное сообщение.



session_start();

function sendMessage($__message) {

    if (isset($_SESSION[$__message])) {
        $_SESSION[$__message]++;
    } else {
        $_SESSION[$__message] = 1;
    }

    return $_SESSION[$__message];

}