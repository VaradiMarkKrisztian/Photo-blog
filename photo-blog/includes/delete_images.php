<?php
 session_start();
 include_once 'database_handler.php';
 include_once 'functions.php';
$id = $_SESSION['Id'];
if(isset($_POST['delete'])){

    //delete images from folder 
    $sql_pictures = "SELECT image_name FROM images WHERE user_id = $id";
    $result = mysqli_query($conn,$sql_pictures);
    while($row = mysqli_fetch_array($result)){
        unlink('../Images/'. $row['image_name']);
    }

    //delete images from images table
    $sql_delete_image =  "DELETE FROM images WHERE user_id = $id";
    mysqli_query($conn,$sql_delete_image);

    //redirect him to the MainPage
    header("location: ../MainPage.php?error=All_images_deleted");
    die();
}
?>