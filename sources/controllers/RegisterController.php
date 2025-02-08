<?php

class RegisterController extends BaseController
{
  public function index(): void
  {
    require_once __DIR__ . "/../views/register/index.php";
  }

  public function post(): void
  {
    $request = new LoginRequest();

    $user = User::findOneByEmail($request->email);

    if(isset($user)){
      echo "L'adresse email est déjà utilisée";
      die();
    }

    $verif = $this->verifierMotDePasse($request->password);
    if (is_string($verif)) {
      echo $verif;
      die();
    }

    if ($request->password != $request->passwordConf) {
      echo "Les mots de passes ne correspondent pas";
      die();
    }

    $user = new User(2, $request->firstname, $request->lastname, $request->email, password_hash($request->password, PASSWORD_DEFAULT));
    var_dump($user);
    echo "Envoyer une session";
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
