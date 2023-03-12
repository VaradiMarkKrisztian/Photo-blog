<?php
session_start();
$userid=$_SESSION['Id'];
require_once 'database_handler.php';
if(isset($_GET['type'], $_GET['id'])){
    $type = filter_var($_GET['type'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;
    $id = filter_var($_GET['id'], FILTER_SANITIZE_FULL_SPECIAL_CHARS) ;

    switch($type){
        case 'Like':
    //inserts the result into the Likes table
    $sql = "INSERT INTO likes(userid, imageid) SELECT $userid, $id FROM images
    WHERE NOT EXISTS (SELECT id FROM likes WHERE userid = $userid AND imageid = $id) LIMIT 1";
     mysqli_query($conn, $sql);
     //updates the amount of likes in images table
    $sql = "UPDATE images SET likes=likes+1 WHERE id= $id ";
    mysqli_query($conn, $sql);
    
    break;
        case 'Dislike':
    //deletes the result into the Likes table
    $sql ="DELETE FROM likes WHERE userid= $userid AND imageid = $id";
    mysqli_query($conn, $sql);
    //updates the amount of likes in images table
    $sql = "UPDATE images SET likes=likes-1 WHERE id= $id ";
    mysqli_query($conn, $sql);
    break;
    }
}
header('location: ../Discover.php');
?>