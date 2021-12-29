<?php

class GuestbookPage{
    function __construct() {
        echo file_get_contents('./index.html');
    }
}