<?php

class CreateGroupRequest
{
    public string $name;

    public function __construct()
    {
        $this->name = $_POST["name"];
    }
}