<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $coffee = $_POST['coffee_type'];
  $qty = (int)$_POST['quantity'];

  $stmt = $conn->prepare("INSERT INTO orders (name, email, coffee_type, quantity) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("sssi", $name, $email, $coffee, $qty);

  if ($stmt->execute()) {
    header("Location: thankyou.html");
    exit();
  } else {
    echo "Error placing order: " . $conn->error;
  }
}
?>
