<?php
 session_start();
 include_once 'database_handler.php';
 include_once 'functions.php';
$id = $_SESSION['Id'];
$avatar = $_SESSION['Avatar'];
if(isset($_POST['delete'])){
 
    //move the data of the deleted user into the delete_users table
    $sql_move = "INSERT deleted_users SELECT id, firstname, lastname, username, email, 
    password, avatar FROM users WHERE id = $id;";
    mysqli_query($conn,$sql_move);

    //delete the users profile picture from the folder
    unlink('../Profile_pic/'. $avatar); 

    //delete images from folder 
    $sql_pictures = "SELECT image_name FROM images WHERE user_id = $id";
    $result = mysqli_query($conn,$sql_pictures);
    while($row = mysqli_fetch_array($result)){
        unlink('../Images/'. $row['image_name']);
    }

    //delete images from images table
    $sql_delete_image =  "DELETE FROM images WHERE user_id = $id";
    mysqli_query($conn,$sql_delete_image);


    //delete the users account from users table
    $sql_delete = "DELETE FROM users WHERE id = $id;";
    mysqli_query($conn,$sql_delete);

    //redirect him to the startpage
    session_unset();
    session_destroy();
    header("location: ../StartPage.php?error=Account_deleted");
    die();
}
?>