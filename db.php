<?php 
$host = "sql305.infinityfree.com"; 
$user = "if0_42754885"; 
$pass = "CoffeeHeaven08"; 
$dbname = "if0_42754885_coffeeheaven";  

$conn = new mysqli($host, $user, $pass, $dbname); 

if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error); 
} 
?>
