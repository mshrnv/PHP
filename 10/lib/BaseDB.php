<?php

class BaseDB {

protected $db;
function __construct(
    $dbName    = "guestbook_db",
    $host      = "localhost",
    $user      = "root",
    $password  = "root"
)
{
    try {
        $this -> db = new PDO("mysql:host=$host;dbname=$dbName", $user, $password);
    } catch (PDOException $e) {
        print("Error!: ".$e->getMessage());
        die("Error!: ".$e->getMessage());
    }
}

}