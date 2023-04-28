<?php
session_start(); 
require_once('db_conn.php');  
    
    if (isset($_SESSION['id'])) {
        function validate($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }

        $updatedItems = "";
        $anyChanges = FALSE;

        if (isset($_POST['new_full_name'])) { 
            $updatedFullName = validate($_POST['new_full_name']);
            if (!empty($updatedFullName)) {
                if (strlen($updatedFullName) <= 50) {
                    $sql = "UPDATE ClientInformation SET full_name = '$updatedFullName' WHERE id={$_SESSION['id']}";
                    if ($conn->query($sql) === TRUE) {
                        $updatedItems .= "Full Name; ";
                        $anyChanges = TRUE;
                    } else {
                        header("Location: editProfile.php?error=Error updating record.");
                        exit();
                    }
                } else {
                    header("Location: editProfile.php?error=Your name is too long.");
                    exit();
                }
            }
        }
        
        if (isset($_POST['new_address1'])) {
            $updatedAddress1 = validate($_POST['new_address1']);
            if (!empty($updatedAddress1)) {
                if (strlen($updatedAddress1) <= 100) {
                    $sql = "UPDATE ClientInformation SET address1 = '$updatedAddress1' WHERE id={$_SESSION['id']}";
                    if ($conn->query($sql) === TRUE) {
                        $updatedItems .= "Address 1; ";
                        $anyChanges = TRUE;
                    } else {
                        header("Location: editProfile.php?error=Error updating record.");
                        exit();
                    }
                } else {
                    header("Location: editProfile.php?error=Your address 1 is too long.");
                    exit();
                }
            }
        }

        if (isset($_POST['new_address2'])) {
            $updatedAddress2 = validate($_POST['new_address2']);
            if (!empty($updatedAddress2)) {
                if (strlen($updatedAddress2) <= 100) {
                    $sql = "UPDATE ClientInformation SET address2 = '$updatedAddress2' WHERE id={$_SESSION['id']}";
                    if ($conn->query($sql) === TRUE) {
                        $updatedItems .= "Address 2; ";
                        $anyChanges = TRUE;
                    } else {
                        header("Location: editProfile.php?error=Error updating record.");
                        exit();
                    }
                } else {
                    header("Location: editProfile.php?error=Your address 2 is too long.");
                    exit();
                }
            }
        }

        if (isset($_POST['new_city'])) {
            $updatedCity = validate($_POST['new_city']);
            if (!empty($updatedCity)) {
                if (strlen($updatedCity) <= 100) {
                    $sql = "UPDATE ClientInformation SET city = '$updatedCity' WHERE id={$_SESSION['id']}";
                    if ($conn->query($sql) === TRUE) {
                        $updatedItems .= "City; ";
                        $anyChanges = TRUE;
                    } else {
                        header("Location: editProfile.php?error=Error updating record.");
                        exit();
                    }
                } else {
                    header("Location: editProfile.php?error=Your city is too long.");
                    exit();
                }
            }
        }

        if (isset($_POST['new_state'])) {
            $updatedState = validate($_POST['new_state']);
            if (!empty($updatedState)) {
                $sql = "UPDATE ClientInformation SET state = '$updatedState' WHERE id={$_SESSION['id']}";
                if ($conn->query($sql) === TRUE) {
                    $updatedItems .= "State; ";
                    $anyChanges = TRUE;
                } else {
                    header("Location: editProfile.php?error=Error updating record.");
                    exit();
                }
            }
        }

        if (isset($_POST['new_zipcode'])) {
            $updatedZipcode = validate($_POST['new_zipcode']);
            if (!empty($updatedZipcode)) {
                if (!(strlen($updatedZipcode) < 5 || strlen($updatedZipcode) > 9)) {
                    $sql = "UPDATE ClientInformation SET zipcode = '$updatedZipcode' WHERE id={$_SESSION['id']}";
                    if ($conn->query($sql) === TRUE) {
                        $updatedItems .= "Zipcode; ";
                        $anyChanges = TRUE;
                    } else {
                        header("Location: editProfile.php?error=Error updating record.");
                        exit();
                    }
                } else {
                    header("Location: editProfile.php?error=Your zipcode is too long or too short (5 - 9 characters).");
                    exit();
                }
            }
        }

        if ($anyChanges === TRUE) {
            $sql = "SELECT * FROM ClientInformation WHERE id={$_SESSION['id']}";
            $result = $conn->query($sql);

            if ($result->num_rows === 1) {
                $row = $result->fetch_assoc();
                $_SESSION['name'] = $row['full_name'];
                    
                if (empty($row['address2']) || is_null($row['address2'])) {
                    $fullAddress = $row['address1'] . ', ' . $row['city'] . ', ' . $row['state'] . ' ' . $row['zipcode'];
                    $_SESSION['full_address'] = $fullAddress;
                } else {
                    $fullAddress = $row['address1'] . ' ' . $row['address2'] . ', ' . $row['city'] . ', ' . $row['state'] . ' ' . $row['zipcode'];
                    $_SESSION['full_address'] = $fullAddress;
                }
            }    
            
            header("Location: editProfile.php?error=The following fields were successfully updated: $updatedItems Fill out the form again to update your infomation, or return to the fuel quote form below.");
            exit();
        }
    } else {
        header("Location: index.php?error=You are not logged in.");
        exit();
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Update Client Profile</title>
        <link rel="stylesheet" type="text/css" href="template.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Update Client Profile</h1>
                    <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                    <?php } ?>
                    <hr />
                    <p>Please fill out the following form to update your relevant account information. </p>
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="new_full_name" class="form-control" placeholder="Full Name" maxlength = "50">
                        </div>    
                        <div class="form-group">
                            <label>Address 1</label>
                            <input type="text" name="new_address1" class="form-control" placeholder="Address 1" maxlength = "100">
                        </div>
                        <div class="form-group">
                            <label>Address 2</label>
                            <input type="text" name="new_address2" class="form-control" placeholder="Address 2" maxlength = "100">
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="new_city" class="form-control" placeholder="City" maxlength = "100">
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <select name = "new_state">
                                <option value="" disabled selected hidden>Choose your state</option>
                                <option value="AL">Alabama</option>
                                <option value="AK">Alaska</option>
                                <option value="AZ">Arizona</option>
                                <option value="AR">Arkansas</option>
                                <option value="CA">California</option>
                                <option value="CO">Colorado</option>
                                <option value="CT">Connecticut</option>
                                <option value="DE">Delaware</option>
                                <option value="DC">District Of Columbia</option>
                                <option value="FL">Florida</option>
                                <option value="GA">Georgia</option>
                                <option value="HI">Hawaii</option>
                                <option value="ID">Idaho</option>
                                <option value="IL">Illinois</option>
                                <option value="IN">Indiana</option>
                                <option value="IA">Iowa</option>
                                <option value="KS">Kansas</option>
                                <option value="KY">Kentucky</option>
                                <option value="LA">Louisiana</option>
                                <option value="ME">Maine</option>
                                <option value="MD">Maryland</option>
                                <option value="MA">Massachusetts</option>
                                <option value="MI">Michigan</option>
                                <option value="MN">Minnesota</option>
                                <option value="MS">Mississippi</option>
                                <option value="MO">Missouri</option>
                                <option value="MT">Montana</option>
                                <option value="NE">Nebraska</option>
                                <option value="NV">Nevada</option>
                                <option value="NH">New Hampshire</option>
                                <option value="NJ">New Jersey</option>
                                <option value="NM">New Mexico</option>
                                <option value="NY">New York</option>
                                <option value="NC">North Carolina</option>
                                <option value="ND">North Dakota</option>
                                <option value="OH">Ohio</option>
                                <option value="OK">Oklahoma</option>
                                <option value="OR">Oregon</option>
                                <option value="PA">Pennsylvania</option>
                                <option value="RI">Rhode Island</option>
                                <option value="SC">South Carolina</option>
                                <option value="SD">South Dakota</option>
                                <option value="TN">Tennessee</option>
                                <option value="TX">Texas</option>
                                <option value="UT">Utah</option>
                                <option value="VT">Vermont</option>
                                <option value="VA">Virginia</option>
                                <option value="WA">Washington</option>
                                <option value="WV">West Virginia</option>
                                <option value="WI">Wisconsin</option>
                                <option value="WY">Wyoming</option>
                            </select>    
                            <br> <br>
                        </div>
                        <div class="form-group">
                            <label>Zipcode</label>
                            <input type="text" name="new_zipcode" class="form-control" placeholder="Zipcode" minlength = "5" maxlength = "9">
                        </div>
                        <div class="form-group">
                            <button name = "submit" class="registerbtn">Update Account Information</button>
                        </div>
                        <div class="login">
                        <p>Finished editing your profile? <a href="fuelQuoteForm.php">Return to fuel quote form</a></p>
                    </form>
                </div>
            </div>
        </div>    
    </body>
</html>