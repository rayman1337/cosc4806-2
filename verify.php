<?php
session_start();
require_once 'user.php';

$userObject = new User();

if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enteredUsername = trim($_POST['username']);
    $enteredPassword = trim($_POST['password']);

    if (!isset($_SESSION['failed_login_attempts'])) {
        $_SESSION['failed_login_attempts'] = 0;
    }

    $databaseConnection = db_connect();

    if (!$databaseConnection) {
        $_SESSION['error'] = "Could not connect to the database.";
        header("Location: login.php");
        exit;
    }

    try {
        $sql = "SELECT * FROM users WHERE username = ?";
        $statement = $databaseConnection->prepare($sql);
        $statement->execute([$enteredUsername]);
        $userRow = $statement->fetch(PDO::FETCH_ASSOC);

        if ($userRow) {
            $hashedPasswordFromDB = $userRow['password'];
            if (password_verify($enteredPassword, $hashedPasswordFromDB)) {
                $_SESSION['authenticated'] = true;
                $_SESSION['username'] = $enteredUsername;
                header("Location: index.php");
                exit;
            }
        }

        $_SESSION['failed_login_attempts'] += 1;
        $_SESSION['error'] = "Login failed. Attempt #" . $_SESSION['failed_login_attempts'];
        header("Location: login.php");
        exit;

    } catch (PDOException $exception) {
        error_log("Login error: " . $exception->getMessage());
        $_SESSION['error'] = "An unexpected error occurred.";
        header("Location: login.php");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>
