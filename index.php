<?php
session_start();

if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
$date = date("l, F j, Y - g:i A");
?>

<!DOCTYPE html>
<html>
<body>
    <h2>Welcome, <?= $username ?>!</h2>
    <p>Logged in at <?= $date ?></p>
    <a href="logout.php">Logout</a>
</body>
</html>
