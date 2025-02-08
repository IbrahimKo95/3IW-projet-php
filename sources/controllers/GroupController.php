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
    }

    public function get($id): void
    {
        $this->view("group/index", ["group" => Group::findById($id)]);
    }

    public function addUser($id): void
    {
        try {
            $group = Group::findById($id);
            $group->addUser($_POST['email']);
        } catch (Exception $e) {
            $this->withMessage($e->getMessage())->back();
        }
        $this->withMessage("Utilisateur ajouté avec succès.")->back();
    }
}