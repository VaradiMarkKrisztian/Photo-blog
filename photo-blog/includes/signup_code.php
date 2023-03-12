<?php
 if(isset($_POST["submit"])){
   $firstname = filter_var($_POST['Firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $lastname = filter_var($_POST['Lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
   $username = filter_var($_POST['Username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL);
    $createpassword = filter_var($_POST['CreatePassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirmpassword = filter_var($_POST['ConfirmPassword'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar=$_FILES['Avatar'];
   require_once 'database_handler.php';
   require_once 'functions.php';

   if(emptyInputSignup($firstname ,$lastname, $username, $email,
      $createpassword, $confirmpassword, $avatar) !== false){
      header("location: ../Signup.php?error=EmptyInput");
      exit();
   }

   if(!invalidUid($username) !==false){
    header("location: ../Signup.php?error=InvalidUid");
      exit();
   }
   if(!invalidEmail($email) !==false){
    header("location: ../Signup.php?error=InvalidEmail");
      exit();
   }
   if(passMatch($createpassword, $confirmpassword) ===false){
    header("location: ../Signup.php?error=PasswordDontMatch");
      exit();
   }
   if(UidExists($conn, $username , $email) !==false){
    header("location: ../Signup.php?error=UsernameOrEmailTaken");
      exit();
   }

   $time = time();
   $avatar_name =$time . $avatar['name'];
   $avatar_tmp_name = $avatar['tmp_name'];
   $avatar_destination_path = '../Profile_pic/'. $avatar_name;
   //make sure file is an image
   $allowed_files = ['png', 'jpg', 'jpeg'];
   $extention = explode('.', $avatar_name);
   $extention = end($extention);
   if(in_array($extention , $allowed_files)){
       //make sure image is small enough 1mb
       if($avatar['size'] < 1000000){
           //upload avatar
           move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
       } else{
           header("location: ../Signup.php?error=File_too_big");
           die();
       }
   } else {
      header("location: ../Signup.php?error=Incorrect_file_type");
      die();
   }


   createUser($conn, $firstname, $lastname, $username, 
   $email, $createpassword, $avatar_name);
 }
 else{
   header("location: ../Signup.php");
}
?>