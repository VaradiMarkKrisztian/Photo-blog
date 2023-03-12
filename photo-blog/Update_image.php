<?php
session_start();
include './includes/database_handler.php';
$avatar = $_SESSION["Avatar"];
$user_id = $_SESSION['Id'];
if(!isset($_SESSION['Id'])){
	header('location: ./StartPage.php');
	die(); //redirects the user if he is not logged in and hides the page
}

if(isset($_GET['Deleteid'])){
    $deleteid = $_GET['Deleteid'];

    //delete images from folder
    $sql_pictures = "SELECT image_name FROM images WHERE id = $deleteid";
    $image = mysqli_query($conn, $sql_pictures);
    $deleteImage = mysqli_fetch_array($image);     
    unlink('./Images/'. $deleteImage['image_name']);

    //delete images from database 
    $Delete_sql = "DELETE FROM images WHERE id = $deleteid";
    $res = mysqli_query($conn, $Delete_sql);    
    header("location:Update_image.php?error=None");
    die();
}

if(isset($_GET['DeleteUserId'])){ //DeleteUserId
  $delete_user_id = $_GET['DeleteUserId'];    
  
  //move the data of the deleted user into the delete_users table
    $sql_move = "INSERT deleted_users SELECT id, firstname, lastname, username, email, 
    password, avatar FROM users WHERE id = $delete_user_id;";
    mysqli_query($conn,$sql_move);

    //delete the users profile picture from the folder
    $sql_avatar_name = "SELECT avatar FROM users WHERE id = $delete_user_id";
    $avatar_name =mysqli_fetch_array(mysqli_query($conn ,$sql_avatar_name)); 
    unlink('./Profile_pic/'. $avatar_name['avatar']); //problem how to get the users avatar through GET

    //delete images from folder
  $sql_pictures = "SELECT image_name FROM images WHERE user_id = $delete_user_id";
  $deleteImage = mysqli_query($conn, $sql_pictures);   
  while($row = mysqli_fetch_array($deleteImage)){
    unlink('./Images/'. $row['image_name']);
  }  

  //delete images from database 
  $Delete_sql = "DELETE FROM images WHERE user_id = $delete_user_id";
  mysqli_query($conn, $Delete_sql);
  
  //delete user from database
  $sql_delete_user = "DELETE FROM users WHERE id = $delete_user_id;";
  mysqli_query($conn,$sql_delete_user);
  //send user back to Update image
  header("location:Update_image.php?error=None");
  die();
 
}

if(isset($_GET['Updateid'])){ 
  $updateid = $_GET['Updateid'];
  header("location:Edit_image.php?Updateid=$updateid");
  die();
}


if(isset($_GET['UpdateUserId'])){ //UpdateUserId
  $update_user_id = $_GET['UpdateUserId'];
  header("location:Edit_user.php?Updateid=$update_user_id");
  die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
    <?php
    if($_SESSION['Username'] ==="Admin"){
    ?>
    Dashboard
    <?php
    }
    else{
    ?>
    Update image
    <?php
    }
    ?>  
    </title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">

</head>
<body>
  <nav>   
    <div class="container nav_container">
      <h1 class="nav_logo"><a href="Mainpage.php">Photo Blog</a></h1>
        <ul class="nav_items">
            <li><a href="Update_image.php">
            <?php
              if($_SESSION['Username'] ==="Admin"){
              ?>
              Dashboard
              <?php
              }
              else{
              ?>
              Edit images
              <?php
              }
              ?>
            </a></li>
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

<div class=" margin">
  <h1 class="title_center">
  <?php
    if($_SESSION['Username'] ==="Admin"){
    ?>
    Dashboard
    <?php
    }
    else{
    ?>
    Update image
    <?php
    }
    ?>  
  </h1> 
</div>


<?php                                       //START OF USER IS NOT ADMIN
if($_SESSION['Username'] !=="Admin"){ 
?>

<table class="table center">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Description</th>
      <th scope="col">Edit image</th>
      <th scope="col">Delete image</th>
    </tr>
  </thead>
  <tbody>
    <!--code so description and title text goes on next line very 20 chars-->
    <?php
    $sql = "SELECT id, title, description, image_name FROM images WHERE user_id= $user_id;";
    $image_found = mysqli_query($conn, $sql);
    $result_image_found = mysqli_fetch_array($image_found);
    if($result_image_found > 0){
    $Show_image_sql = "SELECT id, image_name, title, description FROM images WHERE user_id = $user_id;";
    $result = mysqli_query($conn,$Show_image_sql);
    $counter = 0;
    while($row = mysqli_fetch_array($result)){

    $UAline1  = substr($row['description'], 0, 0);
    $towrapUA = str_replace($UAline1, '', $row['description']);

    $space = str_repeat('&nbsp;', 1);

    $wordwrapped = wordwrap($towrapUA, 60, "\n");
    $wordwrapped = explode("\n", $wordwrapped); // Split at '\n'

    $numlines = count($wordwrapped) - 1;
    $description = '';
    $i = 0;

    foreach($wordwrapped as $line) {
        if($i < $numlines) {
            $description .= $line . "<br>"; // Add \n\r back in if not last line
        } else {
            $description .= $line; // If it's the last line, leave off \n\r
        }

    $i++;
    }
    ?>
    <tr>
      <th><?php echo $counter = $counter + 1;?></th>
      <td style="width:80px; height: 70px;"><img src="./Images/<?php echo $row['image_name'];?>"></td>
      <td><?php echo $row['title'];?></td>
      <td><?php echo $description; ?></td>
      <td><button class="btn margin_top"><a href="Edit_image.php?Updateid=<?php echo $row['id'];?>">Edit</a></button></td>
      <td><button class="btn_red margin_top"><a href="Update_image.php?Deleteid=<?php echo $row['id'];?>">Delete</a></button></td>
    </tr>
  </tbody>
    <?php
    } ?>
</table>
    <button onclick="TogglePopup()" type="" name="" class="right btn_red margin_top">Delete all images</button>

<div class="pop-up flex-container-center hidden ">
    <div class="card outline">
        <div class="button-group justify-content-center">
            <div class="gallery-upload justify-content-center ">
                <form action="./includes/delete_images.php" method="post" enctype="multipart/form-data">
					        <h5>Are you sure you want to delete all your images?</h5>
                    <button type="submit" name="delete" class="btn_red">Delete</button>
                    <button onclick="TogglePopup()"  class ="btn" type="button" name="cancel">Cancel</button>
                </form>
            </div>
        </div> 
    </div>
</div>
    <?php
  }else { ?>
<p style="color:white;">No image(s) found...</p>

<?php
  }                                         //END OF USER IS NOT ADMIN



                                            //START OF USER IS ADMIN
} 
else{ 
  ?>
  <?php
                                            //START OF USERS WHILE
   $Show_users_sql = "SELECT id, firstname, lastname, username, email, is_admin FROM users WHERE NOT id = $user_id;";
   $user_result = mysqli_query($conn,$Show_users_sql);
   $user_counter = 0;
   while($user_row = mysqli_fetch_array($user_result)){
  ?>
  <table class="table center">  
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Firstname</th>
      <th scope="col">Lastname</th>
      <th scope="col">Username</th>
      <th scope="col">Email</th>
      <th scope="col">Role</th>
      <th scope="col">Edit user</th>
      <th scope="col">Delete user</th>
    </tr>
  </thead>
  <tr>
      <td><?php echo $user_counter = $user_counter+1;?></td>
      <td><?php echo $user_row['firstname'];?></td>
      <td><?php echo $user_row['lastname'];?></td>
      <td><?php echo $user_row['username'];?></td>
      <td><?php echo $user_row['email'];?></td>
      <td><?php
      if($user_row['is_admin'] == 1)
       echo 'Admin';
       else echo 'User';
       ?></td>
      <td><button class="btn margin_top"><a href="Edit_user.php?UpdateUserId=<?php echo $user_row['id'];?>">Edit user</a></button></td>
      <td><button class="btn_red margin_top"><a href="Update_image.php?DeleteUserId=<?php echo $user_row['id'];?>">Delete user</a></button></td>
    </tr>
  </table>

  <?php
  ?>
  
  <table  class="table center gap_bot">
  <thead>
    <tr>
      <th scope="col">Id</th>
      <th scope="col">Image</th>
      <th scope="col" rowspan="2">Title</th>
      <th scope="col" rowspan="2">Description</th>
      <th scope="col">Status</th>
      <th scope="col">Edit image</th>
      <th scope="col">Delete image</th>
    </tr>
  </thead>

  <tbody>
    <!--code so description and title text goes on next line very 20 chars-->
                                             


                                               <!--START OF IMAGES WHILE-->
    <?php
    $user_id = $user_row['id'];
    $Show_image_sql = "SELECT id, image_name, title, description, visible FROM images WHERE user_id = $user_id;";
    $result = mysqli_query($conn,$Show_image_sql);
    $image_counter = 0;
    while($row = mysqli_fetch_array($result)){
    $UAline1  = substr($row['description'], 0, 0);
    $towrapUA = str_replace($UAline1, '', $row['description']);

    $space = str_repeat('&nbsp;', 1);

    $wordwrapped = wordwrap($towrapUA, 60, "\n");
    $wordwrapped = explode("\n", $wordwrapped); // Split at '\n'

    $numlines = count($wordwrapped) - 1;
    $description = '';
    $i = 0;

    foreach($wordwrapped as $line) {
        if($i < $numlines) {
            $description .= $line . "<br>"; // Add \n\r back in if not last line
        } else {
            $description .= $line; // If it's the last line, leave off \n\r
        }

    $i++;
    }
    ?>
    <tr>
      <th><?php echo $image_counter = $image_counter + 1;?></th>
      <td style="width:80px; height: 70px;"><img src="./Images/<?php echo $row['image_name'];?>"></td>
      <td><?php echo $row['title'];?></td>
      <td><?php echo $description; ?></td>
      <td><?php
      if($row['visible'] == 1)
       echo 'Visible';
       else echo 'Hidden';
       ?></td>
      <td><button class="btn margin_top"><a href="Edit_image.php?Updateid=<?php echo $row['id'];?>">Edit image</a></button></td>
      <td><button class="btn_red margin_top"><a href="Update_image.php?Deleteid=<?php echo $row['id'];?>">Delete image</a></button></td>
    </tr>
  </tbody>
    
    <?php  
      }//End of images while
    $image_counter=0; 
    ?>

  <?php
  }//end of Users while
  ?>
  
</table>
<?php
} //end of IF ADMIN
?>

<script src="Main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
 integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>