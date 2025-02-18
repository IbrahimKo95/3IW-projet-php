<?php

require_once __DIR__ . "/../models/User.php";
require_once __DIR__ . "/../requests/PostPhotoRequest.php";
require_once __DIR__ . "/../core/BaseController.php";
require_once __DIR__ . "/../core/QueryBuilder.php";
require_once __DIR__ . "/../models/Photo.php";

class PhotoController extends BaseController
{
    public function index($id): void
    {
        $this->view("photo/index", ["group" => Group::findById($id)]);
    }

    public function addPhoto($id): void
    {
        $request = new PostPhotoRequest();
        $properties = get_object_vars($request);
        $allSet = !in_array("", $properties, true);

        $user = User::currentUser();
        if (!$allSet) {
            $this->withMessage("Remplissez tout les champs !", true)->back((array) $request);
        }

        $formats = ["image/jpeg", "image/png", "image/gif"];
        if (!in_array($request->photoType, $formats)) {
            $this->withMessage("Format non autorisé", true)->back((array) $request);
        }

        if ($request->photoSize > 2 * 1024 * 1024) { // 2 Mo
            $this->withMessage("Fichier trop grand (2mo max)", true)->back((array) $request);
        }

        $data = ['user_id' => $user->id, 'group_id' => $id, 'photos' => $request->photo, 'label' => $request->label];
        DB::table('posted_photos')->insertPerso($data, [':user_id' => PDO::PARAM_INT, ':group_id' => PDO::PARAM_INT, ':photos' => PDO::PARAM_LOB]);

        unset($_SESSION['open_modal']);
        unset($_SESSION['modal_message']);

        $this->back();
    }

    public function deletePhoto($id): void
    {
        DB::table('posted_photos')
        ->where('id', '=', $_POST['photo_id'])
        ->delete();

        $this->redirect('/group/'.$id);
    }

    public function changeVisibility($id): void
    {
        $request = new PostPhotoRequest(false);
        $photoId = $request->photoId;
        $visibility = $request->visibility;
        unset($_POST['photo_id']);
        unset($_POST['visibility']);

        $publicToken = ($visibility === 'public') ? bin2hex(random_bytes(16)) : null;

        DB::table('posted_photos')
        ->where('id', '=', $photoId)
        ->update(['visibility' => $visibility, 'token' => $publicToken]);

        $this->redirect('/group/'.$id);
    }

    public function get($token): void
    {
        $photo = Photo::findByToken($token);
        $this->view("photo/display", ["photo" => $photo]);
    }
}
