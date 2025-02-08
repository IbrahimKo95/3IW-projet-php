<?php

class User
{
  private function __construct(
    public int $id,
    public string $firstname,
    public string $lastname,
    public string $email,
    public string $password
  ) {}

  public static function findOneByEmail(string $email): User|null
  {
    $databaseConnection = new PDO(
      "mysql:host=mariadb;dbname=database",
      "user",
      "password"
    );

    $getUserQuery = $databaseConnection->prepare("SELECT id, email, password FROM users WHERE email = :email");

    $getUserQuery->execute([
      "email" => $email
    ]);

    $user = $getUserQuery->fetch(PDO::FETCH_ASSOC);

    return new User($user["id"], $user["email"], $user["password"]);
  }

  public function register ($data) {
    $queryBuilder = new DB();

    $queryBuilder->table('users');
    $queryBuilder->insert($data);
  }

  public function isValidPassword(string $password): bool
  {
    return password_verify($password, $this->password);
  }
}
