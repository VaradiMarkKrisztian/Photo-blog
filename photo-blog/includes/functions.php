<?php
    function emptyInputSignup($firstname ,$lastname, $username, $email,
    $create_password, $confirm_password){
        $result = false;
        if(empty($firstname)  || empty($lastname) || empty($username) || empty($email)
        || empty($create_password) || empty($confirm_password)){
            $result=true;
        }
        else{
            $result=false;
        }
        return $result;
    }
   function invalidUid($username){
    $result = false;
    if(preg_match("/^[a-zA-Z0-9]*$/", $username)){
        $result= true;
    }
    else{
        $result=false;
    }
    return $result;
   }

   function invalidEmail($email){
    $result=false;
    if($email){
        $result=true;
    }
    else{
        $result=false;
    }
    return $result;
   }

   function passMatch($create_password, $confirm_password){
    $result=true;
    if($create_password !== $confirm_password){
        $result=false;
    }
    else{
        $result=true;
    }
    return $result;
   }

   function uidExists($conn, $username , $email){
   $sql = "SELECT * FROM users WHERE username = ? OR email = ?;";
   $prepare_statement = mysqli_stmt_init($conn);
   if(!mysqli_stmt_prepare($prepare_statement, $sql)){
    header("location: ../Signup.php?error=StatementFailed");
    exit();
   }
   /*avoid sql injection*/
   mysqli_stmt_bind_param($prepare_statement, "ss", $username, $email);
   /*s= string
   amount of variables implemented decides how many s we need to add */
   mysqli_stmt_execute($prepare_statement);
   $resultData = mysqli_stmt_get_result($prepare_statement);

   if($row = mysqli_fetch_assoc($resultData)){
        return $row;
        /*can be used for both signup and login*/ 
   }
   else{
    $result=false;
    return $result;
    }    
    mysqli_stmt_close($prepare_statement);
   }

   function createUser($conn, $firstname, $lastname, $username, $email, 
    $create_password, $avatar){
    $sql = "INSERT INTO users(firstname, lastname, username, email ,password, avatar, is_admin) 
    VALUES (?, ?, ?, ?, ?, ?, ?)"; /*7  values */
    $prepare_statement = mysqli_stmt_init($conn);
    if(!mysqli_stmt_prepare($prepare_statement, $sql)){
     header("location: ../Signup.php?error=StatementFailed");
     exit();
    }

    $hashedPass = password_hash($create_password, PASSWORD_DEFAULT);

    /*avoid sql injection*/
    $is_admin=0; /* cannot pass by refference so i must create a variable*/
    mysqli_stmt_bind_param($prepare_statement, "sssssss", $firstname, $lastname, $username, $email, 
    $hashedPass, $avatar, $is_admin);
    /*s= string
    amount of variables implemented decides how many s we need to add */
    mysqli_stmt_execute($prepare_statement);
     mysqli_stmt_close($prepare_statement);
    header("location: ../Signup.php?error=None");
    exit();
    }

    function emptyInputLogin($username,$password){
        $result = false;
        if(empty($username) || empty($password)){
            $result=true;
        }
        else{
            $result=false;
        }
        return $result;
    }


    function loginUser($conn, $username, $password){
        //only 1 of them needs to be true, or email or username matches
        //in uidExists in database
        $uidExists= uidExists($conn, $username, $username);
        if($uidExists === false){
            header('location: ../Login.php?error=WrongUsernameOrEmail');
            exit();
        }
        $hashedPass = $uidExists["password"];
        $checkPass = password_verify($password, $hashedPass);

        if($checkPass === false){
            header("location: ../Login.php?error=WrongPassword");
            exit();
        }
        else if($checkPass === true){
            session_start();
            $_SESSION["Id"] = $uidExists["id"];
            $_SESSION["Firstname"] = $uidExists["firstname"];
            $_SESSION["Lastname"] = $uidExists["lastname"];
            $_SESSION["Username"] = $uidExists["username"];
            $_SESSION["Email"] = $uidExists["email"];
            $_SESSION["Avatar"] = $uidExists["avatar"];
            $_SESSION["Password"] = $uidExists["password"];
            header("location: ../MainPage.php");
            exit();
        }
    }

    function uploadImage($conn, $user_id, $image_title, $image_desc, $image_name, $image_size, $image_date){
    $value0=0;
    $sql = "INSERT INTO images(user_id, title, description, image_name ,image_size, image_date_upload, visible, likes) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)"; /*8  values */
    $prepare_statement = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($prepare_statement, $sql)){
            header("location: ../MainPage.php?error=StatementFailed");
            exit();
        }
    mysqli_stmt_bind_param($prepare_statement, "ssssssss",$user_id, $image_title,
    $image_desc, $image_name, $image_size, $image_date, $value0, $value0);
    /*s= string
    amount of variables implemented decides how many s we need to add */
    mysqli_stmt_execute($prepare_statement);
    mysqli_stmt_close($prepare_statement);
    header("location: ../MainPage.php?error=None");
    exit();
    }

    function emptyInputUserUpdate($firstname ,$lastname, $username, $email){
        $result = false;
        if(empty($firstname)  || empty($lastname) || empty($username) || empty($email)){
            $result=true;
        }
        else{
            $result=false;
        }
        return $result;
    }

    function updateUser($conn,$id, $firstname, $lastname, $username, $email){
    
        $sql = "UPDATE users SET firstname=?, lastname =?, username = ?, email = ? WHERE id= $id;"; /*4 values  +is_admin*/ 
        $prepare_statement = mysqli_stmt_init($conn);
            if(!mysqli_stmt_prepare($prepare_statement, $sql)){
                header("location: ../Edit_image.php?error=StatementFailed&&Updateid=$id");
                exit();
            }
        mysqli_stmt_bind_param($prepare_statement, "ssss",  $firstname, $lastname, $username, $email);
        /*s= string
        amount of variables implemented decides how many s we need to add */
        mysqli_stmt_execute($prepare_statement);
        mysqli_stmt_close($prepare_statement);
        header("location: ../Edit_user.php?error=None&&UpdateUserId=$id");
        exit();
        }

    function updatePost($conn,$id, $image_title, $image_desc){
    
    $sql = "UPDATE images SET title=?, description =? WHERE id= $id;"; /*2  values */
    $prepare_statement = mysqli_stmt_init($conn);
        if(!mysqli_stmt_prepare($prepare_statement, $sql)){
            header("location: ../Edit_image.php?error=StatementFailed&&Updateid=$id");
            exit();
        }
    mysqli_stmt_bind_param($prepare_statement, "ss", $image_title, $image_desc);
    /*s= string
    amount of variables implemented decides how many s we need to add */
    mysqli_stmt_execute($prepare_statement);
    mysqli_stmt_close($prepare_statement);
    header("location: ../Edit_image.php?error=None&&Updateid=$id");
    exit();
    }
?>