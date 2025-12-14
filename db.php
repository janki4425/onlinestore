<?php
$servername = "localhost";
$username   = "root";      
$pwd        = "";          
$dbname     = "onlineshopdb";      

$conn = mysqli_connect($servername, $username, $pwd, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>