<?php
   session_start();
   include 'includes/database_handler.php';
   include 'includes/functions.php';
   $firstname= $_SESSION["Firstname"];
    $lastname= $_SESSION["Lastname"];
    $username = $_SESSION["Username"]; 
    $email= $_SESSION["Email"];
    $avatar = $_SESSION["Avatar"];
    //echo $password = $_SESSION["Password"];
    //print_r($_SESSION);

if(!isset($_SESSION['Id'])){
    header('location: ./StartPage.php');
    die(); //redirects the user if he is not logged in and hides the page
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
  
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->   
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
</head>
    
<div class="container mt-5 mb-5 p-4  justify-content-center black"> 
<div class=" card p-5"> 
<div class=" image d-flex flex-column justify-content-center align-items-center " >  
    <img style="width:150px; height :150px;"  src="./Profile_pic/<?php echo $avatar; ?>"  />
<p></p>
<span class="idd">Firstname: <?php echo $firstname; ?></span> 
<span class="idd">Lastname: <?php echo $lastname; ?></span> 
<span class="idd">Username: <?php echo $username; ?></span> 
 <span class="idd">Email: <?php echo $email; ?></span> 
 <div class="d-flex flex-row align-items-center gap-2">
  
  <span><i class="fa fa-copy"></i></span> </div> 
  <div class="d-flex flex-row  align-items-center mt-3">
    </div>
    <div class=" mt-3"> 
        <button class="btn">
            <a href="Profile_edit.php">Edit Profile</a>
        </button>
     </div> 
      <div class="mt-3">
        <button class="btn" >
            <a href="./Mainpage.php">Back</a>
        </button> 
     </div> 
</div> 

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</html>