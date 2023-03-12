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

<section class="posts">   
    <div class="container posts_container size">
<?php
    $sql = "SELECT images.id, title, description, image_name, image_date_upload, firstname, lastname, username, avatar, likes FROM images
    LEFT JOIN users ON images.user_id=users.id WHERE visible='1';";
    $result = mysqli_query($conn, $sql);
if($result->num_rows > 0){
    while($row = mysqli_fetch_array($result)){
        $filename = "./Images/".$row["image_name"];
        $avatarname= "./Profile_pic/".$row["avatar"];
    ?>                           
        <article class="post">
               <div class="post_thumbnail">
                    <img src="<?php echo $filename; ?>" width="150px" height="150px">
               </div> 
               <h3 class="post_body"><?php echo $row["title"]; ?></h3>
               <p class="post_body"><?php echo $row["description"]; ?></p>
               <div class="post_author">
                     <div class="post_author-avatar">
                         <img src="<?php echo $avatarname; ?>">
                     </div>
                     <div class="post_author-info">
                         <h6> By <?php echo $row['firstname'],' ', $row['lastname'];?></h6>
                         <small> <?php echo $row['image_date_upload']?></small>
                     </div>
                 </div> 
            <?php
        $sql_check_liked= "SELECT userid, imageid FROM likes WHERE userid = $id AND imageid = {$row['id']}";
        $result_check = mysqli_query($conn, $sql_check_liked);
        if($result_check -> num_rows >0){
        //Shows a button the amount of likes an image has and if its already Liked will show as Dislike ?>
        <button class="btn-Like"> <a href="./includes/like.php?type=Dislike&id=<?php echo $row['id']?>">Dislike   
        <?php }
        else{?>
        <button class="btn-Like"> <a href="./includes/like.php?type=Like&id=<?php echo $row['id']?>">Like
        <?php }
        echo $row['likes']?></a></button>
        </article>                                              
    <?php }
}else{ ?>
    <p style="color:white;">No image(s) shared...</p>
<?php } ?>   
        </div>       
    </section>

</body>
</html>