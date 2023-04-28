<?php
//require_once('db_conn.php');

//namespace Price;

class pricing_module {
    private $gallonsRequestedFactor = 0.03; // number of gallons requested
    private $margin; // margin value
    private $currentPrice = 1.50; //  current price . Assignment says can hard code to $1.50
    private $suggestedPrice = 0; // suggested price per gallon = currentPrice + margin 
    private $rateHistoryFactor = 0; //default is 0%, client gets 1% discount if they have requested fuel before
    private $totalPrice; //total price
    private $companyProfitMargin = 0.10; //company profit margin is always 10%
    private $locationFactor = 0.04; //default location factor to 4%, changes to 2% if client is in Texas
    //private $conn = mysqli_connect("localhost", "root", "", "fuel_database");

    /* Functions below */
    public function marginCalculator($state, $accountID, $gallonsRequested) { /*Calculate and set private variable margin */
        //require_once('db_conn.php');
        if ($state == "TX") {
            $this->locationFactor = 0.02;
        } 

        $conn = mysqli_connect("localhost", "root", "", "fuel_database");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        $sql = "SELECT * FROM FuelQuote WHERE accountID='$accountID'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) >= 1) {
            $this->rateHistoryFactor = 0.01;
        }
        mysqli_close($conn);

        if ($gallonsRequested > 1000) {
            $this->gallonsRequestedFactor = 0.02;
        }
        
        $this->margin = $this->currentPrice * ($this->locationFactor - $this->rateHistoryFactor + $this->gallonsRequestedFactor + $this->companyProfitMargin);
    }

    public function getSuggestedPrice () { 
        $this->suggestedPrice = $this->currentPrice + $this->margin;  // sets the value of suggested price per gallon
        return $this->suggestedPrice;
    }

    public function getTotalPrice ($gallonsRequested) {
        $this->totalPrice = $gallonsRequested * $this->suggestedPrice;
        return $this->totalPrice; 
    }
}
?>
