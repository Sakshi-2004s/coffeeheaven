<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$product = $_POST['product'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];
$total = $price * $quantity;
$image = $_POST['image'];

$stmt = $conn->prepare("INSERT INTO orders (user_id, product, price, quantity, total, image) VALUES (?, ?, ?, ?, ?, ?)");

if (!$stmt) {
    die("Prepare failed: " . $conn->error); 

$stmt->bind_param("isdiis", $user_id, $product, $price, $quantity, $total, $image);
$stmt->execute();
$stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Confirmed - Coffee Heaven</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .confirm-container {
      max-width: 600px;
      margin: 60px auto;
      text-align: center;
      background-color: #fffdf8;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 0 12px rgba(0,0,0,0.15);
    }
    .confirm-container img {
      max-width: 100%;
      border-radius: 10px;
      margin-bottom: 20px;
    }
    body {
      background: url('images/homepage-bg.jpeg') no-repeat center center fixed;
      background-size: cover;
      font-family: Arial, sans-serif;
      color: #333;
    }
  </style>
</head>
<body>
  <div class="confirm-container">
    <h2 class="text-success mb-4"> Your Order is Confirmed!</h2>
    <h4><?php echo $product; ?></h4>
    <img src="images/<?php echo $image; ?>" alt="<?php echo $product; ?>">
    <p>Quantity: <strong><?php echo $quantity; ?></strong></p>
    <p>Price per item: ₹<?php echo $price; ?></p>
    <p><strong>Total: ₹<?php echo $total; ?></strong></p>

    <a href="menu.html" class="btn btn-dark mt-4">Back to Menu</a>
    <a href="logout.php" class="btn btn-dark mt-4">Logout</a>

  </div>
</body>
</html>
  