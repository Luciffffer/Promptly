<?php 
    
    $PDO = Database::getInstance();

    $sql = "UPDATE prompts SET approved = 1 WHERE id = :id";

    $statement = $PDO->prepare($sql);
    $statement->bindValue(":id", $this->id);
    $statement->execute();

    $count = $statement->rowCount();
    if($count == 0) throw new Exception("Server error. Something went wrong. Try again later.");