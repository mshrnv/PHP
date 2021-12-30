<?php

require_once './vendor/autoload.php';

$action   = isset($_REQUEST['action'])   ? $_REQUEST['action']        : false;
$username = isset($_REQUEST['username']) ? $_REQUEST['username']      : 'FAILED';
$message  = isset($_REQUEST['message'])  ? trim($_REQUEST['message']) : 'FAILED TO SEND MESSAGE';
$ip       = $_SERVER['REMOTE_ADDR'];

if (isset($_SESSION['username'])) {
    $base = new GuestbookPage($action, $username, $message, $ip);
} else {
    $base = new SignupPage($username);
}

$base -> display();