<?php 

session_start();
if($_SESSION['loggedin'] === true){
    //ok
  } else {
    header("location: login.php");
  }
echo "😘";

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promptly</title>
</head>
<body>
    
</body>
</html>