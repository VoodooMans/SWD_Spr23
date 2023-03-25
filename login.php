<?php 
session_start(); 

if (isset($_POST['uname']) && isset($_POST['password'])) {
    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $uname = validate($_POST['uname']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        header("Location: index.php?error=Username is required");
        exit();
    } else if(empty($pass)){
        header("Location: index.php?error=Password is required");
        exit();
    } else {
        if ("username" === $uname && "password" === $pass) {
            echo "Logged in!";
            $attemptedLogin = $uname;
            $_SESSION['user_name'] = "username";
            $_SESSION['name'] = "username";
            $_SESSION['full_address'] = "123 Main Street, NYC, New York 12345";
            $_SESSION['id'] = "2";
            header("Location: fuelQuoteForm.php");
            exit();
        }else{
            header("Location: index.php?error=Incorect username or password");
            exit();
        }
    }
}else{
    header("Location: index.php");
    exit();
}
