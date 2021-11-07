<?php

session_start();

date_default_timezone_set('Europe/Moscow');

define("messagesOnPage", 5);
$usersFileName = 'users.txt';

$adminsArr = array(
    'admin' => array('password'     => md5('root'),
                     'access_level' => 1),
    'misha' => array('password'     => md5('smd'),
                     'access_level' => 2),
);

file_put_contents($usersFileName, serialize($adminsArr));

//Блок обработки параметров
foreach(['username', 'password', 'action', 'message', 'delete', 'page', 'guestname'] as $variableName)
	$$variableName = isset($_POST[$variableName])
		? preg_replace("/[^a-z0-9А-Яа-я]+/uis", '', $_POST[$variableName])
		: '';

if($username && $password && array_key_exists($username, $adminsArr) && md5($password) === $adminsArr[$username]['password']){
    $_SESSION['username']     = $username;
    $_SESSION['access_level'] = $adminsArr[$username]['access_level'];
    header("Location: http://". $_SERVER['SERVER_NAME'].$_SERVER["SCRIPT_NAME"]);
	die();
} else {
    //printError();
}

if($action == "Signinasguest"){
    $_SESSION['username']     = 'guest';
    $_SESSION['access_level'] = 3;
    header("Location: http://". $_SERVER['SERVER_NAME'].$_SERVER["SCRIPT_NAME"]);
	die();
}

if ($action == "Logout") {
    $_SESSION = [];
    header("Location: http://". $_SERVER['SERVER_NAME'].$_SERVER["SCRIPT_NAME"]);
	die();
}

if ($delete != '') {
    deleteMessage($delete);
}

if ($action == "SendMessage") {
    sendMessage($message, $_SESSION['access_level'] == 3 ? $guestname : $_SESSION['username']);
}

if ($page == '') {
    $page = 1;
}

$numberOfPages = ceil(getMessagesCount() / messagesOnPage);

if (isAuthorized()) {
    printGuestBook($numberOfPages, $page);
}
else {
    printSignInForm();
}

// print $username."<br>";
// print $password."<br>";
// print $message."<br>";
// print $action."<br>";

function isAuthorized() {
	return isset($_SESSION['username']);
}

// function printError(){
//     echo 'Неправильно введен логин или пароль';
// }

function getPagination($__numberOfPages)
{
    $html = '<nav style="margin-top: 10px;">
                <form method="post">
                    <ul class="pagination justify-content-center">';

    for($pageNumber = 1; $pageNumber <= $__numberOfPages; $pageNumber++) {
        $html .= '<li class="page-item" style="margin-right: 5px;">
                    <button class="btn btn-outline-primary btn-sm" type="submit" name="page" value='.$pageNumber.'>'
                        .$pageNumber.
                    '</button>
                  </li>';
    }

    $html .= '</ul></form></nav>';

    return $html;
}

function sendMessage($__text, $__username)
{
    $messagesArr = getMessagesArr();
    $messagesFileName = 'guestbook.txt';
    $messagesArr[] = array(
        'username'     => $__username,
        'datetime'     => date('j.m.Y H:i:s'),
        'message_text' => trim($__text),
        'user_ip'      => $_SERVER['REMOTE_ADDR'],
    );

    file_put_contents($messagesFileName, serializeMessages($messagesArr));
}

function getMessagesArr()
{
    $messagesFileName = 'guestbook.txt';
    $data = file_get_contents($messagesFileName);
    $messagesArr = $data ? unserializeMessages($data) : array();

    return $messagesArr;
}

function getMessagesCount()
{
    $messagesArr = getMessagesArr();
    return $messagesArr ? count($messagesArr) : 1;
}

function getMessages($__currentPage)
{
    $html = '';
    $messagesArr = array_reverse(getMessagesArr());

    $start = ($__currentPage - 1) * messagesOnPage;
    for($message_id = $start; $message_id < $start + messagesOnPage; $message_id++){
        if(!isset($messagesArr[$message_id])){
            continue;
        }
        $messageArr = $messagesArr[$message_id];
        $html .= '<div class="card" style="margin-bottom: 15px;">
                    <div class="card-body" style="position: relative;">
                        <h6 class="card-title"><b>'.$messageArr['username']."</b>\t".getIp($messageArr['user_ip']).'</h6>
                        <p class="card-subtitle mb-2 text-muted">'.$messageArr['datetime'].'</p>
                        <p class="card-text" style="margin-bottom: 0px;">'.$messageArr['message_text'].'</p>
                        '.getCloseButton($messageArr['username'], $message_id).'
                    </div>
                    </div>';
    }

    return $html;
}

function getIp($__ip)
{
    return $_SESSION['access_level'] !== 1 ? '' : $__ip;
}

function getCloseButton($__username, $__id)
{
    $accessLevel = $_SESSION['access_level'];
    if($accessLevel === 1 || $accessLevel === 2 && $__username == $_SESSION['username']){
        return '<form method="post" style="position: absolute; top: 5px; right: 5px;">
                    <button name="delete" value='.$__id.' type="submit" style="border:none; background:none;">
                        <img src="img/close.png" style="width:15px;">
                    </button>
                </form>';
    }
    else {
        return '';
    }
}

function deleteMessage($__messageId)
{
    $messagesFileName = 'guestbook.txt';
    $messagesArr = getMessagesArr();
    unset($messagesArr[count($messagesArr)-$__messageId]);
    $messagesArr = array_values($messagesArr);
    file_put_contents($messagesFileName, serializeMessages($messagesArr));
}

function serializeMessages($__messagesArr)
{
    $messagesArr = array();
    foreach($__messagesArr as $message_id => $messageArr){
        $messagesArr[] = $message_id.'[:||:]'.implode('[:||:]', $messageArr);
    }

    return '[:|||:]'.implode('[:|||:]', $messagesArr).'[:|||:]';
}

function unserializeMessages($__messagesArr)
{
    $__messagesArr = explode('[:|||:]', $__messagesArr);
    $__messagesArr = array_diff($__messagesArr, ['']);
    $messagesArr = array();
    foreach($__messagesArr as $message_id => $message){
        $messageArr = explode('[:||:]', $message);
        $messagesArr[$message_id]['username'] = $messageArr[1];
        $messagesArr[$message_id]['datetime'] = $messageArr[2];
        $messagesArr[$message_id]['message_text'] = $messageArr[3];
        $messagesArr[$message_id]['user_ip'] = $messageArr[4];
    }

    return $messagesArr;
}

function printSignInForm(){
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Guest book</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/auth.css">
    </head>
    <body class="text-center">
        <div>
        <form class="form-signin" method="post">
            <img class="mb-4" src="img/ibooks.png" alt="guestbook" width="72" height="72">
            <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
            <input name="username" type="text" class="form-control" placeholder="Username" autofocus="">
            <input name="password" type="password" class="form-control" placeholder="Password">
            <input name="action" class="btn btn-lg btn-outline-primary btn-block" type="submit" value="Sign in"></input>
            <input name="action" class="btn btn-lg btn-outline-primary btn-block" type="submit" value="Sign in as guest"></input>
        </form>
        </div>
    </body>
    </html>';
}

function printGuestBook($__numberOfPages, $__currentPage){
    echo '<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Guest book</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/book.css">
    </head>
    <body>
    
        <nav class="navbar navbar-light" style="background-color: #e3f2fd;">
            <a class="navbar-brand" href="#" style="margin-left: 20px;">
                <img src="img/ibooks.png" width="30" height="30" class="d-inline-block align-top" alt="">
                GuestBook
            </a>
            <form method="post" class="form-inline my-2 my-lg-0" style="margin-right: 15px;">
                <span class="navbar-text badge badge-success" style="margin-right: 10px; font-size: 14px;">
                Hi, '.$_SESSION['username'].'     <img src="img/hand.png" width="20">  
                </span>
                <input name="action" class="btn btn-outline-danger" type="submit" value="Log out">
            </form>
        </nav>
    
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-9">

                '.getPagination($__numberOfPages).'                    
    
                <div class="container">
    
                    '.getMessages($__currentPage).'
    
                </div>
    
            </div>
    
            <div class="col-md-3 text-center" style="padding: 60px 15px;">
                <form method="post">
                    '.($_SESSION["access_level"] == 3
                    ? '<input name="guestname" type="text" class="form-control" placeholder="Username" required="" autofocus="" style="margin-bottom: 15px;>'
                    : '').'
                    <textarea name="message" class="form-control" placeholder="Message" rows="3" required="" style="margin-bottom: 15px;"></textarea>
                    <input name="action" class="btn btn-outline-success btn-block" type="submit" value="Send Message">
                </form>
            </div>
            </div>
        </div>
    </body>
    </html>';
}