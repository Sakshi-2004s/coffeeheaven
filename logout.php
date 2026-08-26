<?php
session_start();

$username = $_SESSION['username'] ?? '';
session_unset();
session_destroy();
header("Location: signup.php?logout=1&user=" . urlencode($username));
exit();
