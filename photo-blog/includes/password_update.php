<?php
 session_start();
 include_once 'database_handler.php';
 include_once 'functions.php';
$id = $_SESSION['Id'];
if(isset($_POST['submit-password'])){
    $new_password = filter_var($_POST['New_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $confirm_password = filter_var($_POST['Confirm_password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    //remain to do current password verify but how to encrypt and see it

        if(!($new_password == NULL) && !($confirm_password == NULL))
        {
            if(passMatch($new_password,$confirm_password) !== false)
            {
                $hashedPass = password_hash($new_password, PASSWORD_DEFAULT);
                $updateP = "UPDATE users SET password='$hashedPass' WHERE id='$id'";
                $sqlPassword=mysqli_query($conn,$updateP);
            }
            else
            {
                header("location: ../Profile_edit.php?error=New_Password_Dont_Match");
                die();
            } 
            header("location: ../Profile_edit.php?error=None");
                die();
        }
        else
        {
            header("location: ../Profile_edit.php?error=A_Password_Field_Is_Empty");
            die();
        }
    }
    else
    {
        header("location: ../Profile_edit.php?error=Incorrect_Current_Password_Input");
        die();
    }

?>