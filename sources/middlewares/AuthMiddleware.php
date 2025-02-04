<?php

namespace middlewares;

use User;

class AuthMiddleware
{
    public static function handle()
    {
        if(User::currentUser() == null)
        {
            header("Location: /login");
            exit;
        }
    }
}