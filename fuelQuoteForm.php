<?php
session_start(); 

    if (isset($_SESSION['name']) && isset($_SESSION['full_address']) && isset($_SESSION['id'])) {
        if (isset($_POST['gallons_requested']) && isset($_POST['delivery_date'])) {
            function validate($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        
            $gallonsRequested = validate($_POST['gallons_requested']);
            $deliveryDate = validate($_POST['delivery_date']);
            
            if (empty($gallonsRequested)) {
                header("Location: index.php?error=Please request an amount of gallons.");
                exit();
            } else if (empty($deliveryDate)) {
                header("Location: index.php?error=Please select a delivery date.");
                exit();
            } else {
                header("Location: logout.php");
            }
        }
    } else {
        header("Location: profileManagement.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Fuel Quote Form</title>
        <link rel="stylesheet" type="text/css" href="template.css">
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Fuel Quote Form</h1>
                    <p>Hello, <?php echo $_SESSION['name']; ?>!</p>
                    <hr />
                    <p>Please fill out the following form to receive your fuel quote.</p>
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Gallons Requested</label>
                            <input type="number" name="gallons_requested" class="form-control" placeholder="Gallons Requested" required>
                        </div>    
                        <div class="form-group">
                            <fieldset>
                                <legend>Delivery Date</legend>
                                <label for="my-date-picker"> Date:
                                    <input id="my-date-picker" type = "date" name = "delivery_date" onkeydown="return false" min = "2023-03-21" value = "" required>
                                 </label>
                            </fieldset>
                            <br>
                        </div>
                        <div class="form-group">
                            <label>Delivery Address</label>
                            <input type="text" name="delivery_address" class="form-control" value="<?php echo htmlspecialchars($_SESSION['full_address']) ?>" placeholder="Delivery Address" readonly="readonly">
                        </div>
                        <div class="form-group">
                            <label>Suggested Price Per Gallon</label>
                            <input type="number" name="suggested_price" class="form-control" placeholder="Suggested Price Per Gallon" readonly="readonly">
                        </div>
                        <div class="form-group">
                            <label>Total Amount Duen</label>
                            <input type="number" name="total_due" class="form-control" placeholder="Gallons * Price" readonly="readonly">
                        </div> 
                        <div class="form-group">
                            <button name = "complete_form" class="registerbtn">Complete Fuel Quote Form</button>
                        </div>
                        <br>
                        <h2>Client Quote History</h2>
                            <style>
                                table, th, td {
                                border: 1px solid black;
                                border-collapse: collapse;
                                }
                            </style>
                            <table style="width:100%">
                                <tr>
                                    <th></th>
                                    <th>Gallons Requested</th> 
                                    <th>Delivery Address</th>
                                    <th>Delivery Date</th>
                                    <th>Suggested Price Per Gallon</th>
                                    <th>Total Amount Due</th> 
                                </tr>
                                <tr>
                                    <td>Client Quote #1</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Client Quote #2</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </table>  
                            <br> <br>
                            <a href="logout.php">Logout</a>
                            <br>
                    </form>
                </div>
            </div>
        </div>    
    </body>
</html>