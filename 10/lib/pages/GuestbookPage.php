<?php

class GuestbookPage extends BasePage
{
    # private $mesageRepo;

    function __construct($__action, $__username, $__message, $__ip)
    {
        # parent::__construct("base title", " base description", true);
        $this -> mesageRepo = new MessageDB();

        if ($__action == 'send') {
            $this -> mesageRepo -> sendMessage($__username, $__message, $__ip);
            header("Location: http://".$_SERVER['SERVER_NAME'].$_SERVER["SCRIPT_NAME"]);
            exit;
        }

    }

    function buildContent()
    {
        $messages = $this -> mesageRepo -> getAllMessages();
        
        return Template::build(
            file_get_contents('./templates/guestbook.tpl'),
            [
                'messages' => array_reverse($messages),
            ]
        );
    }
}