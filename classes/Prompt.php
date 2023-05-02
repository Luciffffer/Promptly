<?php

require_once(__DIR__ . "/Database.php");



class Prompt
{
 private $id;
 private $title;
 private $description;
 private $tags;
 private $author_id;
 private $model_id;
 private $free;
 private $approved;

 /**
  * Get the value of approved
  */ 
 public function getApproved()
 {
  return $this->approved;
 }

 /**
  * Get the value of free
  */ 
 public function getFree()
 {
  return $this->free;
 }

 /**
  * Get the value of model_id
  */ 
 public function getModel_id()
 {
  return $this->model_id;
 }

 /**
  * Get the value of author_id
  */ 
 public function getAuthor_id()
 {
  return $this->author_id;
 }

 /**
  * Get the value of tags
  */ 
 public function getTags()
 {
  return $this->tags;
 }

 /**
  * Get the value of description
  */ 
 public function getDescription()
 {
  return $this->description;
 }

 /**
  * Get the value of title
  */ 
 public function getTitle()
 {
  return $this->title;
 }

 /**
  * Get the value of id
  */ 
 public function getId()
 {
  return $this->id;
 }

 public static function getAllPrompts()
    {
        $sql = "SELECT * FROM prompts";
        $PDO = Database::getInstance();
        $stmt = $PDO->prepare($sql);
        $stmt->execute();
        $prompts = array();
        
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $prompt = new Prompt(
                $row['id'],
                $row['title'],
                $row['description'],
                $row['tags'],
                $row['author_id'],
                $row['model_id'],
                $row['free'],
                $row['approved']
            );
            
            $prompts[] = $prompt;
        }
        
        return $prompts;
    }

 public static function compareByTitle($a, $b)
 {
     return strcmp($a->getTitle(), $b->getTitle());
 }
}

       
        
