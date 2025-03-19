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
                <li>
                    <form action="index.php" method="POST" style="display: inline;">
                        <input type="hidden" name="logout" value="1">
                        <button type="submit" style="background: none; border: none; color: white; cursor: pointer; text-decoration: underline;">Kijelentkezés</button>
                    </form>
                </li>
                
        <!---   <li>Üdvözöljük, <?php echo htmlspecialchars($_SESSION['username']); ?>!</li>-->
            </ul>
        </nav>
    </header>

    <main>
        <section class="products">
            <div class="product-list">
                <div class="product-card" onclick="showModal('product1.jpg', 'Ez egy stílusos termék leírása.', '10 000 Ft', 'Termék 1')">
                    <img src="src/images/kep1.jpg" alt="Termék 1" class="product-image">
                    <h3 class="product-title">Termék 1</h3>
                </div>
                <div class="product-card" onclick="showModal('product2.jpg', 'Ez egy másik stílusos termék leírása.', '15 000 Ft', 'Termék 2')">
                    <img src="src/images/kep1.jpg" alt="Termék 2" class="product-image">
                    <h3 class="product-title">Termék 2</h3>
                </div>
                <!-- További termékek -->
            </div>
        </section>

        <!-- Modal ablak -->
        <div id="product-modal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="hideModal()">&times;</span>
                <img id="modal-image" src="" alt="Termék kép">
                <h3 id="modal-title"></h3>
                <p id="modal-description"></p>
                <p id="modal-price"></p>
                <button class="modal-button" onclick="addToCart()">Kosárba</button>
            </div>
        </div>

        <!-- Egyetlen kosár -->
        <div class="cart-wrapper">
            <div id="cart" class="cart-main">
                <h3>Kosár</h3>
                <div class="cart-content">
                    <ul id="cart-items"></ul>
                    <div id="cart-total">Összesen: 0 Ft</div>
                    <button onclick="clearCart()">Kosár törlése</button>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="contact-info">
            <p>Kapcsolat: info@oltonykolcsonzo.hu</p>
            <p>Telefon: +36 30 123 4567</p>
            <p>Cím: 1234 Budapest, Példa utca 1.</p>
        </div>
    </footer>

    <script src="src/scripts/main_script.js"></script>
</body>
</html>