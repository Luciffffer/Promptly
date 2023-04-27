<?php 
    include_once("../promptly/classes/User.php");

    session_start();

    /*if($_SESSION['loggedin'] === true){
        //ok
    } else {
        header("Location: login");
    }*/

    if(isset($_POST['verzend'])){
        var_dump("ok");
        $rmv = new User(); 
        $rmv->setId($_SESSION['userId']);
        $rmv->deleteUser();
        header("index: login");
    }
        
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete user</title>
   
     
</head>
<body>
    <form action="" method="POST" class="form">
        <input type="submit" value="
        <?php 
            if(isset($_SESSION['username'])){ 
                echo $_SESSION['username'];
            }
        ?> 
        " name="verzend">
    </form>



</body>
</html>