<?php
session_start();
require_once '../classes/database.php';
require_once '../classes/user.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Basic validation
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "All fields are required";
        header("Location: pages/login.php");
        exit();
    }

    $user = new User();
    if ($user->Login($email, $password)) {
        header("Location: pages/user_page.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid email or password";
        header("Location: pages/login.php");
        exit();
    }
}
