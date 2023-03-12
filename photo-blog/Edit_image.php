<?php
session_start();
include './includes/database_handler.php';
$avatar = $_SESSION["Avatar"];
$user_id = $_SESSION['Id'];

if(!isset($_SESSION['Id'])){
	header('location: ./StartPage.php');
	die(); //redirects the user if he is not logged in and hides the page
}

if(isset($_GET['Updateid'])){
  $updateid = $_GET['Updateid'];
  $sql = "SELECT id, title, description, image_name, visible FROM images WHERE id= $updateid;";
  $result = mysqli_query($conn, $sql);
  $editdata = mysqli_fetch_array($result);

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit image</title>
    <link rel="stylesheet" href="./css/style.css">


</head>
<body>
  <nav>   
    <div class="container nav_container">
      <h1 class="nav_logo"><a href="Mainpage.php">Photo Blog</a></h1>
        <ul class="nav_items">
            <li><a href="Update_image.php">Edit images</a></li>
            <li><a href="Discover.php">Discover</a></li>
            <li class="nav_profile">
            <div class="avatar">
              <img src="./Profile_pic/<?php echo $avatar; ?>">
            </div>
            <ul>
              <li><a href="Profile.php">Profile</a></li>
              <li><a href="includes/Logout.php">Logout</a></li>
            </ul>
          </li>
        </ul>
    </div>
  </nav>


<section class="form_section">
    <div class="container form_section-container">
        <h1 class="center">EDIT IMAGE</h1>
        
        <form action="includes/update_image.php" method="post">
          <img style="width:150px; height :150px; margin-left: 30px;" src="./Images/<?php echo $editdata['image_name']; ?>">
            <input type="text" name="Title" placeholder="Title..." value="<?php echo $editdata['title'];?>">
            <textarea type="text" name="Description" placeholder="Description..."></textarea>
            <label class="label_text">Public image?
            <input type="checkbox" class="image_checkbox" name="Visible" <?php if($editdata['visible'] == 1){?> checked <?php } ?> >
            </label>      
            <!--checkbox for visible-->
            <input type="hidden" value="<?php echo $editdata['id'];?>" name="Image_id" >
            <button type="submit" name="update_image" class="btn">Update</button>
            <button type="button" class="btn"><a href="Update_image.php">Cancel</a></button>
        </form>
    </div>
</section>
<script src="Main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
 integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>