<?php


class Photo
{
    private function __construct(
        public int $id,
        public $photo,
        public User $user,
        public Group $group,
        public string $label,
        public string $visibility,
        public $token
    ) {}

    public static function findById($id): Photo
    {
        $res = DB::table('posted_photos')
            ->where('id', '=', $id)
            ->get();
        return new Photo($res[0]['id'], $res[0]['photos'], User::findById($res[0]['user_id']), Group::findById($res[0]['group_id']), $res[0]['label'], $res[0]['visibility'], $res[0]['token']);
    }

    public static function findByToken($token): Photo
    {
        $res = DB::table('posted_photos')
            ->where('token', '=', $token)
            ->where('visibility', '=', 'public')
            ->get();
        return new Photo($res[0]['id'], $res[0]['photos'], User::findById($res[0]['user_id']), Group::findById($res[0]['group_id']), $res[0]['label'], $res[0]['visibility'], $res[0]['token']);
    }

    public static function getAllForUser($forId): array
    {
        $user = User::currentUser();
        $ids = [];
        foreach ($user->groups() as $group) {
            $ids[] = $group->id;
        }
        $res = DB::table('posted_photos')
            ->join('users_groups', 'posted_photos.user_id', '=', 'users_groups.user_id')
            ->where('users_groups.user_id', '=', $forId)
            ->where('users_groups.groups_id', 'in', $ids)
            ->where('users_groups.permission', 'in', array(1, 2))
            ->select('posted_photos.*')
            ->get();
        $photos = [];
        foreach ($res as $photo) {
            $photos[] = new Photo($photo['id'], $photo['photos'], User::findById($photo['user_id']), Group::findById($photo['group_id']), $photo['label'], $photo['visibility'], $photo['token']);
        }
        return $photos;
    }

    public static function getAllForGroup($forId): array
    {
        $userId = User::currentUser()->id;
        $res = DB::table('posted_photos')
            ->join('users_groups', 'posted_photos.group_id', '=', 'users_groups.groups_id')
            ->where('users_groups.groups_id', '=', $forId)
            ->where('users_groups.user_id', '=', $userId)
            ->where('users_groups.permission', 'in', array(1, 2))
            ->select('posted_photos.*')
            ->get();
        $photos = [];
        foreach ($res as $photo) {
            $photos[] = new Photo($photo['id'], $photo['photos'], User::findById($photo['user_id']), Group::findById($photo['group_id']), $photo['label'], $photo['visibility'], $photo['token']);
        }
        return $photos;
    }
}