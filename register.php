<?php
session_start(); 

if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
    function validate($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $password = validate($_POST['password']);
    $confirm_password = validate($_POST["confirm_password"]);
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    if (strlen($password) < 6) {
        header("Location: register.php?error=Password must have at least 6 characters.");
        exit();
    } else if (empty($confirm_password)) {
        header("Location: register.php?error=Please confirm your password.");
        exit();
    } else if (empty($password)) {
        header("Location: register.php?error=Please enter your password.");
        exit();
    } else if (empty($username)) {
        header("Location: register.php?error=Please enter your username.");
        exit();
    } else if ($password != $confirm_password) {
        header("Location: register.php?error=Passwords did not match.");
        exit();
    } else {
        $_SESSION['user_name'] = $username;
        $_SESSION['id'] = "2";
        header("Location: profileManagement.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Create Account</title>
        <link rel="stylesheet" type="text/css" href="template.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Create Account</h1>
                    <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                    <?php } ?>
                    <hr />
                    <p>Please fill this form to create an account.</p>
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Username" required>
                        </div>    
                        <div class="form-group">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>
                        <div class="form-group">
                            <label>Confirm Password</label>
                            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                        </div>
                        <div class="form-group">
                            <button name = "submit" class="registerbtn">Register Account</button>
                        </div>
                        <p>Already have an account? <a href="index.php">Login here</a>.</p>
                    </form>
                </div>
            </div>
        </div>    
    </body>
</html>
