<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link rel="stylesheet" href="./css/style.css">
    
</head>
<body>
<section class="form_section">
    <div class="container form_section-container">
        <h1 class="center">SIGN UP</h1>
        <form action="./includes/signup_code.php" method="post" enctype="multipart/form-data">
            <input type="text" name="Firstname" placeholder="First Name">
            <input type="text" name="Lastname" placeholder="Last Name">
            <input type="text" name="Username" placeholder="UserName">
            <input type="email" name="Email" placeholder="Email">
            <input type="password" name="CreatePassword" placeholder="Create password">
            <input type="password" name="ConfirmPassword" placeholder="Confirm password">
            <div class="form_control">
                <label for="profile-picture">Profile picture</label>
                <input type="file" name="Avatar" id="Avatar">
            </div>
            <button type="submit" name="submit" class="btn">Sign up</button>
            <small>Already have account? <a href="Login.php">Sign in</a></small>
        </form>
    </div>
</body>
</html>