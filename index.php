<?php
session_start();
require_once 'config/config.php';
require_once 'controllers/UserController.php';

$userController = new UserController();
$error = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $error = $userController->login($_POST['email'], $_POST['password']);
        if ($error === true) { // Ha sikeres a bejelentkezés
            header("Location: home.php");
            exit();
        }
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
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< Updated upstream
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
=======
    <title>Bejelentkezés és Regisztráció</title>
    <link rel="stylesheet" href="src/style/login_style.css">
>>>>>>> Stashed changes
</head>
<body>
    <div class="container">
        <!-- Bejelentkezési űrlap -->
        <div class="form-container" id="loginContainer">
            <div class="form-box">
                <h2>Bejelentkezés</h2>
                <?php if (!empty($error) && $error !== true): ?>
                    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                <form id="loginForm" method="POST" action="index.php">
                    <div class="input-group">
                        <label for="email">Email cím</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="password">Jelszó</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" name="login">Bejelentkezés</button>
                </form>
                <p>Nincs még fiókod? <a href="#" id="showRegister">Regisztrálj itt!</a></p>
            </div>
        </div>

        <!-- Regisztrációs űrlap -->
        <div class="form-container" id="registerContainer">
            <div class="form-box">
                <h2>Regisztráció</h2>
                <form id="registerForm" method="POST" action="index.php">
                    <div class="input-group">
                        <label for="regUsername">Felhasználónév</label>
                        <input type="text" id="regUsername" name="username" required>
                    </div>
                    <div class="input-group">
                        <label for="regEmail">Email cím</label>
                        <input type="email" id="regEmail" name="email" required>
                    </div>
                    <div class="input-group">
                        <label for="regPassword">Jelszó</label>
                        <input type="password" id="regPassword" name="password" required>
                    </div>
                    <div class="input-group">
                        <label for="regConfirmPassword">Jelszó megerősítése</label>
                        <input type="password" id="regConfirmPassword" name="confirm_password" required>
                    </div>
                    <button type="submit" name="register">Regisztráció</button>
                </form>
                <p>Már van fiókod? <a href="#" id="showLogin">Jelentkezz be itt!</a></p>
            </div>
        </div>
    </div>
    <script src="src/scripts/login_script.js"></script>
</body>
</html>