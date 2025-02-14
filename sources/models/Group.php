<?php


class Group
{

    private function __construct(
        public int $id,
        public string $name
    ) {}


    public static function create($name): bool
    {
        $groupId = DB::table("groups")->insert([
            "name" => $name
        ]);
        $userId = User::currentUser()->id;
        DB::table('users_groups')->insert([
            'user_id' => $userId,
            'groups_id' => $groupId,
            'permission' => 2
        ]);
        return true;
    }

    public static function getAll(): array
    {
        $userId = User::currentUser()->id;
        $res = DB::table('users_groups')
            ->join('groups', 'users_groups.groups_id', '=', 'groups.id')
            ->where('users_groups.user_id', '=', $userId)
            ->select('groups.*')
            ->get();
        $groups = [];
        foreach ($res as $group) {
            $groups[] = new Group($group['id'], $group['name']);
        }
        return $groups;
    }

    public function users(): array
    {
        $res = DB::table('users_groups')
            ->join('users', 'users_groups.user_id', '=', 'users.id')
            ->where('users_groups.groups_id', '=', $this->id)
            ->select('users.*')
            ->get();
        $users = [];
        foreach ($res as $user) {
            $users[] = User::findById($user['id']);
        }
        return $users;
    }

    public function photos(): array
    {
        $user = User::currentUser();
        $res = DB::table('posted_photos')
            ->join('users_groups', 'users_groups.groups_id', '=', 'posted_photos.group_id')
            ->where('posted_photos.group_id', '=', $this->id)
            ->where('users_groups.groups_id', '=', $this->id)
            ->where('users_groups.user_id', '=', $user->id)
            ->where('users_groups.permission', '>', '0')
            ->select('posted_photos.*')
            ->get();
        $photos = [];
        foreach ($res as $photo) {
            $photos[] = Photo::findById($photo['id']);
        }
        return $photos;
    }

    public static function findById($id): Group
    {
        $res = DB::table('groups')
            ->where('id', '=', $id)
            ->get();
        return new Group($res[0]['id'], $res[0]['name']);
    }

    public function addUser($email): void
    {
        $user = User::findOneByEmail($email);
        if ($user === null) {
            throw new Exception("Utilisateur introuvable");
        }
        $res = DB::table('users_groups')->select('users_groups.*')
            ->where('user_id', '=', $user->id)
            ->where('groups_id', '=', $this->id)
            ->get();
        if (count($res) > 0) {
            throw new Exception("L'utilisateur est déjà dans le groupe");
        }
        DB::table('users_groups')->insert([
            'user_id' => $user->id,
            'groups_id' => $this->id,
            'permission' => 1
        ]);
    }
}