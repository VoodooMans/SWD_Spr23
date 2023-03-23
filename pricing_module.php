<?php
class pricingModule {

  private $nGallons; // number of gallons requested
  private $margin; // margin value
  private $currentPrice = 1.50; //  current price . Assignment says can hard code to $1.50
  private $suggestedPrice; // suggested price per gallon = currentPrice + margin 
  private $rateHistoryFactor; // bool value that says if the client is an existing customer
  private $totalPrice; // total price


  /* Functions below */

  function suggestedPrice (){ 
    $this->suggestedPrice = $this->currentPrice + $this->margin;  // sets the value of suggested price
    }
  function marginCalculator(/* Put needed arguments*/ ){ /*Calculate and set private variable margin */}
}

?>