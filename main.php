<?php
session_start();
// Ellenőrizzük, hogy be van-e jelentkezve a felhasználó
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
    <link rel="stylesheet" href="src/style/main_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <h1>Öltönykölcsönző</h1>
        <nav>
            <ul>
                <li><a href="#">Kezdőlap</a></li>
                <li><a href="#">Termékek</a></li>
                <li><a href="#">Rólunk</a></li>
                <li><a href="#">Kapcsolat</a></li>
                <li><a href="index.php" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Kijelentkezés</a></li>
                <li>Üdvözöljük, <?php echo htmlspecialchars($_SESSION['username']); ?>!</li>
            </ul>
        </nav>
    </header>

    <!-- Add this form after the header -->
    <form id="logout-form" action="index.php" method="POST" style="display: none;">
        <input type="hidden" name="logout" value="1">
    </form>

    <main>
        <section class="products">
            <div class="product">
                <img src="https://via.placeholder.com/150" alt="Termék 1">
                <h2>Termék 1</h2>
                <p>Ár: 10,000 Ft</p>
                <button onclick="addToCart('Termék 1', 10000)">Kosárba</button>
            </div>
            <div class="product">
                <img src="https://via.placeholder.com/150" alt="Termék 2">
                <h2>Termék 2</h2>
                <p>Ár: 15,000 Ft</p>
                <button onclick="addToCart('Termék 2', 15000)">Kosárba</button>
            </div>
            <div class="product">
                <img src="https://via.placeholder.com/150" alt="Termék 3">
                <h2>Termék 3</h2>
                <p>Ár: 20,000 Ft</p>
                <button onclick="addToCart('Termék 3', 20000)">Kosárba</button>
            </div>
            <div class="product">
                <img src="https://via.placeholder.com/150" alt="Termék 4">
                <h2>Termék 4</h2>
                <p>Ár: 25,000 Ft</p>
                <button onclick="addToCart('Termék 4', 25000)">Kosárba</button>
            </div>
            <div class="product">
                <img src="https://via.placeholder.com/150" alt="Termék 5">
                <h2>Termék 5</h2>
                <p>Ár: 30,000 Ft</p>
                <button onclick="addToCart('Termék 5', 30000)">Kosárba</button>
            </div>
        </section>

        <aside class="cart">
            <h2>Kosár</h2>
            <ul id="cart-items"></ul>
            <p>Összesen: <span id="total-price">0</span> Ft</p>
            <button onclick="clearCart()">Kosár törlése</button>
        </aside>
    </main>

    <script src="src/scripts/script.js"></script>
</body>
</html>