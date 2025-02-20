<?php

class RegisterRequest
{
  public string $firstname;
  public string $lastname;
  public string $email;
  public string $password;
  public string $passwordConfirm;

  public function __construct()
  {
    $this->firstname = $_POST["firstname"];
    $this->lastname = $_POST["lastname"];
    $this->email = strtolower(trim(htmlspecialchars($_POST["email"])));
    $this->password = $_POST["password"];
    $this->passwordConfirm = $_POST["passwordConfirm"];
  }
}
