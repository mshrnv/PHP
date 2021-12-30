<?php

class SignupPage extends BasePage
{
    private $mesageRepo, $username;

    function __construct($__username = false)
    {
        $this -> mesageRepo = new UserDB();
        $this -> username   = $__username;
    }

    function buildContent()
    {   
        var_dump($this -> username);
        $hasUser = $this -> mesageRepo -> hasUser($this -> username);
        var_dump($hasUser);
        return Template::build(
            file_get_contents('./templates/signup.tpl'),
            [
                'is_error' => 0,
            ]
        );
    }
}