<?php
    session_start(); 
    require_once('db_conn.php');
    require_once('pricing_module.php'); 

    //$q = $_REQUEST["q"]; test
    $gallons = $_GET['gallons'];
    $output = $_GET['output'];
    
    $sql = "SELECT * FROM ClientInformation WHERE id={$_SESSION['id']}";
    $result2 = mysqli_query($conn, $sql);
    $row2 = mysqli_fetch_assoc($result2);
    $state = $row2['state'];

    $calculate = new pricing_module();
    $calculate->marginCalculator($state, $_SESSION['id'], $gallons);
    $pricePerGallon = $calculate->getSuggestedPrice();
    $totalPrice = $calculate->getTotalPrice($gallons);

    $pricePerGallon = sprintf("%0.2f", round($pricePerGallon, 2));
    $totalPrice = sprintf("%0.2f", round($totalPrice, 2));

    if ($output == "PPG") {
        echo $gallons === "" ? "No price suggestion" : $pricePerGallon;
    } else {
        echo $gallons === "" ? "No total price suggestion" : $totalPrice;
    }

    mysqli_close($conn);
?>

