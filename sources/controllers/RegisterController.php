<?php

require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../requests/RegisterRequest.php";
require_once __DIR__ . "/../core/BaseController.php";
require_once __DIR__ . "/../core/QueryBuilder.php";

class RegisterController extends BaseController
{
  public function index(): void
  {
    $this->view("register/index");
  }

  public function post(): void
  {
    $request = new RegisterRequest();

    $properties = get_object_vars($request);
    $allSet = !in_array("", $properties, true);

    if (!$allSet) {
      $this->withMessage("Remplissez tout les champs !")->back((array) $request);
    }

    $user = User::findOneByEmail($request->email);

    if(isset($user)){
      $this->withMessage("L'adresse email est déjà utilisée")->back((array) $request);
    }

    $verif = $this->verifierMotDePasse($request->password);
    if (is_string($verif)) {
      $this->withMessage($verif)->back((array) $request);
    }

    if ($request->password != $request->passwordConfirm) {
      $this->withMessage("Les mots de passes ne correspondent pas")->back((array) $request);
    }
    $data = (array) $request;
    unset($data['passwordConfirm']);
    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

    DB::table('users')->insert($data);

    $this->redirect("/login");
  }

  public function verifierMotDePasse($password) {
    if (strlen($password) < 8) {
        return "Le mot de passe doit contenir au moins 8 caractères.";
    }
    if (!preg_match('/[A-Z]/', $password)) {
        return "Le mot de passe doit contenir au moins une majuscule.";
    }
    if (!preg_match('/[a-z]/', $password)) {
        return "Le mot de passe doit contenir au moins une minuscule.";
    }
    if (!preg_match('/[0-9]/', $password)) {
        return "Le mot de passe doit contenir au moins un chiffre.";
    }
    if (!preg_match('/[\W]/', $password)) {
        return "Le mot de passe doit contenir au moins un caractère spécial.";
    }
    return true;
  }
}
