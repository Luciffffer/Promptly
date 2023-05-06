<?php

class File
{
    private $validImageExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    private $maxImageSize = 2000000;

    private string $name;
    private string $path;


    // getters

    public function getName(): string
    {
        return $this->name;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    
    // setters

    public function setImageName (string $name)
    {
        if (empty($name)) {
            throw new Exception("No image uploaded.");
        }
        
        $extension = explode('.', $name);
        $extension = strtolower(end($extension));

        if (!in_array($extension, $this->validImageExtensions)) {
            throw new Exception("Invalid image extention. We accept jpg, jpeg, png, and webp");
        }

        $newName = md5($name) . '-' . date('Y.m.d') . '-' . date('H.i.s') . '.' . $extension;

        $this->name = $newName;
        $this->path = "assets/images/user-submit/" . $newName;
        return $this;
    }


    // others

    public function validateImageSize (int $size): void
    {
        if ($size > $this->maxImageSize) {
            throw new Exception("Image size is too large. Max 1MB");
        }
    }

    public function moveImage (string $tmp_name): void
    {
        move_uploaded_file($tmp_name, __DIR__ . '/../' . $this->path);
    }
}