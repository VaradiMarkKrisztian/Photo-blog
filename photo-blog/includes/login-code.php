<?php
if(isset($_POST["submit"])){
    $Username = $_POST["Username"];
    $password = $_POST["Password"];

    require_once 'database_handler.php';
    require_once 'functions.php';

    if(emptyInputLogin($Username, $password) !== false){
        header("location: ../Login.php?error=emptyInput");
        exit();
    }

    loginUser($conn, $Username, $password);
}
    else{
        header("location: ../Login.php");
        exit();
    }
?>