<?php
session_start();
function  visitors_count() {
    $fileName = 'session.txt';
    touch($fileName);
    $data = file_get_contents($fileName);
    $counter = $data ? ($data) : 0;

    $counter++;

    file_put_contents($fileName, ($counter));

    return $counter;
}

print visitors_count();