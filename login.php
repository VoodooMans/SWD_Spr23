<?php 
session_start(); 
require_once('db_conn.php');

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
        $sql = "SELECT * FROM UserCredentials WHERE username='$uname'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            if (!password_verify($pass, $row['pass'])) {
                header("Location: index.php?error=Incorect User name or password");
                exit();
            } else if (!($row['username'] === $uname)) {
                header("Location: index.php?error=Incorect User name or password");
                exit();
            } else {
                $_SESSION['user_name'] = $row['username'];
                $_SESSION['id'] = $row['id'];

                $id = intval($_SESSION['id']);
                $sql = "SELECT * FROM ClientInformation WHERE id=$id";
                $result2 = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result2) === 1) {
                    $row2 = mysqli_fetch_assoc($result2);
                    $_SESSION['name'] = $row2['full_name'];
                    
                    if (empty($row2['address2']) || is_null($row2['address2'])) {
                        $fullAddress = $row2['address1'] . ', ' . $row2['city'] . ', ' . $row2['state'] . ' ' . $row2['zipcode'];
                        $_SESSION['full_address'] = $fullAddress;
                    } else {
                        $fullAddress = $row2['address1'] . ' ' . $row2['address2'] . ', ' . $row2['city'] . ', ' . $row2['state'] . ' ' . $row2['zipcode'];
                        $_SESSION['full_address'] = $fullAddress;
                    }
                } else if (mysqli_num_rows($result2) === 0) {
                    header("Location: profileManagement.php");
                    exit();
                } else {
                    header("Location: index.php?error=Incorect User name or password 2");
                    exit();
                }
                header("Location: fuelQuoteForm.php");
                exit();
            }
        } else {
            header("Location: index.php?error=Incorect User name or password");
            exit();
        }
    }
}else{
    header("Location: index.php");
    exit();
}

mysqli_close($conn);