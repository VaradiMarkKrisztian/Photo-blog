<?php
 session_start();
 include_once 'database_handler.php';
 include_once 'functions.php';
$user_id = $_SESSION['Id'];
if(isset($_POST['submit_image'])){
    $image_title = filter_var($_POST['Image_title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $image_description = filter_var($_POST['Image_description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $image=$_FILES['Image'];

    if(emptyInputLogin($image_title, $image_description) !== false){
    //it already verified 2 inputs in the login form so it can be used here too without problems
      header("location: ../MainPage.php?error=EmptyInput");
      exit();
   }

    $time = time();
   $image_name = $time . $image['name'];
   $image_tmp_name = $image['tmp_name'];
   $image_destination_path = '../Images/'. $image_name;
   //make sure file is an image
   $allowed_files = ['png', 'jpg', 'jpeg'];
   $extention = explode('.', $image_name);
   $extention = end($extention);
   if(in_array($extention , $allowed_files)){
       //make sure image is small enough 1mb
       if($image['size'] < 1000000){
           //upload image
            $image_size =$image['size'];
            $image_date = date("Y-m-d H:i:s"); //MySQL DATETIME format
           move_uploaded_file($image_tmp_name, $image_destination_path);
       } else{
           header("location: ../MainPage.php?error=File_too_big");
           die();
       }
   } else {
      header("location: ../MainPage.php?error=Incorrect_file_type");
      die();
   }

   uploadImage($conn, $user_id, $image_title, $image_description, $image_name, $image_size, $image_date);
}
else{
    header("location: ../MainPage.php?error=why");
    die();
}

?>