<?php

class PostPhotoRequest
{
    public $photo;
    public $photoType;
    public $photoSize;
    public string $label;

    public $photoId;
    public $visibility;

    public function __construct($forAdd = true)
    {
        if ($forAdd) {
            $this->photo = strlen($_FILES["file"]["tmp_name"]) > 0 ? file_get_contents($_FILES["file"]["tmp_name"]) : null;
            $this->photoType = $_FILES["file"]["type"];
            $this->photoSize = $_FILES["file"]["size"];
            $this->label = $_POST["label"];
        } else {
            $this->photoId = $_POST['photo_id'];
            $this->visibility = $_POST['visibility'];
        }
    }
}