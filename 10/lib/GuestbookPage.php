<?php

class GuestbookPage{
    function __construct() {
        return file_get_contents('./index.html');
    }
}