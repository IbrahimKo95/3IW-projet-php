<?php

class User
{
    private function __construct(
        public int $id,
        public string $email,
        public string $password
    ) {}

    public static function findOneByEmail(string $email): User|null
    {
        $res = DB::table("users")
            ->where("email", "=", $email)
            ->get();
        if (count($res) === 0) {
            return null;
        }
        return new User($res[0]['id'], $res[0]['email'], $res[0]['password']);
    }

    public function isValidPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }

    public static function currentUser(): ?User
    {
        if(!isset($_SESSION)){session_start();}

        if (isset($_SESSION['user_id'])) {
            return self::findById($_SESSION['user_id']);
        }
        return null;
    }
    public static function findById(int $id): User|null
    {
        $res = DB::table("users")
            ->where("id", "=", $id)
            ->get();
        if (count($res) === 0) {
            return null;
        }
        return new User($res[0]['id'], $res[0]['email'], $res[0]['password']);
    }
}
