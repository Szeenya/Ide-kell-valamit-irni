<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

require_once 'config/config.php';
require_once 'models/SuitModel.php';

$suitModel = new SuitModel();
$suits = $suitModel->getAllSuits();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Webshop</title>
    <link rel="stylesheet" href="src/style/main_style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="src/style/navbar.css">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                
            </div>
            <ul class="nav-links">
                <li><a href="home.php">Főoldal</a></li>
                <li><a href="Store.php" class="active">Termékek</a></li>
                <li><a href="#">Rólunk</a></li>
                <li><a href="#">Kapcsolat</a></li>
                <li class="user-info">
                    <span>Üdvözöljük, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                    <form action="index.php" method="POST">
                        <input type="hidden" name="logout" value="1">
                        <button type="submit" class="logout-btn">Kijelentkezés</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <main>
        <section class="products">
            <div class="product-list">
                <?php foreach ($suits as $suit): ?>
                <div class="product-card" onclick="showModal(
                    'src/images/kep1.jpg', 
                    'Méret: <?php echo "Nyak: {$suit['neck']}cm, Ujj: {$suit['sleve']}cm, Derék: {$suit['waist']}cm, Mellkas: {$suit['chest']}cm"; ?>', 
                    '<?php echo number_format($suit['price'], 0, ',', ' ') . ' Ft'; ?>', 
                    '<?php echo htmlspecialchars($suit['type'] . " - " . $suit['color']); ?>')">
                    <img src="src/images/kep1.jpg" 
                         alt="<?php echo htmlspecialchars($suit['type']); ?>" 
                         class="product-image">
                    <h3 class="product-title"><?php echo htmlspecialchars($suit['type'] . " - " . $suit['color']); ?></h3>
                    <p class="product-price"><?php echo number_format($suit['price'], 0, ',', ' '); ?> Ft</p>
                </div>
                <?php endforeach; ?>
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