<?php

class RegisterController extends BaseController
{
  public function index(): void
  {
    require_once __DIR__ . "/../views/register/index.php";
  }
}
