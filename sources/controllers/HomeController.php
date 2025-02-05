<?php

require_once __DIR__ . "/../core/BaseController.php";

class HomeController extends BaseController
{
    public function index(): void
    {
        $groups = Group::getAll();
        $this->view("index", ["groups" => $groups]);
    }
}