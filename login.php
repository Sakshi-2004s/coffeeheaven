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
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result && password_verify($password, $result['password'])) {
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['username'] = $result['username'];

        
        if (isset($_SESSION['redirect_after_login'])) {
            $redirect = $_SESSION['redirect_after_login'];
            unset($_SESSION['redirect_after_login']);
            header("Location: $redirect");
        } else {
            header("Location: menu.html");
        }
        exit();
    } else {
        $error = " Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login - Coffee Heaven</title>
  <link rel="stylesheet" href="style.css">
  <style>
    body {
      background: url('images/homepage-bg.jpeg') no-repeat center center fixed;
      background-size: cover;
      font-family: Arial, sans-serif;
    }
    .login-container {
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
      <a href="index.html" class="text-warning mx-2">Home</a>
      <a href="menu.html" class="text-warning mx-2">Menu</a>
      <a href="about.html" class="text-warning mx-2">About</a>
       <a href="signup.php" class="text-warning mx-2">Sign Up</a>
      <a href="login.php" class="text-warning mx-2">Login</a>
    </nav>

  <div class="login-container">
    <h2>Login to Your Account</h2>

    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>

    <form method="POST">
      <label>Username:</label>
      <input type="text" name="username" required>

      <label>Password:</label>
      <input type="password" name="password" required>

      <button type="submit">Login</button>
    </form>

    <p style="text-align:center;">Don't have an account? <a href="signup.php">Sign up</a></p>
  </div>
</body>
</html>
SHINDE SWARAJ JAGANNATH SHINDE KJBJFSDFBJ