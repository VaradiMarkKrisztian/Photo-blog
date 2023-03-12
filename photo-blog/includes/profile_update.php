<?php
 session_start();
 include_once 'database_handler.php';
 include_once 'functions.php';
$id = $_SESSION['Id'];
 if(isset($_POST['submit-data']))
{
    $firstname= filter_var($_POST['Firstname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_var($_POST['Lastname'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $username = filter_var($_POST['Username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['Email'], FILTER_VALIDATE_EMAIL);
    //$avatar = $_POST["Avatar"];
     //print_r($_SESSION)
        if(!($firstname == NULL)){
            $updateFN = "UPDATE users SET firstname='$firstname' WHERE id='$id'";
            $sqlFirstName=mysqli_query($conn,$updateFN);
            $_SESSION["Firstname"] = $firstname;
        } 
        if(!($lastname == NULL)){
            $updateLN = "UPDATE users SET lastname='$lastname' WHERE id='$id'";
            $sqlLastName=mysqli_query($conn,$updateLN);
            $_SESSION["Lastname"] =$lastname;
        } 
        if(!($username == NULL)){ //also check if its not taken from functions
            if(uidExists($conn,$username,$username) === false){
                if(invalidUid($username) === true){
                    $updateUN = "UPDATE users SET username='$username' WHERE id='$id'";
                    $sqlUserName=mysqli_query($conn,$updateUN);
                    $_SESSION["Username"] =$username;
                }
                else{
                    header("location: ../Profile_edit.php?error=InvalidUsername");
                    die();
                }
            }
            else{
                header("location: ../Profile_edit.php?error=UsernameTaken");
                die();
            }           
        } 
        if(!($email == NULL)){ //also check if its not taken from functions            
            if(uidExists($conn,$email,$email) === false){
                if(!invalidUid($email) == true){
                    $updateE = "UPDATE users SET email='$email' WHERE id='$id'";
                    $sqlEmail=mysqli_query($conn,$updateE);
                    $_SESSION["Email"] = $email;
                }
                else{
                    header("location: ../Profile_edit.php?error=InvalidEmail");
                    die();
                }
            }
            else{
                header("location: ../Profile_edit.php?error=EmailTaken");
                die();
            } 
        } 
            header("location: ../Profile_edit.php?error=Done");
            die();
    }
    else{
        header("location: ../Profile_edit.php?error=DB_Problem");
        die();
    }
?>