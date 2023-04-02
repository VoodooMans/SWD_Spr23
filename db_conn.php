<?php

$sname= "localhost";
$uname= "root";
$pass = "";
$db_name = "fuel_database";

$conn = mysqli_connect($sname, $uname, $pass, $db_name);

if (!$conn) {
    die("Error: connection error. " . mysqli_connect_error());
}

