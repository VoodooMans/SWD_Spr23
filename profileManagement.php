<?php
session_start(); 

    if (isset($_SESSION['user_name'])){
        if (isset($_POST['full_name']) && isset($_POST['address1']) && isset($_POST['address2']) && isset($_POST['city']) && isset($_POST['state']) && isset($_POST['zipcode'])) {
            function validate($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        
            $fullName = validate($_POST['full_name']);
            $address1 = validate($_POST['address1']);
            $address2 = validate($_POST['address2']);
            $city = validate($_POST['city']);
            $state = validate($_POST['state']);
            $zipcode = validate($_POST['zipcode']);
            
            if (empty($fullName)) {
                header("Location: profileManagement.php?error=Please enter your name.");
                exit();
            } else if (empty($address1)) {
                header("Location: profileManagement.php?error=Please enter your address.");
                exit();
            } else if (empty($city)) {
                header("Location: profileManagement.php?error=Please enter your city.");
                exit();
            } else if (empty($state)) {
                header("Location: profileManagement.php?error=Please enter your state.");
                exit();
            } else if (empty($zipcode)) {
                header("Location: profileManagement.php?error=Please enter your zipcode.");
                exit();
            } else if (strlen($fullName) > 50) {
                header("Location: profileManagement.php?error=Your name is too long.");
                exit();
            } else if (strlen($address1) > 100 || strlen($address2) > 100) {
                header("Location: profileManagement.php?error=Your address is too long.");
                exit();
            } else if (strlen($city) > 100) {
                header("Location: profileManagement.php?error=Your city is too long.");
                exit();
            } else if (strlen($zipcode) < 5 || strlen($zipcode) > 9) {
                header("Location: profileManagement.php?error=Your zipcode is too short or too long (Between 5 and 9 characters).");
                exit();
            } else {
                $fullAddress = $address1 . ' ' . $address2 . ', ' . $city . ', ' . $state . ' ' . $zipcode;
                $_SESSION['full_address'] = $fullAddress;
                $_SESSION['name'] = $fullName;
                header("Location: fuelQuoteForm.php");
            }
        } 
    } else {
        header("Location: register.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title> Client Profile Management</title>
        <link rel="stylesheet" type="text/css" href="template.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1> Client Profile Management</h1>
                    <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                    <?php } ?>
                    <hr />
                    <p>Please fill out the following form to finish creating your an account.</p>
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Full Name</label>
                            <input type="text" name="full_name" class="form-control" placeholder="Full Name" maxlength = "50" required>
                        </div>    
                        <div class="form-group">
                            <label>Address 1</label>
                            <input type="text" name="address1" class="form-control" placeholder="Address 1" maxlength = "100" required>
                        </div>
                        <div class="form-group">
                            <label>Address 2</label>
                            <input type="text" name="address2" class="form-control" placeholder="Address 2" maxlength = "100">
                        </div>
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" class="form-control" placeholder="City" maxlength = "100" required>
                        </div>
                        <div class="form-group">
                            <label>State</label>
                            <select name = "state" required>
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
                            <input type="text" name="zipcode" class="form-control" placeholder="Zipcode" minlength = "5" maxlength = "9" required>
                        </div>
                        <div class="form-group">
                            <button name = "submit" class="registerbtn">Complete Account</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>    
    </body>
</html>