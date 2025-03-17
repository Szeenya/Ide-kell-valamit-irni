<?php
session_start();
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
    <style>
        .container {
            display: flex;
            justify-content: space-around;
            padding: 20px;
        }

        .login-form, .register-form {
            width: 300px;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
        }
    </style>
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