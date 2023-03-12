<?php
session_start();
 include_once 'database_handler.php';
 include_once 'functions.php';
if(isset($_POST['update_user'])){
    $firstname = filter_var($_POST['Firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['Lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['Username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL);
    $id= $_POST['User_id'];
    if(!empty($_POST['Is_admin'])) $user_checked = 1;
    else $user_checked = 0;
    //checkbox

    if(!($firstname == NULL)){
        $updateFN = "UPDATE users SET firstname='$firstname' WHERE id='$id'";
        $sqlFirstName=mysqli_query($conn,$updateFN);
    } 
    if(!($lastname == NULL)){
        $updateLN = "UPDATE users SET lastname='$lastname' WHERE id='$id'";
        $sqlLastName=mysqli_query($conn,$updateLN);
    } 
    if(!($username == NULL)){ //also check if its not taken from functions
        if(uidExists($conn,$username,$username) === false){
            if(invalidUid($username) === true){
                $updateUN = "UPDATE users SET username='$username' WHERE id='$id'";
                $sqlUserName=mysqli_query($conn,$updateUN);
            }
            else{
                header("location: ../Edit_user.php?error=InvalidUsername&&UpdateUserId=$id");
                die();
            }
        }
        else{
            header("location: ../Edit_user.php?error=UsernameTaken&&UpdateUserId=$id");
            die();
        }           
    } 
    if(!($email == NULL)){ //also check if its not taken from functions            
        if(uidExists($conn,$email,$email) === false){
            if(!invalidUid($email) == true){
                $updateE = "UPDATE users SET email='$email' WHERE id='$id'";
                $sqlEmail=mysqli_query($conn,$updateE);
            }
            else{
                header("location: ../Edit_user.php?error=InvalidEmail&&UpdateUserId=$id");
                die();
            }
        }
        else{
            header("location: ../Edit_user.php?error=EmailTaken&&UpdateUserId=$id");
            die();
        } 
    } 
    //checkbox
    $updateC = "UPDATE users SET is_admin = '$user_checked' WHERE id = '$id';";
    $sqlChecked = mysqli_query($conn, $updateC);
    header("location: ../Edit_user.php?error=None&&UpdateUserId=$id");
    die();

}
else{
    header("location: ../Edit_user.php?error=why&&UpdateUserId=$id");
    die();
}
?>