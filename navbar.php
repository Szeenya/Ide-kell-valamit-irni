<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Kijelentkezés kezelése
if (isset($_POST['logout'])) {
    session_destroy();
    session_start();
    session_regenerate_id(true);
    header("Location: index.php");
    exit();
}

// Admin státusz lekérése
$is_admin = false;
if (isset($_SESSION['user_id'])) {
    require_once 'config/config.php';
    $stmt = $pdo->prepare("SELECT is_admin FROM users WHERE id = ?");
    $stmt->execute([$_SESSION['user_id']]);
    $is_admin = (bool)$stmt->fetchColumn();
}
?>
<header>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <nav class="navbar navbar-expand-lg custom-navbar sticky-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php"><img src =/src/images/logo.png></a>
            
            <button class="navbar-toggler custom-toggler" type="button" 
                    data-bs-toggle="collapse" 
                    data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" 
                    aria-expanded="false" 
                    aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="home.php">Főoldal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Store.php">Termékek</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="Reservations.php">Foglalásaim</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="aboutus.php">Rólunk</a>
                    </li>
                    <?php if ($is_admin): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="Admintab.php">Admin Panel</a>
                    </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav ms-auto user-nav">
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item-username">
                            <span class=""><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link btn-outline" href="PersonalData.php">Adataim</a>
                        </li>
                        <li class="nav-item">
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="d-inline">
                                <button type="submit" name="logout" class="nav-link btn-outline">Kijelentkezés</button>
                            </form>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</header>