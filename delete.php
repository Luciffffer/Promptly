<?php 
    include_once(__DIR__ . "/classes/User.php");
    include_once(__DIR__ . "/classes/Database.php");

    session_start();
    /*if($_SESSION['loggedin'] === true){
        //ok
    } else {
        header("Location: login");
    }*/

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete user</title>
    <?php if(isset($_SESSION['username'])){ 
        echo $_SESSION['username'];
     }?>
</head>
<body>
    
</body>
</html>