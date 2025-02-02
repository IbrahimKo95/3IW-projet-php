<?php

require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../requests/LoginRequest.php";
require_once __DIR__ . "/../core/BaseController.php";
require_once __DIR__ . "/../core/QueryBuilder.php";

class LoginController extends BaseController
{
    public function index(): void
    {
      require_once __DIR__ . "/../views/login/index.php";
    }

    public function post(): void
    {
        $request = new LoginRequest();
        $user = User::findOneByEmail($request->email);
        if (!$user) {
            echo "L'adresse email ou le mot de passe sont incorrects.";
            die();
        }

        if (!$user->isValidPassword($request->password)) {
            echo "L'adresse email ou le mot de passe sont incorrects.";
            die();
        }

        session_start();
        $_SESSION['user_id'] = $user->id;

        $this->redirect("/");

    }
}
