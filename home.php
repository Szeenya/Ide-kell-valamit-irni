<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Öltönykölcsönző - Főoldal</title>
    <link rel="stylesheet" href="src/style/home_style.css">
    <link rel="stylesheet" href="src/style/navbar.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
              
            </div>
            <ul class="nav-links">
                <li><a href="home.php" class="active">Főoldal</a></li>
                <li><a href="Store.php">Termékek</a></li>
                <li><a href="#">Rólunk</a></li>
                <li><a href="#">Kapcsolat</a></li>
                <li class="user-info">
                    <span>Üdvözöljük, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                    <form action="index.php" method="POST" style="display: inline;">
                        <input type="hidden" name="logout" value="1">
                        <button type="submit" class="logout-btn">Kijelentkezés</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="hero">
            <h2>Üdvözöljük az Öltönykölcsönzőben!</h2>
            <p>Nálunk megtalálja a tökéletes öltönyt minden alkalomra.</p>
            <a href="Store.php" class="cta-button">Böngészés</a>
        </section>

        <section class="features">
            <div class="feature-card">
                <h3>Széles Választék</h3>
                <p>Több száz öltöny közül választhat</p>
            </div>
            <div class="feature-card">
                <h3>Gyors Kiszolgálás</h3>
                <p>24 órán belüli átvétel</p>
            </div>
            <div class="feature-card">
                <h3>Rugalmas Feltételek</h3>
                <p>Kedvező bérleti feltételek</p>
            </div>
        </section>
    </main>

    <footer>
        <div class="contact-info">
            <p>Kapcsolat: info@oltonykolcsonzo.hu</p>
            <p>Telefon: +36 30 123 4567</p>
            <p>Cím: 1234 Budapest, Példa utca 1.</p>
        </div>
    </footer>
</body>
</html>