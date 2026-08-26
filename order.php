<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
  header("Location: signup.php");
  exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Coffee - Coffee Heaven</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .order-container {
      max-width: 700px;
      margin: 50px auto;
      background: #fdfdfd;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .coffee-image {
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

    header h1 {
      font-size: 2rem;
    }
  </style>
</head>
<body>
  <header class="bg-dark text-white text-center py-3">
    <h1>Place Your Order</h1>
  </header>

  <main class="container">
    <div class="order-container text-center">
      <h2 id="product-name"></h2>
      <img id="product-image" class="coffee-image" src="" alt="Coffee Image">
      <p id="product-price" class="lead"></p>

      <form action="confirm.php" method="POST">
        <input type="hidden" name="product" id="product-input">
        <input type="hidden" name="price" id="price-input">
        <input type="hidden" name="image" id="image-input">

        <label for="quantity" class="form-label">Quantity:</label>
        <input type="number" name="quantity" id="quantity" class="form-control mb-3" value="1" min="1" required>

        <button type="submit" class="btn btn-dark">Confirm Order</button>
      </form>
    </div>
  </main>

  <script>
    const params = new URLSearchParams(window.location.search);
    const product = params.get('product');
    const price = params.get('price');
    const image = params.get('image');

    document.getElementById('product-name').textContent = product;
    document.getElementById('product-price').textContent = `Price: ₹${price}`;
    document.getElementById('product-image').src = `images/${image}`;
    document.getElementById('product-image').alt = product;

    document.getElementById('product-input').value = product;
    document.getElementById('price-input').value = price;
    document.getElementById('image-input').value = image;
  </script>
</body>
</html> 