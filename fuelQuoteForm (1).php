<?php
session_start(); 
require_once('db_conn.php');

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
                header("Location: fuelQuoteForm.php?error=Please request an amount of gallons.");
                exit();
            } else if (empty($deliveryDate)) {
                header("Location: fuelQuoteForm.php?error=Please select a delivery date.");
                exit();
            } else if (!is_numeric($gallonsRequested)) {
                header("Location: fuelQuoteForm.php?error=Please request a numeric value for gallons.");
                exit();
            } else if ($gallonsRequested > 10000) { 
                header("Location: fuelQuoteForm.php?error=Too many gallons requested, request less than 10,000 gallons.");
                exit();
            } else {
                $sql = "INSERT INTO FuelQuote (accountID, gallons_requested, delivery_date, delivery_address, price_per_gallon, total_due) VALUES (?, ?, ?, ?, ?, ?)";
                if($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "iissii", $account_id, $param_gallonsRequested, $param_deliveryDate, $param_address, $hardcodedPrice, $hardcodedPrice);

                    $account_id = intval($_SESSION['id']);
                    $param_gallonsRequested = $gallonsRequested;
                    $param_deliveryDate = $deliveryDate;
                    $param_address = $_SESSION['full_address'];
                    $hardcodedPrice = $gallonsRequested;

                    if(mysqli_stmt_execute($stmt)) {
                        header("Location: fuelQuoteForm.php?error=Fuel Requested! Fill out the form to request more, or log out below.");
                        exit();
                    } else {
                        header("Location: fuelQuoteForm.php?error=Oops! Something went wrong. Please try again later.");
                        exit();
                    }
                } else {
                    header("Location: fuelQuoteForm.php?error=Database connection error, please try again.");
                    exit();
                }
            }
        }
    } else {
        header("Location: profileManagement.php");
        exit();
    }

    mysqli_close($conn);
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
                    <p>Hello, <?php echo $_SESSION['name']; ?>! Please fill out the following form to receive your fuel quote.</p>
                    <hr />
                    <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                    <?php } ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Gallons Requested</label>
                            <input type="number" max = "10000" name="gallons_requested" class="form-control" placeholder="Gallons Requested" required>
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
                            <label>Total Amount Due</label>
                            <input type="number" name="total_due" class="form-control" placeholder="Gallons * Price" readonly="readonly">
                        </div> 
                        <div class="form-group">
                            <button name = "complete_form" class="registerbtn">Complete Fuel Quote Form</button>
                        </div>
                    </form>
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
                                    <th>Delivery Date</th>
                                    <th>Delivery Address</th>
                                    <th>Suggested Price Per Gallon</th>
                                    <th>Total Amount Due</th> 
                                </tr>

                                <?php
                                $conn2 = mysqli_connect("localhost", "root", "", "fuel_database");
                                if ($conn2->connect_error) {
                                    die("Connection failed: " . $conn2->connect_error);
                                }
                                
                                $id = intval($_SESSION['id']);
                                $sql = "SELECT * FROM FuelQuote WHERE accountID='$id'";
                                $result = mysqli_query($conn2, $sql);
                                $count = 1;

                                if (mysqli_num_rows($result) > 0) {
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo "<tr><td>" . 'Client Quote #' . $count . "</td><td>" . $row['gallons_requested'] . "</td><td>" .
                                        $row['delivery_date'] . "</td><td>" . $row['delivery_address'] . "</td><td>" . $row['price_per_gallon'] . 
                                        "</td><td>" . $row['total_due'] . "</td></tr>";  
                                        $count++;
                                    }
                                    echo "</table>";
                                } else {
                                    echo "No results";    
                                }

                                mysqli_close($conn2);
                                ?>
                            </table>  
                            <br> 
                            <a href="logout.php">Logout</a>
                        <br>
                </div>
            </div>
        </div>    
    </body>
</html>