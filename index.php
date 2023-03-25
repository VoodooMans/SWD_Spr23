<!DOCTYPE html>
<html>
<head>
    <title>Sign In</title>
    <link rel="stylesheet" type="text/css" href="template.css">
</head>
<body>
    <div class="container">
        <form action="login.php" method="post">
            <h1>Sign In</h1>
            <?php if (isset($_GET['error'])) { ?>
                <p class="error"><?php echo $_GET['error']; ?></p>
            <?php } ?>
            <hr />
            <label>Username</label>
            <input type="text" name="uname" placeholder="Username" required><br />
            <label>Password</label>
            <input type="password" name="password" placeholder="Password" required><br /> 
            <button class="registerbtn">Login</button>
            <div class="login">
            <p>Don't have an account? <a href="register.php">Register Here</a></p>
        </form>
    </div>
</body>
</html>

