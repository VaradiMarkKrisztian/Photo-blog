<?php	  
session_start();
   include 'includes/database_handler.php';
   include 'includes/functions.php';
   $id= $_SESSION["Id"];
   $firstname= $_SESSION["Firstname"];
    $lastname= $_SESSION["Lastname"];
    $username = $_SESSION["Username"]; 
    $email= $_SESSION["Email"];
    $avatar = $_SESSION["Avatar"];
    //print_r($_SESSION);

if(!isset($_SESSION['Id'])){
	header('location: ./StartPage.php');
	die(); //redirects the user if he is not logged in and hides the page
}
?>

<!doctype html>
<html lang="en">
  <head>
    <title>Profile Edit</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>

    <div class="container mt-5 mb-5 p-4 d-flex justify-content-center center black "> 
        <div class="card p-5 "> 
<div class=" image d-flex flex-column justify-content-center align-items-center"> 
        <img style="width:150px; height :150px;" src="./Profile_pic/<?php echo $avatar; ?>">
        <p></p>
        <span class="idd">Firstname: <?php echo $firstname; ?></span> 
        <span class="idd">Lastname: <?php echo $lastname; ?></span> 
        <span class="idd">Username: <?php echo $username; ?></span> 
        <span class="idd">Email: <?php echo $email; ?></span> 
		<button onclick="TogglePopup()" type="" name="" class="btn_red margin_top">Delete account</button>
        </div> 
    </div>
	

    <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
        <div class="card h-100">
	        <div class="card-body">
		<!--Form starts here-->
        <form action="./includes/profile_update.php" method="post">
		<div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<h6 class="mb-2 text-primary">Personal Details</h6>
			</div>
			
			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="firstname">First Name</label>
					<input type="text" class="form-control" placeholder="input last name" name="Firstname">
				</div>
			</div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="Lastname">Last Name</label>
					<input type="text" class="form-control" placeholder="Input first name" name="Lastname">
				</div>
			</div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="Username">User Name</label>
					<input type="text" class="form-control" placeholder="Enter new username" name="Username">
				</div>
			</div>

			<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="Email">Email</label>
					<input type="email" class="form-control" placeholder="Enter new email" name="Email" >
				</div>
			</div>
			
        <div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="allign-right">
					<button type="submit" name="submit-data" class="btn">Update name</button>
				</div>
			</div>
		</div>
	</form>
	 <!--Ends -->
     <div class="gap">   
        <form action="./includes/password_update.php" method="post">
        <!--had to put the password update button code in another php file because the
        isset(update_data) was blocking the way to the database-->
		<div class="row gutters">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<h6 class="mb-2 text-primary">Personal password</h6>
			</div>
			
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="New_password">New Password</label>
					<input type="password" class="form-control" placeholder="Enter new password" name="New_password" >
				</div>
			</div>

            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
				<div class="form-group">
					<label for="Input_new_password_again">Confirm new password</label>
					<input type="password" class="form-control" placeholder="Confirm password" name="Confirm_password" >
				</div>
			</div>
		</div>

		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="text-right">
					<button type="submit" name="submit-password" class="btn">Update password</button>
				</div>
			</div>
		</div>
		 <!--Ends -->
		</form>

		<form action="./includes/profile_picture_update.php" method="post" enctype="multipart/form-data">
		<div class="row gutters">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<h6 class="mb-2 text-primary">Update profile picture</h6>
			</div>
	 		<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
					<input type="file" name="Avatar" id="Avatar">
			</div>
		</div>
	 <div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
				<div class="text-right">
					<button type="button" class="btn"><a href="Profile.php">Go back</a></button>
					<button type="submit" name="submit-pfp" class="btn">Update profile picture</button>
				</div>
			</div>
		</div>
		 <!--Ends -->
		</form>
	        </div>
        </div>
    </div>
				<!--POPUP -->
<div class="pop-up flex-container-center hidden ">
    <div class="card outline">
        <div class="button-group justify-content-center">
            <div class="gallery-upload justify-content-center ">
                <form action="./includes/delete_account.php" method="post" enctype="multipart/form-data">
					<h5>Are you sure you want to delete your account?</h5>
                    <button type="submit" name="delete" class="btn_red">Delete</button>
                    <button onclick="TogglePopup()"  class ="btn" type="button" name="cancel">Cancel</button>
                </form>
            </div>
        </div> 
    </div>
</div>

</div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="Main.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>