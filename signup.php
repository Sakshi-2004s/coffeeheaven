<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
include 'db.php';

if (isset($_SESSION['user_id'])) {
    header("Location: menu.html");
    exit();
}

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($password !== $confirm) {

        $error = "Passwords do not match.";

    } else {

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare(
            "INSERT INTO users (username, email, password) VALUES (?, ?, ?)"
        );

        if (!$stmt) {

            $error = "Database error.";

        } else {

            $stmt->bind_param("sss", $username, $email, $hashed);

            if ($stmt->execute()) {

                $_SESSION['user_id'] = $stmt->insert_id;
                $_SESSION['username'] = $username;

                header("Location: login.php");
                exit();

            } else {

                $error = "Registration failed. Username or email may already be taken.";
            }

            $stmt->close();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">

  <title>Sign Up - Coffee Heaven</title>

  <link rel="stylesheet" href="style.css">

  <style>

    body {
      background: url('images/homepage-bg.jpeg') no-repeat center center fixed;
      background-size: cover;
      font-family: Arial, sans-serif;
    }

    .signup-container {
      max-width: 450px;
      margin: 60px auto;
      padding: 30px;
      background-color: rgba(255, 255, 255, 0.95);
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }

    h2 {
      text-align: center;
      color: #6b3e26;
    }

    label {
      font-weight: bold;
    }

    input {
      width: 100%;
      padding: 10px;
      margin: 8px 0 16px;
      border-radius: 6px;
      border: 1px solid #ccc;
      box-sizing: border-box;
    }

    button {
      width: 100%;
      padding: 12px;
      background-color: #6b3e26;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
    }

    button:hover {
      background-color: #5a2f1c;
    }

    .error {
      color: red;
      margin-bottom: 15px;
      text-align: center;
    }

    .success {
      color: green;
      margin-bottom: 15px;
      text-align: center;
    }

    p {
      text-align: center;
    }

    nav {
      text-align: center;
      margin-top: 20px;
    }

    nav a {
      margin: 0 10px;
      color: #f4c542;
      text-decoration: none;
    }

  </style>

</head>

<body>

  <nav class="text-center">

    <a href="index.html" class="text-warning mx-2">
      Home
    </a>

    <a href="menu.html" class="text-warning mx-2">
      Menu
    </a>

    <a href="about.html" class="text-warning mx-2">
      About
    </a>

    <a href="signup.php" class="text-warning mx-2">
      Sign Up
    </a>

    <a href="login.php" class="text-warning mx-2">
      Login
    </a>

  </nav>


  <div class="signup-container">

    <h2>Create Your Account</h2>

    <?php

    if (!empty($error)) {
        echo "<div class='error'>" . htmlspecialchars($error) . "</div>";
    }

    if (isset($_GET['logout']) && isset($_GET['user'])) {

        $logoutUser = htmlspecialchars($_GET['user']);

        echo "<p class='success'>✅ " .
             $logoutUser .
             ", you have been successfully logged out.</p>";
    }

    ?>

    <form method="POST">

      <label>Username:</label>

      <input
        type="text"
        name="username"
        required
      >

      <label>Email:</label>

      <input
        type="email"
        name="email"
        required
      >

      <label>Password:</label>

      <input
        type="password"
        name="password"
        required
      >

      <label>Confirm Password:</label>

      <input
        type="password"
        name="confirm_password"
        required
      >

      <button type="submit">
        Sign Up
      </button>

    </form>

    <p>
      Already have an account?
      <a href="login.php">Login here</a>
    </p>

  </div>

</body>

</html>
