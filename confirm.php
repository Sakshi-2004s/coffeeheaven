<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$product = isset($_POST['product']) ? trim($_POST['product']) : '';
$price = isset($_POST['price']) ? (float) $_POST['price'] : 0;
$quantity = isset($_POST['quantity']) ? (int) $_POST['quantity'] : 0;
$image = isset($_POST['image']) ? trim($_POST['image']) : '';

$total = $price * $quantity;

if ($product === '' || $price <= 0 || $quantity <= 0) {
    die("Invalid order details.");
}

$stmt = $conn->prepare(
    "INSERT INTO orders (user_id, product, price, quantity, total, image)
     VALUES (?, ?, ?, ?, ?, ?)"
);

if (!$stmt) {
    die("Database error. Please try again.");
}

$stmt->bind_param(
    "isdiis",
    $user_id,
    $product,
    $price,
    $quantity,
    $total,
    $image
);

if (!$stmt->execute()) {
    die("Order could not be confirmed. Please try again.");
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">

  <title>Order Confirmed - Coffee Heaven</title>

  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >

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
      width: 100%;
      max-width: 400px;
      height: 250px;
      object-fit: cover;
      border-radius: 10px;
      margin-bottom: 20px;
    }

    body {
      background: url('homepage-bg.jpeg') no-repeat center center fixed;
      background-size: cover;
      font-family: Arial, sans-serif;
      color: #333;
    }

  </style>

</head>

<body>

  <div class="confirm-container">

    <h2 class="text-success mb-4">
      Your Order is Confirmed!
    </h2>

    <h4>
      <?php echo htmlspecialchars($product); ?>
    </h4>

    <?php if ($image !== ''): ?>

      <img
        src="<?php echo htmlspecialchars($image); ?>"
        alt="<?php echo htmlspecialchars($product); ?>"
      >

    <?php endif; ?>

    <p>
      Quantity:
      <strong><?php echo $quantity; ?></strong>
    </p>

    <p>
      Price per item:
      ₹<?php echo number_format($price, 2); ?>
    </p>

    <p>
      <strong>
        Total: ₹<?php echo number_format($total, 2); ?>
      </strong>
    </p>

    <a
      href="menu.html"
      class="btn btn-dark mt-4"
    >
      Back to Menu
    </a>

    <a
      href="logout.php"
      class="btn btn-dark mt-4"
    >
      Logout
    </a>

  </div>

</body>

</html>
