<?php

include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $coffee = trim($_POST['coffee_type'] ?? '');
    $qty = (int)($_POST['quantity'] ?? 0);

    if ($name === '' || $email === '' || $coffee === '' || $qty <= 0) {
        die("Please enter valid order details.");
    }

    $stmt = $conn->prepare(
        "INSERT INTO orders (name, email, coffee_type, quantity)
         VALUES (?, ?, ?, ?)"
    );

    if (!$stmt) {
        die("Unable to process your order.");
    }

    $stmt->bind_param(
        "sssi",
        $name,
        $email,
        $coffee,
        $qty
    );

    if ($stmt->execute()) {

        $stmt->close();

        header("Location: thankyou.html");
        exit();

    } else {

        $stmt->close();

        die("Unable to place the order. Please try again.");
    }

} else {

    header("Location: index.html");
    exit();

}

?>
