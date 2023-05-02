<?php 

require_once(__DIR__ . "/Database.php");
 

class User 
{
    private $id;
    private $prompt;
    private $negative_prompt;
    private $AI;
    private $AI_Model;
    private $tags;
    private $image;

    
    /**
     * Get the value of image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Get the value of tags
     */ 
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Get the value of AI_Model
     */ 
    public function getAI_Model()
    {
        return $this->AI_Model;
    }

    /**
     * Get the value of AI
     */ 
    public function getAI()
    {
        return $this->AI;
    }

    /**
     * Get the value of negative_prompt
     */ 
    public function getNegative_prompt()
    {
        return $this->negative_prompt;
    }

    /**
     * Get the value of prompt
     */ 
    public function getPrompt()
    {
        return $this->prompt;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }
};