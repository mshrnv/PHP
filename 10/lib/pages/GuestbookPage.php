<?php

class GuestbookPage extends BasePage
{
    # private $mesageRepo;

    function __construct()
    {
        # parent::__construct("base title", " base description", true);
        $this -> mesageRepo = new MessageDB();
    }

    function buildContent()
    {
        # $messages = $this -> mesageRepo -> getAll();

        return Template::build(
            file_get_contents('./templates/guestbook.tpl'),
            [
                #'messages' => $messages
            ]
        );
    }
}