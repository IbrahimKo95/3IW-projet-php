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

    public function fullName(): string
    {
        return $this->firstname . " " . strtoupper($this->lastname);
    }
    public static function findOneByEmail(string $email): User|null
    {
        $res = DB::table("users")
            ->where("email", "=", $email)
            ->get();
        if (count($res) === 0) {
            return null;
        }
        return new User($res[0]['id'], $res[0]['firstname'], $res[0]['lastname'], $res[0]['email'], $res[0]['password']);
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
        return new User($res[0]['id'], $res[0]['firstname'], $res[0]['lastname'], $res[0]['email'], $res[0]['password']);
    }

    public function groups(): array
    {
        $res = DB::table('users_groups')
            ->join('groups', 'users_groups.groups_id', '=', 'groups.id')
            ->where('users_groups.user_id', '=', $this->id)
            ->select('groups.*')
            ->get();
        $groups = [];
        foreach ($res as $group) {
            $groups[] = Group::findById($group['id']);
        }
        return $groups;
    }

    public function getPermission(int $groupId): int
    {
        $res = DB::table('users_groups')
            ->where('user_id', '=', $this->id)
            ->where('groups_id', '=', $groupId)
            ->get();
        return $res[0]['permission'];
    }
    public function register ($data) {
        $queryBuilder = new DB();
    
        $queryBuilder->table('users');
        $queryBuilder->insert($data);
    }
}
