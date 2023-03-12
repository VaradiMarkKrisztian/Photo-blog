<?php 
 session_start();
 include_once 'database_handler.php';
 include_once 'functions.php';
if(isset($_POST['update_image'])){
    $image_title = filter_var($_POST['Title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $image_description = filter_var($_POST['Description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $id= $_POST['Image_id'];
    if(!empty($_POST['Visible'])) $image_checked = 1;
    else $image_checked = 0;
    if(!($image_title == NULL)){
        $updateT = "UPDATE images SET title='$image_title' WHERE id='$id'";
        $sqlT=mysqli_query($conn,$updateT);
    } 
    if(!($image_description == NULL)){
        $updateD = "UPDATE images SET description='$image_description' WHERE id='$id'";
        $sqlD=mysqli_query($conn,$updateD);
    } 
    //checkbox
    $updateC = "UPDATE images SET visible = '$image_checked' WHERE id = '$id';";
    $sqlChecked = mysqli_query($conn, $updateC);
    header("location: ../Edit_image.php?error=None&&Updateid=$id");
    die();
}
else{
    header("location: ../Edit_image.php?error=why&&Updateid=$id");
    die();
}


?>