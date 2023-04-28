<?php
session_start(); 
require_once('db_conn.php');
require_once('pricing_module.php'); 

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
            } else if($deliveryDate < "2023-04-28") {
                header("Location: fuelQuoteForm.php?error=Please select a valid delivery date that is after this date.");
                exit();            
            } else if ($gallonsRequested > 100000) { 
                header("Location: fuelQuoteForm.php?error=Too many gallons requested, request less than 10,000 gallons.");
                exit();
            } else {
                $sql = "SELECT * FROM ClientInformation WHERE id={$_SESSION['id']}";
                $result2 = mysqli_query($conn, $sql);
                $row2 = mysqli_fetch_assoc($result2);
                $state = $row2['state'];

                $calculate = new pricing_module();
                $calculate->marginCalculator($state, $_SESSION['id'], $gallonsRequested);
                $pricePerGallon = $calculate->getSuggestedPrice();
                $total = $calculate->getTotalPrice($gallonsRequested);

                $pricePerGallon = sprintf("%0.2f", round($pricePerGallon, 2));
                $total = sprintf("%0.2f", round($total, 2));
                
                $sql = "INSERT INTO FuelQuote (accountID, gallons_requested, delivery_date, delivery_address, price_per_gallon, total_due) VALUES (?, ?, ?, ?, ?, ?)";
                if($stmt = mysqli_prepare($conn, $sql)) {
                    mysqli_stmt_bind_param($stmt, "iissdd", $account_id, $param_gallonsRequested, $param_deliveryDate, $param_address, $param_suggestedPPG, $param_totalPrice);

                    $account_id = $_SESSION['id'];
                    $param_gallonsRequested = $gallonsRequested;
                    $param_deliveryDate = $deliveryDate;
                    $param_address = $_SESSION['full_address'];
                    $param_suggestedPPG = $pricePerGallon;
                    $param_totalPrice = $total;

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
        <script language = "javascript" type = "text/javascript">
            function displaySuggestedPrice(outputID) {
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById(outputID).innerHTML = this.responseText;
                    }
                };
                var gallons = document.getElementById('gallons').value;

                if (outputID == "suggestedPPG") {
                    var queryString = "?gallons=" + gallons + "&output=PPG"; 
                } else {
                    var queryString = "?gallons=" + gallons + "&output=NotPPG"; 
                }

                xmlhttp.open("GET", "priceCalculation.php" + queryString, true);
                xmlhttp.send();
            }

            function revealButton() {
                document.getElementById('buyFuel').disabled = false;
            }

            function disableButton() {
                document.getElementById('buyFuel').disabled = true;
            }

            function checkEmpty() {
                if(document.getElementById("gallons").value==="") { 
                    document.getElementById('quoteButton').disabled = true; 
                } else { 
                    document.getElementById('quoteButton').disabled = false;
                }
            }
        </script>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1>Fuel Quote Form</h1>
                    <p style="text-align:left;">Hello, <?php echo $_SESSION['name']; ?>! Please fill out the following form to receive your fuel quote.<span style="float:right;">Incorrect profile information? <a href="editProfile.php">Edit Profile</a></span></p>
                    <hr />
                    <?php if (isset($_GET['error'])) { ?>
                    <p class="error"><?php echo $_GET['error']; ?></p>
                    <?php } ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Gallons Requested</label>
                            <input type="number" max = "100000" id="gallons" name="gallons_requested" class="form-control" onkeyup="disableButton(); checkEmpty();" placeholder="Gallons Requested" required>
                        </div>
                        <div class="form-group">
                            <input type = 'button' id="quoteButton" class="registerbtn" onclick = 'displaySuggestedPrice("suggestedPPG"); displaySuggestedPrice("totalPrice"); revealButton();' value = 'Get Quote' disabled>
                        </div> 
                        <div class="form-group">
                            <p>Suggested Price Per Gallon: $<span style="background-color:#f5f5f5;" class="form-control" id="suggestedPPG"></span></p> 
                        </div>
                        <div class="form-group">
                            <p>Total Price: $<span style="background-color:#f5f5f5;" class="form-control" id="totalPrice"></span></p> 
                        </div>  
                        <div class="form-group">
                            <fieldset>
                                <legend>Delivery Date</legend>
                                <label for="my-date-picker">
                                    <input id="my-date-picker" type = "date" name = "delivery_date" onkeydown="return false" min = "2023-04-28" value = "" required>
                                 </label>
                            </fieldset>
                            <br>
                        </div>
                        <div class="form-group">
                            <label>Delivery Address</label>
                            <input type="text" name="delivery_address" class="form-control" value="<?php echo htmlspecialchars($_SESSION['full_address']) ?>" placeholder="Delivery Address" readonly="readonly">
                        </div>   
                        <div class="form-group">
                            <button name = "complete_form" id="buyFuel" class="registerbtn" disabled>Complete Fuel Quote Form</button>
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
                                
                                //$id = intval($_SESSION['id']);
                                //$sql = "SELECT * FROM FuelQuote WHERE accountID='$id'";
                                $sql = "SELECT * FROM FuelQuote WHERE accountID={$_SESSION['id']}";
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
                        <div class="login">
                        <p>Finished requesting fuel? <a href="logout.php">Logout</a></p>
                </div>
            </div>
        </div>    
    </body>
</html>