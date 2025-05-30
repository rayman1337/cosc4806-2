<?php
session_start();
require_once 'globals.php';

if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUser = $_POST['username'];
    $inputPass = $_POST['password'];

    if (!isset($_SESSION['failed_login_Attempts'])) {
        $_SESSION['failed_login_Attempts'] = 0;
    }

    if ($inputUser === Globals::$username && $inputPass === Globals::$password) {
        $_SESSION['authenticated'] = true;
        $_SESSION['username'] = $inputUser;
        header("Location: index.php");
        exit;
    } else {
        $_SESSION['failed_login_Attempts']++;
        $_SESSION['error'] = "Login failed. Attempt #" . $_SESSION['failed_login_Attempts'];
        header("Location: login.php");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
