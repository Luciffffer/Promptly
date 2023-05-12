<?php 

include_once(__DIR__ . "/../classes/Prompt.php");
include_once(__DIR__ . "/../classes/Database.php");

$prompt = new Prompt();
$prompt->deletePrompt($_POST['id']);