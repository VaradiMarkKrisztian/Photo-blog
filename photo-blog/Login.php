<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./css/style.css">
    
</head>
<body>
<section class="form_section">
    <div class="container form_section-container">
        <h1 class="center">LOGIN</h1>
        <form action="includes/login-code.php" method="post">
            <input type="text" name="Username" placeholder="UserName/Email">
            <input type="password" name="Password" placeholder="Password">
            <button type="submit" name="submit" class="btn">Login</button>
            <small>Dont have account? <a href="Signup.php">Create account</a></small>
        </form>
    </div>
</section>
</body>
</html>