<?php
session_start();
require_once 'user.php';

if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    header("Location: index.php");
    exit;
}

$error = $_SESSION['error'] ?? null;
$success = $_SESSION['success'] ?? null;
unset($_SESSION['error'], $_SESSION['success']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredUsername = $_POST['username'];
    $enteredPassword = $_POST['password'];

    if (empty($enteredUsername) || empty($enteredPassword)){
        $_SESSION['error'] = "Username and password are required.";
        header("Location: create_user.php");
    }
    
    if (strlen($enteredPassword) < 10) {
        $_SESSION['error'] = "Password must be at least 10 characters long.";
        header("Location: create_user.php");
        exit;
    }

       
    $userObject = new User();
    $created = $userObject->create_user($enteredUsername, $enteredPassword);

    if ($created) {
        $_SESSION['success'] = "User created successfully! You can now log in.";
        header("Location: create_user.php");
        exit;
    } else {
        $_SESSION['error'] = "Failed to create user. Username may already exist.";
        header("Location: create_user.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html>
<body>
    <h2>Assignment-2: Create User</h2>
    <?php if ($error): ?>
        <p style="color:red;"><?= $error ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color:green;"><?= $success ?></p>
    <?php endif; ?>

    <form method="POST" action="create_user.php">
        <label>Username: <input type="text" name="username" required></label><br><br>
        <label>Password: <input type="password" name="password" required></label><br><br>
        <input type="submit" value="Create User">
    </form>
    <p><a href="login.php">Back to Login</a></p>
</body>
</html>
