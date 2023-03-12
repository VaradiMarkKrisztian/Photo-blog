<?php 
 session_start();
 include_once 'database_handler.php';
 include_once 'functions.php';
$id = $_SESSION['Id'];
if(isset($_POST['submit-pfp'])){
    $avatar=$_FILES['Avatar'];

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
           //delete previous image from file
           $updateA = "SELECT avatar FROM users WHERE id='$id';";
           $result= mysqli_query($conn, $updateA);
           if (!$result) 
            {
            header("location: ../Profile_edit.php?error=Avatar_NotFound");
            die();        
            }
            $sqlProfilepic = mysqli_fetch_row($result);
           unlink('../Profile_pic/'. $sqlProfilepic[0]); 
           //delete current file from folder
           move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
           //upload new file in folder
           $sql = "UPDATE users SET avatar = (?) WHERE id='$id'";
            $prepare_statement = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($prepare_statement, $sql)){
                header("location: ../Profile_edit.php?error=StatementFailed");
                exit();
               }
            mysqli_stmt_bind_param($prepare_statement, "s", $avatar_name);
            //insert the new profile picture name in database
            /*s= string
            amount of variables implemented decides how many s we need to add */
            mysqli_stmt_execute($prepare_statement);
         mysqli_stmt_close($prepare_statement);
       } else{
           header("location: ../Profile_edit.php?error=File too big");
           die();
       }
        $_SESSION["Avatar"] =$avatar_name;
       header("location: ../Profile_edit.php?error=None");
        exit();
   } 
   else {
      header("location: ../Profile_edit.php?error=Incorrect file type");
      die();
   }
}
else{
    header("location: ../Profile_edit.php?error=Something_wrong");
      die();
}
?>