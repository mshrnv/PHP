<?php

#Начинаем сессию и устанавливаем временную зону
session_start();
date_default_timezone_set('Europe/Moscow');

#Константы - количество сообщений на странице
define("MESSAGES_ON_PAGE", 5);
define("PAGES_AROUND", 2);

#Инициализация имени файла с пользователями, флага ошибки авторизации
$usersFileName = 'users.txt';
$authErrorFlag = false;

#Получение данных о пользователях
$usersArr = unserialize(file_get_contents($usersFileName));

#Блок обработки параметров
foreach (array('username', 'password', 'action', 'message', 'deleteMessageId', 'page', 'guestname') as $variableName) {
	$$variableName = isset($_POST[$variableName])
	? htmlspecialchars($_POST[$variableName])
	: '';
}

#Проверка успешной авторизации и запись в сессию данных о юзере
if ($username && $password && array_key_exists($username, $usersArr) && md5($password) === $usersArr[$username]['password']) {
    $_SESSION['username']     = $username;
    $_SESSION['access_level'] = $usersArr[$username]['access_level'];
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

#Отправка нового сообщения
if ($action == "SendMessage" && trim($message) != '') {
    sendMessage($message, $_SESSION['access_level'] == 3 ? $guestname : $_SESSION['username']);
}

#По умолчанию показываем первую страницу сообщений
if ($page == '') {
    $page = 1;
}

#Вычисление количества страниц с сообщениями
$numberOfPages = ceil(getMessagesCount() / MESSAGES_ON_PAGE);

#Если юзер авторизован - выводим гостевую книгу
if (isAuthorized()) {
    printGuestBook($numberOfPages, $page);
}

#Иначе - предлагаем авторизоваться
else {
    printSignInForm($authErrorFlag);
}

/**
 * Определяет: авторизован пользователь или нет.
 *
 * @return boolean true - авторизован, false - нет.
 */
function isAuthorized()
{
	return isset($_SESSION['username']);
}

/**
 * Выдает сообщение о неправильно введенных данных при авторизации.
 *
 * @return string HTML-код блока с ошибкой.
 */
function getAuthError()
{
    return '<div class="alert alert-warning" role="alert">
                Ошибка авторизации: проверьте введенные данные.
            </div>';
}

function paginationListRender(int $__numberOfPages, int $__currentPage)
{
    $pages = array();
    for ($i = 1; $i <= $__numberOfPages; $i++) { 
        if(abs($__currentPage - $i) <= PAGES_AROUND) {
            $pages[] = $i;
        }
    }

    $first = $pages[0];
    $last  = $pages[count($pages) - 1];

    if ($first == 2) {
        array_unshift($pages, 1);
    }
    elseif($first >= 3) {
        array_unshift($pages, 1, '...');
    }

    if ($last == $__numberOfPages - 1) {
        array_push($pages, $__numberOfPages);
    }
    elseif ($last <= $__numberOfPages - 2) {
        array_push($pages, '...', $__numberOfPages);
    }

    return $pages;
}

/**
 * Возвращает HTML-код кнопок навигации между страницами.
 *
 * @param integer $__numberOfPages Общее количество страниц.
 * @param integer $__currentPage   Текущая,выбранная страница.
 * 
 * @return string HTML-код кнопок навгации.
 */
function getPagination(int $__numberOfPages, int $__currentPage)
{
    # Получаем массив кнопок, которые надо вывести на экран
    $pagesArr = paginationListRender($__numberOfPages, $__currentPage);

    # Начало блока навигации
    $html = '<nav style="margin-top: 10px;">
                <form method="post">
                    <ul class="pagination justify-content-center">';

    # Вывод кнопок навигации, кнопку с текущей страницей - выделяем цветом
    foreach($pagesArr as $pageNumber) {
        $html .= '<li class="page-item" style="margin-right: 5px;">
         <button class="btn btn-'
         .($pageNumber != $__currentPage ? 'outline-' : '')
         .'primary btn-sm"
         type="submit" name="page" value="'.$pageNumber.'"'
         .($pageNumber === '...' ? ' disabled="disabled" ' : ' ').'>'
         .$pageNumber.
        '</button></li>';
    }

    #Конец блока навигации
    $html .= '</ul></form></nav>';

    #Возвращаем HTML код
    return $html;
}

/**
 * Записывает новое сообщение в файл guestbook.txt
 *
 * @param string $__text     Текст сообщения.
 * @param string $__username Имя пользователя.
 * 
 * @return void
 */
function sendMessage(string $__text, string $__username)
{

    # Получаем массив сообщений
    $messagesArr      = getMessagesArr();
    $messagesFileName = 'guestbook.txt';

    #Записываем новое сообщение
    $messagesArr[] = array(
                      'username'     => $__username,
                      'datetime'     => date('j.m.Y H:i:s'),
                      'message_text' => trim($__text),
                      'user_ip'      => $_SERVER['REMOTE_ADDR'],
    );

    #Запись в файл
    file_put_contents($messagesFileName, serialize($messagesArr));
}

/**
 * Возвращает массив сообщений.
 *
 * @return array Массив сообщений.
 */
function getMessagesArr()
{

    #Чтение файла и его ансериалицация в массив
    $messagesFileName = 'guestbook.txt';
    $data             = file_get_contents($messagesFileName);
    $messagesArr      = $data ? unserialize($data) : array();

    //
    return $messagesArr;
}

/**
 * Возвращает количество всех сообщений, хранящихся в книге
 * 
 * @return int Количество сообщений.
 */
function getMessagesCount()
{
    $messagesArr = getMessagesArr();
    return $messagesArr ? count($messagesArr) : 1;
}

/**
 * Возвращает HTML-код блоков с сообщениями на заданной странице
 *
 * @param integer $__currentPage Номер страницы.
 * 
 * @return string HTML-код всех сообщений на странице.
 */
function getMessages(int $__currentPage)
{

    #Получение и реверс массива(согласно ТЗ)
    $html        = '';
    $messagesArr = array_reverse(getMessagesArr());

    #Вычисление id первого сообщения на странице
    $start = ($__currentPage - 1) * MESSAGES_ON_PAGE;

    #Поочередный вывод сообщений
    for ($messageId = $start; $messageId < $start + MESSAGES_ON_PAGE; $messageId++) {

        #Обработка случая, когда на странице недостаточно сообщений
        if (!isset($messagesArr[$messageId])) {
            continue;
        }

        #Информацию о текущем сообщение помещаем в массив
        $messageArr = $messagesArr[$messageId];

        #И заносим в HTML
        $html .= '<div class="card" style="margin-bottom: 15px;">
                    <div class="card-body" style="position: relative;">
                        <h6 class="card-title"><b>'.$messageArr['username']."</b>\t".getIp($messageArr['user_ip']).'</h6>
                        <p class="card-subtitle mb-2 text-muted">'.$messageArr['datetime'].'</p>
                        <p class="card-text" style="margin-bottom:0px;">'.$messageArr['message_text'].'</p>
                        '.getCloseButton($messageArr['username'], $messageId).'</div></div>';
    }

    #Возвращаем HTML-код сообщений на странице
    return $html;
}

/**
 * Возвращает IP-адресс, если сессия админа(access_level = 1), в противном случае - пустую строку
 *
 * @param string $__ip IP-адресс клиента при отправке сообщения.
 * 
 * @return string IP-адресс или пустая строка.
 */
function getIp(string $__ip)
{
    return $_SESSION['access_level'] !== 1 ? '' : $__ip;
}

/**
 * Возвращает HTML-код кнопки удаления, если это сообщение пользователя, который его отправил
 * Или, если это сессия админа. В противном случае - пустая строка.
 *
 * @param string  $__username Имя пользователя.
 * @param integer $__id       ID сообщения.
 * 
 * @return string HTML-код или пустая строка.
 */
function getCloseButton(string $__username, int $__id)
{

    #Определяем уровень доступа
    $accessLevel = $_SESSION['access_level'];

    #Проверяем: может ли этот пользователь удалить это сообщание
    if ($accessLevel === 1 || $accessLevel === 2 && $__username == $_SESSION['username']) {

        #Если да, то возвращаем кнопку удаления
        return '<form method="post" style="position: absolute; top: 5px; right: 5px;">
                    <button name="deleteMessageId" value='.$__id.' type="submit" style="border:none; background:none;">
                        <img src="img/close.png" style="width:15px;">
                    </button>
                </form>';
    }

    #В противном случае - пустая строка
    else {
        return '';
    }
}

/**
 * Удаляет сообщение.
 *
 * @param integer $__messageId ID сообщения.
 * 
 * @return void
 */
function deleteMessage(int $__messageId)
{

    #Получаем массив сообщений
    $messagesFileName = 'guestbook.txt';
    $messagesArr      = getMessagesArr();

    #Удаляем заданное сообщение
    unset($messagesArr[count($messagesArr) - $__messageId - 1]);

    #Переиндексируем массив и записываем в файл
    $messagesArr = array_values($messagesArr);
    file_put_contents($messagesFileName, serialize($messagesArr));
}

/**
 * Обновляет текущую страницу
 *
 * @return void
 */
function reload()
{
    header("Location: http://" . $_SERVER['SERVER_NAME'] . $_SERVER["SCRIPT_NAME"]);
}

/**
 * Выводит форму авторизации и сообщение об ошибке если установлен флаг.
 *
 * @param boolean $__errorFlag Флаг ошибки авторизации.
 * 
 * @return void
 */
function printSignInForm(bool $__errorFlag)
{

    #Вывод HTML-кода, если установлен флаг, то под формой выводим ошибку
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Guest book</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body class="text-center">
        <div>
            <form class="form-signin" method="post">
                <img class="mb-4" src="img/ibooks.png" alt="guestbook" width="72" height="72">
                <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
                <input name="username" type="text" class="form-control" placeholder="Username" autofocus="">
                <input name="password" type="password" class="form-control" placeholder="Password">
                <button name="action" class="btn btn-lg btn-outline-primary btn-block" type="submit" value="SignIn">Sign in</button>
                <button name="action" class="btn btn-lg btn-outline-primary btn-block" type="submit" value="SignInAsGuest">Sign in as guest</button>
            </form>
            '.($__errorFlag ? getAuthError() : '').'
        </div></body></html>';
}

/**
 * Выводит гостевую книгу на экран, если user - гость, то допольнительно поле для ввода имени
 *
 * @param integer $__numberOfPages Количество страниц.
 * @param integer $__currentPage   Текущая страница с сообщениями.
 * 
 * @return void
 */
function printGuestBook(int $__numberOfPages, int $__currentPage)
{

    #Вывод HTML-кода гостевой книги
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Guest book</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/book.css">
    </head>
    <body>
    
        <nav class="navbar navbar-light" style="background-color: #ffd89e;">
            <a class="navbar-brand" href="#" style="margin-left: 20px;">
                <img src="img/ibooks.png" width="30" height="30" class="d-inline-block align-top" alt="">
                GuestBook
            </a>
            <form method="post" class="form-inline my-2 my-lg-0" style="margin-right: 15px;">
                <span class="navbar-text badge badge-success" style="margin-right: 10px; font-size: 14px;">
                Hi, '.$_SESSION['username']. '     <img src="img/hand.png" width="20">  
                </span>
                <button name="action" class="btn btn-outline-danger" type="submit" value="LogOut">Log out</button>
            </form>
        </nav>
    
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-9">

                '.getPagination($__numberOfPages, $__currentPage).'                    
    
                <div class="container">
    
                    '.getMessages($__currentPage).'
    
                </div>
    
            </div>
    
            <div class="col-md-3 text-center" style="padding: 60px 15px;">
                <form method="post">
                    '.($_SESSION["access_level"] == 3
                    ? '<input name="guestname" type="text" class="form-control" placeholder="Username" required="" autofocus="" style="margin-bottom: 15px;">'
                    : ''). '
                    <textarea name="message" class="form-control" placeholder="Message" rows="3" required="" style="margin-bottom: 15px;"></textarea>
                    <button name="action" class="btn btn-outline-success btn-block" type="submit" value="SendMessage">Send Message</button>
                </form>
            </div>
            </div>
        </div>
    </body>
    </html>';
}
