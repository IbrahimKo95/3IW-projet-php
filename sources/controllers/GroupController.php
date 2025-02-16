<?php

require_once __DIR__ . "/../core/BaseController.php";
require_once __DIR__ . "/../requests/CreateGroupRequest.php";
require_once __DIR__ . "/../models/Group.php";
class GroupController extends BaseController
{

    public function store(): void
    {
        $request = new CreateGroupRequest();
        Group::create($request->name);
        $this->back();
    }

    public function get($id): void
    {
        $group = Group::findById($id);
        $this->view("group/index", ["group" => $group, "photos" => $group->photos()]);
    }

    public function addUser($id): void
    {
        if(User::currentUser()->getPermission($id) !== 3){
            $this->withMessage("Vous n'avez pas les droits pour effectuer cette action.")->back();
        }
        try {
            $group = Group::findById($id);
            $group->addUser($_POST['email']);
        } catch (Exception $e) {
            $this->withMessage($e->getMessage())->back();
        }
        $this->withMessage("Utilisateur ajouté avec succès.")->back();
    }

    public function manageMember($id): void
    {
        if(User::currentUser()->getPermission($id) !== 3){
            $this->withMessage("Vous n'avez pas les droits pour effectuer cette action.")->back();
        }
        $this->view("group/manageMember", ["group" => Group::findById($id)]);
    }

    public function deleteMember($id, $idUser): void
    {
        if(User::currentUser()->getPermission($id) !== 3){
            $this->withMessage("Vous n'avez pas les droits pour effectuer cette action.")->back();
        }
        $group = Group::findById($id);
        $group->deleteUser($idUser);
        $this->back();
    }

    public function changePermission($id, $idUser): void
    {
        if(User::currentUser()->getPermission($id) !== 3 || $_POST['permission'] == 3){
            $this->withMessage("Vous n'avez pas les droits pour effectuer cette action.")->back();
        }
        $group = Group::findById($id);
        $group->changePermission($idUser, $_POST['permission']);
        $this->back();
    }
}