<?php

# Подключаем файл с функциями
include "guestbook.php";

#Начинаем сессию и устанавливаем временную зону
session_start();
date_default_timezone_set('Europe/Moscow');

#Константы
define("MESSAGES_ON_PAGE", 5);
define("PAGES_AROUND", 2);
define("USERS_FILE_NAME", 'users.txt');
define("GUESTBOOK_FILE_NAME", 'guestbook.txt');
// $usersArr = [
//     'admin' => ['password' => md5('1'), 'access_level' => 1],
//     'root' => ['password' => md5('toor'), 'access_level' => 1],
//     'misha' => ['password' => md5('smd'), 'access_level' => 2],
//     'user' => ['password' => md5('user'), 'access_level' => 2],
// ];   => В README

#Инициализация флага ошибки авторизации
$authErrorFlag = false;

#Получение данных о пользователях
$usersArr = unserialize(getFileContent(USERS_FILE_NAME));

#Блок обработки параметров
foreach (array('username', 'password', 'action', 'message',
        'deleteMessageId', 'editMessageId', 'page', 'guestname') as $variableName) {
	$$variableName = isset($_POST[$variableName])
	? htmlspecialchars($_POST[$variableName])
	: '';
}

#Проверка успешной авторизации и запись в сессию данных о юзере
if ($username && $password && array_key_exists($username, $usersArr) && md5($password) === $usersArr[$username]['password']) {
    $_SESSION['username']     = $username;
    $_SESSION['access_level'] = $usersArr[$username]['access_level'];
    $_SESSION['page']         = 1;
    reload();
	die();
}

#Если нажата кнопка и введены неверные данные - сообщение об ошибке
elseif ($action == 'SignIn') {
    $authErrorFlag = true;
}

#Авторизация гостем
if ($action == "SignInAsGuest") {
    $_SESSION['username']     = 'guest';
    $_SESSION['access_level'] = 3;
    $_SESSION['page']         = 1;
    reload();
	die();
}

#Выход из сесии пользователя
if ($action == "LogOut") {
    session_destroy();
    reload();
	die();
}

#Удаление сообщения
if ($deleteMessageId != '') {
    deleteMessage($deleteMessageId);
}

# Редактирование сообщения
if ($editMessageId != '' && trim($message) != '') {
    editMessage($editMessageId, $message);
}

#Отправка нового сообщения
if ($action == "SendMessage" && trim($message) != '') {
    sendMessage($message, $_SESSION['access_level'] == 3 ? $guestname : $_SESSION['username']);
}

#По умолчанию показываем первую страницу сообщений
if ($page != '') {
    $_SESSION['page'] = $page;
}

#Вычисление количества страниц с сообщениями
$numberOfPages = ceil(getMessagesCount() / MESSAGES_ON_PAGE);

#Если юзер авторизован - выводим гостевую книгу
if (isAuthorized()) {
    printGuestBook($numberOfPages, $_SESSION['page']);
}

#Иначе - предлагаем авторизоваться
else {
    printSignInForm($authErrorFlag);
}
