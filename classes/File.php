<?php

class File
{
    private $validImageExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    private $maxImageSize = 1000000;

    private string $name;


    // getters

    public function getName(): string
    {
        return $this->name;
    }

    
    // setters

    public function setImageName (string $name)
    {
        $extension = explode('.', $name);
        $extension = strtolower(end($extension));

        if (!in_array($extension, $this->validImageExtensions)) {
            throw new Exception("Invalid extention.");
        }

        $newName = md5($name) . '-' . date('Y.m.d') . '-' . date('H.i.s') . '.' . $extension;

        $this->name = $newName;
        return $this;
    }


    // others

    public function validateImageSize (int $size): void
    {
        if ($size > $this->maxImageSize) {
            throw new Exception("Image size is too large. Max 1MB");
        }
    }
}