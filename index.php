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
$error = '';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        $error = $userController->login($_POST['email'], $_POST['password']);
<<<<<<< Updated upstream
        if ($error === true) { // Ha sikeres a bejelentkezés
=======
        if ($error === true) { 
>>>>>>> Stashed changes
            header("Location: home.php");
            exit();
        }
    } elseif (isset($_POST['register'])) {
        $result = $userController->register(
            $_POST['username'],
            $_POST['email'],
            $_POST['password'],
            $_POST['confirm_password']
        );

        if (isset($result['success'])) {
            // Sikeres regisztráció esetén átirányítunk a bejelentkezésre
            $_SESSION['success'] = "Sikeres regisztráció! Kérjük, jelentkezz be!";
            header("Location: index.php");
            exit();
        } else {
            // Hiba esetén megjelenítjük a hibaüzenetet és a regisztrációs űrlapon maradunk
            $errors = $result;
            // JavaScript kód a regisztrációs űrlapon maradáshoz
            echo '<script>
                window.onload = function() {
                    document.querySelector(".container").classList.add("show-register");
                    document.querySelector(".container").classList.remove("show-login");
                }
            </script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< Updated upstream
    <title>Bejelentkezés és Regisztráció</title>
    <link rel="stylesheet" href="src/style/login_style.css">
</head>
<body>
    <div class="container">
        <!-- Bejelentkezési űrlap -->
=======
    <title id="pageTitle">Bejelentkezés</title>
    <link rel="stylesheet" href="src/style/login_style.css">
</head>
<body>
    <div class="container show-login">
>>>>>>> Stashed changes
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

<<<<<<< Updated upstream
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
=======
        <div class="form-container" id="registerContainer">
            <div class="form-box">
                <h2>Regisztráció</h2>
                <?php if (isset($errors['error'])): ?>
                    <div class="error-message"><?php echo htmlspecialchars($errors['error']); ?></div>
                <?php endif; ?>
                <form id="registerForm" method="POST" action="index.php">
                    <div class="input-group">
                        <label for="regUsername">Felhasználónév</label>
                        <input type="text" id="regUsername" name="username" 
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" 
                               required>
                    </div>
                    <div class="input-group">
                        <label for="regEmail">Email cím</label>
                        <input type="email" id="regEmail" name="email" 
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                               required>
>>>>>>> Stashed changes
                    </div>
                    <div class="input-group">
                        <label for="regPassword">Jelszó</label>
                        <input type="password" id="regPassword" name="password" required>
<<<<<<< Updated upstream
=======
                        <small class="form-text text-muted"><br>A jelszónak minimum 8 karaktert és legalább egy nagybetűt kell tartalmaznia.</small>
>>>>>>> Stashed changes
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