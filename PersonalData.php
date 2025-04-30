<?php
session_start();
require_once 'config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    try {
        // Jelenlegi felhasználó adatainak lekérése
        $stmt = $pdo->prepare("SELECT username, password FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        // Először ellenőrizzük a jelszót minden módosításhoz
        if (!$current_password) {
            $error = "A módosításhoz add meg a jelenlegi jelszavad!";
        } elseif (!password_verify($current_password, $user['password'])) {
            $error = "A jelenlegi jelszó nem megfelelő!";
        } else {
            // Ha a jelszó megfelelő, akkor végezzük el a módosításokat
            if ($username && $username !== $user['username']) {
                // Felhasználónév módosítása
                $stmt = $pdo->prepare("UPDATE users SET username = ? WHERE id = ?");
                $stmt->execute([$username, $_SESSION['user_id']]);
                $message = "Felhasználónév sikeresen módosítva!";
            }

            if ($new_password && $confirm_password) {
                if ($new_password === $confirm_password) {
                    // Jelszó módosítása
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $stmt->execute([$hashed_password, $_SESSION['user_id']]);
                    $message .= " Jelszó sikeresen módosítva!";
                } else {
                    $error = "Az új jelszó és a megerősítés nem egyezik!";
                }
            }
        }
    } catch (PDOException $e) {
        $error = "Hiba történt az adatok mentése közben!";
    }
}

// Jelenlegi felhasználónév lekérése
$stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$current_username = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Személyes adatok módosítása</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="src/style/navbar.css">
    <link rel="stylesheet" href="src/style/personal_data.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Személyes adatok módosítása</h3>
                    </div>
                    <div class="card-body">
                        <?php if ($message): ?>
                            <div class="alert alert-success"><?php echo $message; ?></div>
                        <?php endif; ?>
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Felhasználónév</label>
                                <input type="text" class="form-control" id="username" name="username" 
                                       value="<?php echo htmlspecialchars($current_username); ?>">
                            </div>

                            <hr>

                            <div class="mb-3">
                                <label for="current_password" class="form-label">Jelenlegi jelszó</label>
                                <input type="password" class="form-control" id="current_password" name="current_password">
                            </div>

                            <div class="mb-3">
                                <label for="new_password" class="form-label">Új jelszó</label>
                                <input type="password" class="form-control" id="new_password" name="new_password">
                            </div>

                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Új jelszó megerősítése</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            </div>

                            <button type="submit" class="btn btn-primary">Mentés</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <div class="contact-info">
            <p>Kapcsolat: info@oltonykolcsonzo.hu</p>
            <p>Telefon: +36 30 123 4567</p>
            <p>Cím: 1234 Budapest, Példa utca 1.</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>