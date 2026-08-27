<?php

session_start();

$product = $_GET['product'] ?? '';
$price = $_GET['price'] ?? '';
$image = $_GET['image'] ?? '';

$orderParams =
    "product=" . urlencode($product) .
    "&price=" . urlencode($price) .
    "&image=" . urlencode($image);

if (isset($_SESSION['user_id'])) {

    header("Location: order.php?$orderParams");
    exit();

} else {

    header("Location: signup.php");
    exit();

}

?>
