<?php
session_start();
include './includes/database_handler.php';
$avatar = $_SESSION["Avatar"];
$id = $_SESSION['Id'];
if(!isset($_SESSION['Id'])){
	header('location: ./StartPage.php');
	die(); //redirects the user if he is not logged in and hides the page
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">


</head>
<body>
    <nav>   
        <div class="container nav_container">
            <h1 class="nav_logo"><a href="Mainpage.php">Photo Blog</a></h1>
            <ul class="nav_items">
                <button onclick="TogglePopup()" class="btn">Upload</button>
                <li><a href="Update_image.php">
                <?php
                if($_SESSION['Username'] ==="Admin"){
                ?>Dashboard<?php }
                else{ ?>Edit images<?php }?>
                </a></li>
                <li><a href="Discover.php">Discover</a></li>
                </li>
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

                    <!--Search Bar-->

                        <!--Filter-->
    <form class=" margin order col-md-2" action="" method="GET">
        <div class="wrap">                     
            <select name="sort">
                <option value="Name_A-Z" <?php if(isset($_GET['sort']) && $_GET['sort'] == "Name_A-Z") { echo "selected";} ?> >Name Ascending</option>
                <option value="Name_Z-A" <?php if(isset($_GET['sort']) && $_GET['sort'] == "Name_Z-A") { echo "selected";} ?> >Name Descending</option>
                <option value="Time_A-Z" <?php if(isset($_GET['sort']) && $_GET['sort'] == "Time_A-Z") { echo "selected";} ?> >Time Ascending</option>
                <option value="Time_Z-A" <?php if(isset($_GET['sort']) && $_GET['sort'] == "time_Z-A") { echo "selected";} ?> >Time Descending</option>
                <option value="Size_A-Z" <?php if(isset($_GET['sort']) && $_GET['sort'] == "Size_A-Z") { echo "selected";} ?> >Size Ascending</option>
                <option value="Size_Z-A" <?php if(isset($_GET['sort']) && $_GET['sort'] == "Size_Z-A") { echo "selected";} ?> >Size Descending</option>
            </select>
                <button type="submit" class="btn" >Filter</button>
        </div>
    </form>
      
    
                    <!--Image upload pop-up-->    
<div class="pop-up flex-container-center hidden">
    <div class="card">
        <h2>UPLOAD</h2>
        <div class="button-group justify-content-center">
            <div class="gallery-upload justify-content-center">
                <form action="./includes/image_upload.php" method="post" enctype="multipart/form-data">
                        <input type="text" name="Image_title" placeholder="Image title...">
                        <textarea type="text" name="Image_description" placeholder="Image description..."> </textarea>                
                        <input type="file" name="Image" id="Image" >
                    <button type="submit" name="submit_image" class="btn">Upload image</button>
                    <button onclick="TogglePopup()" class ="btn" type="button" name="cancel">Cancel</button>
                </form>
            </div>
        </div> 
    </div>
</div>

            <!--Post update pop-up--> 


               <!--Postari-->
    <section class="posts">   
        <div class="container posts_container size">
<?php
    //Filter by ascending/descending
    $sort_option="";
    if(isset($_GET['sort'])){
        if($_GET['sort'] == "Name_A-Z")
        {
            $sort_option = "ORDER BY title ASC";
        }
        if($_GET['sort'] == "Name_Z-A")
        {
            $sort_option = "ORDER BY title DESC";
        }
        if($_GET['sort'] == "Time_A-Z")
        {
            $sort_option = "ORDER BY image_date_upload ASC";
        }
        if($_GET['sort'] == "Time_Z-A")
        {
            $sort_option = "ORDER BY image_date_upload DESC";
        }
        if($_GET['sort'] == "Size_A-Z")
        {
            $sort_option = "ORDER BY image_size ASC";
        }
        if($_GET['sort'] == "Size_Z-A")
        {
            $sort_option = "ORDER BY image_size DESC";
        }
    }
    //output users posts
    $sql = "SELECT id, title, description, image_name FROM images WHERE user_id= $id $sort_option;";
    $result = mysqli_query($conn, $sql);
if($result->num_rows > 0){
    while($row = mysqli_fetch_array($result)){
        $filename = "./Images/".$row["image_name"];
    ?>                           
    <article class="post">
               <div class="post_thumbnail">
                    <img src="<?php echo $filename; ?>" width="150px" height="150px">
               </div> 
               <h3 class="post_body"><?php echo $row["title"]; ?></h3>
               <p class="post_body"><?php echo $row["description"]; ?></p>
    </article>                                              
    <?php }
}else{ ?>
    <p style="color:white;">No image(s) found...</p>
<?php } ?>   
        </div>       
    </section> 

<script src="Main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
 integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
