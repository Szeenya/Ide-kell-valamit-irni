<?php
session_start();
if (isset($_POST['logout'])) {
    session_destroy();
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-42000, '/');
    }
    header("Location: index.php");
    exit();
}
require_once 'config/config.php';
require_once 'controllers/UserController.php';

$userController = new UserController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $error = $userController->login($_POST['email'], $_POST['password']);
    } elseif (isset($_POST['register'])) {
        $errors = $userController->register(
            $_POST['username'],
            $_POST['email'],
            $_POST['password'],
            $_POST['confirm_password']
        );
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="src/style/login_style.css">
    
</head>
<body>
    <div class="container">
        <!-- Login Form -->
        <div class="login-form">
            <h2>Login</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" name="login">Login</button>
            </form>
        </div>

        <!-- Register Form -->
        <div class="register-form">
            <h2>Register</h2>
            <form action="" method="POST">
                <div class="form-group">
                    <label for="reg-username">Username:</label>
                    <input type="text" id="reg-username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="reg-email">Email:</label>
                    <input type="email" id="reg-email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="reg-password">Password:</label>
                    <input type="password" id="reg-password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="reg-confirm-password">Confirm Password:</label>
                    <input type="password" id="reg-confirm-password" name="confirm_password" required>
                </div>
                <button type="submit" name="register">Register</button>
            </form>
        </div>
    </div>
</body>
</html>