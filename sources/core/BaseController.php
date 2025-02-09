<?php

class BaseController
{

    public function redirect(string $url)
    {
        header("Location: $url");
        exit;
    }


    public function view(string $view, array $data = [])
    {
        extract($data);
        $flashMessage = $_SESSION['flash_message'] ?? null;
        unset($_SESSION['flash_message']);
        require_once __DIR__ . "/../views/layout.php";
        require_once __DIR__ . "/../views/$view.php";
    }

    public function back()
    {
        $previousUrl = $_SERVER['HTTP_REFERER'] ?? '/';
        header("Location: $previousUrl");
        exit;
    }

    public function withMessage(string $message)
    {
        $_SESSION['flash_message'] = $message;
        return $this;
    }

}
