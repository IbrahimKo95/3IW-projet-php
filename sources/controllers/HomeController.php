<?php

require_once __DIR__ . "/../core/BaseController.php";

class HomeController extends BaseController
{
    public function index(): void
    {
        $this->view("index", ["groups" => User::currentUser()->groups(), "photos" => User::currentUser()->photos()]);
    }
}